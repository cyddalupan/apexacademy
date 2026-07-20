<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function redirect()
    {
        $user = request()->user();

        return match ($user->role) {
            'super_admin' => redirect('/super-admin/dashboard'),
            'admin' => redirect('/admin/dashboard'),
            default => redirect('/dashboard/employee'),
        };
    }
}
