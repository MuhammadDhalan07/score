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
        Schema::create('value', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('person_id')->nullable();
            $table->foreignUlid('category_id')->nullable();
            $table->foreignUlid('details_value_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('details_value', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('category_id')->nullable();
            $table->foreignUlid('value_id')->index()->references('id')->on('value');
            $table->double('value_1')->nullable();
            $table->double('total')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('value');
        Schema::dropIfExists('details_value');
    }
};
