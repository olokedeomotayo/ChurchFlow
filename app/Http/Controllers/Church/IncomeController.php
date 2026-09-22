<?php

namespace App\Http\Controllers\Church;

use App\Http\Controllers\Controller;
use App\Models\FinancialAccount;
use App\Models\Income;
use App\Services\ActivityLogService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as ResponseFacade;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class IncomeController extends Controller
{
    /**
     * Display income records.
     */
    public function index(Request $request): View
    {
        $church = $request->user()->church;

        abort_unless(
            $church,
            403,
            'Your account is not associated with a church.'
        );

        /*
         * Financial Account Selection
         *
         * null = All Accounts
         * value = selected financial account
         */
        $selectedAccountId = $request->filled('financial_account_id')
            ? (int) $request->financial_account_id
            : null;

        $selectedAccount = null;

        if ($selectedAccountId) {
            $selectedAccount = $church->financialAccounts()
                ->whereKey($selectedAccountId)
                ->first();

            abort_unless(
                $selectedAccount,
                404,
                'The selected financial account was not found.'
            );
        }

        /*
         * Base income query.
         *
         * All filters, including the selected financial account,
         * are applied to this query.
         */
        $incomeQuery = $church->incomes()
            ->with([
                'member',
                'financialAccount',
            ])
            ->when(
                $selectedAccountId,
                fn ($query) => $query->where(
                    'financial_account_id',
                    $selectedAccountId
                )
            )
            ->when(
                $request->filled('category'),
                fn ($query) => $query->where(
                    'category',
                    $request->category
                )
            )
            ->when(
                $request->filled('payment_method'),
                fn ($query) => $query->where(
                    'payment_method',
                    $request->payment_method
                )
            )
            ->when(
                $request->filled('date_from'),
                fn ($query) => $query->whereDate(
                    'income_date',
                    '>=',
                    $request->date_from
                )
            )
            ->when(
                $request->filled('date_to'),
                fn ($query) => $query->whereDate(
                    'income_date',
                    '<=',
                    $request->date_to
                )
            );

        /*
         * Paginated income records.
         */
        $incomes = (clone $incomeQuery)
            ->orderByDesc('income_date')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        /*
         * Summary totals follow the selected financial account.
         */
        $totalIncome = (clone $incomeQuery)
            ->sum('amount');

        $currentMonthIncome = (clone $incomeQuery)
            ->whereMonth(
                'income_date',
                now()->month
            )
            ->whereYear(
                'income_date',
                now()->year
            )
            ->sum('amount');

        /*
         * Categories available within the selected account.
         */
        $categories = (clone $incomeQuery)
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        /*
         * All church financial accounts for the account selector.
         */
        $accounts = $church->financialAccounts()
            ->orderByDesc('is_default')
            ->orderBy('name')
            ->get();

        return view('church.income.index', [
            'church' => $church,
            'incomes' => $incomes,
            'totalIncome' => $totalIncome,
            'currentMonthIncome' => $currentMonthIncome,
            'categories' => $categories,
            'accounts' => $accounts,
            'selectedAccount' => $selectedAccount,
            'selectedAccountId' => $selectedAccountId,
        ]);
    }

    /**
     * Display the form for creating income.
     */
    public function create(Request $request): View
    {
        $church = $request->user()->church;

        abort_unless(
            $church,
            403,
            'Your account is not associated with a church.'
        );

        $members = $church->members()
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        $accounts = $church->financialAccounts()
            ->where('is_active', true)
            ->orderByDesc('is_default')
            ->orderBy('name')
            ->get();

        $defaultAccount = $accounts->firstWhere(
            'is_default',
            true
        ) ?? $accounts->first();

        return view('church.income.create', [
            'church' => $church,
            'members' => $members,
            'accounts' => $accounts,
            'defaultAccount' => $defaultAccount,
        ]);
    }

    /**
     * Store a new income record.
     */
    public function store(
        Request $request,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $church = $request->user()->church;

        abort_unless(
            $church,
            403,
            'Your account is not associated with a church.'
        );

        $validated = $request->validate([
            'category' => [
                'required',
                'string',
                'max:100',
            ],
            'source' => [
                'nullable',
                'string',
                'max:255',
            ],
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],
            'income_date' => [
                'required',
                'date',
            ],
            'payment_method' => [
                'nullable',
                'string',
                'max:50',
            ],
            'reference' => [
                'nullable',
                'string',
                'max:100',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'member_id' => [
                'nullable',
                'integer',
                'exists:members,id',
            ],
            'financial_account_id' => [
                'required',
                'integer',
                'exists:financial_accounts,id',
            ],
        ]);

        $this->validateMemberBelongsToChurch(
            $church,
            $validated['member_id'] ?? null
        );

        $financialAccount = $this->getActiveFinancialAccount(
            $church->id,
            (int) $validated['financial_account_id']
        );

        $income = $church->incomes()->create($validated);

        $activityLog->record(
            action: 'created',
            subject: $income,
            description: sprintf(
                'Income record created: ₦%s under %s, assigned to %s.',
                number_format(
                    (float) $income->amount,
                    2
                ),
                $income->category,
                $financialAccount->name
            )
        );

        return redirect()
            ->route('church.income.index')
            ->with(
                'success',
                'Income recorded successfully.'
            );
    }

    /**
     * Display a single income record.
     */
    public function show(
        Request $request,
        Income $income
    ): View {
        $this->ensureBelongsToChurch(
            $request,
            $income
        );

        $income->load([
            'member',
            'financialAccount',
        ]);

        return view('church.income.show', [
            'income' => $income,
        ]);
    }

    /**
     * Display the income edit form.
     */
    public function edit(
        Request $request,
        Income $income
    ): View {
        $this->ensureBelongsToChurch(
            $request,
            $income
        );

        $church = $request->user()->church;

        $members = $church->members()
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        /*
         * Include all active accounts plus the income's current account.
         */
        $accounts = $church->financialAccounts()
            ->where(function ($query) use ($income) {
                $query
                    ->where('is_active', true)
                    ->orWhere(
                        'id',
                        $income->financial_account_id
                    );
            })
            ->orderByDesc('is_default')
            ->orderBy('name')
            ->get();

        return view('church.income.edit', [
            'income' => $income,
            'members' => $members,
            'accounts' => $accounts,
        ]);
    }

    /**
     * Update an income record.
     */
    public function update(
        Request $request,
        Income $income,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $this->ensureBelongsToChurch(
            $request,
            $income
        );

        $church = $request->user()->church;

        $validated = $request->validate([
            'category' => [
                'required',
                'string',
                'max:100',
            ],
            'source' => [
                'nullable',
                'string',
                'max:255',
            ],
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],
            'income_date' => [
                'required',
                'date',
            ],
            'payment_method' => [
                'nullable',
                'string',
                'max:50',
            ],
            'reference' => [
                'nullable',
                'string',
                'max:100',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'member_id' => [
                'nullable',
                'integer',
                'exists:members,id',
            ],
            'financial_account_id' => [
                'required',
                'integer',
                'exists:financial_accounts,id',
            ],
        ]);

        $this->validateMemberBelongsToChurch(
            $church,
            $validated['member_id'] ?? null
        );

        $financialAccount = $this->getFinancialAccount(
            $church->id,
            (int) $validated['financial_account_id']
        );

        $income->update($validated);

        $activityLog->record(
            action: 'updated',
            subject: $income,
            description: sprintf(
                'Income record updated: ₦%s under %s, assigned to %s.',
                number_format(
                    (float) $income->amount,
                    2
                ),
                $income->category,
                $financialAccount->name
            )
        );

        return redirect()
            ->route(
                'church.income.show',
                $income
            )
            ->with(
                'success',
                'Income updated successfully.'
            );
    }

    /**
     * Delete an income record.
     */
    public function destroy(
        Request $request,
        Income $income,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $this->ensureBelongsToChurch(
            $request,
            $income
        );

        $amount = (float) $income->amount;
        $category = $income->category;
        $accountName = $income->financialAccount?->name;

        $activityLog->record(
            action: 'deleted',
            subject: $income,
            description: sprintf(
                'Income record deleted: ₦%s under %s%s.',
                number_format(
                    $amount,
                    2
                ),
                $category,
                $accountName
                    ? " from {$accountName}"
                    : ''
            )
        );

        $income->delete();

        return redirect()
            ->route('church.income.index')
            ->with(
                'success',
                'Income deleted successfully.'
            );
    }

    /**
     * Export all church income records as CSV.
     */
    public function export(Request $request): Response
    {
        $church = $request->user()->church;

        abort_unless(
            $church,
            403,
            'Your account is not associated with a church.'
        );

        $incomes = $church->incomes()
            ->with([
                'member',
                'financialAccount',
            ])
            ->orderByDesc('income_date')
            ->orderByDesc('id')
            ->get();

        $filename = 'church-income-' . now()->format(
            'Y-m-d-H-i-s'
        ) . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $columns = [
            'Member ID',
            'Financial Account',
            'Category',
            'Source',
            'Amount',
            'Income Date',
            'Payment Method',
            'Reference',
            'Description',
        ];

        $callback = function () use (
            $incomes,
            $columns
        ) {
            $file = fopen(
                'php://output',
                'w'
            );

            fputcsv(
                $file,
                $columns
            );

            foreach ($incomes as $income) {
                fputcsv($file, [
                    $income->member?->member_id,
                    $income->financialAccount?->name,
                    $income->category,
                    $income->source,
                    $income->amount,
                    $income->income_date?->format('Y-m-d'),
                    $income->payment_method,
                    $income->reference,
                    $income->description,
                ]);
            }

            fclose($file);
        };

        return ResponseFacade::stream(
            $callback,
            200,
            $headers
        );
    }

    /**
     * Display the income import page.
     */
    public function import(Request $request): View
    {
        $church = $request->user()->church;

        abort_unless(
            $church,
            403,
            'Your account is not associated with a church.'
        );

        $accounts = $church->financialAccounts()
            ->where('is_active', true)
            ->orderByDesc('is_default')
            ->orderBy('name')
            ->get();

        $defaultAccount = $accounts->firstWhere(
            'is_default',
            true
        ) ?? $accounts->first();

        return view('church.income.import', [
            'church' => $church,
            'accounts' => $accounts,
            'defaultAccount' => $defaultAccount,
        ]);
    }

    /**
     * Import income records from CSV.
     */
    public function importStore(
        Request $request,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $church = $request->user()->church;

        abort_unless(
            $church,
            403,
            'Your account is not associated with a church.'
        );

        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:csv,txt',
                'max:5120',
            ],
        ]);

        $defaultAccount = $church->financialAccounts()
            ->where('is_active', true)
            ->where('is_default', true)
            ->first();

        if (! $defaultAccount) {
            $defaultAccount = $church->financialAccounts()
                ->where('is_active', true)
                ->orderBy('name')
                ->first();
        }

        if (! $defaultAccount) {
            return back()->with(
                'error',
                'Please create at least one active financial account before importing income.'
            );
        }

        $file = $request->file('file');

        $handle = fopen(
            $file->getRealPath(),
            'r'
        );

        if (! $handle) {
            return back()->with(
                'error',
                'The uploaded file could not be opened.'
            );
        }

        $header = fgetcsv($handle);

        if (! $header) {
            fclose($handle);

            return back()->with(
                'error',
                'The uploaded CSV file is empty.'
            );
        }

        $header = array_map(
            fn ($value) => strtolower(
                trim(
                    preg_replace(
                        '/^\xEF\xBB\xBF/',
                        '',
                        (string) $value
                    )
                )
            ),
            $header
        );

        $requiredColumns = [
            'category',
            'amount',
            'income date',
        ];

        foreach ($requiredColumns as $requiredColumn) {
            if (! in_array(
                $requiredColumn,
                $header,
                true
            )) {
                fclose($handle);

                return back()->with(
                    'error',
                    "The CSV file is missing the required column: {$requiredColumn}."
                );
            }
        }

        $imported = 0;
        $skipped = 0;

        while (($row = fgetcsv($handle)) !== false) {

            if (
                count($row) === 1 &&
                trim((string) $row[0]) === ''
            ) {
                continue;
            }

            $row = array_pad(
                $row,
                count($header),
                null
            );

            $data = array_combine(
                $header,
                $row
            );

            if (! $data) {
                $skipped++;
                continue;
            }

            $category = trim(
                (string) ($data['category'] ?? '')
            );

            $amount = trim(
                (string) ($data['amount'] ?? '')
            );

            $incomeDate = trim(
                (string) ($data['income date'] ?? '')
            );

            if (
                $category === '' ||
                $amount === '' ||
                $incomeDate === ''
            ) {
                $skipped++;
                continue;
            }

            if (
                ! is_numeric($amount) ||
                (float) $amount < 0.01
            ) {
                $skipped++;
                continue;
            }

            try {
                $parsedDate = Carbon::parse(
                    $incomeDate
                )->format('Y-m-d');
            } catch (\Throwable) {
                $skipped++;
                continue;
            }

            /*
             * Financial Account
             *
             * If a Financial Account is supplied in the CSV,
             * it must match an active account belonging to the church.
             *
             * If the column is blank, the default active account
             * is used.
             */
            $financialAccount = $defaultAccount;

            if (
                ! empty($data['financial account'])
            ) {
                $accountName = trim(
                    (string) $data['financial account']
                );

                $financialAccount = $church
                    ->financialAccounts()
                    ->where('is_active', true)
                    ->where('name', $accountName)
                    ->first();

                if (! $financialAccount) {
                    $skipped++;
                    continue;
                }
            }

            $memberId = null;

            if (! empty($data['member id'])) {
                $member = $church->members()
                    ->where(
                        'member_id',
                        trim(
                            (string) $data['member id']
                        )
                    )
                    ->first();

                if ($member) {
                    $memberId = $member->id;
                }
            }

            $church->incomes()->create([
                'financial_account_id' => $financialAccount->id,

                'category' => $category,

                'source' => ! empty($data['source'])
                    ? trim(
                        (string) $data['source']
                    )
                    : null,

                'amount' => (float) $amount,

                'income_date' => $parsedDate,

                'payment_method' => ! empty(
                    $data['payment method']
                )
                    ? trim(
                        (string) $data['payment method']
                    )
                    : null,

                'reference' => ! empty(
                    $data['reference']
                )
                    ? trim(
                        (string) $data['reference']
                    )
                    : null,

                'description' => ! empty(
                    $data['description']
                )
                    ? trim(
                        (string) $data['description']
                    )
                    : null,

                'member_id' => $memberId,
            ]);

            $imported++;
        }

        fclose($handle);

        if ($imported > 0) {
            $activityLog->record(
                action: 'imported',
                description: sprintf(
                    '%d income record(s) imported from CSV%s.',
                    $imported,
                    $skipped > 0
                        ? " with {$skipped} row(s) skipped"
                        : ''
                )
            );
        }

        $message = sprintf(
            '%d income record(s) imported successfully.',
            $imported
        );

        if ($skipped > 0) {
            $message .= sprintf(
                ' %d row(s) were skipped.',
                $skipped
            );
        }

        return redirect()
            ->route('church.income.index')
            ->with(
                'success',
                $message
            );
    }

    /**
     * Download a CSV import template.
     */
    public function downloadTemplate(
        Request $request
    ): StreamedResponse {
        $church = $request->user()->church;

        abort_unless(
            $church,
            403,
            'Your account is not associated with a church.'
        );

        $filename = 'church-income-template.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $defaultAccount = $church->financialAccounts()
            ->where('is_active', true)
            ->where('is_default', true)
            ->first();

        if (! $defaultAccount) {
            $defaultAccount = $church->financialAccounts()
                ->where('is_active', true)
                ->orderBy('name')
                ->first();
        }

        $callback = function () use (
            $defaultAccount
        ) {
            $file = fopen(
                'php://output',
                'w'
            );

            fputcsv($file, [
                'Member ID',
                'Financial Account',
                'Category',
                'Source',
                'Amount',
                'Income Date',
                'Payment Method',
                'Reference',
                'Description',
            ]);

            fputcsv($file, [
                'MEM-0001',
                $defaultAccount?->name ?? 'Main Account',
                'Tithe',
                'Sunday Service',
                '50000.00',
                now()->format('Y-m-d'),
                'cash',
                'REC-0001',
                'Example income record',
            ]);

            fclose($file);
        };

        return ResponseFacade::stream(
            $callback,
            200,
            $headers
        );
    }

    /**
     * Get an active financial account belonging to the church.
     */
    private function getActiveFinancialAccount(
        int $churchId,
        int $accountId
    ): FinancialAccount {
        $account = FinancialAccount::query()
            ->where('church_id', $churchId)
            ->whereKey($accountId)
            ->where('is_active', true)
            ->first();

        abort_unless(
            $account,
            422,
            'The selected financial account is invalid or inactive.'
        );

        return $account;
    }

    /**
     * Get a financial account belonging to the church.
     */
    private function getFinancialAccount(
        int $churchId,
        int $accountId
    ): FinancialAccount {
        $account = FinancialAccount::query()
            ->where('church_id', $churchId)
            ->whereKey($accountId)
            ->first();

        abort_unless(
            $account,
            422,
            'The selected financial account does not belong to your church.'
        );

        return $account;
    }

    /**
     * Validate that a member belongs to the church.
     */
    private function validateMemberBelongsToChurch(
        $church,
        ?int $memberId
    ): void {
        if (! $memberId) {
            return;
        }

        $belongsToChurch = $church
            ->members()
            ->whereKey($memberId)
            ->exists();

        abort_unless(
            $belongsToChurch,
            403,
            'The selected member does not belong to your church.'
        );
    }

    /**
     * Ensure the income belongs to the authenticated church.
     */
    private function ensureBelongsToChurch(
        Request $request,
        Income $income
    ): void {
        $church = $request->user()->church;

        if (
            ! $church ||
            $income->church_id !== $church->id
        ) {
            abort(404);
        }
    }
}