<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('technology_items', 'order')) {
            Schema::table('technology_items', function (Blueprint $table) {
                $table->unsignedInteger('order')->nullable()->after('active');
                $table->index(['technology_category_id', 'order']);
            });
        }

        DB::unprepared('DROP TRIGGER IF EXISTS trg_technology_items_order_before_insert');

        DB::unprepared("
            CREATE TRIGGER trg_technology_items_order_before_insert
            BEFORE INSERT ON technology_items
            FOR EACH ROW
            BEGIN
                IF NEW.deleted_at IS NULL THEN
                    IF NEW.`order` IS NULL THEN
                        SET NEW.`order` = (
                            SELECT COALESCE(MAX(ti.`order`), 0) + 1
                            FROM technology_items ti
                            WHERE ti.deleted_at IS NULL
                              AND ti.technology_category_id = NEW.technology_category_id
                        );
                    END IF;
                ELSE
                    SET NEW.`order` = NULL;
                END IF;
            END
        ");

        DB::statement('SET @cat := NULL');
        DB::statement('SET @rownum := 0');
        DB::statement('
            UPDATE technology_items ti
            JOIN (
                SELECT
                    id,
                    technology_category_id,
                    (@rownum := IF(@cat = technology_category_id, @rownum + 1, 1)) AS rn,
                    (@cat := technology_category_id) AS _cat
                FROM technology_items
                WHERE deleted_at IS NULL
                ORDER BY technology_category_id, id
            ) seq ON seq.id = ti.id
            SET ti.`order` = seq.rn
            WHERE ti.deleted_at IS NULL
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_technology_items_order_before_insert');

        if (Schema::hasColumn('technology_items', 'order')) {
            Schema::table('technology_items', function (Blueprint $table) {
                $table->dropIndex(['technology_category_id', 'order']);
                $table->dropColumn('order');
            });
        }
    }
};
