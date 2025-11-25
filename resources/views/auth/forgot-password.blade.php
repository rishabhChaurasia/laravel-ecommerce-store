@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="flex min-h-screen items-center justify-center px-4 py-12 sm:px-6 lg:px-8 bg-gray-50 dark:bg-zinc-950">
    <div class="w-full max-w-sm">
        <div class="rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-zinc-900 p-8">
            <div class="flex flex-col items-center mb-6">
                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-gray-100 dark:bg-zinc-800 mb-4">
                    <svg class="w-6 h-6 text-gray-900 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-semibold tracking-tight text-gray-900 dark:text-white text-center">
                    Forgot your password?
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 text-center">
                    No problem. Just let us know your email address and we will email you a password reset link.
                </p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 rounded-md bg-green-50 dark:bg-green-900/20 p-3">
                    <p class="text-sm text-green-800 dark:text-green-400">{{ session('status') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <!-- Email -->
                <div class="space-y-2">
                    <label for="email" class="text-sm font-medium text-gray-900 dark:text-white">
                        Email
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        placeholder="m@example.com"
                        required
                        autofocus
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-zinc-950 text-gray-900 dark:text-white placeholder:text-gray-500 dark:placeholder:text-gray-400 focus:ring-1 focus:ring-gray-400 dark:focus:ring-gray-600 focus:border-gray-400 dark:focus:border-gray-600"
                    />
                    @error('email')
                        <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full inline-flex items-center justify-center rounded-md bg-gray-900 dark:bg-white px-4 py-2 text-sm font-medium text-white dark:text-gray-900 transition-colors hover:bg-gray-800 dark:hover:bg-gray-100"
                >
                    Email Password Reset Link
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
                Remember your password?
                <a href="{{ route('login') }}" class="font-medium text-gray-900 dark:text-white hover:underline">
                    Sign in
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
