<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = ['summary', 'body', 'posted_date', 'posted_by'];

    protected $casts = [
        'posted_date' => 'datetime',
    ];

    public function postedBy()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function interestedUsers()
    {
        return $this->belongsToMany(User::class, 'job_user', 'job_id', 'user_id');
    }
}
