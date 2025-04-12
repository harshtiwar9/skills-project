@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 text-gray-800 dark:text-gray-200">
    <h1 class="text-2xl font-bold mb-4">Inactive Jobs</h1>

    @if($jobs->count() > 0)
        <p class="mb-4">Total Inactive Jobs: <strong>{{ $jobs->total() }}</strong></p> <!-- Job count -->

        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-800 text-left">
                    <th class="border border-gray-300 px-4 py-2">#</th>
                    <th class="border border-gray-300 px-4 py-2">Job Title</th>
                    <th class="border border-gray-300 px-4 py-2">Description</th>
                    <th class="border border-gray-300 px-4 py-2">Posted Date</th>
                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jobs as $index => $job)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="border border-gray-300 px-4 py-2">{{ $index + $jobs->firstItem() }}</td> <!-- Job index -->
                        <td class="border border-gray-300 px-4 py-2">{{ $job->summary }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ Str::limit($job->body, 50) }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $job->posted_date->format('M d, Y') }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <a href="{{ route('jobs.show', $job->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                View
                            </a>
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
            <p>No inactive jobs are available at the moment.</p>
        </div>
    @endif
</div>
@endsection
