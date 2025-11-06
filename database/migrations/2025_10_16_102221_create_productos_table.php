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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);   //Nombre del producto
            $table->text('descripcion')->nullable();    //Este atributo puede ser nulo
            $table->decimal('precio', 8,2); //Puede contener 2 decimales
            $table->integer('cantidad');
            //Crear la relación con la tabla users declarando el foreing key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
