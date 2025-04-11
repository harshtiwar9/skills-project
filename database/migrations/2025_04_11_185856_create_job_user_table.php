<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobUserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('job_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_id'); // ID of the job
            $table->unsignedBigInteger('user_id'); // ID of the user
            $table->timestamps(); // Created at and updated at timestamps

            //Setting up foreign key constraints which reference the jobs and users tables
            $table->foreign('job_id')
                ->references('id')->on('jobs')
                ->onDelete('cascade'); // If the job is deleted, delete the job_user record as well
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade'); // If the user is deleted, delete the job_user record as wel
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_user');
    }
};
