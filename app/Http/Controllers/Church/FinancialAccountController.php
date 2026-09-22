<?php

namespace App\Http\Controllers\Church;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\FinancialAccount;
use App\Models\Income;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FinancialAccountController extends Controller
{
    /**
     * Display all financial accounts for the current church.
     */
    public function index(): View
    {
        $user = Auth::user();
        $church = $user?->church;

        abort_unless($church, 403);
        abort_unless($user->can('financial-settings.view'), 403);

        $accounts = FinancialAccount::query()
            ->where('church_id', $church->id)
            ->orderByDesc('is_default')
            ->orderBy('name')
            ->get();

        $totalBalance = $accounts->sum(
            fn (FinancialAccount $account) => $account->current_balance
        );

        return view('church.settings.financial-accounts.index', [
            'user' => $user,
            'church' => $church,
            'accounts' => $accounts,
            'totalBalance' => $totalBalance,
        ]);
    }

    /**
     * Show the create financial account form.
     */
    public function create(): View
    {
        $user = Auth::user();
        $church = $user?->church;

        abort_unless($church, 403);
        abort_unless($user->can('financial-settings.update'), 403);

        return view('church.settings.financial-accounts.create', [
            'user' => $user,
            'church' => $church,
        ]);
    }

    /**
     * Store a new financial account.
     */
    public function store(
        Request $request,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $user = Auth::user();
        $church = $user?->church;

        abort_unless($church, 403);
        abort_unless($user->can('financial-settings.update'), 403);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'type' => [
                'required',
                'in:bank,cash,mobile_money,pos,other',
            ],
            'provider_name' => [
                'nullable',
                'string',
                'max:255',
            ],
            'account_number' => [
                'nullable',
                'string',
                'max:100',
            ],
            'opening_balance' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999999999.99',
            ],
            'opening_balance_date' => [
                'required',
                'date',
            ],
            'currency' => [
                'required',
                'string',
                'size:3',
            ],
            'is_default' => [
                'nullable',
                'boolean',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        $nameExists = FinancialAccount::query()
            ->where('church_id', $church->id)
            ->where('name', $validated['name'])
            ->exists();

        if ($nameExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'name' => 'An account with this name already exists.',
                ]);
        }

        $isFirstAccount = ! FinancialAccount::query()
            ->where('church_id', $church->id)
            ->exists();

        $isDefault = $isFirstAccount || (bool) ($validated['is_default'] ?? false);

        if ($isDefault) {
            FinancialAccount::query()
                ->where('church_id', $church->id)
                ->update(['is_default' => false]);
        }

        $account = FinancialAccount::create([
            'church_id' => $church->id,
            'name' => $validated['name'],
            'type' => $validated['type'],
            'provider_name' => $validated['provider_name'] ?? null,
            'account_number' => $validated['account_number'] ?? null,
            'opening_balance' => $validated['opening_balance'],
            'opening_balance_date' => $validated['opening_balance_date'],
            'currency' => strtoupper($validated['currency']),
            'is_default' => $isDefault,
            'is_active' => $validated['is_active'] ?? true,
            'notes' => $validated['notes'] ?? null,
        ]);

        $activityLog->record(
            action: 'created',
            subject: $account,
            description: sprintf(
                'Financial account "%s" created with opening balance of ₦%s.',
                $account->name,
                number_format((float) $account->opening_balance, 2)
            )
        );

        return redirect()
            ->route('church.settings.financial-accounts.index')
            ->with('success', 'Financial account created successfully.');
    }

    /**
     * Show the edit financial account form.
     */
    public function edit(FinancialAccount $financialAccount): View
    {
        $user = Auth::user();
        $church = $user?->church;

        abort_unless($church, 403);
        abort_unless($user->can('financial-settings.update'), 403);

        $this->ensureBelongsToChurch($financialAccount, $church->id);

        return view('church.settings.financial-accounts.edit', [
            'user' => $user,
            'church' => $church,
            'account' => $financialAccount,
        ]);
    }

    /**
     * Update a financial account.
     */
    public function update(
        Request $request,
        FinancialAccount $financialAccount,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $user = Auth::user();
        $church = $user?->church;

        abort_unless($church, 403);
        abort_unless($user->can('financial-settings.update'), 403);

        $this->ensureBelongsToChurch($financialAccount, $church->id);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'type' => [
                'required',
                'in:bank,cash,mobile_money,pos,other',
            ],
            'provider_name' => [
                'nullable',
                'string',
                'max:255',
            ],
            'account_number' => [
                'nullable',
                'string',
                'max:100',
            ],
            'opening_balance' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999999999.99',
            ],
            'opening_balance_date' => [
                'required',
                'date',
            ],
            'currency' => [
                'required',
                'string',
                'size:3',
            ],
            'is_default' => [
                'nullable',
                'boolean',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        $nameExists = FinancialAccount::query()
            ->where('church_id', $church->id)
            ->where('name', $validated['name'])
            ->whereKeyNot($financialAccount->id)
            ->exists();

        if ($nameExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'name' => 'An account with this name already exists.',
                ]);
        }

        $isDefault = (bool) ($validated['is_default'] ?? false);

        if ($isDefault) {
            FinancialAccount::query()
                ->where('church_id', $church->id)
                ->whereKeyNot($financialAccount->id)
                ->update(['is_default' => false]);
        }

        /*
         * Prevent the church from ending up with no default account
         * when this is currently the default account.
         */
        if ($financialAccount->is_default && ! $isDefault) {
            $replacementDefaultExists = FinancialAccount::query()
                ->where('church_id', $church->id)
                ->whereKeyNot($financialAccount->id)
                ->where('is_active', true)
                ->exists();

            if ($replacementDefaultExists) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'is_default' => 'Please set another active account as the default before removing this account as the default.',
                    ]);
            }

            $isDefault = true;
        }

        $financialAccount->update([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'provider_name' => $validated['provider_name'] ?? null,
            'account_number' => $validated['account_number'] ?? null,
            'opening_balance' => $validated['opening_balance'],
            'opening_balance_date' => $validated['opening_balance_date'],
            'currency' => strtoupper($validated['currency']),
            'is_default' => $isDefault,
            'is_active' => $validated['is_active'] ?? false,
            'notes' => $validated['notes'] ?? null,
        ]);

        $activityLog->record(
            action: 'updated',
            subject: $financialAccount,
            description: sprintf(
                'Financial account "%s" updated.',
                $financialAccount->name
            )
        );

        return redirect()
            ->route('church.settings.financial-accounts.index')
            ->with('success', 'Financial account updated successfully.');
    }

    /**
     * Delete a financial account.
     */
    public function destroy(
        FinancialAccount $financialAccount,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $user = Auth::user();
        $church = $user?->church;

        abort_unless($church, 403);
        abort_unless($user->can('financial-settings.update'), 403);

        $this->ensureBelongsToChurch($financialAccount, $church->id);

        $hasIncome = Income::query()
            ->where('church_id', $church->id)
            ->where('financial_account_id', $financialAccount->id)
            ->exists();

        $hasExpenses = Expense::query()
            ->where('church_id', $church->id)
            ->where('financial_account_id', $financialAccount->id)
            ->exists();

        if ($hasIncome || $hasExpenses) {
            return back()->with(
                'error',
                'This account cannot be deleted because it has financial transactions. You can deactivate it instead.'
            );
        }

        if ($financialAccount->is_default) {
            $replacement = FinancialAccount::query()
                ->where('church_id', $church->id)
                ->whereKeyNot($financialAccount->id)
                ->where('is_active', true)
                ->orderBy('name')
                ->first();

            if ($replacement) {
                $replacement->update(['is_default' => true]);
            }
        }

        $accountName = $financialAccount->name;

        $financialAccount->delete();

        $activityLog->record(
            action: 'deleted',
            subject: null,
            description: sprintf(
                'Financial account "%s" deleted.',
                $accountName
            )
        );

        return redirect()
            ->route('church.settings.financial-accounts.index')
            ->with('success', 'Financial account deleted successfully.');
    }

    /**
     * Set an account as the church's default account.
     */
    public function setDefault(
        FinancialAccount $financialAccount,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $user = Auth::user();
        $church = $user?->church;

        abort_unless($church, 403);
        abort_unless($user->can('financial-settings.update'), 403);

        $this->ensureBelongsToChurch($financialAccount, $church->id);

        if (! $financialAccount->is_active) {
            return back()->with(
                'error',
                'An inactive account cannot be set as the default account.'
            );
        }

        FinancialAccount::query()
            ->where('church_id', $church->id)
            ->update(['is_default' => false]);

        $financialAccount->update([
            'is_default' => true,
        ]);

        $activityLog->record(
            action: 'updated',
            subject: $financialAccount,
            description: sprintf(
                'Financial account "%s" set as the default account.',
                $financialAccount->name
            )
        );

        return back()->with(
            'success',
            'Default financial account updated successfully.'
        );
    }

    /**
     * Activate a financial account.
     */
    public function activate(
        FinancialAccount $financialAccount,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $user = Auth::user();
        $church = $user?->church;

        abort_unless($church, 403);
        abort_unless($user->can('financial-settings.update'), 403);

        $this->ensureBelongsToChurch($financialAccount, $church->id);

        $financialAccount->update([
            'is_active' => true,
        ]);

        $activityLog->record(
            action: 'updated',
            subject: $financialAccount,
            description: sprintf(
                'Financial account "%s" activated.',
                $financialAccount->name
            )
        );

        return back()->with(
            'success',
            'Financial account activated successfully.'
        );
    }

    /**
     * Deactivate a financial account.
     */
    public function deactivate(
        FinancialAccount $financialAccount,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $user = Auth::user();
        $church = $user?->church;

        abort_unless($church, 403);
        abort_unless($user->can('financial-settings.update'), 403);

        $this->ensureBelongsToChurch($financialAccount, $church->id);

        if ($financialAccount->is_default) {
            return back()->with(
                'error',
                'The default account cannot be deactivated. Set another active account as default first.'
            );
        }

        $financialAccount->update([
            'is_active' => false,
        ]);

        $activityLog->record(
            action: 'updated',
            subject: $financialAccount,
            description: sprintf(
                'Financial account "%s" deactivated.',
                $financialAccount->name
            )
        );

        return back()->with(
            'success',
            'Financial account deactivated successfully.'
        );
    }

    /**
     * Ensure the account belongs to the authenticated church.
     */
    private function ensureBelongsToChurch(
        FinancialAccount $financialAccount,
        int $churchId
    ): void {
        abort_unless(
            (int) $financialAccount->church_id === $churchId,
            404
        );
    }
}