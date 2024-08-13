<?php

namespace Modules\Employee\database\seeders;

use App\Models\Branch;
use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Commission\Models\EmployeeCommission;
use Modules\Employee\Models\BranchEmployee;
use Modules\Employee\Models\EmployeeRating;
use Modules\Service\Models\ServiceEmployee;
use Modules\Commission\Models\Commission;
use Illuminate\Support\Arr;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        /*
         * Employees Seed
         * ------------------
         */

        // DB::table('employees')->truncate();
        // echo "Truncate: employees \n";

        $employee = [
            [
              'first_name' => 'Miles',
              'last_name' => 'Warren',
              'email' => 'miles@gmail.com',
              'feature_image' => public_path('/dummy-images/profile/boarder/Miles.png'),
              'password' => Hash::make('12345678'),
              'mobile' => '1-4752125589',
              'gender' => 'male',
              'email_verified_at' => Carbon::now(),
              'user_type' => 'boarder',
              'show_in_calender' => 1,
              'about_self' => 'Passionate and attentive pet caretaker devoted to ensuring the well-being and happiness of furry companions.',
              'expert' => 'First aid knowledge for pets',
              'created_at' => Carbon::now(),
              'updated_at' => Carbon::now(),
              'latitude'=>'54.607868',
              'longitude'=>'-5.926437'


            ],
            [
                'first_name' => 'Julian',
                'last_name' => 'Fisher',
                'email' => 'julian@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/boarder/Julian.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-4515478568',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'boarder',
                'show_in_calender' => 1,
                'about_self' => 'Experienced pet caregiver with a deep love for animals and a nurturing approach.',
                'expert' => 'Pet massage and relaxation techniques',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'latitude'=>'55.953251',
                'longitude'=>'-3.188267'

                
            ],
            [
                'first_name' => 'Glen',
                'last_name' => 'Hamiltor',
                'email' => 'glen@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/boarder/Glen.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-5541547857',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'boarder',
                'show_in_calender' => 1,
                'about_self' => 'Energetic and responsible pet sitter dedicated to creating a safe and enjoyable environment.',
                'expert' => 'Basic training for young pets',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'latitude'=>'57.553484',
                'longitude'=>'-3.335724'
            ],
            [
                'first_name' => 'Karen',
                'last_name' => 'Scottt',
                'email' => 'karen@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/boarder/Karen.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-2585841498',
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'boarder',
                'show_in_calender' => 1,
                'about_self' => 'Compassionate and patient animal lover with a track record of building strong bonds with pets.',
                'expert' => 'Behavioral assessments for socialization',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'latitude'=>'50.909698',
                'longitude'=>'-1.404351'
            ],
            [
                'first_name' => 'Jessica',
                'last_name' => 'Nelson',
                'email' => 'jessica@gmail.com   ',
                'feature_image' => public_path('/dummy-images/profile/boarder/Jessica.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-7852547855',
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'boarder',
                'show_in_calender' => 1,
                'about_self' => 'Detail-oriented pet care provider who prioritizes the specific needs and routines of each animal.',
                'expert' => 'Expert in positive reinforcement training methods',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'latitude'=>'50.259998',
                'longitude'=>'-3.325724'
            ],
            [
                'first_name' => 'Amalia',
                'last_name' => 'Martin',
                'email' => 'amalia@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/boarder/Amalia.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-2175478625',
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'boarder',
                'show_in_calender' => 1,
                'about_self' => 'Trustworthy and reliable pet caretaker committed to treating every furry friend like family.',
                'expert' => 'Large breed dog handling experience',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'latitude'=>'57.643484',
                'longitude'=>'-3.334724'
            ],

            //Vet

            [
                'first_name' => 'Dr. Felix',
                'last_name' => 'Harris',
                'email' => 'felix@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/veterinarian/Dr.Felix.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-7485961589',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'vet',
                'show_in_calender' => 1,
                'about_self' => 'Experienced in routine surgeries and dental procedures',
                'expert' => 'Behavior',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'latitude'=>'50.909698',
                'longitude'=>'-1.404351'
            ],
            [
                'first_name' => 'Dr. Jorge',
                'last_name' => 'Perez',
                'email' => 'jorge@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/veterinarian/Dr.Jorge.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-2563987415',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'vet',
                'show_in_calender' => 1,
                'about_self' => 'Dedicated to providing personalized care for each patient',
                'expert' => 'Cardiology',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Dr. Daniel',
                'last_name' => 'Wiliams',
                'email' => 'daniel@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/veterinarian/Dr.Daniel.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-3565478941',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'vet',
                'show_in_calender' => 1,
                'about_self' => 'Experienced in treating a variety of exotic pet diseases',
                'expert' => 'Dermatology',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'latitude'=>'53.3833318',
                'longitude'=>'-1.404351'
            ],
            [
                'first_name' => 'Dr. Jose',
                'last_name' => 'Parry',
                'email' => 'jose@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/veterinarian/Dr.Jose.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-8574965125',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'vet',
                'show_in_calender' => 1,
                'about_self' => 'Compassionate care for pets with chronic conditions',
                'expert' => 'Emergency and Critical Care',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'latitude'=>'51.063202',
                'longitude'=>'-1.308000'
            ],
            [
                'first_name' => 'Dr. Erik',
                'last_name' => 'Simon',
                'email' => 'erik@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/veterinarian/Dr.Erik.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-5674587152',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'vet',
                'show_in_calender' => 1,
                'about_self' => 'Caring for pets with various ocular diseases and injuries',
                'expert' => 'Orthopedic Surgery',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'latitude'=>'50.063202',
                'longitude'=>'-1.308000'
            ],
            [
                'first_name' => 'Dr. Parsa',
                'last_name' => 'Evana',
                'email' => 'parsa@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/veterinarian/Dr.Parsa.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-4578965541',
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'vet',
                'show_in_calender' => 1,
                'about_self' => 'Experience in acupuncture for pain management and stress reduction',
                'expert' => 'Nutrition',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Dr. Erica',
                'last_name' => 'Mendiz',
                'email' => 'erica@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/veterinarian/Dr.Erica.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-4578965541',
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'vet',
                'show_in_calender' => 1,
                'about_self' => 'Dedicated to providing immediate and compassionate care in emergencies',
                'expert' => 'Anesthesiology',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            //groomer
            [
                'first_name' => 'Richard',
                'last_name' => 'Howard',
                'email' => 'richard@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/groomer/Richard.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-7481547856',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'groomer',
                'show_in_calender' => 1,
                'about_self' => 'Passionate about pampering pets with gentle grooming techniques.',
                'expert' => 'Breed-Specific Styling',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'latitude'=>'51.063202',
                'longitude'=>'-1.308000'
            ],
            [
                'first_name' => 'Roberto',
                'last_name' => 'Gorden',
                'email' => 'roberto@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/groomer/Roberto.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-1241547857',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'groomer',
                'show_in_calender' => 1,
                'about_self' => 'Skilled groomer specializing in breed-specific trims and creative styling.',
                'expert' => 'Cat Grooming',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Ken',
                'last_name' => 'Simon',
                'email' => 'ken@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/groomer/Ken.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-7485841458',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'groomer',
                'show_in_calender' => 1,
                'about_self' => 'Dedicated to providing stress-free grooming experiences for furry clients.',
                'expert' => 'Furminator Shed-Less Treatment',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Wade',
                'last_name' => 'Allen',
                'email' => 'wade@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/groomer/Wade.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-1452547859',
                'gender' => 'groomer',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'groomer',
                'show_in_calender' => 1,
                'about_self' => 'Experienced groomer with a keen eye for detail and a love for pet makeovers.',
                'expert' => 'Specialty Spa Treatments',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Deborah',
                'last_name' => 'Thomas',
                'email' => 'deborah@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/groomer/Deborah.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-1475478605',
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'groomer',
                'show_in_calender' => 1,
                'about_self' => 'Patient and caring groomer committed to ensuring pets look and feel their best.',
                'expert' => 'Poodle Styling',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Susan',
                'last_name' => 'Williams',
                'email' => 'susan@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/groomer/Susan.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-2381547861',
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'groomer',
                'show_in_calender' => 1,
                'about_self' => 'Professional groomer adept at handling pets of all sizes and temperaments.',
                'expert' => 'Mat and Tangle Removal',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Dorothy',
                'last_name' => 'Norman',
                'email' => 'dorothy@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/groomer/Dorothy.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-5261546325',
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'groomer',
                'show_in_calender' => 1,
                'about_self' => 'Passionate about animals, skilled in breed-specific grooming techniques, and dedicated to providing top-notch care for furry friends.',
                'expert' => 'Coat Care, Nail Trimming',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Sara',
                'last_name' => 'Gross',
                'email' => 'sara@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/groomer/Sara.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-5861547785',
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'groomer',
                'show_in_calender' => 1,
                'about_self' => 'Experienced in handling various pet temperaments, committed to creating a stress-free grooming experience, and always striving for pawfection!',
                'expert' => 'Scissoring, Grooming Styles',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // trainer

            [
                'first_name' => 'Tristan',
                'last_name' => 'Erickson',
                'email' => 'tristan@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/trainer/Tristan.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-4752125545',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'trainer',
                'show_in_calender' => 1,
                'about_self' => ' Experienced trainer skilled in advanced obedience and off-leash control..',
                'expert' => 'Experienced Cat Trainer, Teaching Felines Fun Tricks & Interactive Behavior.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Vernon',
                'last_name' => 'Simon',
                'email' => 'vernon@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/trainer/Vernon.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-4515478569',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'trainer',
                'show_in_calender' => 1,
                'about_self' =>'Patient and positive trainer specializing in puppy socialization and basic obedience.',
                'expert' => 'Mastering Leash Training & Off-Leash Control, Ensuring Safe & Enjoyable Walks.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Oscar',
                'last_name' => 'Miles',
                'email' => 'oscar@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/trainer/Oscar.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-5541547857',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'trainer',
                'show_in_calender' => 1,
                'about_self' => 'Compassionate trainer focusing on fear and anxiety management for stressed pets.',
                'expert' => 'Clicker Training Guru, Utilizing Positive Reinforcement for Precise Behavioral Shaping.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Tracy',
                'last_name' => 'Jones',
                'email' => 'tracy@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/trainer/Tracy.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-4759025523',
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'trainer',
                'show_in_calender' => 1,
                'about_self' => 'Specialized in service dog training to empower individuals with disabilities and their canine partners.',
                'expert' => 'Certified Service Dog Trainer, Providing Tailored Training for Assistance and Support Tasks.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Emily',
                'last_name' => 'Parks',
                'email' => 'emily@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/trainer/Emily.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-3515478545',
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'trainer',
                'show_in_calender' => 1,
                'about_self' => 'Dedicated to helping pets overcome behavioral challenges through positive reinforcement.',
                'expert' => 'Behavior Modification Specialist, Addressing Anxiety & Aggression with Positive Behavior Techniques..',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Molly',
                'last_name' => 'Jorden',
                'email' => 'molly@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/trainer/Molly.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-4585478546',
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'trainer',
                'show_in_calender' => 1,
                'about_self' => 'Experienced in breed-specific training and creative enrichment activities.',
                'expert' => 'Specializes in Agility Training & Canine Good Citizen (CGC) Certification, Making Training Fun and Engaging.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            //walker

            [
                'first_name' => 'Pedro',
                'last_name' => 'Norris',
                'email' => 'pedro@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/walker/Pedro.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-3852417895',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'walker',
                'show_in_calender' => 1,
                'about_self' => 'Enthusiastic pet walker, providing joyful exercise and attentive care.',
                'expert' => 'Expert in handling large and energetic breeds',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Thomas',
                'email' => 'david@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/walker/David.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-8954785412',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'walker',
                'show_in_calender' => 1,
                'about_self' => 'Experienced dog walker, committed to ensuring daily adventures and tail-wagging fun.',
                'expert' => 'Specialized in caring for senior dogs and accommodating their pace',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Andy',
                'last_name' => 'Potter',
                'email' => 'andy@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/walker/Andy.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-4785125896',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'walker',
                'show_in_calender' => 1,
                'about_self' => "Caring and reliable walker, tailoring walks to meet each pet's needs.",
                'expert' => 'Expertise in managing leash-reactive or aggressive behavior',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Lance',
                'last_name' => 'Martin',
                'email' => 'lance@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/walker/Lance.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-5874589625',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'walker',
                'show_in_calender' => 1,
                'about_self' => 'Gentle and patient walker, focused on building trust and strong bonds with furry friends.',
                'expert' => 'Experienced in handling small animals (e.g., rabbits, mouse,squirrel) during supervised outdoor excursions',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Beverly',
                'last_name' => 'Baker',
                'email' => 'beverly@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/walker/Beverly.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-7481547856',
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'walker',
                'show_in_calender' => 1,
                'about_self' => 'Responsible and punctual walker, catering to dogs of all sizes and breeds.',
                'expert' => 'Proficient in using GPS and mobile apps for tracking walks and providing updates to pet owners',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'latitude'=>'57.653484',
                'longitude'=>'-3.125724'
            ],
            [
                'first_name' => 'Crysta',
                'last_name' => 'Ellis',
                'email' => 'crysta@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/walker/Crysta.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-2481547857',
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'walker',
                'show_in_calender' => 1,
                'about_self' => 'Passionate cat and small pet walker, providing gentle and enriching outings.',
                'expert' => 'Knowledgeable about maintaining proper hygiene and cleaning protocols during and after walks',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'latitude'=>'50.909698',
                'longitude'=>'-3.125724'
            ],

            //daycare

            [
                'first_name' => 'Justin',
                'last_name' => 'Green',
                'email' => 'justin@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/daycare/Justin.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-4152874589',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'day_taker',
                'show_in_calender' => 1,
                'about_self' => 'Loving and responsible day care taker, providing a safe and fun environment for furry guests.',
                'expert' => 'Experience in managing group play sessions for dogs of various sizes and temperaments.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'latitude'=>'50.259998',
                'longitude'=>'-3.325724'
            ],
            [
                'first_name' => 'Ivan',
                'last_name' => 'Gonzalez',
                'email' => 'ivan@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/daycare/Ivan.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-2145874590',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'day_taker',
                'show_in_calender' => 1,
                'about_self' => 'Enthusiastic pet lover, dedicated to ensuring every pet has a tail-wagging time in day care.',
                'expert' => 'Knowledgeable in administering medications and catering to pets with special requirements.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'latitude'=>'50.259998',
                'longitude'=>'-3.325724'
            ],
            [
                'first_name' => 'Riley',
                'last_name' => 'Baker',
                'email' => 'riley@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/daycare/Riley.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-4152878956',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'day_taker',
                'show_in_calender' => 1,
                'about_self' => 'Patient and attentive, ensuring pets receive proper care and affection throughout the day.',
                'expert' => 'Expert in organizing and supervising playtime activities for cats and small animals.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Ramon',
                'last_name' => 'Burns',
                'email' => 'ramon@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/daycare/Ramon.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-1452744592',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'day_taker',
                'show_in_calender' => 1,
                'about_self' => ' Nurturing day care taker, committed to providing individualized attention and playtime.',
                'expert' => 'Knowledgeable in providing nutritious snacks and meals during the day.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'latitude'=>'53.383331',
                'longitude'=>'-3.325724'
            ],
            [
                'first_name' => 'Betty',
                'last_name' => 'Thomas',
                'email' => 'betty@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/daycare/Betty.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-7892874558',
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'day_taker',
                'show_in_calender' => 1,
                'about_self' => 'Experienced in handling pets of all personalities, making sure they enjoy their stay at day care.',
                'expert' => 'Experienced in recognizing signs of stress and providing appropriate care.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Helen',
                'last_name' => 'Robinson',
                'email' => 'helen@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/daycare/Helen.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-1252874547',
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'day_taker',
                'show_in_calender' => 1,
                'about_self' => 'Passionate about fostering a happy and social atmosphere for pets in day care.',
                'expert' => 'Specialized in handling multiple pets at once and managing a busy day care schedule.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'latitude'=>'50.259998',
                'longitude'=>'-3.325724'
            ],

            [
                'first_name' => 'Demo',
                'last_name' => 'Admin',
                'email' => 'demo@Porosenocheck.com',
                'password' => Hash::make('12345678'),
                'mobile' => '44-5289568745',
                'date_of_birth' => fake()->date,
                // 'avatar' => $avatarPath.'male.webp',
                'feature_image' => public_path('/dummy-images/profile/Admin/demo_super_admin.png'),
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'demo_admin',
                'about_self' => '-',
                'expert' => '-',
            ],
            [
                'first_name' => 'Harry ',
                'last_name' => 'Thomas',
                'email' => 'harry@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/petsitter/harry.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-3678125559',
                'gender' => 'Male',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'pet_sitter',
                'show_in_calender' => 1,
                'about_self' =>"I'm a devoted pet sitter who believes in giving pets the love and attention they deserve.",
                'expert' => "I've been caring for pets for over a decade, creating countless tails of happiness.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'latitude'=>'50.259798',
                'longitude'=>'-3.315724'
            ],
            [
                'first_name' => 'Dan',
                'last_name' => 'Gordon',
                'email' => 'dan@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/petsitter/dan.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-1452878564',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'pet_sitter',
                'show_in_calender' => 1,
                'about_self' => "With years of experience, I'm dedicated to ensuring your pets feel safe, happy, and loved.",
                'expert' => "With many years of professional pet sitting, I've been part of many pet families.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'latitude'=>'53.383331',
                'longitude'=>'-3.315624'
            ],
            [
                'first_name' => 'Harvey',
                'last_name' => 'Francis',
                'email' => 'harvey@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/petsitter/harvey.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-8874547968',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'pet_sitter',
                'show_in_calender' => 1,
                'about_self' => "I'm a reliable pet sitter with a soft spot for animals, and I'm committed to their well-being.",
                'expert' => "My pet sitting journey spans many years, filled with furry friends and unforgettable moments.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'latitude'=>'57.653484',
                'longitude'=>'-3.314624'
            ],
            [
                'first_name' => 'Leona ',
                'last_name' => 'Davis',
                'email' => 'leona@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/petsitter/leona.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-2547841493',
                'gender' => 'Female',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'pet_sitter',
                'show_in_calender' => 1,
                'about_self' =>"As a passionate pet sitter, I'm all about creating a joyful and stress-free experience for your pets.",
                'expert' => "I've dedicated the past many years to making pets' lives better, one walk and cuddle at a time.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'latitude'=>'50.259798',
                'longitude'=>'-3.315724'
            ],
            [
                'first_name' => 'Angela',
                'last_name' => 'Perez',
                'email' => 'angela@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/petsitter/angela.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-3652547855',
                'gender' => 'Female',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'pet_sitter',
                'show_in_calender' => 1,
                'about_self' => "I treat every pet as if they were my own, ensuring they get the best care and lots of cuddles.",
                'expert' => "For many years, I've been the go-to pet sitter, turning pawsibilities into realities.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'latitude'=>'53.383331',
                'longitude'=>'-3.315624'
            ],
            [
                'first_name' => 'Amy',
                'last_name' => 'Ellis',
                'email' => 'amy@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/petsitter/amy.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-4785478627',
                'gender' => 'Female',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'pet_sitter',
                'show_in_calender' => 1,
                'about_self' => "I'm a compassionate pet sitter who believes that pets are family, and I'm dedicated to their happiness and well-being.",
                'expert' => "I've spent a rewarding decade as a pet sitter, ensuring that tails wag and whiskers twitch with delight.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'latitude'=>'57.653484',
                'longitude'=>'-3.314624'
            ],

            [
                'first_name' => 'Mario',
                'last_name' => 'Francis',
                'email' => 'mario@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/pet_store_seller/mario.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-58981256',
                'gender' => 'Male',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'pet_store',
                'show_in_calender' => 1,
                'about_self' => "Pet parent creating a cozy space for pets and their owners.",
                'expert' => "Knowledgeable in holistic pet care; offering premium pet-friendly products.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'latitude'=>'50.909698',
                'longitude'=>'-3.125724'
            ],
            [
                'first_name' => 'Dave',
                'last_name' => 'Lopez',
                'email' => 'dave@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/pet_store_seller/dave.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-15478568',
                'gender' => 'Male',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'pet_store',
                'show_in_calender' => 1,
                'about_self' => "Passionate bird lover curating an avian wonderland.",
                'expert' => "Knowledgeable in avian care; offering diverse bird-related supplies.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'latitude'=>'57.653484',
                'longitude'=>'-3.314624'
            ],
            [
                'first_name' => 'Marsha',
                'last_name' => 'Hamiltor',
                'email' => 'marsha@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/pet_store_seller/marsha.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-52547855',
                'gender' => 'Female',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'pet_store',
                'show_in_calender' => 1,
                'about_self' => "Cat enthusiast crafting a paradise for feline companions.",
                'expert' => "Expert in feline behavior; offering unique cat-centric products.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'latitude'=>'50.909698',
                'longitude'=>'-3.125724'
            ],
            [
                'first_name' => 'Brenda',
                'last_name' => 'Perry',
                'email' => 'brenda@gmail.com',
                'feature_image' => public_path('/dummy-images/profile/pet_store_seller/brenda.png'),
                'password' => Hash::make('12345678'),
                'mobile' => '1-75478625',
                'gender' => 'Female',
                'email_verified_at' => Carbon::now(),
                'user_type' => 'pet_store',
                'show_in_calender' => 1,
                'about_self' => "Lifelong animal advocate committed to enhancing pet happiness.",
                'expert' => "Specialized in dog wellness and high-quality canine accessories.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'latitude'=>'57.653484',
                'longitude'=>'-3.314624'
            ],

        ];

        if (env('IS_DUMMY_DATA')) {
            $commission = Commission::first();
            foreach ($employee  as $key => $employee_data) {

                $image = $employee_data['feature_image'] ?? null;
                $empData = Arr::except($employee_data, [ 'feature_image','about_self','expert']);
                $emp = User::create($empData);
                $emp->assignRole($emp->user_type);

                if($emp->email == 'felix@gmail.com'){
                    $emp->assignRole('pet_store');
                    $emp->update(['enable_store' => 1]);
                    EmployeeCommission::create([
                        'employee_id' => $emp->id,
                        'commission_id' => 2,
                    ]);
                }

                if (isset($image)) {
                    $this->attachFeatureImage($emp, $image);
                }

                $branchId = get_pet_center_id();
                
                BranchEmployee::create([
                    'branch_id' => $branchId,
                    'employee_id' => $emp->id,
                ]);

                if($emp->user_type == 'pet_store'){
                    EmployeeCommission::create([
                        'employee_id' => $emp->id,
                        'commission_id' => 2,
                    ]);
                }
                else{
                    EmployeeCommission::create([
                        'employee_id' => $emp->id,
                        'commission_id' => $commission->id,
                    ]);
                }

                UserProfile::create([
                    'user_id' => $emp->id,
                    'about_self' => $employee_data['about_self'],   
                    'expert' => $employee_data['expert']  
                ]);
                
                // $this->dummyReview($emp->id);

            }

        }


        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
    private function attachFeatureImage($model, $publicPath)
    {
        if(!env('IS_DUMMY_DATA_IMAGE')) return false;

        $file = new \Illuminate\Http\File($publicPath);

        $media = $model->addMedia($file)->preservingOriginal()->toMediaCollection('profile_image');

        return $media;
    }
    private function dummyReview($emp_id) {
        $employeerating = [
            [
                'employee_id' => $emp_id,
                'user_id' => fake()->numberBetween(2, 40),
                'review_msg' => 'Awesome service',
                'rating' => fake()->numberBetween(3, 5),
            ],
            [
                'employee_id' => $emp_id,
                'user_id' => fake()->numberBetween(2, 40),
                'review_msg' => 'Very nice',
                'rating' => fake()->numberBetween(3, 5),
            ],
            [
                'employee_id' => $emp_id,
                'user_id' => fake()->numberBetween(2, 40),
                'review_msg' => 'Very Good',
                'rating' => fake()->numberBetween(3, 5),
            ],
            [
                'employee_id' => $emp_id,
                'user_id' => fake()->numberBetween(2, 40),
                'review_msg' => 'Nice',
                'rating' => fake()->numberBetween(3, 5),
            ],
            [
                'employee_id' => $emp_id,
                'user_id' => fake()->numberBetween(2, 40),
                'review_msg' => 'Awesome service',
                'rating' => fake()->numberBetween(3, 5),
            ],
            [
                'employee_id' => $emp_id,
                'user_id' => fake()->numberBetween(2, 40),
                'review_msg' => 'Good service',
                'rating' => fake()->numberBetween(3, 5),
            ],
        ];
        foreach ($employeerating  as $key => $employeeRating_data) {
            EmployeeRating::create($employeeRating_data);
        }
    }
}
                     