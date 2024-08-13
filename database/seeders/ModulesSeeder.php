<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Modules;
use Carbon\Carbon;

class ModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $modules = [
           
            [
                'module_name' => 'Booking',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'module_name' => 'Boarding',
                'description' => '',
                'status' => 1, 
                'more_permission' =>json_encode(['boarding_booking','boarder','facility']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_name' => 'Veterinary',
                'description' => '',
                'status' => 1,   
                'more_permission' =>json_encode(['veterinary_booking','veterinarian','veterinary_category','veterinary_service']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                
            ],
            [
                'module_name' => 'Grooming',
                'description' => '',
                'status' => 1,   
                'more_permission' =>json_encode(['grooming_booking','groomer','grooming_category','grooming_service']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                
            ],

            [
                'module_name' => 'Traning',
                'description' => '',
                'status' => 1,   
                'more_permission' =>json_encode(['training_booking','trainer','training_type','training_duration']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                
            ],
            [
                'module_name' => 'Walking',
                'description' => '',
                'status' => 1,   
                'more_permission' =>json_encode(['walking_booking','walker','walking_duration','booking_request']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                
            ],
            [
                'module_name' => 'DayCare',
                'description' => '',
                'status' => 1,   
                'more_permission' =>json_encode(['daycare_booking','care_taker']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                
            ],

            [
                'module_name' => 'PetSitter',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                
            ],

            [
                'module_name' => 'Service',
                'description' => '',
                'more_permission' =>json_encode(['assign_service']),
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                
            ],

            [
                'module_name' => 'Category',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                
            ],

            [
                'module_name' => 'subcategory',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                
            ],

            [
                'module_name' => 'Product',
                'description' => '',
                'status' => 1, 
                'more_permission' =>json_encode(['brand','product_category','product_subcategory','unit','tag']),  
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'module_name' => 'Product Variation',
                'description' => '',
                'status' => 1,  
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_name' => 'Order',
                'description' => '',
                'status' => 1, 
                'more_permission' =>json_encode(['order_review']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'module_name' => 'Supply',
                'description' => '',
                'status' => 1, 
                'more_permission' =>json_encode(['logistics','shipping_zones']),  
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'module_name' => 'Location',
                'description' => '',
                'status' => 1, 
                'more_permission' =>json_encode(['city','state','country']),  
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
            [
                'module_name' => 'Employees',
                'description' => '',
                'status' => 1, 
                'more_permission' =>json_encode(['employee_password','employee_earning','employee_payout','pending_employees']),  
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_name' => 'Owners',
                'description' => '',
                'status' => 1,   
                'more_permission' =>json_encode(["owner's pet",'user_password']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                
            ],

            [
                'module_name' => 'Review',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_name' => 'Tax',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'module_name' => 'Events',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'module_name' => 'Blogs',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'module_name' => 'Syetem Service',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'module_name' => 'Pet',
                'description' => '',
                'status' => 1,   
                'more_permission' =>json_encode(['pet type','breed']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_name' => 'Reports',
                'more_permission' =>json_encode(['daily_bookings','overall_bookings','order_reports']),
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
      
            [
                'module_name' => 'Page',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
      
            [
                'module_name' => 'Notification',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_name' => 'App Banner',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'module_name' => 'Notification Template',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], 
            [
                'module_name' => 'Constant',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], 
            [
                'module_name' => 'Permission',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], 
            [
                'module_name' => 'Modules',
                'description' => '',
                'status' => 1,   
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ] 
        ];

        // if(env('IS_DUMMY_DATA')) {
            foreach ($modules as $key => $module_data) {
                
                $modules = Modules::create($module_data);
                
            }
        // }

    }
}
