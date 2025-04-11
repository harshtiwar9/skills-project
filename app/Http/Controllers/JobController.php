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
        $jobs = Job::where('posted_date', '>='. Carbon::now()->subMonths(2))
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
    public function expressInterest($jobId)
    {
        $job = Job::findOrFail($jobId);
        $user = Auth::user();

        //check if the user is a viewer
        if ($user->role !== 'viewer') {
            return redirect()->route('jobs.index')->with('error', 'Only viewers can express interest in this job.');
        }

        // Check if the user is already interested in the job
        if ($job->interestedUsers()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'You have already expressed interest in this job.');
        }

        // Attach the user to the job's interested users
        $job->interestedUsers()->syncWithoutDetaching([$user->id]);

        // Redirect to the jobs index with a success message
        return redirect()->back()->with('success', 'You have expressed interest in this job!');
    }


}

