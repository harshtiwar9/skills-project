@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 text-gray-800 dark:text-gray-200">
    <!-- Toast Notification -->
    @if(session('success'))
        <div id="toast" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @elseif(session('warning'))
        <div id="toast" class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
            {{ session('warning') }}
        </div>
    @elseif(session('error'))
        <div id="toast" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <script>
        // Automatically hide the toast after 3 seconds
        setTimeout(() => {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.style.display = 'none';
            }
        }, 3000);
    </script>

    <!-- Show title based on user role -->
    <h1 class="text-2xl font-bold mb-4">
        @if(auth()->check() && auth()->user()->role === 'poster')
            Active Jobs
        @else
            Available Jobs
        @endif
    </h1>

    @if($jobs->count() > 0)
        <p class="mb-4">Total Jobs: <strong>{{ $jobs->total() }}</strong></p> <!-- Job count -->

        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-800 text-left">
                    <th class="border border-gray-300 px-4 py-2">#</th>
                    <th class="border border-gray-300 px-4 py-2">Job Title</th>
                    <th class="border border-gray-300 px-4 py-2">Description</th>
                    <th class="border border-gray-300 px-4 py-2">Posted Date</th>
                    @if(auth()->check() && auth()->user()->role === 'poster')
                        <th class="border border-gray-300 px-4 py-2 text-center">Posted By</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Interest Expressed</th>
                    @else
                        <th class="border border-gray-300 px-4 py-2 text-center">Your Interest</th>
                    @endif
                    <th class="border border-gray-300 px-4 py-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jobs as $index => $job)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="border border-gray-300 px-4 py-2">{{ $index + $jobs->firstItem() }}</td> <!-- Job index -->
                        <td class="border border-gray-300 px-4 py-2">{{ $job->summary }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ Str::limit($job->body, 50) }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $job->posted_date->format('M d, Y') }}</td>
                        @if(auth()->check() && auth()->user()->role === 'poster')
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                {{-- Show "You" for the logged-in user's jobs, otherwise show the poster's name --}}
                                @if(auth()->id() === $job->posted_by)
                                    You
                                @else
                                    {{ $job->poster->name }}
                                @endif
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                {{-- Show interest count for all posters --}}
                                @if($job->interestedUsers->count() > 0)
                                    <span class="bg-green-100 text-green-800 text-sm font-semibold px-2.5 py-0.5 rounded">
                                        {{ $job->interestedUsers->count() }} Interested
                                    </span>
                                @else
                                    <span class="text-gray-500 text-sm">No interest yet</span>
                                @endif
                            </td>
                        @else
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                {{-- Viewer Perspective: Show if the viewer has expressed interest --}}
                                @if(auth()->check() && $job->interestedUsers->contains(auth()->id()))
                                    <span class="bg-green-100 text-green-800 text-sm font-semibold px-2.5 py-0.5 rounded">
                                        Yes
                                    </span>
                                @endif
                            </td>
                        @endif
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            {{-- Buttons for viewers --}}
                            {{-- View Details button (visible to everyone) --}}
                            <a href="{{ route('jobs.show', $job->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">View</a>

                            {{-- Buttons for the poster only --}}
                            @if(auth()->check() && auth()->id() === $job->posted_by)
                                <a href="{{ route('jobs.edit', $job->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 ml-2">Edit</a>
                                <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Are you sure you want to delete this job?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6">
            {{ $jobs->links() }} <!-- Pagination -->
        </div>
    @else
        <div class="text-gray-600 mt-8 p-4 bg-gray-100 border rounded text-center">
            @if(auth()->check() && auth()->user()->role === 'poster')
                <p class="mb-4">You haven’t posted any jobs yet.</p>
                <a href="{{ route('jobs.create') }}"
                   class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Post a New Job
                </a>
            @else
                <p>No jobs are available at the moment. Please check back later.</p>
            @endif
        </div>
    @endif
</div>
@endsection
