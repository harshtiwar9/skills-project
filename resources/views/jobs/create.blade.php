@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 text-gray-800 dark:text-gray-200">
    @if(auth()->check() && auth()->user()->role === 'poster')
        <h1 class="text-2xl font-bold mb-4">Post a New Job</h1>

        <form method="POST" action="{{ route('jobs.store') }}">
            @csrf

            <!-- Form fields for creating a new job -->
            <div>
                <x-input-label for="summary" :value="__('Job Title')" />
                <input id="summary"
                    class="block mt-1 w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    type="text"
                    name="summary"
                    required />
            </div>

            <div class="mt-4">
                <x-input-label for="body" :value="__('Job Description')" />
                <textarea id="body" name="body"
                    class="block mt-1 w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    required></textarea>
            </div>

            <div class="mt-4 flex justify-start space-x-4">
                <x-primary-button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    {{ __('Post Job') }}
                </x-primary-button>

                <!-- Cancel Button -->
                <a href="{{ route('jobs.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Cancel
                </a>
            </div>
        </form>
    @else
        <p class="text-red-500">You are not authorized to create a job.</p>
    @endif
</div>
@endsection
