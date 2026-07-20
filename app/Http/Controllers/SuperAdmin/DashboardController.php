<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_companies' => Company::count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_employees' => User::where('role', 'employee')->count(),
            'active_companies' => Company::where('status', 'active')->count(),
        ];

        return view('super-admin.dashboard', compact('stats'));
    }
}
