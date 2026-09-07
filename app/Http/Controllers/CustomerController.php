<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'user')
            ->latest()
            ->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer)
    {
        abort_if($customer->role !== 'user', 404);

        return view('admin.customers.show', compact('customer'));
    }

    public function edit(User $customer)
    {
        abort_if($customer->role !== 'user', 404);

        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, User $customer)
    {
        abort_if($customer->role !== 'user', 404);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($customer->id),
            ],
        ]);

        $customer->update($validated);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    public function confirmDelete(User $customer)
    {
        abort_if($customer->role !== 'user', 404);

        return view('admin.customers.delete', compact('customer'));
    }

    public function destroy(User $customer)
    {
        abort_if($customer->role !== 'user', 404);
        $customer->delete();

        return redirect()->route('admin.customers.index')->with('success', 'Customer deleted successfully.');
    }
}
