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
        Schema::disableForeignKeyConstraints();

        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 45)->nullable();
            $table->unsignedBigInteger('facebook_id')->nullable();
            $table->string('instagram_id', 30)->nullable();
            $table->string('email')->nullable();
            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->date('birthday');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
