<?php

use App\Models\Role;
use Spatie\Permission\DefaultTeamResolver;
use Spatie\Permission\Models\Permission;

return [

    'models' => [

        /*
         * When using the "HasPermissions" trait from this package, we need to know which
         * Eloquent model should be used to retrieve your permissions.
         */

        'permission' => Permission::class,

        /*
         * When using the "HasRoles" trait from this package, we use our custom
         * Role model so ChurchFlow can support church-specific roles.
         */

        'role' => Role::class,

        /*
         * Teams are not being used. ChurchFlow handles tenancy through church_id.
         */

        'team' => null,

        /*
         * Default model used when resolving model IDs.
         */

        'default_model' => null,
    ],

    'table_names' => [

        /*
         * Role and permission tables.
         */

        'roles' => 'roles',

        'permissions' => 'permissions',

        'model_has_permissions' => 'model_has_permissions',

        'model_has_roles' => 'model_has_roles',

        'role_has_permissions' => 'role_has_permissions',
    ],

    'column_names' => [

        /*
         * Pivot column names.
         */

        'role_pivot_key' => null,

        'permission_pivot_key' => null,

        /*
         * Polymorphic model key.
         */

        'model_morph_key' => 'model_id',

        /*
         * Teams are disabled.
         */

        'team_foreign_key' => 'team_id',
    ],

    /*
     * Register the permission check method on Laravel's Gate.
     */

    'register_permission_check_method' => true,

    /*
     * Reset permissions when using Laravel Octane.
     */

    'register_octane_reset_listener' => false,

    /*
     * Enable role and permission events.
     */

    'events_enabled' => false,

    /*
     * Teams are disabled because ChurchFlow uses church_id
     * for multi-tenancy.
     */

    'teams' => false,

    /*
     * Team resolver.
     */

    'team_resolver' => DefaultTeamResolver::class,

    /*
     * Passport client credentials.
     */

    'use_passport_client_credentials' => false,

    /*
     * Hide permission names in exception messages.
     */

    'display_permission_in_exception' => false,

    /*
     * Hide role names in exception messages.
     */

    'display_role_in_exception' => false,

    /*
     * Wildcard permissions are disabled.
     */

    'enable_wildcard_permission' => false,

    /*
     * Custom wildcard permission class.
     */

    // 'wildcard_permission' => Spatie\Permission\WildcardPermission::class,

    /*
     * Cache-specific settings.
     */

    'cache' => [

        /*
         * Cache permissions and roles for 24 hours.
         */

        'expiration_time' => DateInterval::createFromDateString('24 hours'),

        /*
         * Permission cache key.
         */

        'key' => 'spatie.permission.cache',

        /*
         * Use the default cache store.
         */

        'store' => 'default',
    ],
];