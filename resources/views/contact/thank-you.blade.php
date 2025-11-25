@extends('layouts.app')

@section('title', 'Thank You - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-white dark:bg-dark-bg transition-colors duration-300 relative isolate overflow-hidden flex items-center justify-center">
    <!-- Particles Background -->
    <canvas id="particles-canvas" class="absolute inset-0 -z-10 h-full w-full opacity-50"></canvas>

    <div class="mx-auto max-w-2xl px-6 py-24 sm:px-6 sm:py-32 lg:px-8 text-center">
        <div class="bg-white/50 dark:bg-[#101010]/50 backdrop-blur-xl rounded-3xl p-8 md:p-12 border border-gray-100 dark:border-0 shadow-sm">
            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30 mb-8">
                <svg class="h-10 w-10 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold tracking-tight text-black dark:text-white sm:text-4xl mb-4">
                Message Sent!
            </h1>
            
            <p class="text-lg leading-8 text-gray-600 dark:text-gray-300 mb-10">
                Thank you for reaching out. We've received your message and will get back to you as soon as possible.
            </p>
            
            <div class="flex items-center justify-center gap-x-6 mt-2">
                <a href="{{ route('home') }}" class="rounded-xl bg-black px-8 py-3 text-sm font-semibold text-white  hover:bg-gray-800  dark:bg-white dark:text-black dark:hover:bg-gray-200 transition-all duration-200">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
