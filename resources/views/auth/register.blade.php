@extends('layouts.auth')

@section('content')
<div class="mb-6 text-center">
    <h2 class="text-xl font-semibold tracking-wide text-white">Create Account</h2>
    <p class="text-xs text-stone-400 mt-1">Join the Fashion Hub collection dashboard</p>
</div>

@if ($errors->any())
    <div class="mb-4 text-xs p-3 rounded-lg bg-rose-500/10 border border-rose-500/20 text-rose-400">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('register') }}" class="space-y-4">
    @csrf

    <div>
        <label for="name" class="block text-[11px] uppercase tracking-wider font-semibold text-stone-400 mb-2">Full Name</label>
        <input 
            id="name" 
            type="text" 
            name="name" 
            value="{{ old('name') }}" 
            required 
            autofocus 
            placeholder="Alexander McQueen"
            class="w-full px-4 py-3 bg-stone-950/60 border border-stone-800 rounded-xl text-sm text-stone-200 placeholder-stone-600 focus:outline-none focus:border-amber-400 transition duration-200">
    </div>

    <div>
        <label for="email" class="block text-[11px] uppercase tracking-wider font-semibold text-stone-400 mb-2">Email Address</label>
        <input 
            id="email" 
            type="email" 
            name="email" 
            value="{{ old('email') }}" 
            required 
            placeholder="designer@fashionhub.com"
            class="w-full px-4 py-3 bg-stone-950/60 border border-stone-800 rounded-xl text-sm text-stone-200 placeholder-stone-600 focus:outline-none focus:border-amber-400 transition duration-200">
    </div>

    <div>
        <label for="password" class="block text-[11px] uppercase tracking-wider font-semibold text-stone-400 mb-2">Password</label>
        <input 
            id="password" 
            type="password" 
            name="password" 
            required 
            placeholder="••••••••"
            class="w-full px-4 py-3 bg-stone-950/60 border border-stone-800 rounded-xl text-sm text-stone-200 placeholder-stone-600 focus:outline-none focus:border-amber-400 transition duration-200">
    </div>

    <div>
        <label for="password_confirmation" class="block text-[11px] uppercase tracking-wider font-semibold text-stone-400 mb-2">Confirm Password</label>
        <input 
            id="password_confirmation" 
            type="password" 
            name="password_confirmation" 
            required 
            placeholder="••••••••"
            class="w-full px-4 py-3 bg-stone-950/60 border border-stone-800 rounded-xl text-sm text-stone-200 placeholder-stone-600 focus:outline-none focus:border-amber-400 transition duration-200">
    </div>

    <button type="submit" class="w-full py-3.5 mt-2 bg-amber-400 hover:bg-amber-300 text-stone-950 font-semibold text-xs uppercase tracking-widest rounded-xl transition duration-200 shadow-lg shadow-amber-400/10">
        Create Account
    </button>
</form>

<div class="mt-6 pt-6 border-t border-stone-800/60 text-center">
    <p class="text-xs text-stone-400">
        Already have an account? 
        <a href="{{ route('login') }}" class="text-amber-400 hover:text-amber-300 font-medium transition">Sign In</a>
    </p>
</div>
@endsection