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
            $table->text('body'); // Job description
            $table->timestamp('posted_date')->useCurrent(); // Automatically set to the current date
            $table->foreignId('posted_by')->constrained('users')->onDelete('cascade'); // ID of the poster
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
}
