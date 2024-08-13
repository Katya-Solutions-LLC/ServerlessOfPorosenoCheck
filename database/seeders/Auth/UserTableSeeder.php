<?php

namespace Database\Seeders\Auth;

use App\Events\Backend\UserCreated;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Arr;
use App\Models\Address;

/**
 * Class UserTableSeeder.
 */
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        // Add the master administrator, user id of 1
        $avatarPath = config('app.avatar_base_path');
       

        $users = [
            [
              'first_name' => 'Super',
              'last_name' => 'Admin',
              'email' => 'admin@Porosenocheck.com',
              'password' => Hash::make('12345678'),
              'mobile' => '44-5289568745',
              'date_of_birth' => fake()->date,
              'avatar' => $avatarPath.'male.webp',
              'profile_image' => public_path('/dummy-images/profile/Admin/super_admin.png'),
              'gender' => 'male',
              'email_verified_at' => Carbon::now(),
              'created_at' => Carbon::now(),
              'updated_at' => Carbon::now(),
              'user_type' => 'admin',
            ],
            
            [
              'first_name' => 'John',
              'last_name' => 'Doe',
              'email' => 'john@gmail.com',
              'password' => Hash::make('12345678'),
              'mobile' => '1-4578952512',
              'date_of_birth' => fake()->date,
              'profile_image' => public_path('/dummy-images/profile/owner/John.png'),
              'avatar' => $avatarPath.'male.webp',
              'gender' => 'male',
              'email_verified_at' => Carbon::now(),
              'created_at' => Carbon::now(),
              'updated_at' => Carbon::now(),
              'user_type' => 'user',
              'address' => [
                [
                  'postal_code' => '445632',
                  'address_line_1' => '23, Square Street',
                  'address_line_2' => 'Near Sea View Point',
                  'city' =>  10001,
                  'state' => 3866,
                  'country' => 230,
                ],
                [
                  'postal_code' => '442387',
                  'address_line_1' => '3, Hill Street',
                  'address_line_2' => 'Near Mile View Building',
                  'city' =>  10002,
                  'state' => 3866,
                  'country' => 230,
                ]
              ]
            ],
            [
                'first_name' => 'Robert',
                'last_name' => 'Martin',
                'email' => 'robert@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '1-7485961545',
                'date_of_birth' => fake()->date,
                'avatar' => $avatarPath.'male.webp',
                'profile_image' => public_path('/dummy-images/profile/owner/Robert.png'),
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
              'user_type' => 'user',

            ],
            [
                'first_name' => 'Bentley',
                'last_name' => 'Howard',
                'email' => 'bentley@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '1-2563987448',
                'date_of_birth' => fake()->date,
                'avatar' => null,
                'profile_image' => public_path('/dummy-images/profile/owner/Bentley.png'),
                'gender' => 'other',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
              'user_type' => 'user',

            ],
            [
                'first_name' => 'Brian',
                'last_name' => 'Shaw',
                'email' => 'brian@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '1-3565478912',
                'date_of_birth' => fake()->date,
                'avatar' => null,
                'profile_image' => public_path('/dummy-images/profile/owner/Brian.png'),
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
              'user_type' => 'user',

            ],
            [
                'first_name' => 'Liam',
                'last_name' => 'Long',
                'email' => 'liam@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '1-8574965162',
                'date_of_birth' => fake()->date,
                'avatar' => null,
                'profile_image' => public_path('/dummy-images/profile/owner/Liam.png'),
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
              'user_type' => 'user',

            ],
            [
                'first_name' => 'Gilbert',
                'last_name' => 'Adams',
                'email' => 'gilbert@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '1-5674587110',
                'date_of_birth' => fake()->date,
                'avatar' => null,
                'profile_image' => public_path('/dummy-images/profile/owner/Gilbert.png'),
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'user',

            ],
            [
                'first_name' => 'Pedra',
                'last_name' => 'Danlel',
                'email' => 'pedra@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '1-6589741258',
                'date_of_birth' => fake()->date,
                'avatar' => null,
                'profile_image' => public_path('/dummy-images/profile/owner/Pedra.png'),
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
              'user_type' => 'user',

            ],
            [
                'first_name' => 'Diana',
                'last_name' => 'Norris',
                'email' => 'diana@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '1-5687412589',
                'date_of_birth' => fake()->date,
                'avatar' => null,
                'profile_image' => public_path('/dummy-images/profile/owner/Diana.png'),
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
              'user_type' => 'user',

            ],
            [
                'first_name' => 'Stella',
                'last_name' => 'Green',
                'email' => 'stella@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '1-6352897456',
                'date_of_birth' => fake()->date,
                'avatar' => null,
                'profile_image' => public_path('/dummy-images/profile/owner/Stella.png'),
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
              'user_type' => 'user',

            ],
            [
                'first_name' => 'Lisa',
                'last_name' => 'Lucas',
                'email' => 'lisa@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '1-3652417895',
                'date_of_birth' => fake()->date,
                'avatar' => null,
                'profile_image' => public_path('/dummy-images/profile/owner/Lisa.png'),
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
              'user_type' => 'user',

            ],
            // [
            //   'first_name' => 'Demo',
            //   'last_name' => 'Admin',
            //   'email' => 'demo@Porosenocheck.com',
            //   'password' => Hash::make('12345678'),
            //   'mobile' => '44-5289568745',
            //   'date_of_birth' => fake()->date,
            //   'avatar' => $avatarPath.'male.webp',
            //   'profile_image' => public_path('/dummy-images/profile/Admin/super_admin.png'),
            //   'gender' => 'male',
            //   'email_verified_at' => Carbon::now(),
            //   'created_at' => Carbon::now(),
            //   'updated_at' => Carbon::now(),
            //   'user_type' => 'demo_admin',
            // ]
            
           
        ];
        
        if (env('IS_DUMMY_DATA')) {
          foreach ($users as $key => $user_data) {
              $featureImage = $user_data['profile_image'] ?? null;
              $userData = Arr::except($user_data, ['profile_image','address']);
              $user = User::create($userData);

              if (isset($user_data['address'])) {
                $addresses = $user_data['address'];
                
                foreach($addresses as $addressData){
                    $address = new Address($addressData);
                    $user->address()->save($address);
                }
              }
        
              $user->assignRole($user_data['user_type']);
            
         
              event(new UserCreated($user));
              if (isset($featureImage)) {
                  $this->attachFeatureImage($user, $featureImage);
              }
          }
          if (env('IS_FAKE_DATA')) {
            User::factory()->count(30)->create()->each(function ($user){
              $user->assignRole('user');
              $img = public_path('/dummy-images/customers/'.fake()->numberBetween(1,13).'.webp');
              $this->attachFeatureImage($user, $img);
            });
          }
      }


        Schema::enableForeignKeyConstraints();
    }

    private function attachFeatureImage($model, $publicPath)
    {
        if(!env('IS_DUMMY_DATA_IMAGE')) return false;

        $file = new \Illuminate\Http\File($publicPath);

        $media = $model->addMedia($file)->preservingOriginal()->toMediaCollection('profile_image');

        return $media;
    }
}
