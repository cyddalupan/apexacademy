<?php

namespace App\Http\Controllers;

use App\Models\EmployeeTraining;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        $employeeId = request()->user()->id;

        $trainings = EmployeeTraining::where('employee_id', $employeeId)
            ->with('trainingModule')
            ->latest()
            ->get();

        return view('employee.dashboard', compact('trainings'));
    }
}
