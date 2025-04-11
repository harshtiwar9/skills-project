<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    //
    use HasFactory;

    // Allow mass assignment for these fields:
    protected $fillable = ['summary', 'body', 'posted_by'];

    // Define the relationship: each job is posted by a user
    public function poster()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    // Define the relationship: each job can have many interested users
    public function interestedUsers()
    {
        return $this->belongsToMany(User::class, 'job_user');
    }
}
