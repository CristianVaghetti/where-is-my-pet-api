<?php

namespace Database\Seeders;

use App\Models\PetType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PetTypes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['CACHORRO', 'GATO', 'GRANDE PORTE'];

        foreach($types as $type){
            PetType::create([
                'name' => $type,
            ]);
        }
    }
}
