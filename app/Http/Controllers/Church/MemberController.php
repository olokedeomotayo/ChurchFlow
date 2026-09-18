<?php

namespace App\Http\Controllers\Church;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MemberController extends Controller
{
    /**
     * Display all members belonging to the authenticated church.
     */
    public function index(Request $request): View
    {
        $church = $request->user()->church;

        $members = $church->members()
            ->latest()
            ->paginate(15);

        return view('church.members.index', [
            'church' => $church,
            'members' => $members,
        ]);
    }

    /**
     * Display the form for creating a new member.
     */
    public function create(Request $request): View
    {
        $church = $request->user()->church;

        return view('church.members.create', [
            'church' => $church,
        ]);
    }

    /**
     * Store a newly created member.
     */
    public function store(Request $request): RedirectResponse
    {
        $church = $request->user()->church;

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'middle_name' => ['nullable', 'string', 'max:100'],

            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string'],

            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female,other'],
            'marital_status' => [
                'nullable',
                'in:single,married,widowed,divorced',
            ],

            'joined_at' => ['nullable', 'date'],
            'membership_status' => [
                'required',
                'in:active,inactive,suspended',
            ],
            'membership_type' => [
                'required',
                'in:member,visitor,worker,leader',
            ],

            'emergency_contact_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'emergency_contact_phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'emergency_contact_relationship' => [
                'nullable',
                'string',
                'max:100',
            ],

            'notes' => ['nullable', 'string'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Generate Member ID
        |--------------------------------------------------------------------------
        */

        $nextId = (Member::max('id') ?? 0) + 1;

        $memberId = 'MEM-' . str_pad(
            $nextId,
            6,
            '0',
            STR_PAD_LEFT
        );


        /*
        |--------------------------------------------------------------------------
        | Create Member
        |--------------------------------------------------------------------------
        */

        $church->members()->create([
            ...$validated,
            'member_id' => $memberId,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('church.members.index')
            ->with(
                'success',
                'Member added successfully.'
            );
    }

    /**
     * Download the member import template.
     */
    public function downloadTemplate()
    {
        $headers = [
            'first_name',
            'middle_name',
            'last_name',
            'email',
            'phone',
            'address',
            'date_of_birth',
            'gender',
            'marital_status',
            'joined_at',
            'membership_type',
            'membership_status',
            'emergency_contact_name',
            'emergency_contact_phone',
            'emergency_contact_relationship',
            'notes',
        ];

        $filename = 'churchflow_members_template.csv';

        $callback = function () use ($headers) {
            $file = fopen('php://output', 'w');

            fputcsv($file, $headers);

            fputcsv($file, [
                'John',
                'Michael',
                'Doe',
                'john@example.com',
                '08012345678',
                '123 Example Street, Lagos',
                '1990-01-15',
                'male',
                'single',
                '2026-09-11',
                'member',
                'active',
                'Jane Doe',
                '08087654321',
                'Spouse',
                'Sample member record',
            ]);

            fclose($file);
        };

        return response()->streamDownload(
            $callback,
            $filename,
            [
                'Content-Type' => 'text/csv',
            ]
        );
    }

    /**
     * Import members from a CSV file.
     */
    public function importStore(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:csv,txt',
                'max:5120',
            ],
        ]);

        $user = $request->user();
        $church = $user->church;

        if (!$church) {
            return back()->with(
                'error',
                'Your account is not associated with a church.'
            );
        }

        $file = $request->file('file');

        $handle = fopen($file->getRealPath(), 'r');

        if (!$handle) {
            return back()->with(
                'error',
                'The uploaded file could not be opened.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Read CSV Header
        |--------------------------------------------------------------------------
        */

        $headers = fgetcsv($handle);

        if (!$headers) {
            fclose($handle);

            return back()->with(
                'error',
                'The CSV file is empty.'
            );
        }

        $headers = array_map(
            fn ($header) => strtolower(trim($header)),
            $headers
        );

        $requiredHeaders = [
            'first_name',
            'last_name',
        ];

        foreach ($requiredHeaders as $requiredHeader) {
            if (!in_array($requiredHeader, $headers, true)) {
                fclose($handle);

                return back()->with(
                    'error',
                    "The CSV file is missing the required column: {$requiredHeader}."
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Import Members
        |--------------------------------------------------------------------------
        */

        $imported = 0;
        $skipped = 0;

        while (($row = fgetcsv($handle)) !== false) {

            /*
            |----------------------------------------------------------------------
            | Skip Empty Rows
            |----------------------------------------------------------------------
            */

            if (
                count(array_filter(
                    $row,
                    fn ($value) => trim((string) $value) !== ''
                )) === 0
            ) {
                continue;
            }

            /*
            |----------------------------------------------------------------------
            | Match CSV Columns
            |----------------------------------------------------------------------
            */

            $data = [];

            foreach ($headers as $index => $header) {
                $data[$header] = isset($row[$index])
                    ? trim($row[$index])
                    : null;
            }

            /*
            |----------------------------------------------------------------------
            | Validate Required Fields
            |----------------------------------------------------------------------
            */

            if (
                empty($data['first_name']) ||
                empty($data['last_name'])
            ) {
                $skipped++;

                continue;
            }

            /*
            |----------------------------------------------------------------------
            | Prevent Duplicate Email
            |----------------------------------------------------------------------
            */

            if (!empty($data['email'])) {

                $existingMember = $church->members()
                    ->where('email', $data['email'])
                    ->exists();

                if ($existingMember) {
                    $skipped++;

                    continue;
                }
            }

            /*
            |----------------------------------------------------------------------
            | Create Member
            |----------------------------------------------------------------------
            */

            $church->members()->create([

                'first_name' => $data['first_name'],

                'middle_name' => $data['middle_name'] ?? null,

                'last_name' => $data['last_name'],

                'email' => $data['email'] ?? null,

                'phone' => $data['phone'] ?? null,

                'address' => $data['address'] ?? null,

                'date_of_birth' => !empty($data['date_of_birth'])
                    ? $data['date_of_birth']
                    : null,

                'gender' => $data['gender'] ?? null,

                'marital_status' => $data['marital_status'] ?? null,

                'joined_at' => !empty($data['joined_at'])
                    ? $data['joined_at']
                    : now(),

                'membership_type' => $data['membership_type'] ?? 'member',

                'membership_status' => $data['membership_status'] ?? 'active',

                'emergency_contact_name' =>
                    $data['emergency_contact_name'] ?? null,

                'emergency_contact_phone' =>
                    $data['emergency_contact_phone'] ?? null,

                'emergency_contact_relationship' =>
                    $data['emergency_contact_relationship'] ?? null,

                'notes' => $data['notes'] ?? null,
            ]);

            $imported++;
        }

        fclose($handle);

        /*
        |--------------------------------------------------------------------------
        | Import Result
        |--------------------------------------------------------------------------
        */

        $message = "{$imported} member(s) imported successfully.";

        if ($skipped > 0) {
            $message .= " {$skipped} row(s) were skipped.";
        }

        return redirect()
            ->route('church.members.index')
            ->with('success', $message);
    }

    /**
 * Export all church members to CSV.
 */
public function export(Request $request)
{
    $user = $request->user();
    $church = $user->church;

    if (!$church) {
        return back()->with(
            'error',
            'Your account is not associated with a church.'
        );
    }

    $members = $church->members()
        ->orderBy('first_name')
        ->orderBy('last_name')
        ->get();

    $filename = 'churchflow_members_' . now()->format('Y-m-d_H-i-s') . '.csv';

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ];

    $callback = function () use ($members) {

        $file = fopen('php://output', 'w');

        /*
        |--------------------------------------------------------------------------
        | CSV Header
        |--------------------------------------------------------------------------
        */

        fputcsv($file, [
            'first_name',
            'middle_name',
            'last_name',
            'email',
            'phone',
            'address',
            'date_of_birth',
            'gender',
            'marital_status',
            'joined_at',
            'membership_type',
            'membership_status',
            'emergency_contact_name',
            'emergency_contact_phone',
            'emergency_contact_relationship',
            'notes',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Member Records
        |--------------------------------------------------------------------------
        */

        foreach ($members as $member) {

            fputcsv($file, [
                $member->first_name,
                $member->middle_name,
                $member->last_name,
                $member->email,
                $member->phone,
                $member->address,
                $member->date_of_birth?->format('Y-m-d'),
                $member->gender,
                $member->marital_status,
                $member->joined_at?->format('Y-m-d'),
                $member->membership_type,
                $member->membership_status,
                $member->emergency_contact_name,
                $member->emergency_contact_phone,
                $member->emergency_contact_relationship,
                $member->notes,
            ]);
        }

        fclose($file);
    };

    return response()->stream(
        $callback,
        200,
        $headers
    );
}

/**
 * Show the member import page.
 */
public function import(): View
{
    return view('church.members.import');
}
}