<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            // Members
            'members.view',
            'members.create',
            'members.update',
            'members.delete',

            // Attendance
            'attendance.view',
            'attendance.create',
            'attendance.update',
            'attendance.delete',

            // Services
            'services.view',
            'services.create',
            'services.update',
            'services.delete',

            // Income
            'income.view',
            'income.create',
            'income.update',
            'income.delete',

            // Expenses
            'expenses.view',
            'expenses.create',
            'expenses.update',
            'expenses.delete',

            // Billing
            'billing.view',
            'billing.create',
            'billing.update',
            'billing.delete',

            // Financial Settings
            'financial-settings.view',
            'financial-settings.update',

            // Groups
            'groups.view',
            'groups.create',
            'groups.update',
            'groups.delete',

            // Users
            'users.view',
            'users.create',
            'users.update',
            'users.delete',

            // Roles
            'roles.view',
            'roles.create',
            'roles.update',
            'roles.delete',

            // Audit Logs
            'audit-logs.view',

            // Reports
            'reports.view',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $churchOwner = Role::firstOrCreate(
            [
                'name' => 'church_owner',
                'guard_name' => 'web',
            ],
            [
                'church_id' => null,
            ]
        );

        $churchOwner->syncPermissions($permissions);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}