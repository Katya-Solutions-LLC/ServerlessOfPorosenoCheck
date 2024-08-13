<?php

namespace Modules\Pet\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Pet\Models\Pet;

class PetDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PetTypeSeederTableSeeder::class);
        $this->call(BreedSeederTableSeeder::class);
        $this->call(PetTableSeeder::class);
    }
}
