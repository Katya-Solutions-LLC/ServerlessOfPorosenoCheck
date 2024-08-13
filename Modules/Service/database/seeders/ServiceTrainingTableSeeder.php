<?php

namespace Modules\Service\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Service\Models\ServiceTraining;

class ServiceTrainingTableSeeder extends Seeder
{
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
                    'name' => 'Basic Obedience Training',
                    'slug' => 'Basic Obedience Training',
                    'description' => "Teaching fundamental commands such as sit, stay, down, come, and heel.",
                    'status' => 1,
                ],
                [
                    'name' => 'Puppy Training',
                    'slug' => 'Puppy Training',
                    'description' => "Socialization exercises, housebreaking, and basic commands tailored for young pups.",
                    'status' => 1,
                ],
                [
                    'name' => 'Behavioral Modification',
                    'slug' => 'Behavioral Modification',
                    'description' => "Addressing and correcting behavioral issues such as aggression, anxiety, or excessive barking.",
                    'status' => 1,
                ],
                [
                    'name' => 'Service Dog Training',
                    'slug' => 'Service Dog Training',
                    'description' => "Specialized training for service dogs to perform tasks for individuals with disabilities.",
                    'status' => 1,
                ],
                [
                    'name' => 'Fear and Anxiety Management',
                    'slug' => 'Fear and Anxiety Management',
                    'description' => "Techniques to help pets cope with fear or anxiety-inducing situations.",
                    'status' => 1,
                ],
                [
                    'name' => 'Recall Training',
                    'slug' => 'Recall Training',
                    'description' => "Focusing on teaching pets to come when called, an essential safety command.",
                    'status' => 1,
                ],
                [
                    'name' => 'Trick Training',
                    'slug' => 'Trick Training',
                    'description' => "Teaching fun and entertaining tricks to impress friends and family.",
                    'status' => 1,
                ],
                [
                    'name' => 'Leash Training',
                    'slug' => 'Leash Training',
                    'description' => "Teaching pets to walk politely on a leash without pulling.",
                    'status' => 1,
                ],
                [
                    'name' => 'Advanced Obedience Training',
                    'slug' => 'Advanced Obedience Training',
                    'description' => "Building on basic commands, introducing more complex cues and off-leash control.",
                    'status' => 1,
                ],
              
                
            ];
            foreach ($data as $key => $value) {
                $servicetraining = [
                    'name' => $value['name'],
                    'slug' => $value['slug'],
                    'description' => $value['description'],
                    'status' => $value['status'],
                ];
                $servicetraining = ServiceTraining::create($servicetraining);
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
