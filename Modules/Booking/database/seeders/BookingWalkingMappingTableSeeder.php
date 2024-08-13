<?php

namespace Modules\Booking\database\seeders;
use Illuminate\Database\Seeder;

class BookingWalkingMappingTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('booking_walking_mapping')->delete();
        
        \DB::table('booking_walking_mapping')->insert(array (
            0 => 
            array (
                'id' => 1,
                'booking_id' => 38,
                'date_time' => '2023-08-02 10:30:00',
                'address' => '123 Main St,
United Kingdom,
Central Square, London
Postal Code: 544512',
                'price' => 15.0,
                'duration' => '0:15',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2023-08-01 14:10:11',
                'updated_at' => '2023-08-01 14:10:11',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'booking_id' => 39,
                'date_time' => '2023-08-01 10:20:00',
                'address' => '123 Main St,
United Kingdom,
Central Square, London
Postal Code: 544512',
                'price' => 35.0,
                'duration' => '0:30',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2023-08-01 14:10:55',
                'updated_at' => '2023-08-01 14:10:55',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'booking_id' => 40,
                'date_time' => '2023-08-05 10:40:00',
                'address' => '123 Main St,
United Kingdom,
Central Square, London
Postal Code: 544512',
                'price' => 25.0,
                'duration' => '0:45',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2023-08-01 14:11:35',
                'updated_at' => '2023-08-01 14:11:35',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'booking_id' => 41,
                'date_time' => '2023-08-14 17:45:00',
                'address' => '123 Main St,
United Kingdom,
Central Square, London
Postal Code: 544512',
                'price' => 10.0,
                'duration' => '00:20',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2023-08-01 14:12:17',
                'updated_at' => '2023-08-01 14:12:17',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'booking_id' => 42,
                'date_time' => '2023-08-18 20:30:00',
                'address' => '123 Main St,
United Kingdom,
Central Square, London
Postal Code: 544512',
                'price' => 20.0,
                'duration' => '0:25',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2023-08-01 14:12:46',
                'updated_at' => '2023-08-01 14:12:46',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'booking_id' => 43,
                'date_time' => '2023-08-24 21:30:00',
                'address' => '123 Main St,
United Kingdom,
Central Square, London
Postal Code: 544512',
                'price' => 34.0,
                'duration' => '0:50',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2023-08-01 14:13:17',
                'updated_at' => '2023-08-01 14:13:17',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'booking_id' => 44,
                'date_time' => '2023-08-25 21:40:00',
                'address' => '123 Main St,
United Kingdom,
Central Square, London
Postal Code: 544512',
                'price' => 30.0,
                'duration' => '0:40',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2023-08-01 14:14:03',
                'updated_at' => '2023-08-01 14:14:03',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'booking_id' => 45,
                'date_time' => '2023-08-22 22:40:00',
                'address' => '123 Main St,
United Kingdom,
Central Square, London
Postal Code: 544512',
                'price' => 34.0,
                'duration' => '0:50',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2023-08-01 14:14:36',
                'updated_at' => '2023-08-01 14:14:36',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'booking_id' => 46,
                'date_time' => '2023-08-21 23:45:00',
                'address' => '123 Main St,
United Kingdom,
Central Square, London
Postal Code: 544512',
                'price' => 30.0,
                'duration' => '0:40',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2023-08-01 14:14:59',
                'updated_at' => '2023-08-01 14:14:59',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'booking_id' => 47,
                'date_time' => '2023-08-20 10:35:00',
                'address' => '123 Main St,
United Kingdom,
Central Square, London
Postal Code: 544512',
                'price' => 40.0,
                'duration' => '0:35',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2023-08-01 14:15:37',
                'updated_at' => '2023-08-01 14:15:37',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'booking_id' => 48,
                'date_time' => '2023-08-28 22:45:00',
                'address' => '123 Main St,
United Kingdom,
Central Square, London
Postal Code: 544512',
                'price' => 30.0,
                'duration' => '0:40',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2023-08-01 14:16:03',
                'updated_at' => '2023-08-01 14:16:03',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'booking_id' => 49,
                'date_time' => '2023-08-30 21:40:00',
                'address' => '123 Main St,
United Kingdom,
Central Square, London
Postal Code: 544512',
                'price' => 35.0,
                'duration' => '0:30',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2023-08-01 14:16:34',
                'updated_at' => '2023-08-01 14:16:34',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'booking_id' => 77,
                'date_time' => '2023-08-27 20:20:00',
                'address' => '123 Main St,
United Kingdom,
Central Square, London
Postal Code: 544512',
                'price' => 35.0,
                'duration' => '0:30',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2023-08-26 07:23:34',
                'updated_at' => '2023-08-26 07:23:34',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'booking_id' => 100,
                'date_time' => '2023-08-26 16:50:00',
                'address' => '123 Main St,
United Kingdom,
Central Square, London
Postal Code: 544512',
                'price' => 20.0,
                'duration' => '0:25',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2023-08-26 08:17:54',
                'updated_at' => '2023-08-26 08:17:54',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'booking_id' => 109,
                'date_time' => '2023-08-26 18:30:00',
                'address' => '123 Main St,
United Kingdom,
Central Square, London
Postal Code: 544512',
                'price' => 35.0,
                'duration' => '0:30',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2023-08-26 09:24:37',
                'updated_at' => '2023-08-26 09:24:37',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'booking_id' => 114,
                'date_time' => '2023-08-26 21:35:00',
                'address' => '123 Main St,
United Kingdom,
Central Square, London
Postal Code: 544512',
                'price' => 10.0,
                'duration' => '00:20',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2023-08-26 09:43:48',
                'updated_at' => '2023-08-26 09:43:48',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'booking_id' => 121,
                'date_time' => '2023-09-06 19:30:00',
                'address' => '123 Main St,
United Kingdom,
Central Square, London
Postal Code: 544512',
                'price' => 35.0,
                'duration' => '0:30',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2023-08-26 10:03:04',
                'updated_at' => '2023-08-26 10:03:04',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'booking_id' => 127,
                'date_time' => '2023-08-26 10:30:00',
                'address' => '123 Main St,
United Kingdom,
Central Square, London
Postal Code: 544512',
                'price' => 10.0,
                'duration' => '00:20',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2023-08-26 10:17:19',
                'updated_at' => '2023-08-26 10:17:19',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'booking_id' => 132,
                'date_time' => '2023-08-27 07:35:00',
                'address' => '123 Main St,
United Kingdom,
Central Square, London
Postal Code: 544512',
                'price' => 20.0,
                'duration' => '0:25',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2023-08-26 10:29:57',
                'updated_at' => '2023-08-26 10:29:57',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'booking_id' => 139,
                'date_time' => '2023-08-26 07:35:00',
                'address' => '123 Main St,
United Kingdom,
Central Square, London
Postal Code: 544512',
                'price' => 20.0,
                'duration' => '0:25',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2023-08-26 10:43:16',
                'updated_at' => '2023-08-26 10:43:16',
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'booking_id' => 149,
                'date_time' => '2023-09-04 07:35:00',
                'address' => '123 Main St,
United Kingdom,
Central Square, London
Postal Code: 544512',
                'price' => 35.0,
                'duration' => '0:30',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_by' => NULL,
                'created_at' => '2023-08-26 11:08:49',
                'updated_at' => '2023-08-26 11:08:49',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}