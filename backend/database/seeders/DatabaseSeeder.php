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
            'name' => 'Admin',
            'email' => 'admin@ebis.com',
            'role' => 'admin',
            'password' => bcrypt('ebis12345'),
        ]);

        User::factory()->create([
            'id' => 2,
            'name' => 'User',
            'email' => 'user@ebis.com',
            'role' => 'user',
            'password' => bcrypt('ebis12345'),
        ]);

        User::factory(10)->create();

        $this->call(NoticiaSeeder::class);
        $this->call(EmpleadoSeeder::class);
        // Se quita porque se establece en AppServiceProvider que si un user se crea, se crea una calculadora de ahorro para el
        // Si se elimina un usuario, se elimina su calculadora_ahorro para el
        /* $this->call(CalculadoraAhorrosSeeder::class); */
        $this->call(MensajesContactoSeeder::class);
        $this->call(PortfolioSeeder::class);
        $this->call(IndexFundSeeder::class);
        $this->call(FormacionSeeder::class);

    }
}
