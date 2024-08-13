<?php

namespace Modules\Pet\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Pet\Models\Breed;

class BreedSeederTableSeeder extends Seeder
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
                //cat breed
                [
                    'name' => 'Abyssinian',
                    'slug' => 'abyssinian',
                    'pettype_id' => 1,
                    'status' => 1,
                    'description' => '1Energetic and graceful breed with a ticked coat and curiosity.',
                ],
                [
                    'name' => 'American Shorthair',
                    'slug' => 'American Shorthair',
                    'pettype_id' => 1,
                    'status' => 1,
                    'description' => 'Friendly, adaptable, and versatile breed with various coat colors/patterns',
                ],
                [
                    'name' => 'Bengal',
                    'slug' => 'Bengal',
                    'pettype_id' => 1,
                    'status' => 1,
                    'description' => '',

                ],
                [
                    'name' => 'British Shorthair',
                    'slug' => 'British Shorthair',
                    'pettype_id' => 1,
                    'status' => 1,
                    'description' => '',

                ],
                [
                    'name' => 'Persian',
                    'slug' => 'Persian',
                    'pettype_id' => 1,
                    'status' => 1,
                    'description' => '',

                ],
                [
                    'name' => 'Himalayan',
                    'slug' => 'Himalayan',
                    'pettype_id' => 1,
                    'status' => 1,
                    'description' => '',

                ],
                [
                    'name' => 'Siamese',
                    'slug' => 'Siamese',
                    'pettype_id' => 1,
                    'status' => 1,
                    'description' => '',

                ],
                [
                    'name' => 'Chartreux',
                    'slug' => 'Chartreux',
                    'pettype_id' => 1,
                    'status' => 1,
                    'description' => '',

                ],
                [
                    'name' => 'Ragdoll',
                    'slug' => 'Ragdoll',
                    'pettype_id' => 1,
                    'status' => 1,
                    'description' => '',

                ],
                [
                    'name' => 'Sphynx',
                    'slug' => 'Sphynx',
                    'pettype_id' => 1,
                    'status' => 1,
                    'description' => '',

                ],
                //dog breed
                [
                    'name' => 'Labrador Retriever',
                    'slug' => 'Labrador Retriever',
                    'pettype_id' => 2,
                    'status' => 1,
                    'description' => 'Loyal, friendly, and outgoing; a playful family companion and retriever',
                ],
                [
                    'name' => 'German Shepherd',
                    'slug' => 'German Shepherd',
                    'pettype_id' => 2,
                    'status' => 1,
                    'description' => 'Loyal, friendly, and outgoing; a playful family companion and retriever',
                ],
                [
                    'name' => 'Golden Retriever',
                    'slug' => 'Golden Retriever',
                    'pettype_id' => 2,
                    'status' => 1,
                    'description' => '',

                ],
                [
                    'name' => 'Bulldog',
                    'slug' => 'Bulldog',
                    'pettype_id' => 2,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Beagle',
                    'slug' => 'Beagle',
                    'pettype_id' => 2,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Poodle',
                    'slug' => 'Poodle',
                    'pettype_id' => 2,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Rottweiler',
                    'slug' => 'Rottweiler',
                    'pettype_id' => 2,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Yorkshire Terrier',
                    'slug' => 'Yorkshire Terrier',
                    'pettype_id' => 2,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Boxer',
                    'slug' => 'Boxer',
                    'pettype_id' => 2,
                    'status' => 1,
                    'description' => '',

                ],
                [
                    'name' => 'Boston Terrier',
                    'slug' => 'Boston Terrier',
                    'pettype_id' => 2,
                    'status' => 1,
                    'description' => '',
                ],
                 //3
                [
                    'name' => 'Dutch Rabbit',
                    'slug' => 'Dutch Rabbit',
                    'pettype_id' => 3,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Netherland Dwarf',
                    'slug' => 'Netherland Dwarf',
                    'pettype_id' => 3,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Mini Lop',
                    'slug' => 'Mini Lop',
                    'pettype_id' => 3,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Lionhead',
                    'slug' => 'Lionhead',
                    'pettype_id' => 3,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Mini Rex',
                    'slug' => 'Mini Rex',
                    'pettype_id' => 3,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Flemish Giant',
                    'slug' => 'Flemish Giant',
                    'pettype_id' => 3,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'English Spot',
                    'slug' => 'English Spot',
                    'pettype_id' => 3,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Rex Rabbit',
                    'slug' => 'Rex Rabbit',
                    'pettype_id' => 3,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'American Fuzzy Lop',
                    'slug' => 'American Fuzzy Lop',
                    'pettype_id' => 3,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Angora Rabbit',
                    'slug' => 'Angora Rabbit',
                    'pettype_id' => 3,
                    'status' => 1,
                    'description' => '',
                ],
                //4
                [
                    'name' => 'Dumbo',
                    'slug' => 'Dumbo',
                    'pettype_id' => 4,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Hooded',
                    'slug' => 'Hooded',
                    'pettype_id' => 4,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Rex',
                    'slug' => 'Rex',
                    'pettype_id' => 4,
                    'status' => 1,
                    'description' => '',

                ],
                [
                    'name' => 'Patchwork',
                    'slug' => 'Patchwork',
                    'pettype_id' => 4,
                    'status' => 1,
                    'description' => '',

                ],
                [
                    'name' => 'Fawn',
                    'slug' => 'Fawn',
                    'pettype_id' => 4,
                    'status' => 1,
                    'description' => '',

                ],
                [
                    'name' => 'Berkshire',
                    'slug' => 'Berkshire',
                    'pettype_id' => 4,
                    'status' => 1,
                    'description' => '',

                ],
                [
                    'name' => 'Pearl',
                    'slug' => 'Pearl',
                    'pettype_id' => 4,
                    'status' => 1,
                    'description' => '',

                ],
                [
                    'name' => 'Mink',
                    'slug' => 'Mink',
                    'pettype_id' => 4,
                    'status' => 1,
                    'description' => '',

                ],
                [
                    'name' => 'Irish',
                    'slug' => 'Irish',
                    'pettype_id' => 4,
                    'status' => 1,
                    'description' => '',

                ],

                 //5
                 [
                    'name' => 'Budgerigar',
                    'slug' => 'Budgerigar',
                    'pettype_id' => 5,
                    'status' => 1,
                    'description' => '',

                ],
                [
                    'name' => 'Lovebirds',
                    'slug' => 'Lovebirds',
                    'pettype_id' => 5,
                    'status' => 1,
                    'description' => '',

                ],
                [
                    'name' => 'Parrots',
                    'slug' => 'Parrots',
                    'pettype_id' => 5,
                    'status' => 1,
                    'description' => '',

                ],
                [
                    'name' => 'Finch',
                    'slug' => 'Finch',
                    'pettype_id' => 5,
                    'status' => 1,
                    'description' => '',

                ],
                [
                    'name' => 'Cockatiel',
                    'slug' => 'Cockatiel',
                    'pettype_id' => 5,
                    'status' => 1,
                    'description' => '',

                ],
                [
                    'name' => 'Blue & Gold Macaw',
                    'slug' => 'Blue & Gold Macaw',
                    'pettype_id' => 5,
                    'status' => 1,
                    'description' => '',

                ],
                [
                    'name' => 'Pionus',
                    'slug' => 'Pionus',
                    'pettype_id' => 5,
                    'status' => 1,
                    'description' => '',

                ],
                [
                    'name' => 'Monk Parakeet',
                    'slug' => 'Monk Parakeet',
                    'pettype_id' => 5,
                    'status' => 1,
                    'description' => '',

                ],
                [
                    'name' => 'Canary',
                    'slug' => 'Canary',
                    'pettype_id' => 5,
                    'status' => 1,
                    'description' => '',

                ],
                [
                    'name' => 'Sparrow',
                    'slug' => 'Sparrow',
                    'pettype_id' => 5,
                    'status' => 1,
                    'description' => '',

                ],

                  //6
                [
                    'name' => 'Eastern Gray',
                    'slug' => 'Eastern Gray',
                    'pettype_id' => 6,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Red',
                    'slug' => 'Red',
                    'pettype_id' => 6,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Fox',
                    'slug' => 'Fox',
                    'pettype_id' => 6,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Douglas',
                    'slug' => 'Douglas',
                    'pettype_id' => 6,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Western Gray',
                    'slug' => 'Western Gray',
                    'pettype_id' => 6,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'American Red',
                    'slug' => 'American Red',
                    'pettype_id' => 6,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Eastern Chipmunk',
                    'slug' => 'Eastern Chipmunk',
                    'pettype_id' => 6,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Flying',
                    'slug' => 'Flying',
                    'pettype_id' => 6,
                    'status' => 1,
                    'description' => '',
                ],

                    //6
                [
                    'name' => 'Eastern Gray',
                    'slug' => 'Eastern Gray',
                    'pettype_id' => 6,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Red',
                    'slug' => 'Red',
                    'pettype_id' => 6,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Fox',
                    'slug' => 'Fox',
                    'pettype_id' => 6,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Douglas',
                    'slug' => 'Douglas',
                    'pettype_id' => 6,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Western Gray',
                    'slug' => 'Western Gray',
                    'pettype_id' => 6,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'American Red',
                    'slug' => 'American Red',
                    'pettype_id' => 6,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Eastern Chipmunk',
                    'slug' => 'Eastern Chipmunk',
                    'pettype_id' => 6,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Flying',
                    'slug' => 'Flying',
                    'pettype_id' => 6,
                    'status' => 1,
                    'description' => '',
                ],
                  //7
                [
                    'name' => 'Red-Eared',
                    'slug' => 'Red-Eared',
                    'pettype_id' => 7,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Painted',
                    'slug' => 'Painted',
                    'pettype_id' => 7,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Russian',
                    'slug' => 'Russian',
                    'pettype_id' => 7,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Greek',
                    'slug' => 'Greek',
                    'pettype_id' => 7,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'African',
                    'slug' => 'African',
                    'pettype_id' => 7,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Diamondback',
                    'slug' => 'Diamondback',
                    'pettype_id' => 7,
                    'status' => 1,
                    'description' => '',
                ],
                //8
                [
                    'name' => 'Panther',
                    'slug' => 'Panther',
                    'pettype_id' => 8,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Veiled',
                    'slug' => 'Veiled',
                    'pettype_id' => 8,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Senegal',
                    'slug' => 'Senegal',
                    'pettype_id' => 8,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => "Oustalet's",
                    'slug' => "Oustalet's",
                    'pettype_id' => 8,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Graceful',
                    'slug' => 'Graceful',
                    'pettype_id' => 8,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => "Meller's",
                    'slug' => "Meller's",
                    'pettype_id' => 8,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => "Jackson's",
                    'slug' => "Jackson's",
                    'pettype_id' => 8,
                    'status' => 1,
                    'description' => '',
                ],
                 //9
                [
                    'name' => 'Arabian',
                    'slug' => 'Arabian',
                    'pettype_id' => 9,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Thoroughbred',
                    'slug' => 'Thoroughbred',
                    'pettype_id' => 9,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Paint',
                    'slug' => 'Paint',
                    'pettype_id' => 9,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => "Morgan",
                    'slug' => "Morgan",
                    'pettype_id' => 9,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Andalusian',
                    'slug' => 'Andalusian',
                    'pettype_id' => 9,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => "Friesian",
                    'slug' => "Friesian",
                    'pettype_id' => 9,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => "Palomino",
                    'slug' => "Palomino",
                    'pettype_id' => 9,
                    'status' => 1,
                    'description' => '',
                ],
                   //10
                [
                    'name' => 'Betta Fish',
                    'slug' => 'Betta Fish',
                    'pettype_id' => 10,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Goldfish',
                    'slug' => 'goldfish',
                    'pettype_id' => 10,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Guppy',
                    'slug' => 'guppy',
                    'pettype_id' => 10,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => "Neon Tetra",
                    'slug' => "neon-tetra",
                    'pettype_id' => 10,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => 'Angelfish',
                    'slug' => 'angelfish',
                    'pettype_id' => 10,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => "Platies",
                    'slug' => "platies",
                    'pettype_id' => 10,
                    'status' => 1,
                    'description' => '',
                ],
                [
                    'name' => "Swordtail",
                    'slug' => "swordtail",
                    'pettype_id' => 10,
                    'status' => 1,
                    'description' => '',
                ]
            ];
            foreach ($data as $key => $value) {
                $pettype = [
                    'name' => $value['name'],
                    'slug' => $value['slug'],
                    'pettype_id' => $value['pettype_id'],
                    'description' => $value['description'],
                    'status' => $value['status'],
                ];
                $pettype = Breed::create($pettype);
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
