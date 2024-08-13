<?php

namespace Modules\Service\database\seeders;

use Illuminate\Database\Seeder;

class ServiceDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SystemServiceTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(ServiceFacilityTableSeeder::class);
        $this->call(ServiceDurationTableSeeder::class);
        $this->call(ServiceTrainingTableSeeder::class);
    }
}
