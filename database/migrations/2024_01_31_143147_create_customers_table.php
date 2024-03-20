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
        Schema::create('customers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('avatar')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('location')->nullable();
            $table->string('weight')->nullable();
            $table->string('size')->nullable();
            $table->string('medics')->nullable();
            $table->string('origin')->nullable();
            $table->string('situation')->nullable();
            $table->string('activity')->nullable();
            $table->string('diseases')->nullable();
            $table->string('password')->nullable();
            $table->string('hash');
            $table->string('state');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
