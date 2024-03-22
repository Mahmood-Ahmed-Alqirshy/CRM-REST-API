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
            $table->dropIndex('users_email_unique');
            $table->dropColumn('email');
            $table->dropColumn('email_verified_at');
            $table->dropColumn('remember_token');
            $table->renameColumn('name', 'username');
            $table->unique('username');
        });

        Schema::drop('password_reset_tokens');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable()->unique('users_email_unique');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->dropIndex('users_username_unique');
            $table->renameColumn('username', 'name');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }
};
