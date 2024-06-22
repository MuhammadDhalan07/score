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
        Schema::create('details_value', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name')->nullable();
            $table->foreignUlid('person_id')->nullable();
            $table->foreignUlid('category_id')->nullable();
            $table->double('value_1')->nullable();
            $table->double('value_2')->nullable();
            $table->double('value_3')->nullable();
            $table->double('value_4')->nullable();
            $table->double('total')->storedAs('value_1 + value_2 + value_3 + value_4 / 4 * 100')->nullable();
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
    }
};
