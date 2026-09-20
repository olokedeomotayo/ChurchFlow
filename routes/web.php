<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ContactController;

use App\Http\Controllers\Admin\ChurchController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingsController;

use App\Http\Controllers\Church\ChurchDashboardController;
use App\Http\Controllers\Church\PaymentController;
use App\Http\Controllers\Church\MemberController;
use App\Http\Controllers\Church\GroupController;
use App\Http\Controllers\Church\CheckInController;
use App\Http\Controllers\Church\ServiceController;
use App\Http\Controllers\Church\AttendanceController;
use App\Http\Controllers\Church\IncomeController;
use App\Http\Controllers\Church\ExpenseController;
use App\Http\Controllers\Church\ReportController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'landing.index')
    ->name('landing');

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');


/*
|--------------------------------------------------------------------------
| Church Registration / Onboarding
|--------------------------------------------------------------------------
*/

Route::post('/register', [RegisterController::class, 'store'])
    ->name('register.store');


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Platform Admin Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('platform.admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | Churches
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'churches',
                ChurchController::class
            );


            /*
            |--------------------------------------------------------------------------
            | Church Account Actions
            |--------------------------------------------------------------------------
            */

            Route::patch(
                'churches/{church}/activate',
                [ChurchController::class, 'activate']
            )->name('churches.activate');

            Route::patch(
                'churches/{church}/suspend',
                [ChurchController::class, 'suspend']
            )->name('churches.suspend');

            Route::patch(
                'churches/{church}/extend-trial',
                [ChurchController::class, 'extendTrial']
            )->name('churches.extend-trial');


            /*
            |--------------------------------------------------------------------------
            | Subscription Plans
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'plans',
                PlanController::class
            )->only([
                'index',
                'create',
                'store',
                'edit',
                'update',
            ]);

            Route::patch(
                'plans/{plan}/activate',
                [PlanController::class, 'activate']
            )->name('plans.activate');

            Route::patch(
                'plans/{plan}/deactivate',
                [PlanController::class, 'deactivate']
            )->name('plans.deactivate');


            /*
            |--------------------------------------------------------------------------
            | Subscriptions
            |--------------------------------------------------------------------------
            */

            Route::get(
                'subscriptions',
                [SubscriptionController::class, 'index']
            )->name('subscriptions.index');

            Route::get(
                'subscriptions/{subscription}',
                [SubscriptionController::class, 'show']
            )->name('subscriptions.show');

            Route::patch(
                'subscriptions/{subscription}/activate',
                [SubscriptionController::class, 'activate']
            )->name('subscriptions.activate');

            Route::patch(
                'subscriptions/{subscription}/extend-trial',
                [SubscriptionController::class, 'extendTrial']
            )->name('subscriptions.extend-trial');

            Route::get(
                'subscriptions/{subscription}/change-plan',
                [SubscriptionController::class, 'changePlan']
            )->name('subscriptions.change-plan');

            Route::patch(
                'subscriptions/{subscription}/change-plan',
                [SubscriptionController::class, 'updatePlan']
            )->name('subscriptions.update-plan');

            Route::patch(
                'subscriptions/{subscription}/cancel',
                [SubscriptionController::class, 'cancel']
            )->name('subscriptions.cancel');

            Route::patch(
                'subscriptions/{subscription}/renew',
                [SubscriptionController::class, 'renew']
            )->name('subscriptions.renew');


            /*
            |--------------------------------------------------------------------------
            | System Settings
            |--------------------------------------------------------------------------
            */

            Route::get(
                'settings',
                [SettingsController::class, 'index']
            )->name('settings.index');


            /*
            |--------------------------------------------------------------------------
            | Platform Settings
            |--------------------------------------------------------------------------
            */

            Route::get(
                'settings/platform',
                [SettingsController::class, 'platform']
            )->name('settings.platform');

            Route::post(
                'settings/platform',
                [SettingsController::class, 'updatePlatform']
            )->name('settings.platform.update');


            /*
            |--------------------------------------------------------------------------
            | Subscription Settings
            |--------------------------------------------------------------------------
            */

            Route::get(
                'settings/subscription',
                [SettingsController::class, 'subscription']
            )->name('settings.subscription');

            Route::post(
                'settings/subscription',
                [SettingsController::class, 'updateSubscription']
            )->name('settings.subscription.update');


            /*
            |--------------------------------------------------------------------------
            | Payment Settings
            |--------------------------------------------------------------------------
            */

            Route::get(
                'settings/payment',
                [SettingsController::class, 'payment']
            )->name('settings.payment');

            Route::post(
                'settings/payment',
                [SettingsController::class, 'updatePayment']
            )->name('settings.payment.update');


            /*
            |--------------------------------------------------------------------------
            | Email Settings
            |--------------------------------------------------------------------------
            */

            Route::get(
                'settings/email',
                [SettingsController::class, 'email']
            )->name('settings.email');

            Route::post(
                'settings/email',
                [SettingsController::class, 'updateEmail']
            )->name('settings.email.update');


            /*
            |--------------------------------------------------------------------------
            | Security Settings
            |--------------------------------------------------------------------------
            */

            Route::get(
                'settings/security',
                [SettingsController::class, 'security']
            )->name('settings.security');

            Route::post(
                'settings/security',
                [SettingsController::class, 'updateSecurity']
            )->name('settings.security.update');


            /*
            |--------------------------------------------------------------------------
            | System Information
            |--------------------------------------------------------------------------
            */

            Route::get(
                'settings/system-information',
                [SettingsController::class, 'systemInformation']
            )->name('settings.system-information');

        });


    /*
    |--------------------------------------------------------------------------
    | Platform Admin Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )
        ->middleware('platform.admin')
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Church Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/church/dashboard',
        [ChurchDashboardController::class, 'index']
    )
        ->middleware('church.access')
        ->name('church.dashboard');


    /*
    |--------------------------------------------------------------------------
    | Church Payments
    |--------------------------------------------------------------------------
    */

    Route::middleware('church.access')
        ->prefix('church/payments')
        ->name('church.payments.')
        ->group(function () {

            Route::get(
                '/',
                [PaymentController::class, 'index']
            )->name('index');

            Route::post(
                '/{plan}/initialize',
                [PaymentController::class, 'initialize']
            )->name('initialize');

            Route::get(
                '/callback',
                [PaymentController::class, 'callback']
            )->name('callback');

        });


    /*
    |--------------------------------------------------------------------------
    | Church Management Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('church')
        ->name('church.')
        ->middleware('church.access')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | Members
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/members',
                [MemberController::class, 'index']
            )->name('members.index');

            Route::get(
                '/members/create',
                [MemberController::class, 'create']
            )->name('members.create');

            Route::post(
                '/members',
                [MemberController::class, 'store']
            )->name('members.store');

            Route::get(
                '/members/{member}',
                [MemberController::class, 'show']
            )->name('members.show');

            Route::get(
                '/members/{member}/edit',
                [MemberController::class, 'edit']
            )->name('members.edit');

            Route::put(
                '/members/{member}',
                [MemberController::class, 'update']
            )->name('members.update');


            /*
            |--------------------------------------------------------------------------
            | Member Import / Export
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/members/template',
                [MemberController::class, 'downloadTemplate']
            )->name('members.template');

            Route::get(
                '/members/import',
                [MemberController::class, 'import']
            )->name('members.import');

            Route::post(
                '/members/import',
                [MemberController::class, 'importStore']
            )->name('members.import.store');

            Route::get(
                '/members/export',
                [MemberController::class, 'export']
            )->name('members.export');


            /*
            |--------------------------------------------------------------------------
            | Groups & Departments
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/groups',
                [GroupController::class, 'index']
            )->name('groups.index');

            Route::get(
                '/groups/create',
                [GroupController::class, 'create']
            )->name('groups.create');

            Route::post(
                '/groups',
                [GroupController::class, 'store']
            )->name('groups.store');

            Route::get(
                '/groups/{group}/members/edit',
                [GroupController::class, 'editMembers']
            )->name('groups.members.edit');

            Route::put(
                '/groups/{group}/members',
                [GroupController::class, 'updateMembers']
            )->name('groups.members.update');

            Route::get(
                '/groups/{group}',
                [GroupController::class, 'show']
            )->name('groups.show');

            Route::get(
                '/groups/{group}/edit',
                [GroupController::class, 'edit']
            )->name('groups.edit');

            Route::put(
                '/groups/{group}',
                [GroupController::class, 'update']
            )->name('groups.update');

            Route::delete(
                '/groups/{group}',
                [GroupController::class, 'destroy']
            )->name('groups.destroy');


            /*
            |--------------------------------------------------------------------------
            | Check-In
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/check-in',
                [CheckInController::class, 'index']
            )->name('checkin.index');

            Route::post(
                '/check-in',
                [CheckInController::class, 'store']
            )->name('checkin.store');


            /*
            |--------------------------------------------------------------------------
            | Services
            |--------------------------------------------------------------------------
            */

            Route::resource(
                '/services',
                ServiceController::class
            )->names('services');


            /*
            |--------------------------------------------------------------------------
            | Attendance
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/attendance',
                [AttendanceController::class, 'index']
            )->name('attendance.index');


            /*
            |--------------------------------------------------------------------------
            | Income
            |--------------------------------------------------------------------------
            */

            // Income Import & Export
            Route::get('/income/export', [IncomeController::class, 'export'])
                ->name('income.export');

            Route::get('/income/import', [IncomeController::class, 'import'])
                ->name('income.import');

            Route::post('/income/import', [IncomeController::class, 'importStore'])
                ->name('income.import.store');

            Route::get('/income/template', [IncomeController::class, 'downloadTemplate'])
                ->name('income.template');

            // Income Resource
            Route::resource('/income', IncomeController::class)
                ->whereNumber('income')
                ->names('income');



            // =====================================================
            // EXPENSES
            // =====================================================

            Route::get('/expenses/export', [ExpenseController::class, 'export'])
                ->name('expenses.export');

            Route::get('/expenses/import', [ExpenseController::class, 'import'])
                ->name('expenses.import');

            Route::post('/expenses/import', [ExpenseController::class, 'importStore'])
                ->name('expenses.import.store');

            Route::get('/expenses/template', [ExpenseController::class, 'downloadTemplate'])
                ->name('expenses.template');

            Route::resource('/expenses', ExpenseController::class)
                ->whereNumber('expense')
                ->names('expenses');

            // =====================================================
            // REPORTS
            // =====================================================

            Route::get('/reports/export', [ReportController::class, 'export'])
                ->name('reports.export');

            /*
            |--------------------------------------------------------------------------
            | Reports
            |--------------------------------------------------------------------------
            */

            Route::get('/reports', [ReportController::class, 'index'])
                ->name('reports.index');

            Route::get('/reports/export', [ReportController::class, 'export'])
                ->name('reports.export');

            Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])
                ->name('reports.export.pdf');

        });

});