<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Comprobante;
use App\Models\Documento;
use App\Models\Marca;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(DocumentoSeeder::class);
        $this->call(ComprobanteSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UbicacioneSeeder::class);
    }
}
