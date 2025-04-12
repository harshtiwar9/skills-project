@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 text-gray-800 dark:text-gray-200">
    @if(auth()->check() && auth()->user()->role === 'poster')
        <h1 class="text-2xl font-bold mb-4">Post a New Job</h1>

        <form action="{{ route('jobs.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-medium">Job Title</label>
                <input type="text" name="summary" class="w-full border p-2 rounded text-gray-800" value="{{ old('summary') }}">
                @error('summary')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-medium">Job Description</label>
                <textarea name="body" class="w-full border p-2 rounded text-gray-800" rows="5">{{ old('body') }}</textarea>
                @error('body')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Job</button>
        </form>
    @else
        <p class="text-red-500">You are not authorized to create a job.</p>
    @endif
</div>
@endsection
