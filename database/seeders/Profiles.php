<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Profile;

class Profiles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profiles = [
            [
                'name' => 'CADASTRADOR',
                'description' => 'CADASTRA OS PETS.',
                'status' => true,
            ],[
                'name' => 'USUÁRIO',
                'description' => 'ACESSA O SISTEMA PRA BUSCAR SEU PET.',
                'status' => true,
            ]
        ];

        foreach($profiles as $profile){
            Profile::create($profile);
        }
    }
}
