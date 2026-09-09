<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::with('user')->latest()->paginate(10);

        return view('admin.vendors.index', compact('vendors'));
    }
    public function create()
    {
        return view('admin.vendors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'store_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:30',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'status' => [
                'required',
                Rule::in([
                    'pending',
                    'active',
                    'suspended',
                    'rejected',
                ]),
            ],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'vendor',
        ]);

        $logo = null;
        $banner = null;

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo')->store('vendors/logos', 'public');
        }

        if ($request->hasFile('banner')) {
            $banner = $request->file('banner')->store('vendors/banners', 'public');
        }

        Vendor::create([
            'user_id' => $user->id,
            'store_name' => $validated['store_name'],
            'slug' => $this->generateUniqueSlug($validated['store_name']),
            'description' => $validated['description'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'logo' => $logo,
            'banner' => $banner,
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'state' => $validated['state'] ?? null,
            'country' => $validated['country'] ?? null,
            'postal_code' => $validated['postal_code'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor created successfully.');
    }

    public function show(Vendor $vendor)
    {
        $vendor->load(['user','products.category']);

        return view('admin.vendors.show', compact('vendor'));
    }

    public function edit(Vendor $vendor)
    {
        $vendor->load('user');

        return view('admin.vendors.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($vendor->user_id),
            ],

            'password' => 'nullable|string|min:8|confirmed',
            'store_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:30',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',

            'status' => [
                'required',
                Rule::in([
                    'pending',
                    'active',
                    'suspended',
                    'rejected',
                ]),
            ],
        ]);

        $vendor->user->name = $validated['name'];
        $vendor->user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $vendor->user->password = $validated['password'];
        }

        $vendor->user->save();

        if ($vendor->store_name !== $validated['store_name']) {
            $vendor->slug = $this->generateUniqueSlug($validated['store_name'], $vendor->id);
        }

        if ($request->hasFile('logo')) {
            if ($vendor->logo) {
                Storage::disk('public')->delete($vendor->logo);
            }
            $vendor->logo = $request->file('logo')->store('vendors/logos', 'public');
        }

        if ($request->hasFile('banner')) {
            if ($vendor->banner) {
                Storage::disk('public')->delete($vendor->banner);
            }

            $vendor->banner = $request->file('banner')->store('vendors/banners', 'public');
        }

        $vendor->store_name = $validated['store_name'];
        $vendor->description = $validated['description'] ?? null;
        $vendor->phone = $validated['phone'] ?? null;
        $vendor->address = $validated['address'] ?? null;
        $vendor->city = $validated['city'] ?? null;
        $vendor->state = $validated['state'] ?? null;
        $vendor->country = $validated['country'] ?? null;
        $vendor->postal_code = $validated['postal_code'] ?? null;
        $vendor->status = $validated['status'];

        $vendor->save();

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor updated successfully.');
    }

    public function delete(Vendor $vendor)
    {
        $vendor->load(['user','products']);

        return view('admin.vendors.delete', compact('vendor'));
    }

    public function destroy(Vendor $vendor)
    {
        if ($vendor->products()->exists()) {
            return redirect()->route('admin.vendors.show', $vendor)->with('error','This vendor cannot be deleted because the vendor has products. Remove or reassign the products first.');
        }

        if ($vendor->logo) {
            Storage::disk('public')->delete($vendor->logo);
        }

        if ($vendor->banner) {
            Storage::disk('public')->delete($vendor->banner);
        }

        $user = $vendor->user;
        $vendor->delete();

        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor deleted successfully.');
    }

    private function generateUniqueSlug(string $storeName,?int $ignoreVendorId = null): string
    {
        $slug = Str::slug($storeName);
        $originalSlug = $slug;
        $counter = 1;

        while (Vendor::where('slug', $slug)->when($ignoreVendorId,fn ($query) => $query->where('id', '!=', $ignoreVendorId))->exists())
        {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
