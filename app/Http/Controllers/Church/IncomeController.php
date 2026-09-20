<?php

namespace App\Http\Controllers\Church;

use App\Http\Controllers\Controller;
use App\Models\Income;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as ResponseFacade;
use Illuminate\View\View;

class IncomeController extends Controller
{
    /**
     * Display income records.
     */
    public function index(Request $request): View
    {
        $church = $request->user()->church;

        if (!$church) {
            abort(403, 'Your account is not associated with a church.');
        }

        $incomes = $church->incomes()
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
            )
            ->orderByDesc('income_date')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        $totalIncome = $church->incomes()->sum('amount');

        $currentMonthIncome = $church->incomes()
            ->whereMonth('income_date', now()->month)
            ->whereYear('income_date', now()->year)
            ->sum('amount');

        $categories = $church->incomes()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('church.income.index', [
            'church' => $church,
            'incomes' => $incomes,
            'totalIncome' => $totalIncome,
            'currentMonthIncome' => $currentMonthIncome,
            'categories' => $categories,
        ]);
    }

    /**
     * Display the form for creating income.
     */
    public function create(Request $request): View
    {
        $church = $request->user()->church;

        if (!$church) {
            abort(403, 'Your account is not associated with a church.');
        }

        $members = $church->members()
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        return view('church.income.create', [
            'church' => $church,
            'members' => $members,
        ]);
    }

    /**
     * Store a new income record.
     */
    public function store(Request $request): RedirectResponse
    {
        $church = $request->user()->church;

        if (!$church) {
            abort(403, 'Your account is not associated with a church.');
        }

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
        ]);

        $this->validateMemberBelongsToChurch(
            $church,
            $validated['member_id'] ?? null
        );

        $church->incomes()->create($validated);

        return redirect()
            ->route('church.income.index')
            ->with('success', 'Income recorded successfully.');
    }

    /**
     * Display a single income record.
     */
    public function show(
        Request $request,
        Income $income
    ): View {
        $this->ensureBelongsToChurch($request, $income);

        $income->load('member');

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
        $this->ensureBelongsToChurch($request, $income);

        $church = $request->user()->church;

        $members = $church->members()
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        return view('church.income.edit', [
            'income' => $income,
            'members' => $members,
        ]);
    }

    /**
     * Update an income record.
     */
    public function update(
        Request $request,
        Income $income
    ): RedirectResponse {
        $this->ensureBelongsToChurch($request, $income);

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
        ]);

        $this->validateMemberBelongsToChurch(
            $church,
            $validated['member_id'] ?? null
        );

        $income->update($validated);

        return redirect()
            ->route('church.income.show', $income)
            ->with('success', 'Income updated successfully.');
    }

    /**
     * Delete an income record.
     */
    public function destroy(
        Request $request,
        Income $income
    ): RedirectResponse {
        $this->ensureBelongsToChurch($request, $income);

        $income->delete();

        return redirect()
            ->route('church.income.index')
            ->with('success', 'Income deleted successfully.');
    }

    /**
     * Export all church income records as CSV.
     */
    public function export(Request $request): Response
    {
        $church = $request->user()->church;

        if (!$church) {
            abort(403, 'Your account is not associated with a church.');
        }

        $incomes = $church->incomes()
            ->with('member')
            ->orderByDesc('income_date')
            ->orderByDesc('id')
            ->get();

        $filename = 'church-income-' . now()->format('Y-m-d-H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $columns = [
            'Member ID',
            'Category',
            'Source',
            'Amount',
            'Income Date',
            'Payment Method',
            'Reference',
            'Description',
        ];

        $callback = function () use ($incomes, $columns) {
            $file = fopen('php://output', 'w');

            fputcsv($file, $columns);

            foreach ($incomes as $income) {
                fputcsv($file, [
                    $income->member?->member_id,
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

        if (!$church) {
            abort(403, 'Your account is not associated with a church.');
        }

        return view('church.income.import', [
            'church' => $church,
        ]);
    }
    /**
     * Import income records from CSV.
     */
    public function importStore(Request $request): RedirectResponse
    {
        $church = $request->user()->church;

        if (!$church) {
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

        if (!$handle) {
            return back()->with(
                'error',
                'The uploaded file could not be opened.'
            );
        }

        $header = fgetcsv($handle);

        if (!$header) {
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
            'income date',
        ];

        foreach ($requiredColumns as $requiredColumn) {
            if (!in_array($requiredColumn, $header, true)) {
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

            if (!$data) {
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
                !is_numeric($amount) ||
                (float) $amount < 0.01
            ) {
                $skipped++;
                continue;
            }

            try {
                $parsedDate = \Carbon\Carbon::parse(
                    $incomeDate
                )->format('Y-m-d');
            } catch (\Throwable) {
                $skipped++;
                continue;
            }

            $memberId = null;

            if (!empty($data['member id'])) {

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

            $church->incomes()->create([
                'category' => $category,

                'source' => !empty($data['source'])
                    ? trim($data['source'])
                    : null,

                'amount' => (float) $amount,

                'income_date' => $parsedDate,

                'payment_method' => !empty($data['payment method'])
                    ? trim($data['payment method'])
                    : null,

                'reference' => !empty($data['reference'])
                    ? trim($data['reference'])
                    : null,

                'description' => !empty($data['description'])
                    ? trim($data['description'])
                    : null,

                'member_id' => $memberId,
            ]);

            $imported++;
        }

        fclose($handle);

        $message = "{$imported} income record(s) imported successfully.";

        if ($skipped > 0) {
            $message .= " {$skipped} row(s) were skipped.";
        }

        return redirect()
            ->route('church.income.index')
            ->with('success', $message);
    }

    /**
     * Download a CSV import template.
     */
    public function downloadTemplate(Request $request): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $church = $request->user()->church;

        if (!$church) {
            abort(403, 'Your account is not associated with a church.');
        }

        $filename = 'church-income-template.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Member ID',
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
     * Validate that a member belongs to the church.
     */
    private function validateMemberBelongsToChurch(
        $church,
        ?int $memberId
    ): void {
        if (!$memberId) {
            return;
        }

        $belongsToChurch = $church
            ->members()
            ->whereKey($memberId)
            ->exists();

        if (!$belongsToChurch) {
            abort(403, 'The selected member does not belong to your church.');
        }
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
            !$church ||
            $income->church_id !== $church->id
        ) {
            abort(404);
        }
    }
}