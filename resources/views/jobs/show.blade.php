@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 text-gray-800 dark:text-gray-200">
    <!-- Display the job title and description -->
    <h1 class="text-2xl font-bold mb-2">{{ $job->summary }}</h1>
    <p class="mb-4">{{ $job->body }}</p>

    <!-- Display the job's posted date -->
    <p class="text-sm mb-2">Posted on: {{ \Carbon\Carbon::parse($job->posted_date)->format('M d, Y') }}</p>

    <!-- Display the poster's information -->
    <p class="text-sm mb-6">Posted by:
        @if(auth()->check() && auth()->id() === $job->posted_by)
            <!-- Show "You (Poster Name - email)" if the logged-in user is the poster -->
            <strong>You</strong> ({{ auth()->user()->name }} - {{ auth()->user()->email }})
        @else
            <!-- Show the poster's name and email for other users -->
            <strong>{{ $job->postedBy->name ?? 'Unknown' }}</strong>
            ({{ $job->postedBy->email ?? 'No email available' }})
        @endif
    </p>

    <!-- Viewer actions: Express or revert interest -->
    @if(auth()->check() && auth()->user()->role === 'viewer')
        @if($job->interestedUsers->contains(auth()->id()))
            <!-- Show 'Revert Interest' button if the viewer has already expressed interest -->
            <form method="POST" action="{{ route('jobs.revertInterest', $job->id) }}">
                @csrf
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">
                    Revert Interest
                </button>
            </form>
        @else
            <!-- Show 'Express Interest' button if the viewer has not expressed interest -->
            <form method="POST" action="{{ route('jobs.interest', $job->id) }}">
                @csrf
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Express Interest
                </button>
            </form>
        @endif
    @endif

    <!-- Poster actions: Show a list of interested users -->
    @if(auth()->check() && auth()->user()->id === $job->posted_by)
        <h3 class="mt-6 font-semibold">Interested Users:</h3>
        @if($job->interestedUsers->isEmpty())
            <!-- Show a message if no users have expressed interest -->
            <p>No one has expressed interest yet.</p>
        @else
            <!-- List all users who have expressed interest -->
            <ul class="list-disc pl-6">
                @foreach($job->interestedUsers as $user)
                    <li>{{ $user->name }} ({{ $user->email }})</li>
                @endforeach
            </ul>
        @endif
    @endif

    <!-- Back to job listings link -->
    <a href="{{ route('jobs.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">
        ← Back to job listings
    </a>
</div>
@endsection
