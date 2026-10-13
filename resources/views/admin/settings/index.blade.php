@extends('layouts.app')
@section('title', 'Settings - Fashion Hub')
@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <p class="text-sm text-amber-400 font-semibold mb-2">
                ADMINISTRATION
            </p>

            <h1 class="text-3xl font-bold text-white">
                Settings
            </h1>

            <p class="text-stone-400 mt-2">
                Manage your store, administrator account, security and preferences.
            </p>
        </div>

        @include('components.alerts')

        <section id="general" class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-6 mb-6">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-white">
                    General Settings
                </h2>
                <p class="text-sm text-stone-400 mt-1">
                    Configure your store information and regional preferences.
                </p>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="block text-sm text-stone-300 mb-2">
                            Store Name
                        </label>
                        <input type="text" name="store_name" value="{{ old('store_name', $settings->store_name) }}"
                            required maxlength="255"
                            class="w-full rounded-xl bg-stone-950 border border-stone-700 text-white px-4 py-3 focus:border-amber-500 focus:ring-amber-500">
                    </div>

                    <div>
                        <label class="block text-sm text-stone-300 mb-2">
                            Store Email
                        </label>
                        <input type="email" name="store_email" value="{{ old('store_email', $settings->store_email) }}"
                            class="w-full rounded-xl bg-stone-950 border border-stone-700 text-white px-4 py-3 focus:border-amber-500">
                    </div>

                    <div>
                        <label class="block text-sm text-stone-300 mb-2">
                            Phone Number
                        </label>
                        <input type="text" name="store_phone" value="{{ old('store_phone', $settings->store_phone) }}"
                            class="w-full rounded-xl bg-stone-950 border border-stone-700 text-white px-4 py-3 focus:border-amber-500">
                    </div>

                    <div>
                        <label class="block text-sm text-stone-300 mb-2">
                            Currency
                        </label>
                        <select name="currency" required
                            class="w-full rounded-xl bg-stone-950 border border-stone-700 text-white px-4 py-3">
                            @foreach ([
            'PKR' => 'PKR - Pakistani Rupee',
            'USD' => 'USD - US Dollar',
            'GBP' => 'GBP - British Pound',
            'EUR' => 'EUR - Euro',
            'AED' => 'AED - UAE Dirham',
            'SAR' => 'SAR - Saudi Riyal',
        ] as $code => $label)
                                <option value="{{ $code }}" @selected(old('currency', $settings->currency) === $code)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm text-stone-300 mb-2">
                            Store Address
                        </label>
                        <textarea name="store_address" rows="3"
                            class="w-full rounded-xl bg-stone-950 border border-stone-700 text-white px-4 py-3 focus:border-amber-500">{{ old('store_address', $settings->store_address) }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm text-stone-300 mb-2">
                            Timezone
                        </label>
                        <input type="text" name="timezone" value="{{ old('timezone', $settings->timezone) }}"
                            placeholder="Asia/Karachi" required
                            class="w-full rounded-xl bg-stone-950 border border-stone-700 text-white px-4 py-3 focus:border-amber-500">
                        <p class="text-xs text-stone-500 mt-2">
                            Use a valid PHP timezone, such as Asia/Karachi.
                        </p>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="bg-amber-500 hover:bg-amber-400 text-stone-950 font-bold px-6 py-3 rounded-xl transition">
                        Save General Settings
                    </button>
                </div>
            </form>
        </section>

        <section id="profile" class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-6 mb-6">
            <h2 class="text-xl font-bold text-white">
                Admin Profile
            </h2>
            <p class="text-sm text-stone-400 mt-1 mb-6">
                Update your administrator account information.
            </p>

            <form action="{{ route('admin.settings.profile') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm text-stone-300 mb-2">
                            Full Name
                        </label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full rounded-xl bg-stone-950 border border-stone-700 text-white px-4 py-3">
                    </div>

                    <div>
                        <label class="block text-sm text-stone-300 mb-2">
                            Email Address
                        </label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full rounded-xl bg-stone-950 border border-stone-700 text-white px-4 py-3">
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="bg-amber-500 hover:bg-amber-400 text-stone-950 font-bold px-6 py-3 rounded-xl">
                        Update Profile
                    </button>
                </div>
            </form>
        </section>

        <section id="security" class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-6 mb-6">
            <h2 class="text-xl font-bold text-white">
                Security
            </h2>
            <p class="text-sm text-stone-400 mt-1 mb-6">
                Change your password to keep your account secure.
            </p>

            <form action="{{ route('admin.settings.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm text-stone-300 mb-2">
                            Current Password
                        </label>
                        <input type="password" name="current_password" required autocomplete="current-password"
                            class="w-full rounded-xl bg-stone-950 border border-stone-700 text-white px-4 py-3">
                    </div>

                    <div>
                        <label class="block text-sm text-stone-300 mb-2">
                            New Password
                        </label>
                        <input type="password" name="password" required minlength="8" autocomplete="new-password"
                            class="w-full rounded-xl bg-stone-950 border border-stone-700 text-white px-4 py-3">
                    </div>

                    <div>
                        <label class="block text-sm text-stone-300 mb-2">
                            Confirm New Password
                        </label>
                        <input type="password" name="password_confirmation" required minlength="8"
                            autocomplete="new-password"
                            class="w-full rounded-xl bg-stone-950 border border-stone-700 text-white px-4 py-3">
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="bg-amber-500 hover:bg-amber-400 text-stone-950 font-bold px-6 py-3 rounded-xl">
                        Change Password
                    </button>
                </div>
            </form>
        </section>

        <section id="notifications" class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-6 mb-6">
            <h2 class="text-xl font-bold text-white">
                Notification Preferences
            </h2>
            <p class="text-sm text-stone-400 mt-1 mb-6">
                Choose which events you want the application to track for notifications.
            </p>

            <form action="{{ route('admin.settings.notifications') }}" method="POST">
                @csrf
                @method('PUT')

                @php
                    $notificationOptions = [
                        'notify_new_orders' => ['New orders', 'Track when customers place orders.'],
                        'notify_low_stock' => ['Low inventory', 'Track products that need restocking.'],
                        'notify_new_customers' => ['New customers', 'Track newly registered customers.'],
                    ];
                @endphp

                <div class="space-y-5">
                    @foreach ($notificationOptions as $field => $option)
                        <label class="flex items-start gap-4 cursor-pointer">
                            <input type="checkbox" name="{{ $field }}" value="1"
                                @checked(old($field, $settings->$field))
                                class="mt-1 h-5 w-5 rounded border-stone-600 bg-stone-950 text-amber-500 focus:ring-amber-500">
                            <span>
                                <span class="block text-white font-medium">
                                    {{ $option[0] }}
                                </span>
                                <span class="block text-sm text-stone-400 mt-1">
                                    {{ $option[1] }}
                                </span>
                            </span>
                        </label>
                    @endforeach
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="bg-amber-500 hover:bg-amber-400 text-stone-950 font-bold px-6 py-3 rounded-xl">
                        Save Notifications
                    </button>
                </div>
            </form>
        </section>

        <section id="system" class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-6 mb-6">
            <h2 class="text-xl font-bold text-white">
                System Information
            </h2>
            <p class="text-sm text-stone-400 mt-1 mb-6">
                Technical information about your application environment.
            </p>

            <div class="divide-y divide-stone-800">
                @foreach ([
            'Application' => 'Fashion Hub',
            'Laravel Version' => $systemInfo['laravel'],
            'PHP Version' => $systemInfo['php'],
            'Environment' => $systemInfo['environment'],
            'Debug Mode' => $systemInfo['debug'],
        ] as $label => $value)
                    <div
                        class="flex flex-col sm:flex-row
                            sm:items-center sm:justify-between gap-2 py-4">
                        <span class="text-stone-400">{{ $label }}</span>
                        <span class="text-white font-medium">{{ $value }}</span>
                    </div>
                @endforeach
            </div>

            <p class="text-xs text-stone-500 mt-4">
                For production deployments, keep debug mode disabled.
            </p>
        </section>
    </div>
@endsection
