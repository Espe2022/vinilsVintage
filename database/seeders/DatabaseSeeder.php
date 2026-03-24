<?php

// Define el namespace donde se encuentra este seeder
namespace Database\Seeders;

// Importa el modelo User para poder crear usuarios
use App\Models\User;

// Importa la clase base Seeder de Laravel
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Método principal que se ejecuta al lanzar los seeders.
     * Aquí se definen los datos que se insertarán en la base de datos.
     */
    public function run(): void
    {
        // Crea 10 usuarios aleatorios usando factories (comentado)
        // User::factory(10)->create();

        // Crea un usuario específico de prueba con datos fijos
        User::factory()->create([
            'name' => 'Test User',    // Nombre del usuario
            'email' => 'test@example.com',  // Email del usuario
        ]);
    }
}

/*
Un seeder en Laravel sirve para rellenar la base de datos con datos iniciales o de prueba, útil 
para desarrollo, testing o demos.

run()   Es el método principal del seeder y se ejecuta cuando lanzas el comando: php artisan db:seed
También puede ejecutarse automáticamente con: php artisan migrate:fresh --seed

Una factory es una clase que permite generar datos falsos automáticamente para un modelo, usando la
librería Faker.

Diferencia entre: 
    - factory(10) → crea 10 usuarios aleatorios
    - factory()->create([...]) → crea un usuario concreto con datos definidos

Diferencia hay entre create() y make():
    - create() → guarda en la base de datos
    - make() → crea el objeto pero NO lo guarda

¿Por qué usar seeders? ¿Por qué no insertar datos manualmente?
Porque los seeders:
    - Automatizan el proceso
    - Permiten repetirlo fácilmente
    - Facilitan testing
    - Aseguran consistencia entre entornos

¿De dónde salen los datos aleatorios?
De la librería Faker, que genera datos como nombres, emails, etc.

¿Qué pasa si ejecuto el seeder varias veces? ¿Se duplican los datos?
Sí, se crearán registros nuevos cada vez, a menos que controles eso manualmente (por ejemplo 
con firstOrCreate o borrando antes).

¿Para qué sirve namespace Database\Seeders?
Organiza el código y permite que Laravel encuentre correctamente la clase.

¿Podrías llamar a otros seeders desde aquí?
Sí, usando:
        $this->call(OtroSeeder::class);
        
*/