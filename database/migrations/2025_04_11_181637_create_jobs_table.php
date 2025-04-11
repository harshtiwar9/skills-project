<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('summary'); // Job title
            $table->string('body'); // Job description
            $table->string('posted_date')->useCurrent(); // Automatically set to the current date
            $table->string('posted_by'); // ID of the poster
            $table->timestamps(); // Created at and updated at timestamps

            // Setting up foreign key constraints which reference the users table
            $table->foreign('posted_by')
                ->references('id')->on('users')
                ->onDelete('cascade'); // If the user is deleted, delete the job as well
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
