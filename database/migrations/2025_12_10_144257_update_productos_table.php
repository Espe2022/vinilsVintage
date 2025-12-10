<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations
     * Cambiar el orden de las columnas categoria y stock
     */
    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
            if (!Schema::hasColumn('productos', 'categoria')) {
                $table->string('categoria')->after('imagen');
            }

            if (!Schema::hasColumn('productos', 'stock')) {
                $table->integer('stock')->default(0)->after('categoria');
            }
        });
    }


    /**
     * Reverse the migrations
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn(['categoria', 'stock']);
        });
    }
};
