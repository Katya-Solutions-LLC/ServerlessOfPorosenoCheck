<?php

namespace Modules\Product\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Models\Unit;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'gm',
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_by' => 1,
            ],
            [
                'name' => 'kg',
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_by' => 1,
            ],
            [
                'name' => 'pcs',
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_by' => 1,
            ],
            [
                'name' => 'ml',
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_by' => 1,
            ],
            [
                'name' => 'pack',
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_by' => 1,
            ],
            [
                'name' => 'ltr',
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_by' => 1,
            ],
            [
                'name' => 'each',
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_by' => 1,
            ],
            [
                'name' => '250gm',
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_by' => 1,
            ],
        ];

        if(env('IS_DUMMY_DATA')) {
            foreach ($data as $key => $value) {
                Unit::create($value);
            }
        }
    }
}
