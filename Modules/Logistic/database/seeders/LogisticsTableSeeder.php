<?php

namespace Modules\Logistic\database\seeders;

use Illuminate\Database\Seeder;

class LogisticsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('logistics')->delete();

        \DB::table('logistics')->insert(array (
            0 =>
            array (
                'created_at' => '2023-12-07 15:12:37',
                'created_by' => 1,
                'deleted_at' => '2023-12-08 11:15:01',
                'deleted_by' => 1,
                'id' => 1,
                'name' => 'Fedex',
                'status' => 1,
                'updated_at' => '2023-12-08 11:15:01',
                'updated_by' => 1,
            ),
            1 =>
            array (
                'created_at' => '2023-12-07 15:12:47',
                'created_by' => 1,
                'deleted_at' => '2023-12-08 11:15:05',
                'deleted_by' => 1,
                'id' => 2,
                'name' => 'Bluedart',
                'status' => 1,
                'updated_at' => '2023-12-08 11:15:05',
                'updated_by' => 1,
            ),
            2 =>
            array (
                'created_at' => '2023-12-08 11:19:22',
                'created_by' => 1,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'id' => 3,
                'name' => 'Fedex',
                'status' => 1,
                'updated_at' => '2023-12-08 11:19:22',
                'updated_by' => 1,
            ),
            3 =>
            array (
                'created_at' => '2023-12-08 11:19:29',
                'created_by' => 1,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'id' => 4,
                'name' => 'Bluedart',
                'status' => 1,
                'updated_at' => '2023-12-08 11:19:29',
                'updated_by' => 1,
            ),
        ));


    }
}
