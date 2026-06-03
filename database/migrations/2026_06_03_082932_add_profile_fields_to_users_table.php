<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add first_name and last_name
            $table->string('first_name')->nullable()->after('name');
            $table->string('last_name')->nullable()->after('first_name');
            
            // Add profile photo path
            $table->string('profile_photo_path', 2048)->nullable()->after('email');
            
            // Add Google OAuth fields
            $table->string('google_id')->nullable()->unique()->after('profile_photo_path');
            $table->string('avatar')->nullable()->after('google_id');
            
            // Make password nullable for OAuth users
            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name', 'profile_photo_path', 'google_id', 'avatar']);
            $table->string('password')->nullable(false)->change();
        });
    }
};
