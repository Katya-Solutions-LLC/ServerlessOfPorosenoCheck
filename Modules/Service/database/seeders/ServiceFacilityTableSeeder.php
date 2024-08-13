<?php

namespace Modules\Service\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Modules\Service\Models\ServiceFacility;

class ServiceFacilityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks!
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        /*
         * Services Seed
         * ------------------
         */

        // DB::table('services')->truncate();
        // echo "Truncate: services \n";
        if (env('IS_DUMMY_DATA')) {
            $data = [
                [
                    'name' => 'Feeding and Watering',
                    'slug' => 'Feeding and Watering',
                    'description' => 'Ensuring pets are fed according to their dietary needs and have access to fresh water.',
                    'status' => 1,
                ],
                [
                    'name' => '24/7 Supervision',
                    'slug' => '24/7 Supervision',
                    'description' => 'Round-the-clock monitoring to ensure the safety and well-being of all pets.',
                    'status' => 1,
                ],
                [
                    'name' => 'Special Care for Seniors and Special Needs Pets',
                    'slug' => 'Special Care for Seniors and Special Needs Pets',
                    'description' => 'Catering to the specific requirements of older pets or those with medical conditions.',
                    'status' => 1,
                ],
                [
                    'name' => 'Play Areas',
                    'slug' => 'Play Areas',
                    'description' => 'Designated areas or play yards where pets can exercise and interact with other compatible animals.',
                    'status' => 1,
                ],
                [
                    'name' => 'Private Suites',
                    'slug' => 'Private Suites',
                    'description' => 'Offer private, comfortable rooms or suites for pets who prefer more solitude and a quiet environment.',
                    'status' => 1,
                ],
                [
                    'name' => 'Pet Photography',
                    'slug' => 'Pet Photography',
                    'description' => 'Offer pet photography sessions and send pictures to owners as a delightful keepsake.',
                    'status' => 1,
                ],
                [
                    'name' => 'Report Cards',
                    'slug' => 'Report Cards',
                    'description' => "Provide daily or periodic report cards to pet owners detailing their pet's activities and behaviors.",
                    'status' => 1,
                ],
              
            ];
            foreach ($data as $key => $value) {
                $service = [
                    'slug' => $value['slug'],
                    'name' => $value['name'],
                    'description' => $value['description'],
                    'status' => $value['status'],
                ];
                $service = ServiceFacility::create($service);
            }
        }
        // Enable foreign key checks!
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    private function attachFeatureImage($model, $publicPath)
    {
        if(!env('IS_DUMMY_DATA_IMAGE')) return false;

        $file = new \Illuminate\Http\File($publicPath);

        $media = $model->addMedia($file)->preservingOriginal()->toMediaCollection('feature_image');

        return $media;
    }
}
