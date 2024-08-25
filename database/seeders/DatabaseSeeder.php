<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CitiesSeeder::class);
        $this->call(Profiles::class);
        $this->call(Roles::class);
        $this->call(PetTypes::class);

        \App\User::factory()->create([
            'profile_id' => 3,
            'email' => 'guest@guest.com',
            'username' => 'CONVIDADO',
            'name' => 'CONVIDADO',
            'password' => Hash::make('guest'),
            'status' => true,
            'remember_token' => Str::random(10),
        ]);
    }
}
