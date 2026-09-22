<?php

namespace App\Http\Controllers\Church;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\FinancialAccount;
use App\Services\ActivityLogService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as ResponseFacade;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    /**
     * Display expense records.
     */
    public function index(Request $request): View
    {
        $church = $request->user()->church;

        abort_unless(
            $church,
            403,
            'Your account is not associated with a church.'
        );

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

        $expenseQuery = $church->expenses()
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
                    'expense_date',
                    '>=',
                    $request->date_from
                )
            )
            ->when(
                $request->filled('date_to'),
                fn ($query) => $query->whereDate(
                    'expense_date',
                    '<=',
                    $request->date_to
                )
            );

        $expenses = (clone $expenseQuery)
            ->orderByDesc('expense_date')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        $totalExpenses = (clone $expenseQuery)
            ->sum('amount');

        $currentMonthExpenses = (clone $expenseQuery)
            ->whereMonth(
                'expense_date',
                now()->month
            )
            ->whereYear(
                'expense_date',
                now()->year
            )
            ->sum('amount');

        $categories = (clone $expenseQuery)
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $accounts = $church->financialAccounts()
            ->orderByDesc('is_default')
            ->orderBy('name')
            ->get();

        return view('church.expenses.index', [
            'church' => $church,
            'expenses' => $expenses,
            'totalExpenses' => $totalExpenses,
            'currentMonthExpenses' => $currentMonthExpenses,
            'categories' => $categories,
            'accounts' => $accounts,
            'selectedAccount' => $selectedAccount,
            'selectedAccountId' => $selectedAccountId,
        ]);
    }

    /**
     * Display the form for creating an expense.
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

        $defaultAccount = $accounts
            ->firstWhere('is_default', true)
            ?? $accounts->first();

        return view('church.expenses.create', [
            'church' => $church,
            'members' => $members,
            'accounts' => $accounts,
            'defaultAccount' => $defaultAccount,
        ]);
    }

    /**
     * Store a new expense record.
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
            'financial_account_id' => [
                'required',
                'integer',
                'exists:financial_accounts,id',
            ],
            'category' => [
                'required',
                'string',
                'max:100',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],
            'expense_date' => [
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
            'vendor' => [
                'nullable',
                'string',
                'max:255',
            ],
            'notes' => [
                'nullable',
                'string',
            ],
            'member_id' => [
                'nullable',
                'integer',
                'exists:members,id',
            ],
        ]);

        $financialAccount = $this->getActiveFinancialAccount(
            $church,
            (int) $validated['financial_account_id']
        );

        $this->validateMemberBelongsToChurch(
            $church,
            $validated['member_id'] ?? null
        );

        $expense = $church->expenses()->create($validated);

        $activityLog->record(
            action: 'created',
            subject: $expense,
            description: sprintf(
                'Expense record created: ₦%s under %s in %s.',
                number_format((float) $expense->amount, 2),
                $expense->category,
                $financialAccount->name
            )
        );

        return redirect()
            ->route('church.expenses.index')
            ->with(
                'success',
                'Expense recorded successfully.'
            );
    }

    /**
     * Display a single expense record.
     */
    public function show(
        Request $request,
        Expense $expense
    ): View {
        $this->ensureBelongsToChurch(
            $request,
            $expense
        );

        $expense->load([
            'member',
            'financialAccount',
        ]);

        return view('church.expenses.show', [
            'expense' => $expense,
        ]);
    }

    /**
     * Display the expense edit form.
     */
    public function edit(
        Request $request,
        Expense $expense
    ): View {
        $this->ensureBelongsToChurch(
            $request,
            $expense
        );

        $church = $request->user()->church;

        $members = $church->members()
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        $accounts = $church->financialAccounts()
            ->where(function ($query) use ($expense) {
                $query
                    ->where('is_active', true)
                    ->orWhereKey($expense->financial_account_id);
            })
            ->orderByDesc('is_default')
            ->orderBy('name')
            ->get();

        return view('church.expenses.edit', [
            'expense' => $expense,
            'members' => $members,
            'accounts' => $accounts,
        ]);
    }

    /**
     * Update an expense record.
     */
    public function update(
        Request $request,
        Expense $expense,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $this->ensureBelongsToChurch(
            $request,
            $expense
        );

        $church = $request->user()->church;

        $validated = $request->validate([
            'financial_account_id' => [
                'required',
                'integer',
                'exists:financial_accounts,id',
            ],
            'category' => [
                'required',
                'string',
                'max:100',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],
            'expense_date' => [
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
            'vendor' => [
                'nullable',
                'string',
                'max:255',
            ],
            'notes' => [
                'nullable',
                'string',
            ],
            'member_id' => [
                'nullable',
                'integer',
                'exists:members,id',
            ],
        ]);

        $financialAccount = $this->getFinancialAccount(
            $church,
            (int) $validated['financial_account_id']
        );

        $this->validateMemberBelongsToChurch(
            $church,
            $validated['member_id'] ?? null
        );

        $expense->update($validated);

        $activityLog->record(
            action: 'updated',
            subject: $expense,
            description: sprintf(
                'Expense record updated: ₦%s under %s in %s.',
                number_format((float) $expense->amount, 2),
                $expense->category,
                $financialAccount->name
            )
        );

        return redirect()
            ->route('church.expenses.show', $expense)
            ->with(
                'success',
                'Expense updated successfully.'
            );
    }

    /**
     * Delete an expense record.
     */
    public function destroy(
        Request $request,
        Expense $expense,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $this->ensureBelongsToChurch(
            $request,
            $expense
        );

        $amount = (float) $expense->amount;
        $category = $expense->category;
        $accountName = $expense->financialAccount?->name
            ?? 'Unassigned Account';

        $activityLog->record(
            action: 'deleted',
            subject: $expense,
            description: sprintf(
                'Expense record deleted: ₦%s under %s in %s.',
                number_format($amount, 2),
                $category,
                $accountName
            )
        );

        $expense->delete();

        return redirect()
            ->route('church.expenses.index')
            ->with(
                'success',
                'Expense deleted successfully.'
            );
    }

    /**
     * Export church expenses as CSV.
     */
    public function export(Request $request): Response
    {
        $church = $request->user()->church;

        abort_unless(
            $church,
            403,
            'Your account is not associated with a church.'
        );

        $expenses = $church->expenses()
            ->with([
                'member',
                'financialAccount',
            ])
            ->orderByDesc('expense_date')
            ->orderByDesc('id')
            ->get();

        $filename = 'church-expenses-'
            . now()->format('Y-m-d-H-i-s')
            . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' =>
                'attachment; filename="' . $filename . '"',
        ];

        $columns = [
            'Member ID',
            'Category',
            'Description',
            'Amount',
            'Expense Date',
            'Payment Method',
            'Reference',
            'Vendor',
            'Notes',
            'Financial Account',
        ];

        $callback = function () use (
            $expenses,
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

            foreach ($expenses as $expense) {
                fputcsv($file, [
                    $expense->member?->member_id,
                    $expense->category,
                    $expense->description,
                    $expense->amount,
                    $expense->expense_date?->format('Y-m-d'),
                    $expense->payment_method,
                    $expense->reference,
                    $expense->vendor,
                    $expense->notes,
                    $expense->financialAccount?->name,
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
     * Display the expense import page.
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

        $defaultAccount = $accounts
            ->firstWhere('is_default', true)
            ?? $accounts->first();

        return view('church.expenses.import', [
            'church' => $church,
            'accounts' => $accounts,
            'defaultAccount' => $defaultAccount,
        ]);
    }

    /**
     * Import expenses from CSV.
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

        $activeAccounts = $church->financialAccounts()
            ->where('is_active', true)
            ->orderByDesc('is_default')
            ->orderBy('name')
            ->get();

        if ($activeAccounts->isEmpty()) {
            return back()->with(
                'error',
                'Please create at least one active financial account before importing expenses.'
            );
        }

        $defaultAccount = $activeAccounts
            ->firstWhere('is_default', true)
            ?? $activeAccounts->first();

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
            fn ($value) => strtolower(trim($value)),
            $header
        );

        $requiredColumns = [
            'category',
            'amount',
            'expense date',
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

            $expenseDate = trim(
                (string) ($data['expense date'] ?? '')
            );

            if (
                $category === '' ||
                $amount === '' ||
                $expenseDate === ''
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
                    $expenseDate
                )->format('Y-m-d');
            } catch (\Throwable) {
                $skipped++;
                continue;
            }

            $memberId = null;

            if (! empty($data['member id'])) {
                $member = $church->members()
                    ->where(
                        'member_id',
                        trim($data['member id'])
                    )
                    ->first();

                if ($member) {
                    $memberId = $member->id;
                }
            }

            /*
             * Financial Account is optional for backwards
             * compatibility with older CSV files.
             */
            $financialAccount = $defaultAccount;

            if (
                isset($data['financial account']) &&
                trim((string) $data['financial account']) !== ''
            ) {
                $accountName = trim(
                    (string) $data['financial account']
                );

                $financialAccount = $activeAccounts
                    ->first(
                        fn (
                            FinancialAccount $account
                        ) => strcasecmp(
                            $account->name,
                            $accountName
                        ) === 0
                    );

                if (! $financialAccount) {
                    $skipped++;
                    continue;
                }
            }

            $church->expenses()->create([
                'financial_account_id' =>
                    $financialAccount->id,

                'category' => $category,

                'description' =>
                    ! empty($data['description'])
                        ? trim($data['description'])
                        : null,

                'amount' => (float) $amount,

                'expense_date' => $parsedDate,

                'payment_method' =>
                    ! empty($data['payment method'])
                        ? trim($data['payment method'])
                        : null,

                'reference' =>
                    ! empty($data['reference'])
                        ? trim($data['reference'])
                        : null,

                'vendor' =>
                    ! empty($data['vendor'])
                        ? trim($data['vendor'])
                        : null,

                'notes' =>
                    ! empty($data['notes'])
                        ? trim($data['notes'])
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
                    '%d expense record(s) imported from CSV%s.',
                    $imported,
                    $skipped > 0
                        ? " with {$skipped} row(s) skipped"
                        : ''
                )
            );
        }

        $message = sprintf(
            '%d expense record(s) imported successfully.',
            $imported
        );

        if ($skipped > 0) {
            $message .= sprintf(
                ' %d row(s) were skipped.',
                $skipped
            );
        }

        return redirect()
            ->route('church.expenses.index')
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
    ): \Symfony\Component\HttpFoundation\StreamedResponse {
        $church = $request->user()->church;

        abort_unless(
            $church,
            403,
            'Your account is not associated with a church.'
        );

        $defaultAccount = $church->financialAccounts()
            ->where('is_active', true)
            ->orderByDesc('is_default')
            ->orderBy('name')
            ->first();

        $filename = 'church-expenses-template.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' =>
                'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use (
            $defaultAccount
        ) {
            $file = fopen(
                'php://output',
                'w'
            );

            fputcsv($file, [
                'Member ID',
                'Category',
                'Description',
                'Amount',
                'Expense Date',
                'Payment Method',
                'Reference',
                'Vendor',
                'Notes',
                'Financial Account',
            ]);

            fputcsv($file, [
                'MEM-0001',
                'Utilities',
                'Electricity bill',
                '50000.00',
                now()->format('Y-m-d'),
                'bank transfer',
                'EXP-0001',
                'Eko Electricity',
                'Example expense record',
                $defaultAccount?->name,
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
        $church,
        int $accountId
    ): FinancialAccount {
        $account = $church->financialAccounts()
            ->whereKey($accountId)
            ->where('is_active', true)
            ->first();

        abort_unless(
            $account,
            422,
            'The selected financial account is not available.'
        );

        return $account;
    }

    /**
     * Get a financial account belonging to the church.
     */
    private function getFinancialAccount(
        $church,
        int $accountId
    ): FinancialAccount {
        $account = $church->financialAccounts()
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
     * Ensure the expense belongs to the authenticated church.
     */
    private function ensureBelongsToChurch(
        Request $request,
        Expense $expense
    ): void {
        $church = $request->user()->church;

        abort_unless(
            $church &&
            $expense->church_id === $church->id,
            404
        );
    }
}