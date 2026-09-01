@extends('layouts.auth')

@section('content')
<div class="mb-6 text-center">
    <h2 class="text-xl font-semibold tracking-wide text-white">Welcome Back</h2>
    <p class="text-xs text-stone-400 mt-1">Enter your credentials to access your account</p>
</div>

@if (session('status'))
    <div class="mb-4 text-xs p-3 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400">
        {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-4 text-xs p-3 rounded-lg bg-rose-500/10 border border-rose-500/20 text-rose-400">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('login') }}" class="space-y-4">
    @csrf

    <div>
        <label for="email" class="block text-[11px] uppercase tracking-wider font-semibold text-stone-400 mb-2">Email Address</label>
        <input 
            id="email" 
            type="email" 
            name="email" 
            value="{{ old('email') }}" 
            required 
            autofocus 
            placeholder="designer@fashionhub.com"
            class="w-full px-4 py-3 bg-stone-950/60 border border-stone-800 rounded-xl text-sm text-stone-200 placeholder-stone-600 focus:outline-none focus:border-amber-400 transition duration-200">
    </div>

    <div>
        <div class="flex justify-between items-center mb-2">
            <label for="password" class="block text-[11px] uppercase tracking-wider font-semibold text-stone-400">Password</label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-xs text-amber-400 hover:text-amber-300 transition">Forgot?</a>
            @endif
        </div>
        <input 
            id="password" 
            type="password" 
            name="password" 
            required 
            placeholder="••••••••"
            class="w-full px-4 py-3 bg-stone-950/60 border border-stone-800 rounded-xl text-sm text-stone-200 placeholder-stone-600 focus:outline-none focus:border-amber-400 transition duration-200">
    </div>

    <div class="flex items-center">
        <input 
            id="remember_me" 
            type="checkbox" 
            name="remember" 
            class="w-4 h-4 rounded bg-stone-950 border-stone-800 text-amber-400 focus:ring-0 focus:ring-offset-0">
        <label for="remember_me" class="ml-2 text-xs text-stone-400">Remember session</label>
    </div>

    <button type="submit" class="w-full py-3.5 mt-2 bg-amber-400 hover:bg-amber-300 text-stone-950 font-semibold text-xs uppercase tracking-widest rounded-xl transition duration-200 shadow-lg shadow-amber-400/10">
        Sign In
    </button>
</form>

<div class="mt-6 pt-6 border-t border-stone-800/60 text-center">
    <p class="text-xs text-stone-400">
        Don't have an account? 
        <a href="{{ route('register') }}" class="text-amber-400 hover:text-amber-300 font-medium transition">Register now</a>
    </p>
</div>
@endsection