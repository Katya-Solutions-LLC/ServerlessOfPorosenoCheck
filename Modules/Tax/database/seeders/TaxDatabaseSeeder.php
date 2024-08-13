<?php

namespace Modules\Tax\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Tax\Models\Tax;

class TaxDatabaseSeeder extends Seeder
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

        $taxes = [
            [
                'title' => 'Sales Tax',
                'type' => 'percentage',
                'value' => 1,
                'module_type' => 'services'
            ],
       
            [
                'title' => 'Other Taxes',
                'type' => 'percentage',
                'value' => 2,
                'module_type' => 'services'
            ],
           
            [
                'title' => 'Service Tax or Gross Receipts Tax',
                'type' => 'fixed',
                'value' => 5,
                'module_type' => 'services'
            ],

            [
                'title' => 'Sales Tax',
                'type' => 'percentage',
                'value' => 5,
                'module_type' => 'products'
            ],
        ];
        if (env('IS_DUMMY_DATA')) {
            foreach ($taxes  as $key => $taxes_data) {
                $tax = Tax::create($taxes_data);
            }
        }

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
