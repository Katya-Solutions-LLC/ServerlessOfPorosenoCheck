<?php

namespace Modules\World\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Modules\World\Models\World;
use Modules\MenuBuilder\Models\MenuBuilder;

class WorldDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CitySeederTableSeeder::class);
        $this->call(CountrySeederTableSeeder::class);
        $this->call(StateSeederTableSeeder::class);
    }
}
