<?php

namespace Modules\Pet\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Pet\Models\PetType;
use Illuminate\Support\Arr;

class PetTypeSeederTableSeeder extends Seeder
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

        // DB::table('pettype')->truncate();
        // echo "Truncate: pettype \n";

        if (env('IS_DUMMY_DATA')) {
            $data = [
                [
                    'name' => 'Cat',
                    'slug' => 'cat',
                    'status' => 1,
                    'image' => public_path('/dummy-images/pet_type/Cat.png'),
                ],
                [
                    'name' => 'Dog',
                    'slug' => 'dog',
                    'status' => 1,
                    'image' => public_path('/dummy-images/pet_type/Dog.png'),
                ],
                [
                    'name' => 'Rabbit',
                    'slug' => 'rabbit',
                    'status' => 1,
                    'image' => public_path('/dummy-images/pet_type/Rabbit.png'),
                ],
                [
                    'name' => 'Mouse',
                    'slug' => 'mouse',
                    'status' => 1,
                    'image' => public_path('/dummy-images/pet_type/Mouse.png'),
                ],
                [
                    'name' => 'Bird',
                    'slug' => 'bird',
                    'status' => 1,
                    'image' => public_path('/dummy-images/pet_type/Bird.png'),
                ],
                [
                    'name' => 'Squirrel',
                    'slug' => 'squirrel',
                    'status' => 1,
                    'image' => public_path('/dummy-images/pet_type/Squirrel.png'),
                ],
                [
                    'name' => 'Turtle',
                    'slug' => 'turtle',
                    'status' => 1,
                    'image' => public_path('/dummy-images/pet_type/Turtle.png'),
                ],
                [
                    'name' => 'Chameleon',
                    'slug' => 'chameleon',
                    'status' => 1,
                    'image' => public_path('/dummy-images/pet_type/Chameleon.png'),
                ],
                [
                    'name' => 'Horse',
                    'slug' => 'horse',
                    'status' => 1,
                    'image' => public_path('/dummy-images/pet_type/Horse.png'),
                ],
                [
                    'name' => 'Fish',
                    'slug' => 'fish',
                    'status' => 1,
                    'image' => public_path('/dummy-images/pet_type/Fish.png'),
                ],

            ];
            foreach ($data as $key => $val) {
                $image = $val['image'] ?? null;
                $type = Arr::except($val, ['image']);
                $type = PetType::create($type);
                if (isset($image)) {
                    $this->attachFeatureImage($type, $image);
                    
                }
            }
           
        }
        // Enable foreign key checks!
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    private function attachFeatureImage($model, $publicPath)
    {
        if(!env('IS_DUMMY_DATA_IMAGE')) return false;

        $file = new \Illuminate\Http\File($publicPath);

        $media = $model->addMedia($file)->preservingOriginal()->toMediaCollection('pettype_image');

        return $media;
    }
}
