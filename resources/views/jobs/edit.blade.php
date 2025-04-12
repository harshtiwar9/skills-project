@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Job</h1>

    <form action="{{ route('jobs.update', $job->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-medium">Job Title</label>
            <input type="text" name="summary" class="w-full border p-2 rounded" value="{{ old('summary', $job->summary) }}">
            @error('summary')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium">Job Description</label>
            <textarea name="body" class="w-full border p-2 rounded" rows="5">{{ old('body', $job->body) }}</textarea>
            @error('body')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Update Job</button>
        <a href="{{ route('jobs.index') }}" class="ml-4 text-blue-500 hover:underline">Cancel</a>
    </form>
</div>
@endsection
