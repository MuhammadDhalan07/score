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
        Schema::create('athlete', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('athlete_name')->nullable();
            $table->string('athlete_code')->nullable();
            $table->date('date_of_entry')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('long_time')->nullable();
            $table->string('cabor')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person');
    }
};
