<?php

namespace Database\Seeders;

use App\Models\Caracteristica;
use App\Models\Marca;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarcaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Marca::create([

            'id' => 1,
            'caracteristica_id' => 'nike'

        ]);
    }
}
