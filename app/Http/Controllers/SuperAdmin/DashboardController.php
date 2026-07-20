<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

    public function companies()
    {
        $companies = Company::withCount('users')->latest()->paginate(15);
        return view('super-admin.companies.index', compact('companies'));
    }

    public function companiesCreate()
    {
        return view('super-admin.companies.create');
    }

    public function companiesStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'nullable|string|max:255|unique:companies,domain',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|max:255|unique:users,email',
        ]);

        $company = Company::create([
            'name' => $validated['name'],
            'domain' => $validated['domain'],
        ]);

        User::create([
            'name' => $validated['admin_name'],
            'email' => $validated['admin_email'],
            'password' => Hash::make(Str::random(16)),
            'role' => 'admin',
            'company_id' => $company->id,
            'status' => 'active',
        ]);

        return redirect('/super-admin/companies')
            ->with('status', 'Company created successfully');
    }

    public function companiesShow(Company $company)
    {
        $company->loadCount('users');
        return view('super-admin.companies.show', compact('company'));
    }

    public function companiesEdit(Company $company)
    {
        return view('super-admin.companies.edit', compact('company'));
    }

    public function companiesUpdate(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'nullable|string|max:255|unique:companies,domain,' . $company->id,
        ]);

        $company->update($validated);

        return redirect('/super-admin/companies')
            ->with('status', 'Company updated successfully');
    }

    public function companiesSuspend(Company $company)
    {
        $company->update(['status' => 'suspended']);
        return redirect('/super-admin/companies')
            ->with('status', 'Company suspended');
    }

    public function companiesActivate(Company $company)
    {
        $company->update(['status' => 'active']);
        return redirect('/super-admin/companies')
            ->with('status', 'Company activated');
    }

    public function companiesAdmins(Company $company)
    {
        $admins = User::byCompany($company->id)->where('role', 'admin')->get();
        return view('super-admin.companies.admins', compact('admins', 'company'));
    }
}
