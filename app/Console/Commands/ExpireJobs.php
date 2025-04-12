<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Job;
use Carbon\Carbon;

class ExpireJobs extends Command
{
    protected $signature = 'jobs:expire';
    protected $description = 'Delete jobs older than 2 months';

    public function handle()
    {
        // Calculate the threshold
        $threshold = Carbon::now()->subMonths(2);

        // Find jobs older than the threshold and delete them
        $expiredJobs = Job::where('posted_date', '<', $threshold)->get();
        foreach ($expiredJobs as $job) {
            $job->delete();
        }

        $this->info('Expired jobs have been deleted.');
    }
}
