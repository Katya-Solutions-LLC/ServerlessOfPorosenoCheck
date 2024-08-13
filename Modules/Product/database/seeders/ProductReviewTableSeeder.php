<?php

namespace Modules\Product\database\seeders;

use Illuminate\Database\Seeder;

class ProductReviewTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('product_review')->delete();
        
        \DB::table('product_review')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 2,
                'product_id' => 50,
                'product_variation_id' => 121,
                'rating' => 5,
                'review_msg' => 'The product exceeded my expectations with its quality. I highly recommend it. 😄😍',
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_by' => 2,
                'deleted_at' => NULL,
                'created_at' => '2024-04-01 07:25:37',
                'updated_at' => '2024-04-01 07:26:55',
                'employee_id' => 58,
            ),
        ));
        
        
    }
}