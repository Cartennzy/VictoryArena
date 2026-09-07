<?php

if (!function_exists('canMenu')) {
    /**
     * Permission helper untuk menu
     * BUKAN security (security tetap di middleware)
     */
    function canMenu(string $permission): bool
    {
        $role = auth()->user()->role ?? null;

        $permissions = [
            'admin' => [
                'dashboard',
                'customers',
                'reservations',
                'reports',
            ],
            'customer' => [
                'dashboard',
                'booking',
                'schedule',
            ],
        ];

        return in_array($permission, $permissions[$role] ?? []);
    }
}
