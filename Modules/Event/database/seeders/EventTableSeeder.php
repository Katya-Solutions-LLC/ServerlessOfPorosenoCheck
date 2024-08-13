<?php

namespace Modules\Event\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Event\Models\Event;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class EventTableSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks!
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        if (env('IS_DUMMY_DATA')) {
            $data =[
                [
                    'name' => 'Pet Adoption Fair',
                    'slug' => 'Pet Adoption Fair',
                    // 'date' => '2023-08-08',
                    'date' => Carbon::today()->addDays(rand(1, 30)),
                    'user_id' =>12,
                    'location' => '1 Fantastic Street,
Near Croma Building,
Toronto, ON M5V 2W6,
Canada',
                    'description' => 'Partner with local animal shelters and rescue organizations to host an adoption fair where people can meet and adopt adorable pets in need of loving homes.',
                    'status' => 1,
                    'image' => public_path('/dummy-images/event/1.Pet Adoption Fair.png'),
                ],
                [
                    'name' => 'Pet Health Check-Up Day',
                    'slug' => 'Pet Health Check-Up Day',
                    // 'date' => '2023-08-10',
                    'date' => Carbon::today()->addDays(rand(1, 30)),
                    'user_id' =>18,
                    'location' => '22 Maple Avenue,
Next to Skyline Tower,
Vancouver, BC V6Z 1Z1,
Canada',
                    'description' => 'Offer a day of free or discounted pet health check-ups, where pet owners can bring their furry companions for a general health assessment, vaccinations, and preventive care advice.',
                    'status' => 1,
                    'image' => public_path('/dummy-images/event/2.Pet Health Check-Up Day.png'),
                ],
                [
                    'name' => 'Pet Grooming for Charity',
                    'slug' => 'Pet Grooming for Charity',
                    // 'date' => '2023-08-15',
                    'date' => Carbon::today()->addDays(rand(1, 30)),
                    'user_id' =>25,
                    'location' => '123 Lakeview Drive,
Across from City Center,
Calgary, AB T2P 0L5,
Canada',
                    'description' => 'Dedicate a portion of your proceeds from a specific day or week to support a local animal shelter or pet-related charity.',
                    'status' => 1,
                    'image' => public_path('/dummy-images/event/3.Pet Grooming for Charity.png'),
                ],
                [
                    'name' => 'Pet Costume Contest',
                    'slug' => 'Pet Costume Contest',
                    // 'date' => '2023-08-22',
                    'date' => Carbon::today()->addDays(rand(1, 30)),
                    'user_id' =>13,
                    'location' => '45 Riverside Road,
Adjacent to Tech Park,
Kelowna, BC V1Y 3P2,
Canada',
                    'description' => 'Hold a fun and creative pet costume contest, encouraging participants to dress up their furry friends in various themes and win exciting prizes.',
                    'status' => 1,
                    'image' => public_path('/dummy-images/event/4.Pet Costume Contest.png'),
                ],
                [
                    'name' => 'Pet Talent Show',
                    'slug' => 'Pet Talent Show',
                    // 'date' => '2023-10-03',
                    'date' => Carbon::today()->addDays(rand(1, 30)),
                    'user_id' =>33,
                    'location' => '678 Pine Street,
Near Harbor Mall,
Montreal, QC H3A 1A7,
Canada',
                    'description' => 'Let pets showcase their unique talents and tricks. From dogs performing tricks to cats doing agility, this event will surely entertain the audience.',
                    'status' => 1,
                    'image' => public_path('/dummy-images/event/5.Pet Talent Show.png'),
                ],
                [
                    'name' => 'Pet Grooming Photo Contest',
                    'slug' => 'Pet Grooming Photo Contest',
                    // 'date' => '2023-08-27',
                    'date' => Carbon::today()->addDays(rand(1, 30)),
                    'user_id' =>30,
                    'location' => '789 Mountain View Lane,
Beside Business Plaza,
Edmonton, AB T5J 3H1,
Canada',
                    'description' => 'Encourage pet owners to share photos of their freshly groomed pets on social media, and award prizes for the most stylish and adorable transformations.',
                    'status' => 1,
                    'image' => public_path('/dummy-images/event/6.Pet Grooming Photo Contest.png'),
                ],
                [
                    'name' => 'Dog Agility Competition',
                    'slug' => 'Dog Agility Competition',
                    // 'date' => '2023-09-20',
                    'date' => Carbon::today()->addDays(rand(1, 30)),
                    'user_id' =>41,
                    'location' => '56 Forest Avenue,
By Civic Center,
Winnipeg, MB R3L 0L9,
Canada',
                    'description' => 'Set up an agility course with obstacles for dogs to showcase their speed and skills. This event can be a great way to entertain both participants and spectators.',
                    'status' => 1,
                    'image' => public_path('/dummy-images/event/7.Dog Agility Competition.png'),
                ],
                [
                    'name' => 'Pet Birthday Paw-ty',
                    'slug' => 'Pet Birthday Paw-ty',
                    // 'date' => '2023-09-30',
                    'date' => Carbon::today()->addDays(rand(1, 30)),
                    'user_id' =>45,
                    'location' => '999 Oceanfront Drive,
Near Innovation Park,
Halifax, NS B3H 4R2,
Canada',
                    'description' => 'Celebrate the birthdays of pets at the day care with pet-friendly birthday cakes, party hats, and goodie bags for the furry guests.',
                    'status' => 1,
                    'image' => public_path('/dummy-images/event/8.Pet Birthday Paw-ty.png'),
                ],
                [
                    'name' => 'Vaccination Drive',
                    'slug' => 'Vaccination Drive',
                    // 'date' => '2023-09-25',
                    'date' => Carbon::today()->addDays(rand(1, 30)),
                    'user_id' =>23,
                    'location' => '333 Sunset Boulevard,
Just off Downtown Square,
Regina, SK S4P 3V2,
Canada',
                    'description' => 'Organize a vaccination drive to ensure pets in the community are up-to-date on their vaccinations to prevent the spread of infectious diseases.',
                    'status' => 1,
                    'image' => public_path('/dummy-images/event/9.Vaccination Drive.png'),
                ],
                [
                    'name' => 'Fear-Free Training Seminar',
                    'slug' => 'Fear-Free Training Seminar',
                    // 'date' => '2023-09-08',
                    'date' => Carbon::today()->addDays(rand(1, 30)),
                    'user_id' =>36,
                    'location' => '777 Riverwalk Place,
Opposite Civic Auditorium,
Quebec City, QC G1R 2L1,
Canada',
                    'description' => 'Host a seminar on fear-free training techniques, emphasizing positive reinforcement methods to build trust and confidence in pets.',
                    'status' => 1,
                    'image' => public_path('/dummy-images/event/10.Fear-Free Training Seminar.png'),
                ],
                [
                    'name' => 'Puppy/Kitten Socialization & Grooming Party',
                    'slug' => 'Puppy/Kitten Socialization & Grooming Party',
                    // 'date' => '2023-09-10',
                    'date' => Carbon::today()->addDays(rand(1, 30)),
                    'user_id' =>26,
                    'location' => '21 Serene Street,
Near Tech Hub,
Victoria, BC V8W 2B7,
Canada',
                    'description' => 'Organize a socialization and grooming event specifically for young pets, helping them become more comfortable with grooming at an early age.',
                    'status' => 1,
                    'image' => public_path('/dummy-images/event/11.Puppy-Kitten Socialization _ Grooming Party.png'),
                ],
                [
                    'name' => 'Pet Olympics',
                    'slug' => 'Pet Olympics',
                    // 'date' => '2023-11-08',
                    'date' => Carbon::today()->addDays(rand(1, 30)),
                    'user_id' =>39,
                    'location' => "555 Harborview Road,
Close to Shopping Center,
St. John's, NL A1A 1A1,
Canada",
                    'description' => 'Organize a fun event with various pet-friendly games and activities to entertain pets and their owners.',
                    'status' => 1,
                    'image' => public_path('/dummy-images/event/12.Pet Olympics.png'),
                ],
            ];
            foreach ($data as $key => $value) {
                $image = $value['image'] ?? null;
                $event = Arr::except($value, ['image']);
                $event = [
                    'name' => $value['name'],
                    'slug' => $value['slug'],
                    'date' => $value['date'],
                    'description' =>  $value['description'],
                    'user_id' =>$value['user_id'],
                    'location' =>$value['location'],
                    'status' => $value['status'],
                ];
                $event = Event::create($event);
                if (isset($image)) {
                    $this->attachFeatureImage($event, $image);
                    
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

        $media = $model->addMedia($file)->preservingOriginal()->toMediaCollection('event_image');

        return $media;
    }
}
