@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 text-gray-800 dark:text-gray-200">
    <h1 class="text-2xl font-bold mb-2">{{ $job->summary }}</h1>

    <p class="mb-4">{{ $job->body }}</p>

    <p class="text-sm mb-6">Posted on: {{ \Carbon\Carbon::parse($job->posted_date)->format('M d, Y') }}</p>

    <!-- If user is a viewer, show 'Express Interest' button -->
    @if(auth()->check() && auth()->user()->role === 'viewer')
        <form method="POST" action="{{ route('jobs.interest', $job->id) }}">
            @csrf
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                Express Interest
            </button>
        </form>
    @endif

    <!-- If user is the poster, show interested users -->
    @if(auth()->check() && auth()->user()->id === $job->posted_by)
        <h3 class="mt-6 font-semibold">Interested Users:</h3>
        @if($job->interestedUsers->isEmpty())
            <p>No one has expressed interest yet.</p>
        @else
            <ul class="list-disc pl-6">
                @foreach($job->interestedUsers as $user)
                    <li>{{ $user->name }} ({{ $user->email }})</li>
                @endforeach
            </ul>
        @endif
    @endif

    <a href="{{ route('jobs.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">
        ← Back to job listings
    </a>
</div>
@endsection
<!-- This code is a Blade template for displaying a job posting in a Laravel application.
