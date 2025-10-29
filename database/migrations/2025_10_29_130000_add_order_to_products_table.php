<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('order')->nullable()->after('active');
            $table->index('order');
        });

        // Garantir que não haja trigger pré-existente com o mesmo nome
        DB::unprepared('DROP TRIGGER IF EXISTS trg_products_order_before_insert');

        // Trigger para definir automaticamente a ordem apenas quando deleted_at IS NULL
        DB::unprepared("
            CREATE TRIGGER trg_products_order_before_insert
            BEFORE INSERT ON products
            FOR EACH ROW
            BEGIN
                IF NEW.deleted_at IS NULL THEN
                    IF NEW.`order` IS NULL THEN
                        SET NEW.`order` = (
                            SELECT COALESCE(MAX(p.`order`), 0) + 1
                            FROM products p
                            WHERE p.deleted_at IS NULL
                        );
                    END IF;
                ELSE
                    SET NEW.`order` = NULL;
                END IF;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_products_order_before_insert');

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['order']);
            $table->dropColumn('order');
        });
    }
};