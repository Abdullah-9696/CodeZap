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
        // Users table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable(); // Added for email verification support
            $table->string('password');
            $table->boolean('is_admin')->default(false); // Custom is_admin column
            $table->string('remember_token', 100)->nullable(); // Added for Remember Me and auth
            $table->timestamps();
        });

        // Password resets table (optimized)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Changed to primary key for uniqueness
            $table->string('token');
            $table->timestamp('created_at')->nullable();
            $table->index(['email', 'created_at']); // Composite index for faster queries
        });

        // Sessions table (optional, for database session driver)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); // Added foreign key constraint
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};