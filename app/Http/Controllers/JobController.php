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
    public function index()
    {

        // Calculate the date 2 months ago
        $threshold = Carbon::now()->subMonths(2);

        // Get all jobs posted in the last 2 months if no jobs are posted
        $jobs = Job::where('posted_date', '>=', $threshold)
            ->orderBy('posted_date', 'desc')
            ->paginate(10);
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
        $request->validate([
            'summary' => 'required|max:255',
            'body' => 'required',
        ]);

        Job::create([
            'summary' => $request->summary,
            'body' => $request->body,
            'posted_by' => Auth::id(),
        ]);

        // Redirect to the jobs index with a success message
        return redirect()->route('jobs.index')->with('success', 'Job posted successfully!');
    }

    // Show a specific job
    public function show(Job $job)
    {
        return view('jobs.show', compact('job'));
    }

    // Show form to edit a job
    public function edit(Job $job)
    {
        if($job->posted_by != Auth::id()) {
            return redirect()->route('jobs.index')->with('error', 'You are not authorized to edit this job.');
        }
        return view('jobs.edit', compact('job'));
    }

    // Update a job
    public function update(Request $request, Job $job)
    {
        if($job->posted_by != Auth::id()) {
            return redirect()->route('jobs.index')->with('error', 'You are not authorized to edit this job.');
        }

        $request->validate([
            'summary' => 'required|max:255',
            'body' => 'required',
        ]);

        $job->update([
            'summary' => $request->summary,
            'body' => $request->body,
        ]);

        // Redirect to the jobs index with a success message
        return redirect()->route('jobs.index')->with('success', 'Job updated successfully!');
    }

    // Delete a job
    public function destroy(Job $job)
    {
        if($job->posted_by != Auth::id()) {
            return redirect()->route('jobs.index')->with('error', 'You are not authorized to delete this job.');
        }

        $job->delete();

        // Redirect to the jobs index with a success message
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
}

