<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function perPage(int $default = 15, array $allowed = [10, 15, 25, 50, 100]): int
    {
        $perPage = (int) request()->query('per_page', $default);

        return in_array($perPage, $allowed, true) ? $perPage : $default;
    }
}
