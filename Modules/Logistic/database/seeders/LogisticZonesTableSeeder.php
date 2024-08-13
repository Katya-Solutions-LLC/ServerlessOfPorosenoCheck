<?php

namespace Modules\Logistic\database\seeders;

use Illuminate\Database\Seeder;

class LogisticZonesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('logistic_zones')->delete();
        
        \DB::table('logistic_zones')->insert(array (
           
            0 => 
            array (
                'country_id' => 230,
                'created_at' => '2023-12-05 10:11:34',
                'created_by' => 1,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'express_delivery_charge' => 0.0,
                'express_delivery_time' => NULL,
                'id' => 1,
                'logistic_id' => 3,
                'name' => 'Square Mile Zone',
                'standard_delivery_charge' => 5.0,
                'standard_delivery_time' => '3 Day',
                'state_id' => 3866,
                'updated_at' => '2023-12-05 10:11:34',
                'updated_by' => 1,
            ),
            1 => 
            array (
                'country_id' => 230,
                'created_at' => '2023-12-05 10:14:07',
                'created_by' => 1,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'express_delivery_charge' => 0.0,
                'express_delivery_time' => NULL,
                'id' => 2,
                'logistic_id' => 4,
                'name' => 'Canary Wharf Zone',
                'standard_delivery_charge' => 3.0,
                'standard_delivery_time' => '1 Day',
                'state_id' => 3866,
                'updated_at' => '2023-12-05 10:14:17',
                'updated_by' => 1,
            ),
        ));
        
        
    }
}