<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\GenericNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class SettingController extends Controller
{
    public function index()
    {
        /** @var Setting|null $settings */
        $settings = Setting::query()->first();

        if ($settings === null) {
            $settings = Setting::query()->create([
                'store_name' => 'Fashion Hub',
                'currency' => 'PKR',
                'timezone' => 'Asia/Karachi',
            ]);
        }

        $user = Auth::user();

        $systemInfo = [
            'laravel' => app()->version(),
            'php' => PHP_VERSION,
            'environment' => app()->environment(),
            'debug' => config('app.debug') ? 'Enabled' : 'Disabled',
        ];

        return view('admin.settings.index', compact('settings', 'user', 'systemInfo'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'store_name' => ['required', 'string', 'max:255'],
            'store_email' => ['nullable', 'email', 'max:255'],
            'store_phone' => ['nullable', 'string', 'max:30'],
            'store_address' => ['nullable', 'string', 'max:1000'],
            'currency' => ['required', Rule::in(['PKR', 'USD', 'GBP', 'EUR', 'AED', 'SAR'])],
            'timezone' => ['required', 'timezone'],
        ]);

        /** @var Setting|null $settings */
        $settings = Setting::query()->first();

        if ($settings === null) {
            $settings = new Setting();
        }

        $settings->fill($validated);
        $settings->save();

        if (Auth::check() && Auth::user()->role === 'admin') {
            Auth::user()->notify(new GenericNotification(
                title: 'General Settings Updated',
                message: 'Store configuration settings have been updated successfully.',
                type: 'success',
                url: route('admin.settings.index')
            ));
        }

        return redirect()->route('admin.settings.index')->with('success', 'General settings updated successfully.');
    }

    public function updateNotifications(Request $request)
    {
        $request->merge([
            'notify_new_orders' => $request->boolean('notify_new_orders'),
            'notify_low_stock' => $request->boolean('notify_low_stock'),
            'notify_new_customers' => $request->boolean('notify_new_customers'),
        ]);

        $validated = $request->validate([
            'notify_new_orders' => ['required', 'boolean'],
            'notify_low_stock' => ['required', 'boolean'],
            'notify_new_customers' => ['required', 'boolean'],
        ]);

        /** @var Setting|null $settings */
        $settings = Setting::query()->first();

        if ($settings === null) {
            $settings = new Setting([
                'store_name' => 'Fashion Hub',
                'currency' => 'PKR',
                'timezone' => 'Asia/Karachi',
            ]);
        }

        $settings->fill($validated);
        $settings->save();

        if (Auth::check() && Auth::user()->role === 'admin') {
            Auth::user()->notify(new GenericNotification(
                title: 'Notification Preferences Updated',
                message: 'Your system notification event preferences have been modified.',
                type: 'info',
                url: route('admin.settings.index')
            ));
        }

        return redirect()->route('admin.settings.index')->with('success', 'Notification preferences updated successfully.');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        if ($user === null) {
            abort(401);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        $user->notify(new GenericNotification(
            title: 'Profile Updated',
            message: 'Your administrator profile details were successfully updated.',
            type: 'success',
            url: route('admin.settings.index')
        ));

        return redirect()->route('admin.settings.index')->with('success', 'Admin profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        if ($user === null) {
            abort(401);
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        $user->notify(new GenericNotification(
            title: 'Password Changed',
            message: 'Your administrator account password was recently changed.',
            type: 'warning',
            url: route('admin.settings.index')
        ));

        return redirect()->route('admin.settings.index')->with('success', 'Password changed successfully.');
    }
}
