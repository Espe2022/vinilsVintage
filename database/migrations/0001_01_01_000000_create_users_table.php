<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Migración de usuarios y sesiones
|--------------------------------------------------------------------------
|
| Las migraciones en Laravel permiten crear y modificar tablas
| de la base de datos de forma controlada y versionada.
|
*/

return new class extends Migration
{
    /**
     * Run the migrations.
     * Ejecutar migración (crear tablas).
     */
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Tabla users
        |--------------------------------------------------------------------------
        |
        | Guarda la información de los usuarios del sistema
        |
        */
        Schema::create('users', function (Blueprint $table) {
            $table->id();   // ID autoincremental
            $table->string('name'); // Nombre del usuario
            $table->string('email')->unique();  // Email único
            $table->timestamp('email_verified_at')->nullable(); // Verificación email
            $table->string('password');  // Contraseña
            $table->rememberToken();     // Token para recordar sesión
            $table->timestamps();   // created_at y updated_at
        });

        /*
        |--------------------------------------------------------------------------
        | Tabla password_reset_tokens
        |--------------------------------------------------------------------------
        |
        | Se utiliza para gestionar el reseteo de contraseñas
        |
        */
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Email como clave primaria
            $table->string('token');    // Token de recuperación
            $table->timestamp('created_at')->nullable();    // Fecha de creación
        });

        /*
        |--------------------------------------------------------------------------
        | Tabla sessions
        |--------------------------------------------------------------------------
        |
        | Guarda las sesiones de los usuarios cuando usan la aplicación
        |
        */
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();    // ID de sesión
            $table->foreignId('user_id')->nullable()->index();  // Usuario asociado
            $table->string('ip_address', 45)->nullable();   // IP del usuario
            $table->text('user_agent')->nullable(); // Navegador
            $table->longText('payload');    // Datos de la sesión
            $table->integer('last_activity')->index();  // Última actividad
        });
    }

    /**
     * Reverse the migrations.
     * Revertir migración (eliminar tablas)
     *
     */
    public function down(): void
    {
        // Elimina las tablas si existen
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

/*
Este archivo es una migración que crea las tablas necesarias para gestionar usuarios, recuperación de 
contraseña y sesiones en la aplicación.

Esta migración es la base del sistema de autenticación de usuarios, necesario para funcionalidades como 
carrito, compras y perfil.

Las migraciones permiten crear y modificar tablas con código, en lugar de hacerlo manualmente en la 
base de datos.

up()    Crea las tablas en la base de datos.

down()  Revierte los cambios, eliminando las tablas.

$table->timestamps()    Crea las columnas created_at y updated_at automáticamente.

Email es unique     Para evitar que dos usuarios tengan el mismo correo.

Laravel utiliza migraciones para mantener la base de datos sincronizada entre entornos y facilitar 
el trabajo en equipo.

*/