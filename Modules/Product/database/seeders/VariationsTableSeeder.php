<?php

namespace Modules\Product\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Models\Variations;
use Modules\Product\Models\VariationValue;

class VariationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $variations = [
            [
                'name' => 'Size',
                'type' => 'text',
                'values' => [
                    [
                        'name' => 'Small',
                        'value' => 'S'
                    ],
                    [
                        'name' => 'Mediam',
                        'value' => 'M'
                    ],
                    [
                        'name' => 'Large',
                        'value' => 'L'
                    ],
                ],
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_by' => 1,
            ],
            [
                'name' => 'Colour',
                'type' => 'color',
                'values' => [
                    [
                        'name' => 'Red',
                        'value' => '#f81b1b'
                    ],
                    [
                        'name' => 'Blue',
                        'value' => '#3DB5FF'
                    ],
                    [
                        'name' => 'Green',
                        'value' => '#79DD36'
                    ],
                ],
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_by' => 1,
            ]
        ];

        foreach ($variations as $key => $value) {
            $values = $value['values'];

            $data = \Arr::except($value, ['values']);

            $variation = Variations::create($data);

            foreach ($values as $k => $v) {
                $variation->values()->create($v);
            }
        }
        //
    }
}
