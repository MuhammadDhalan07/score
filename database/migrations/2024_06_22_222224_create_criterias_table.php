<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('criteria', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('criteria_name')->nullable();
            $table->string('priority')->nullable();
            $table->string('quality')->nullable();
            $table->foreignUlid('atlet_id')->nullable();
            $table->foreignUlid('parent_id')->nullable()->index();

            $table->bigInteger('sort')->nullable()->index();
            $table->string('sort_hirarki')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();
        });

        $generateTriggerSortHirarki = fn ($name, $condition, $record) => <<<SQL
        CREATE TRIGGER $name $condition ON `criteria` FOR EACH ROW
        BEGIN
            IF $record.parent_id IS NULL THEN
                SET NEW.sort_hirarki = NEW.sort;
            ELSE
                SET NEW.sort_hirarki = CONCAT((SELECT sort FROM criteria WHERE id = IFNULL(NEW.parent_id, $record.parent_id) LIMIT 1), "-", IFNULL(NEW.sort, $record.sort));
            END IF;
        END;
    SQL;

    DB::unprepared($generateTriggerSortHirarki('criteria_before_insert', 'BEFORE INSERT', 'NEW'));
    DB::unprepared($generateTriggerSortHirarki('criteria_before_update', 'BEFORE UPDATE', 'OLD'));

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criteria');
    }
};
