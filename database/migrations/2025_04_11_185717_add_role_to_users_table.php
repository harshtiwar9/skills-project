<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleToUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Adding a new column 'role' to the users table as "poster" or "viewer"
            $table->enum('role', ['poster', 'viewer'])->default('viewer')->after('email'); // Default role is 'viewer'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Dropping the 'role' column from the users table
            $table->dropColumn('role');
        });
    }
};
