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
        //Up() elimina la columna
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn('cantidad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Down() la vuelve a crear si haces migrate:rollback
        Schema::table('productos', function (Blueprint $table) {
            $table->integer('cantidad')->default(0);
        });
    }
};
