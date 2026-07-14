<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $query = Company::query();

        if ($request->has('status')) {
            $query->where('status', $request->boolean('status'));
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $companies = $query->paginate(15);

        return $this->success($companies);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'trade_name' => 'nullable|string|max:255',
            'document' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:2',
            'zip_code' => 'nullable|string|max:10',
            'status' => 'boolean',
            'logo' => 'nullable|string',
            'settings' => 'nullable|array',
        ]);

        $company = Company::create($validated);

        return $this->success($company, 'Company created successfully', 201);
    }

    public function show(Company $company)
    {
        return $this->success($company->load(['users', 'clients', 'servers']));
    }

    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'trade_name' => 'nullable|string|max:255',
            'document' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:2',
            'zip_code' => 'nullable|string|max:10',
            'status' => 'sometimes|boolean',
            'logo' => 'nullable|string',
            'settings' => 'nullable|array',
        ]);

        $company->update($validated);

        return $this->success($company, 'Company updated successfully');
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return $this->success(null, 'Company deleted successfully');
    }
}
