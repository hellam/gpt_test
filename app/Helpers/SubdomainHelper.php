<?php

namespace App\Helpers;

class SubdomainHelper
{
    public static function reserved(): array
    {
        return [
            'admin', 'superadmin', 'api', 'www', 'root',
            'saas', 'system', 'login', 'dashboard', 'test'
        ];
    }

    public static function isReserved(string $slug): bool
    {
        return in_array(strtolower($slug), static::reserved());
    }
}
