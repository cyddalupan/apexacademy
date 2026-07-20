<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Position;
use App\Models\TrainingModule;
use App\Models\EmployeeTraining;

class DashboardController extends Controller
{
    public function index()
    {
        $companyId = request()->get('_company_id');

        $stats = [
            'employee_count' => User::byCompany($companyId)->employee()->count(),
            'position_count' => Position::where('company_id', $companyId)->count(),
            'training_count' => TrainingModule::where('company_id', $companyId)->count(),
            'flagged_count' => EmployeeTraining::whereIn('employee_id', 
                User::byCompany($companyId)->employee()->pluck('id')
            )->where('status', 'flagged')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
