<?php

namespace Modules\Logistic\database\seeders;

use Illuminate\Database\Seeder;

class LogisticZoneCityTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('logistic_zone_city')->delete();
        
        \DB::table('logistic_zone_city')->insert(array (
            0 => 
            array (
                'city_id' => 1,
                'created_at' => '2023-12-05 09:46:41',
                'created_by' => NULL,
                'deleted_by' => NULL,
                'id' => 1,
                'logistic_id' => 1,
                'logistic_zone_id' => 3,
                'updated_at' => '2023-12-05 09:46:41',
                'updated_by' => NULL,
            ),
            1 => 
            array (
                'city_id' => 10001,
                'created_at' => '2023-12-05 10:11:34',
                'created_by' => NULL,
                'deleted_by' => NULL,
                'id' => 2,
                'logistic_id' => 1,
                'logistic_zone_id' => 1,
                'updated_at' => '2023-12-05 10:11:34',
                'updated_by' => NULL,
            ),
            2 => 
            array (
                'city_id' => 10001,
                'created_at' => '2023-12-05 10:14:35',
                'created_by' => NULL,
                'deleted_by' => NULL,
                'id' => 5,
                'logistic_id' => 2,
                'logistic_zone_id' => 2,
                'updated_at' => '2023-12-05 10:14:35',
                'updated_by' => NULL,
            ),
            3 => 
            array (
                'city_id' => 10002,
                'created_at' => '2023-12-05 10:14:35',
                'created_by' => NULL,
                'deleted_by' => NULL,
                'id' => 6,
                'logistic_id' => 2,
                'logistic_zone_id' => 2,
                'updated_at' => '2023-12-05 10:14:35',
                'updated_by' => NULL,
            ),
        ));
        
        
    }
}