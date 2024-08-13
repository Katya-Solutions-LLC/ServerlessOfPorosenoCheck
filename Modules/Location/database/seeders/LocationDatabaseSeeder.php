<?php

namespace Modules\Location\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Modules\Location\Models\Location;
use Modules\MenuBuilder\Models\MenuBuilder;

class LocationDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Location::create([
            'name' => 'Default Location',
            'address_line_1' => 'Default Address',
            'is_default' => 1,
            'status' => 1
        ]);
    }
}
