<?php

namespace App\Http\Controllers\Church;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Services\ActivityLogService;
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

        if (! $church) {
            abort(403, 'Your account is not associated with a church.');
        }

        $expenses = $church->expenses()
            ->with('member')
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
            )
            ->orderByDesc('expense_date')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        $totalExpenses = $church->expenses()->sum('amount');

        $currentMonthExpenses = $church->expenses()
            ->whereMonth('expense_date', now()->month)
            ->whereYear('expense_date', now()->year)
            ->sum('amount');

        $categories = $church->expenses()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('church.expenses.index', [
            'church' => $church,
            'expenses' => $expenses,
            'totalExpenses' => $totalExpenses,
            'currentMonthExpenses' => $currentMonthExpenses,
            'categories' => $categories,
        ]);
    }

    /**
     * Display the form for creating an expense.
     */
    public function create(Request $request): View
    {
        $church = $request->user()->church;

        if (! $church) {
            abort(403, 'Your account is not associated with a church.');
        }

        $members = $church->members()
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        return view('church.expenses.create', [
            'church' => $church,
            'members' => $members,
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

        if (! $church) {
            abort(403, 'Your account is not associated with a church.');
        }

        $validated = $request->validate([
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

        $this->validateMemberBelongsToChurch(
            $church,
            $validated['member_id'] ?? null
        );

        $expense = $church->expenses()->create($validated);

        $activityLog->record(
            action: 'created',
            subject: $expense,
            description: sprintf(
                'Expense record created: ₦%s under %s.',
                number_format((float) $expense->amount, 2),
                $expense->category
            )
        );

        return redirect()
            ->route('church.expenses.index')
            ->with('success', 'Expense recorded successfully.');
    }

    /**
     * Display a single expense record.
     */
    public function show(
        Request $request,
        Expense $expense
    ): View {
        $this->ensureBelongsToChurch($request, $expense);

        $expense->load('member');

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
        $this->ensureBelongsToChurch($request, $expense);

        $church = $request->user()->church;

        $members = $church->members()
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        return view('church.expenses.edit', [
            'expense' => $expense,
            'members' => $members,
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
        $this->ensureBelongsToChurch($request, $expense);

        $church = $request->user()->church;

        $validated = $request->validate([
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

        $this->validateMemberBelongsToChurch(
            $church,
            $validated['member_id'] ?? null
        );

        $expense->update($validated);

        $activityLog->record(
            action: 'updated',
            subject: $expense,
            description: sprintf(
                'Expense record updated: ₦%s under %s.',
                number_format((float) $expense->amount, 2),
                $expense->category
            )
        );

        return redirect()
            ->route('church.expenses.show', $expense)
            ->with('success', 'Expense updated successfully.');
    }

    /**
     * Delete an expense record.
     */
    public function destroy(
        Request $request,
        Expense $expense,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $this->ensureBelongsToChurch($request, $expense);

        $amount = (float) $expense->amount;
        $category = $expense->category;

        $activityLog->record(
            action: 'deleted',
            subject: $expense,
            description: sprintf(
                'Expense record deleted: ₦%s under %s.',
                number_format($amount, 2),
                $category
            )
        );

        $expense->delete();

        return redirect()
            ->route('church.expenses.index')
            ->with('success', 'Expense deleted successfully.');
    }

    /**
     * Export all church expenses as CSV.
     */
    public function export(Request $request): Response
    {
        $church = $request->user()->church;

        if (! $church) {
            abort(403, 'Your account is not associated with a church.');
        }

        $expenses = $church->expenses()
            ->with('member')
            ->orderByDesc('expense_date')
            ->orderByDesc('id')
            ->get();

        $filename = 'church-expenses-' . now()->format('Y-m-d-H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
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
        ];

        $callback = function () use ($expenses, $columns) {
            $file = fopen('php://output', 'w');

            fputcsv($file, $columns);

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

        if (! $church) {
            abort(403, 'Your account is not associated with a church.');
        }

        return view('church.expenses.import', [
            'church' => $church,
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

        if (! $church) {
            abort(403, 'Your account is not associated with a church.');
        }

        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:csv,txt',
                'max:5120',
            ],
        ]);

        $file = $request->file('file');

        $handle = fopen($file->getRealPath(), 'r');

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
            if (! in_array($requiredColumn, $header, true)) {
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
                $parsedDate = \Carbon\Carbon::parse(
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

            $church->expenses()->create([
                'category' => $category,

                'description' => ! empty($data['description'])
                    ? trim($data['description'])
                    : null,

                'amount' => (float) $amount,

                'expense_date' => $parsedDate,

                'payment_method' => ! empty($data['payment method'])
                    ? trim($data['payment method'])
                    : null,

                'reference' => ! empty($data['reference'])
                    ? trim($data['reference'])
                    : null,

                'vendor' => ! empty($data['vendor'])
                    ? trim($data['vendor'])
                    : null,

                'notes' => ! empty($data['notes'])
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

        $message = "{$imported} expense record(s) imported successfully.";

        if ($skipped > 0) {
            $message .= " {$skipped} row(s) were skipped.";
        }

        return redirect()
            ->route('church.expenses.index')
            ->with('success', $message);
    }

    /**
     * Download a CSV import template.
     */
    public function downloadTemplate(
        Request $request
    ): \Symfony\Component\HttpFoundation\StreamedResponse {
        $church = $request->user()->church;

        if (! $church) {
            abort(403, 'Your account is not associated with a church.');
        }

        $filename = 'church-expenses-template.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

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

        if (! $belongsToChurch) {
            abort(
                403,
                'The selected member does not belong to your church.'
            );
        }
    }

    /**
     * Ensure the expense belongs to the authenticated church.
     */
    private function ensureBelongsToChurch(
        Request $request,
        Expense $expense
    ): void {
        $church = $request->user()->church;

        if (
            ! $church ||
            $expense->church_id !== $church->id
        ) {
            abort(404);
        }
    }
}