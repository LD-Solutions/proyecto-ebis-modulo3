<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Empleado;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'id' => 1,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        User::factory(10)->create();

        $this->call(NoticiaSeeder::class);
        $this->call(EmpleadoSeeder::class);
        // Se quita porque se establece en AppServiceProvider que si un user se crea, se crea una calculadora de ahorro para el
        // Si se elimina un usuario, se elimina su calculadora_ahorro para el
        /* $this->call(CalculadoraAhorrosSeeder::class); */
        $this->call(MensajesContactoSeeder::class);

    }
}
