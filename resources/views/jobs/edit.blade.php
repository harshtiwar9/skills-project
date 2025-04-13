@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 text-gray-800 dark:text-gray-200">
    @if(auth()->check() && auth()->user()->id === $job->posted_by && auth()->user()->role === 'poster')
        <h1 class="text-2xl font-bold mb-4">Edit Job</h1>

        <form method="POST" action="{{ route('jobs.update', $job->id) }}">
            @csrf
            @method('PUT')

            <!-- Form fields for editing the job -->
            <div>
                <x-input-label for="summary" :value="__('Job Title')" />
                <x-text-input id="summary" class="block mt-1 w-full" type="text" name="summary" value="{{ $job->summary }}" required />
            </div>

            <div class="mt-4">
                <x-input-label for="body" :value="__('Job Description')" />
                <textarea id="body" name="body" class="block mt-1 w-full" required>{{ $job->body }}</textarea>
            </div>

            <div class="mt-4 flex justify-between">
                <x-primary-button>
                    {{ __('Update Job') }}
                </x-primary-button>

                <!-- Cancel Button -->
                <a href="{{ route('jobs.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Cancel
                </a>
            </div>
        </form>
    @else
        <p class="text-red-500">You are not authorized to edit this job.</p>
    @endif
</div>
@endsection
