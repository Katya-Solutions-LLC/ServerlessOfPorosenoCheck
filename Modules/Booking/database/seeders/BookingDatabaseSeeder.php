<?php

namespace Modules\Booking\database\seeders;

use Illuminate\Database\Seeder;

class BookingDatabaseSeeder extends Seeder
{
 
    public function run()
    {
        $this->call(BookingsTableSeeder::class);
        $this->call(BookingBoardingMappingTableSeeder::class);
        $this->call(BookingDaycareMappingTableSeeder::class);
        $this->call(BookingGroomingMappingTableSeeder::class);
        $this->call(BookingTrainingMappingTableSeeder::class);
        $this->call(BookingVeterinaryMappingTableSeeder::class);
        $this->call(BookingWalkingMappingTableSeeder::class);
        $this->call(BookingTransactionsTableSeeder::class);
        $this->call(CommissionEarningsTableSeeder::class);
    }
}
