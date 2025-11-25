@extends('layouts.app')

@section('title', 'Contact Us - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-white dark:bg-dark-bg transition-colors duration-300 relative isolate overflow-hidden">
    <!-- Particles Background -->
    <canvas id="particles-canvas" class="absolute inset-0 -z-10 h-full w-full opacity-50"></canvas>

    <div class="mx-auto max-w-7xl px-6 lg:px-8 py-24 sm:py-32">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-16 gap-y-16">
            
            <!-- Left Column: Text Content -->
            <div class="flex flex-col justify-center">
                <h1 class="text-5xl md:text-7xl font-bold tracking-tight text-black dark:text-white mb-6">
                    Contact us.
                </h1>
                <h2 class="text-3xl md:text-4xl font-semibold text-gray-400 dark:text-gray-500 mb-8">
                    We're here to help.
                </h2>
                <div class="space-y-4 text-lg text-gray-600 dark:text-gray-300">
                    <p>Reach out for support or inquiries.</p>
                    <p>We respond within 24 hours.</p>
                </div>

                <div class="mt-12 flex gap-6">
                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-bold uppercase tracking-wider text-gray-400">Email</span>
                        <a href="mailto:hello@example.com" class="text-xl font-medium text-black dark:text-white hover:underline">hello@example.com</a>
                    </div>
                </div>
            </div>

            <!-- Right Column: Form -->
            <div class="bg-white/50 dark:bg-[#101010]/50 backdrop-blur-xl rounded-3xl p-8 md:p-12 border border-gray-100 dark:border-0">
                <h3 class="text-2xl font-bold text-black dark:text-white mb-2">Send us a message</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-8">We'll get back soon</p>

                <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                    @csrf
                    @if(session('success'))
                        <div class="p-4 rounded-xl bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 text-sm font-medium">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                        <input type="text" name="name" id="name" required 
                               class="block w-full rounded-xl border-0 px-4 py-3 text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 dark:text-white dark:ring-0 sm:text-sm sm:leading-6 transition-all duration-200 bg-white/50 dark:bg-black/20">
                    </div>

                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <input type="email" name="email" id="email" required 
                               class="block w-full rounded-xl border-0 px-4 py-3 text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 dark:text-white dark:ring-0 sm:text-sm sm:leading-6 transition-all duration-200 bg-white/50 dark:bg-black/20">
                    </div>

                    <div class="space-y-2">
                        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                        <textarea name="message" id="message" rows="4" required 
                                  class="block w-full rounded-xl border-0 px-4 py-3 text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 dark:text-white dark:ring-0 sm:text-sm sm:leading-6 transition-all duration-200 bg-white/50 dark:bg-black/20"></textarea>
                    </div>

                    <button type="submit" 
                            class="w-full rounded-xl bg-black px-4 py-4 text-sm font-bold text-white shadow-lg hover:bg-gray-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black dark:bg-white dark:text-black dark:hover:bg-gray-200 transition-all duration-200 transform hover:scale-[1.02]">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
