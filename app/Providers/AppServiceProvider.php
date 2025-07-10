<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\CalculadoraAhorros;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::created(function ($user) {
            CalculadoraAhorros::create([
                'id_usuario' => $user->id,
                'ingreso_mensual' => fake()->numberBetween(1000, 5000),
            ]);
        });

        User::deleting(function ($user) {
            $user->calculadoraAhorros()?->delete();
        });
    }
}
