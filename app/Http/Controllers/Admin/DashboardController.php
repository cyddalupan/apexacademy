<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use App\Models\Position;
use App\Models\TrainingModule;
use App\Models\EmployeeTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $companyId = request()->get('_company_id');
        $company = Company::findOrFail($companyId);

        $stats = [
            'employee_count' => User::byCompany($companyId)->byRole('employee')->count(),
            'position_count' => Position::where('company_id', $companyId)->count(),
            'training_count' => TrainingModule::where('company_id', $companyId)->count(),
            'flagged_count' => EmployeeTraining::whereIn('employee_id', 
                User::byCompany($companyId)->byRole('employee')->pluck('id')
            )->where('status', 'flagged')->count(),
        ];

        return view('admin.dashboard', compact('stats', 'company'));
    }

    public function employees()
    {
        $companyId = request()->get('_company_id');
        $employees = User::byCompany($companyId)
            ->byRole('employee')
            ->with('position')
            ->latest()
            ->paginate(15);
        return view('admin.employees.index', compact('employees'));
    }

    public function employeesCreate()
    {
        $companyId = request()->get('_company_id');
        $positions = Position::where('company_id', $companyId)->get();
        return view('admin.employees.create', compact('positions'));
    }

    public function employeesStore(Request $request)
    {
        $companyId = request()->get('_company_id');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'position_id' => 'nullable|exists:positions,id',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'employee',
            'company_id' => $companyId,
            'position_id' => $validated['position_id'],
            'status' => 'active',
        ]);

        return redirect('/admin/employees')
            ->with('status', 'Employee created successfully');
    }

    public function employeesShow(User $employee)
    {
        $companyId = request()->get('_company_id');

        if ($employee->company_id !== $companyId) {
            abort(403);
        }

        $employee->load('position', 'trainings.trainingModule');
        return view('admin.employees.show', compact('employee'));
    }

    public function employeesEdit(User $employee)
    {
        $companyId = request()->get('_company_id');

        if ($employee->company_id !== $companyId) {
            abort(403);
        }

        $positions = Position::where('company_id', $companyId)->get();
        return view('admin.employees.edit', compact('employee', 'positions'));
    }

    public function employeesUpdate(Request $request, User $employee)
    {
        $companyId = request()->get('_company_id');

        if ($employee->company_id !== $companyId) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $employee->id,
            'position_id' => 'nullable|exists:positions,id',
        ]);

        $employee->update($validated);

        return redirect('/admin/employees')
            ->with('status', 'Employee updated successfully');
    }

    public function positions()
    {
        $companyId = request()->get('_company_id');
        $positions = Position::where('company_id', $companyId)
            ->withCount('employees')
            ->latest()
            ->paginate(15);
        return view('admin.positions.index', compact('positions'));
    }

    public function positionsCreate()
    {
        return view('admin.positions.create');
    }

    public function positionsStore(Request $request)
    {
        $companyId = request()->get('_company_id');

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Position::create([
            'company_id' => $companyId,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? '',
        ]);

        return redirect('/admin/positions')
            ->with('status', 'Position created successfully');
    }

    public function positionsShow(Position $position)
    {
        $companyId = request()->get('_company_id');

        if ($position->company_id !== $companyId) {
            abort(403);
        }

        $position->load('employees', 'trainingModules');
        return view('admin.positions.show', compact('position'));
    }

    public function positionsEdit(Position $position)
    {
        $companyId = request()->get('_company_id');

        if ($position->company_id !== $companyId) {
            abort(403);
        }

        return view('admin.positions.edit', compact('position'));
    }

    public function positionsUpdate(Request $request, Position $position)
    {
        $companyId = request()->get('_company_id');

        if ($position->company_id !== $companyId) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $position->update($validated);

        return redirect('/admin/positions')
            ->with('status', 'Position updated successfully');
    }
}
