<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    // Show all active jobs
    public function index(Request $request)
    {
        $threshold = now()->subMonths(2); // Jobs posted in the last 2 months

        // Fetch jobs for posters, sorted by posted_date in descending order
        $jobs = Job::where('posted_date', '>=', $threshold)
                   ->orderBy('posted_date', 'desc')
                   ->paginate(10);

        // Redirect to page 1 if the requested page number is invalid
        if ($request->has('page') && $request->page > $jobs->lastPage()) {
            return redirect()->route('jobs.index', ['page' => 1]);
        }

        return view('jobs.index', compact('jobs'));
    }

    // Show form to create a new job
    public function create()
    {
        return view('jobs.create');
    }

    // Store a new job
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'poster') {
            return redirect()->route('jobs.index')->with('error', 'You are not authorized to create a job.');
        }

        $request->validate([
            'summary' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        Job::create([
            'summary' => $request->summary,
            'body' => $request->body,
            'posted_by' => Auth::id(),
        ]);

        return redirect()->route('jobs.index')->with('success', 'Job created successfully!');
    }

    // Show a specific job
    public function show(Job $job)
    {
        return view('jobs.show', compact('job'));
    }

    // Show form to edit a job
    public function edit(Job $job)
    {
        if ($job->posted_by != Auth::id()) {
            return redirect()->route('jobs.index')->with('error', 'You are not authorized to edit this job.');
        }
        return view('jobs.edit', compact('job'));
    }

    // Update a job
    public function update(Request $request, Job $job)
    {
        if (Auth::id() !== $job->posted_by || Auth::user()->role !== 'poster') {
            return redirect()->route('jobs.index')->with('error', 'You are not authorized to edit this job.');
        }

        $request->validate([
            'summary' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $job->update([
            'summary' => $request->summary,
            'body' => $request->body,
        ]);

        return redirect()->route('jobs.index')->with('success', 'Job updated successfully!');
    }

    // Delete a job
    public function destroy(Job $job)
    {
        if (Auth::id() !== $job->posted_by || Auth::user()->role !== 'poster') {
            return redirect()->route('jobs.index')->with('error', 'You are not authorized to delete this job.');
        }

        $job->delete();

        return redirect()->route('jobs.index')->with('success', 'Job deleted successfully!');
    }

    // Let a user express interest in a job
    public function expressInterest(Job $job)
    {
        $user = Auth::user();

        // Attach the user to the job's interested users if not already attached
        if (!$job->interestedUsers->contains($user->id)) {
            $job->interestedUsers()->attach($user->id);
        }

        // Redirect back to the job index page with a success message
        return redirect()->route('jobs.index')->with('success', 'You have successfully expressed interest in the job: ' . $job->summary);
    }

    // Let a user revert interest in a job
    public function revertInterest(Job $job)
    {
        $user = Auth::user();

        // Detach the user from the job's interested users
        if ($job->interestedUsers->contains($user->id)) {
            $job->interestedUsers()->detach($user->id);
        }

        // Redirect back to the job index page with a warning message
        return redirect()->route('jobs.index')->with('warning', 'Your interest in the job "' . $job->summary . '" has been reverted.');
    }

    // Show all inactive jobs
    public function inactiveJobs(Request $request)
    {
        // Check if the user is authenticated and is a poster
        if (!Auth::check() || Auth::user()->role !== 'poster') {
            return redirect()->route('jobs.index')->with('warning', 'You are not authorized to view inactive jobs.');
        }

        $threshold = now()->subMonths(2); // Jobs older than 2 months
        $jobs = Job::where('posted_date', '<', $threshold)->paginate(10);

        // Redirect to page 1 if the requested page number is invalid
        if ($request->has('page') && $request->page > $jobs->lastPage()) {
            return redirect()->route('jobs.inactive', ['page' => 1]);
        }

        return view('jobs.inactive', compact('jobs'));
    }
}
