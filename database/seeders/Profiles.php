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
                'id' => 2,
                'name' => 'Cadastrador',
                'description' => 'Cadastra as fotos dos pets.',
                'status' => true,
            ],[
                'id' => 3,
                'name' => 'Usuário',
                'description' => 'Acessa o sistema para buscar o seu pet',
                'status' => true,
            ]
        ];

        foreach($profiles as $profile){
            Profile::create($profile);
        }
    }
}
