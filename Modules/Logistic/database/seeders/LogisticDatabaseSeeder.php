<?php

namespace Modules\Logistic\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Modules\MenuBuilder\Models\MenuBuilder;

class LogisticDatabaseSeeder extends Seeder
{
   /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LogisticsTableSeeder::class);
        $this->call(LogisticZonesTableSeeder::class);
        $this->call(LogisticZoneCityTableSeeder::class);
    }
}
