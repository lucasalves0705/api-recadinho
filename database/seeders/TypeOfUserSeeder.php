<?php

namespace Database\Seeders;

use App\Models\TypeOfUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeOfUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeOfUser::query()->updateOrInsert([
            'id' => 1,
            'description' => 'Administrador'
        ]);

        TypeOfUser::query()->updateOrInsert([
            'id' => 2,
            'description' => 'Artista'
        ]);

        TypeOfUser::query()->updateOrInsert([
            'id' => 3,
            'description' => 'Cliente'
        ]);
    }
}
