<?php

namespace App\Http\Controllers\Church;

use App\Http\Controllers\Controller;
use App\Models\ChurchFinancialSetting;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FinancialSettingController extends Controller
{
    /**
     * Display church financial settings.
     */
    public function edit(): View
    {
        $user = Auth::user();
        $church = $user?->church;

        abort_unless($church, 403);

        $financialSetting = ChurchFinancialSetting::firstOrCreate(
            ['church_id' => $church->id],
            [
                'opening_balance' => 0,
                'opening_balance_date' => now()->toDateString(),
            ]
        );

        return view('church.settings.financial', [
            'user' => $user,
            'church' => $church,
            'financialSetting' => $financialSetting,
        ]);
    }

    /**
     * Update church financial settings.
     */
    public function update(
        Request $request,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $user = Auth::user();
        $church = $user?->church;

        abort_unless($church, 403);

        $validated = $request->validate([
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
        ]);

        $financialSetting = ChurchFinancialSetting::updateOrCreate(
            ['church_id' => $church->id],
            [
                'opening_balance' => $validated['opening_balance'],
                'opening_balance_date' => $validated['opening_balance_date'],
            ]
        );

        $activityLog->record(
            action: 'updated',
            subject: $financialSetting,
            description: sprintf(
                'Financial settings updated. Opening balance: ₦%s, opening balance date: %s.',
                number_format(
                    (float) $financialSetting->opening_balance,
                    2
                ),
                $financialSetting->opening_balance_date?->format('d M Y')
            )
        );

        return redirect()
            ->route('church.settings.financial.edit')
            ->with(
                'success',
                'Opening balance updated successfully.'
            );
    }
}