<?php

namespace Modules\Product\database\seeders;

use Illuminate\Database\Seeder;

class ProductVariationStocksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('product_variation_stocks')->delete();
        
        \DB::table('product_variation_stocks')->insert(array (
            0 => 
            array (
                'id' => 1,
                'product_variation_id' => 1,
                'location_id' => 1,
                'stock_qty' => 6,
                'created_at' => '2023-09-20 12:18:47',
                'updated_at' => '2023-09-20 12:18:47',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'product_variation_id' => 2,
                'location_id' => 1,
                'stock_qty' => 10,
                'created_at' => '2023-09-20 12:18:47',
                'updated_at' => '2023-09-20 12:18:47',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'product_variation_id' => 3,
                'location_id' => 1,
                'stock_qty' => 10,
                'created_at' => '2023-09-20 12:18:47',
                'updated_at' => '2023-09-20 12:18:47',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 6,
                'product_variation_id' => 6,
                'location_id' => 1,
                'stock_qty' => 10,
                'created_at' => '2023-09-20 12:48:03',
                'updated_at' => '2023-09-20 12:48:03',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 7,
                'product_variation_id' => 7,
                'location_id' => 1,
                'stock_qty' => 5,
                'created_at' => '2023-09-20 12:48:03',
                'updated_at' => '2023-09-20 12:48:03',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 8,
                'product_variation_id' => 8,
                'location_id' => 1,
                'stock_qty' => 5,
                'created_at' => '2023-09-20 12:48:03',
                'updated_at' => '2023-09-20 12:48:03',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 9,
                'product_variation_id' => 9,
                'location_id' => 1,
                'stock_qty' => 10,
                'created_at' => '2023-09-20 12:51:46',
                'updated_at' => '2023-09-20 12:51:46',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 10,
                'product_variation_id' => 10,
                'location_id' => 1,
                'stock_qty' => 12,
                'created_at' => '2023-09-20 12:51:46',
                'updated_at' => '2023-09-20 12:51:46',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 11,
                'product_variation_id' => 11,
                'location_id' => 1,
                'stock_qty' => 7,
                'created_at' => '2023-09-20 12:53:05',
                'updated_at' => '2023-09-20 12:53:05',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 12,
                'product_variation_id' => 12,
                'location_id' => 1,
                'stock_qty' => 4,
                'created_at' => '2023-09-20 12:53:05',
                'updated_at' => '2023-09-20 12:53:05',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 13,
                'product_variation_id' => 13,
                'location_id' => 1,
                'stock_qty' => 10,
                'created_at' => '2023-09-20 12:54:07',
                'updated_at' => '2023-09-20 12:54:07',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 14,
                'product_variation_id' => 14,
                'location_id' => 1,
                'stock_qty' => 4,
                'created_at' => '2023-09-20 12:54:07',
                'updated_at' => '2023-09-20 12:54:07',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 15,
                'product_variation_id' => 15,
                'location_id' => 1,
                'stock_qty' => 10,
                'created_at' => '2023-09-20 13:01:04',
                'updated_at' => '2023-09-20 13:01:04',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 16,
                'product_variation_id' => 16,
                'location_id' => 1,
                'stock_qty' => 15,
                'created_at' => '2023-09-20 13:01:04',
                'updated_at' => '2023-09-20 13:01:04',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 17,
                'product_variation_id' => 17,
                'location_id' => 1,
                'stock_qty' => 8,
                'created_at' => '2023-09-20 13:05:28',
                'updated_at' => '2023-09-20 13:05:28',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 18,
                'product_variation_id' => 18,
                'location_id' => 1,
                'stock_qty' => 9,
                'created_at' => '2023-09-20 13:05:28',
                'updated_at' => '2023-09-20 13:05:28',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 19,
                'product_variation_id' => 19,
                'location_id' => 1,
                'stock_qty' => 5,
                'created_at' => '2023-09-20 13:05:28',
                'updated_at' => '2023-09-20 13:05:28',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 20,
                'product_variation_id' => 20,
                'location_id' => 1,
                'stock_qty' => 11,
                'created_at' => '2023-09-20 13:08:04',
                'updated_at' => '2023-09-20 13:08:04',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 21,
                'product_variation_id' => 21,
                'location_id' => 1,
                'stock_qty' => 7,
                'created_at' => '2023-09-20 13:08:04',
                'updated_at' => '2023-09-20 13:08:04',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 22,
                'product_variation_id' => 22,
                'location_id' => 1,
                'stock_qty' => 30,
                'created_at' => '2023-09-20 13:12:56',
                'updated_at' => '2023-09-20 13:12:56',
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 23,
                'product_variation_id' => 23,
                'location_id' => 1,
                'stock_qty' => 20,
                'created_at' => '2023-09-21 04:12:32',
                'updated_at' => '2023-09-21 04:12:32',
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'id' => 24,
                'product_variation_id' => 24,
                'location_id' => 1,
                'stock_qty' => 10,
                'created_at' => '2023-09-21 04:12:32',
                'updated_at' => '2023-09-21 04:12:32',
                'deleted_at' => NULL,
            ),
            22 => 
            array (
                'id' => 25,
                'product_variation_id' => 25,
                'location_id' => 1,
                'stock_qty' => 15,
                'created_at' => '2023-09-21 04:12:32',
                'updated_at' => '2023-09-21 04:12:32',
                'deleted_at' => NULL,
            ),
            23 => 
            array (
                'id' => 26,
                'product_variation_id' => 26,
                'location_id' => 1,
                'stock_qty' => 11,
                'created_at' => '2023-09-21 04:15:34',
                'updated_at' => '2023-09-21 04:15:34',
                'deleted_at' => NULL,
            ),
            24 => 
            array (
                'id' => 27,
                'product_variation_id' => 27,
                'location_id' => 1,
                'stock_qty' => 20,
                'created_at' => '2023-09-21 04:15:34',
                'updated_at' => '2023-09-21 04:15:34',
                'deleted_at' => NULL,
            ),
            25 => 
            array (
                'id' => 28,
                'product_variation_id' => 28,
                'location_id' => 1,
                'stock_qty' => 12,
                'created_at' => '2023-09-21 04:15:34',
                'updated_at' => '2023-09-21 04:15:34',
                'deleted_at' => NULL,
            ),
            26 => 
            array (
                'id' => 29,
                'product_variation_id' => 29,
                'location_id' => 1,
                'stock_qty' => 15,
                'created_at' => '2023-09-21 04:19:45',
                'updated_at' => '2023-09-21 04:19:45',
                'deleted_at' => NULL,
            ),
            27 => 
            array (
                'id' => 30,
                'product_variation_id' => 30,
                'location_id' => 1,
                'stock_qty' => 20,
                'created_at' => '2023-09-21 04:19:45',
                'updated_at' => '2023-09-21 04:19:45',
                'deleted_at' => NULL,
            ),
            28 => 
            array (
                'id' => 31,
                'product_variation_id' => 31,
                'location_id' => 1,
                'stock_qty' => 15,
                'created_at' => '2023-09-21 04:19:45',
                'updated_at' => '2023-09-21 04:19:45',
                'deleted_at' => NULL,
            ),
            29 => 
            array (
                'id' => 32,
                'product_variation_id' => 32,
                'location_id' => 1,
                'stock_qty' => 10,
                'created_at' => '2023-09-21 04:24:25',
                'updated_at' => '2023-09-21 04:24:25',
                'deleted_at' => NULL,
            ),
            30 => 
            array (
                'id' => 33,
                'product_variation_id' => 33,
                'location_id' => 1,
                'stock_qty' => 10,
                'created_at' => '2023-09-21 04:24:25',
                'updated_at' => '2023-09-21 04:24:25',
                'deleted_at' => NULL,
            ),
            31 => 
            array (
                'id' => 34,
                'product_variation_id' => 34,
                'location_id' => 1,
                'stock_qty' => 15,
                'created_at' => '2023-09-21 04:24:25',
                'updated_at' => '2023-09-21 04:24:25',
                'deleted_at' => NULL,
            ),
            32 => 
            array (
                'id' => 35,
                'product_variation_id' => 35,
                'location_id' => 1,
                'stock_qty' => 11,
                'created_at' => '2023-09-21 04:30:15',
                'updated_at' => '2023-09-21 04:30:15',
                'deleted_at' => NULL,
            ),
            33 => 
            array (
                'id' => 36,
                'product_variation_id' => 36,
                'location_id' => 1,
                'stock_qty' => 20,
                'created_at' => '2023-09-21 04:30:15',
                'updated_at' => '2023-09-21 04:30:15',
                'deleted_at' => NULL,
            ),
            34 => 
            array (
                'id' => 37,
                'product_variation_id' => 37,
                'location_id' => 1,
                'stock_qty' => 15,
                'created_at' => '2023-09-21 04:30:15',
                'updated_at' => '2023-09-21 04:30:15',
                'deleted_at' => NULL,
            ),
            35 => 
            array (
                'id' => 38,
                'product_variation_id' => 38,
                'location_id' => 1,
                'stock_qty' => 10,
                'created_at' => '2023-09-21 04:34:30',
                'updated_at' => '2023-09-21 04:34:30',
                'deleted_at' => NULL,
            ),
            36 => 
            array (
                'id' => 39,
                'product_variation_id' => 39,
                'location_id' => 1,
                'stock_qty' => 10,
                'created_at' => '2023-09-21 04:34:30',
                'updated_at' => '2023-09-21 04:34:30',
                'deleted_at' => NULL,
            ),
            37 => 
            array (
                'id' => 40,
                'product_variation_id' => 40,
                'location_id' => 1,
                'stock_qty' => 10,
                'created_at' => '2023-09-21 04:34:30',
                'updated_at' => '2023-09-21 04:34:30',
                'deleted_at' => NULL,
            ),
            38 => 
            array (
                'id' => 41,
                'product_variation_id' => 41,
                'location_id' => 1,
                'stock_qty' => 20,
                'created_at' => '2023-09-21 04:38:04',
                'updated_at' => '2023-09-21 04:38:04',
                'deleted_at' => NULL,
            ),
            39 => 
            array (
                'id' => 42,
                'product_variation_id' => 42,
                'location_id' => 1,
                'stock_qty' => 20,
                'created_at' => '2023-09-21 04:38:04',
                'updated_at' => '2023-09-21 04:38:04',
                'deleted_at' => NULL,
            ),
            40 => 
            array (
                'id' => 43,
                'product_variation_id' => 43,
                'location_id' => 1,
                'stock_qty' => 15,
                'created_at' => '2023-09-21 04:38:04',
                'updated_at' => '2023-09-21 04:38:04',
                'deleted_at' => NULL,
            ),
            41 => 
            array (
                'id' => 44,
                'product_variation_id' => 44,
                'location_id' => 1,
                'stock_qty' => 15,
                'created_at' => '2023-09-21 04:42:26',
                'updated_at' => '2023-09-21 04:42:26',
                'deleted_at' => NULL,
            ),
            42 => 
            array (
                'id' => 45,
                'product_variation_id' => 45,
                'location_id' => 1,
                'stock_qty' => 26,
                'created_at' => '2023-09-21 04:42:26',
                'updated_at' => '2023-09-21 04:42:26',
                'deleted_at' => NULL,
            ),
            43 => 
            array (
                'id' => 46,
                'product_variation_id' => 46,
                'location_id' => 1,
                'stock_qty' => 15,
                'created_at' => '2023-09-21 04:42:26',
                'updated_at' => '2023-09-21 04:42:26',
                'deleted_at' => NULL,
            ),
            44 => 
            array (
                'id' => 47,
                'product_variation_id' => 47,
                'location_id' => 1,
                'stock_qty' => 22,
                'created_at' => '2023-09-21 04:49:33',
                'updated_at' => '2023-09-21 04:49:33',
                'deleted_at' => NULL,
            ),
            45 => 
            array (
                'id' => 48,
                'product_variation_id' => 48,
                'location_id' => 1,
                'stock_qty' => 12,
                'created_at' => '2023-09-21 04:49:33',
                'updated_at' => '2023-09-21 04:49:33',
                'deleted_at' => NULL,
            ),
            46 => 
            array (
                'id' => 49,
                'product_variation_id' => 49,
                'location_id' => 1,
                'stock_qty' => 15,
                'created_at' => '2023-09-21 04:49:33',
                'updated_at' => '2023-09-21 04:49:33',
                'deleted_at' => NULL,
            ),
            47 => 
            array (
                'id' => 50,
                'product_variation_id' => 50,
                'location_id' => 1,
                'stock_qty' => 20,
                'created_at' => '2023-09-21 04:55:36',
                'updated_at' => '2023-09-21 04:55:36',
                'deleted_at' => NULL,
            ),
            48 => 
            array (
                'id' => 51,
                'product_variation_id' => 51,
                'location_id' => 1,
                'stock_qty' => 20,
                'created_at' => '2023-09-21 04:55:36',
                'updated_at' => '2023-09-21 04:55:36',
                'deleted_at' => NULL,
            ),
            49 => 
            array (
                'id' => 52,
                'product_variation_id' => 52,
                'location_id' => 1,
                'stock_qty' => 6,
                'created_at' => '2023-09-21 04:55:36',
                'updated_at' => '2023-09-21 04:55:36',
                'deleted_at' => NULL,
            ),
            50 => 
            array (
                'id' => 53,
                'product_variation_id' => 53,
                'location_id' => 1,
                'stock_qty' => 21,
                'created_at' => '2023-09-21 04:58:37',
                'updated_at' => '2023-09-21 04:58:37',
                'deleted_at' => NULL,
            ),
            51 => 
            array (
                'id' => 54,
                'product_variation_id' => 54,
                'location_id' => 1,
                'stock_qty' => 25,
                'created_at' => '2023-09-21 04:58:37',
                'updated_at' => '2023-09-21 04:58:37',
                'deleted_at' => NULL,
            ),
            52 => 
            array (
                'id' => 55,
                'product_variation_id' => 55,
                'location_id' => 1,
                'stock_qty' => 10,
                'created_at' => '2023-09-21 04:58:37',
                'updated_at' => '2023-09-21 04:58:37',
                'deleted_at' => NULL,
            ),
            53 => 
            array (
                'id' => 56,
                'product_variation_id' => 56,
                'location_id' => 1,
                'stock_qty' => 20,
                'created_at' => '2023-09-21 05:46:10',
                'updated_at' => '2023-09-21 05:46:10',
                'deleted_at' => NULL,
            ),
            54 => 
            array (
                'id' => 57,
                'product_variation_id' => 57,
                'location_id' => 1,
                'stock_qty' => 20,
                'created_at' => '2023-09-21 05:46:10',
                'updated_at' => '2023-09-21 05:46:10',
                'deleted_at' => NULL,
            ),
            55 => 
            array (
                'id' => 58,
                'product_variation_id' => 58,
                'location_id' => 1,
                'stock_qty' => 10,
                'created_at' => '2023-09-21 05:46:10',
                'updated_at' => '2023-09-21 05:46:10',
                'deleted_at' => NULL,
            ),
            56 => 
            array (
                'id' => 59,
                'product_variation_id' => 59,
                'location_id' => 1,
                'stock_qty' => 12,
                'created_at' => '2023-09-21 05:56:23',
                'updated_at' => '2023-09-21 05:56:23',
                'deleted_at' => NULL,
            ),
            57 => 
            array (
                'id' => 60,
                'product_variation_id' => 60,
                'location_id' => 1,
                'stock_qty' => 15,
                'created_at' => '2023-09-21 05:56:23',
                'updated_at' => '2023-09-21 05:56:23',
                'deleted_at' => NULL,
            ),
            58 => 
            array (
                'id' => 61,
                'product_variation_id' => 61,
                'location_id' => 1,
                'stock_qty' => 13,
                'created_at' => '2023-09-21 05:56:23',
                'updated_at' => '2023-09-21 05:56:23',
                'deleted_at' => NULL,
            ),
            59 => 
            array (
                'id' => 62,
                'product_variation_id' => 62,
                'location_id' => 1,
                'stock_qty' => 11,
                'created_at' => '2023-09-21 06:07:37',
                'updated_at' => '2023-09-21 06:07:37',
                'deleted_at' => NULL,
            ),
            60 => 
            array (
                'id' => 63,
                'product_variation_id' => 63,
                'location_id' => 1,
                'stock_qty' => 10,
                'created_at' => '2023-09-21 06:07:37',
                'updated_at' => '2023-09-21 06:07:37',
                'deleted_at' => NULL,
            ),
            61 => 
            array (
                'id' => 64,
                'product_variation_id' => 64,
                'location_id' => 1,
                'stock_qty' => 10,
                'created_at' => '2023-09-21 06:07:37',
                'updated_at' => '2023-09-21 06:07:37',
                'deleted_at' => NULL,
            ),
            62 => 
            array (
                'id' => 65,
                'product_variation_id' => 65,
                'location_id' => 1,
                'stock_qty' => 11,
                'created_at' => '2023-09-21 06:07:37',
                'updated_at' => '2023-09-21 06:07:37',
                'deleted_at' => NULL,
            ),
            63 => 
            array (
                'id' => 66,
                'product_variation_id' => 66,
                'location_id' => 1,
                'stock_qty' => 20,
                'created_at' => '2023-09-21 06:22:50',
                'updated_at' => '2023-09-21 06:22:50',
                'deleted_at' => NULL,
            ),
            64 => 
            array (
                'id' => 67,
                'product_variation_id' => 67,
                'location_id' => 1,
                'stock_qty' => 21,
                'created_at' => '2023-09-21 06:22:50',
                'updated_at' => '2023-09-21 06:22:50',
                'deleted_at' => NULL,
            ),
            65 => 
            array (
                'id' => 68,
                'product_variation_id' => 68,
                'location_id' => 1,
                'stock_qty' => 15,
                'created_at' => '2023-09-21 06:22:50',
                'updated_at' => '2023-09-21 06:22:50',
                'deleted_at' => NULL,
            ),
            66 => 
            array (
                'id' => 69,
                'product_variation_id' => 69,
                'location_id' => 1,
                'stock_qty' => 20,
                'created_at' => '2023-09-21 06:29:32',
                'updated_at' => '2023-09-21 06:29:32',
                'deleted_at' => NULL,
            ),
            67 => 
            array (
                'id' => 70,
                'product_variation_id' => 70,
                'location_id' => 1,
                'stock_qty' => 30,
                'created_at' => '2023-09-21 06:29:32',
                'updated_at' => '2023-09-21 06:29:32',
                'deleted_at' => NULL,
            ),
            68 => 
            array (
                'id' => 71,
                'product_variation_id' => 71,
                'location_id' => 1,
                'stock_qty' => 9,
                'created_at' => '2023-09-21 06:29:32',
                'updated_at' => '2023-09-21 06:29:32',
                'deleted_at' => NULL,
            ),
            69 => 
            array (
                'id' => 72,
                'product_variation_id' => 72,
                'location_id' => 1,
                'stock_qty' => 50,
                'created_at' => '2023-09-21 06:34:42',
                'updated_at' => '2023-09-21 06:34:42',
                'deleted_at' => NULL,
            ),
            70 => 
            array (
                'id' => 73,
                'product_variation_id' => 73,
                'location_id' => 1,
                'stock_qty' => 35,
                'created_at' => '2023-09-21 06:39:34',
                'updated_at' => '2023-09-21 06:39:34',
                'deleted_at' => NULL,
            ),
            71 => 
            array (
                'id' => 74,
                'product_variation_id' => 74,
                'location_id' => 1,
                'stock_qty' => 15,
                'created_at' => '2023-09-21 06:44:13',
                'updated_at' => '2023-09-21 06:46:06',
                'deleted_at' => NULL,
            ),
            72 => 
            array (
                'id' => 75,
                'product_variation_id' => 75,
                'location_id' => 1,
                'stock_qty' => 20,
                'created_at' => '2023-09-21 06:44:13',
                'updated_at' => '2023-09-21 06:46:06',
                'deleted_at' => NULL,
            ),
            73 => 
            array (
                'id' => 76,
                'product_variation_id' => 76,
                'location_id' => 1,
                'stock_qty' => 10,
                'created_at' => '2023-09-21 06:46:06',
                'updated_at' => '2023-09-21 06:46:06',
                'deleted_at' => NULL,
            ),
            74 => 
            array (
                'id' => 77,
                'product_variation_id' => 77,
                'location_id' => 1,
                'stock_qty' => 51,
                'created_at' => '2023-09-21 07:29:04',
                'updated_at' => '2023-09-21 07:29:04',
                'deleted_at' => NULL,
            ),
            75 => 
            array (
                'id' => 78,
                'product_variation_id' => 78,
                'location_id' => 1,
                'stock_qty' => 11,
                'created_at' => '2023-09-21 07:42:53',
                'updated_at' => '2023-09-21 07:42:53',
                'deleted_at' => NULL,
            ),
            76 => 
            array (
                'id' => 79,
                'product_variation_id' => 79,
                'location_id' => 1,
                'stock_qty' => 15,
                'created_at' => '2023-09-21 07:42:53',
                'updated_at' => '2023-09-21 07:42:53',
                'deleted_at' => NULL,
            ),
            77 => 
            array (
                'id' => 80,
                'product_variation_id' => 80,
                'location_id' => 1,
                'stock_qty' => 8,
                'created_at' => '2023-09-21 07:42:53',
                'updated_at' => '2023-09-21 07:42:53',
                'deleted_at' => NULL,
            ),
            78 => 
            array (
                'id' => 81,
                'product_variation_id' => 81,
                'location_id' => 1,
                'stock_qty' => 35,
                'created_at' => '2023-09-21 07:45:46',
                'updated_at' => '2023-09-21 07:45:46',
                'deleted_at' => NULL,
            ),
            79 => 
            array (
                'id' => 82,
                'product_variation_id' => 82,
                'location_id' => 1,
                'stock_qty' => 25,
                'created_at' => '2023-09-21 07:49:31',
                'updated_at' => '2023-09-21 07:49:31',
                'deleted_at' => NULL,
            ),
            80 => 
            array (
                'id' => 83,
                'product_variation_id' => 83,
                'location_id' => 1,
                'stock_qty' => 22,
                'created_at' => '2023-09-21 07:49:31',
                'updated_at' => '2023-09-21 07:49:31',
                'deleted_at' => NULL,
            ),
            81 => 
            array (
                'id' => 84,
                'product_variation_id' => 84,
                'location_id' => 1,
                'stock_qty' => 16,
                'created_at' => '2023-09-21 07:49:31',
                'updated_at' => '2023-09-21 07:49:31',
                'deleted_at' => NULL,
            ),
            82 => 
            array (
                'id' => 85,
                'product_variation_id' => 85,
                'location_id' => 1,
                'stock_qty' => 35,
                'created_at' => '2023-09-21 08:12:38',
                'updated_at' => '2023-09-21 08:12:38',
                'deleted_at' => NULL,
            ),
            83 => 
            array (
                'id' => 86,
                'product_variation_id' => 86,
                'location_id' => 1,
                'stock_qty' => 51,
                'created_at' => '2023-09-21 08:15:35',
                'updated_at' => '2023-09-21 08:15:35',
                'deleted_at' => NULL,
            ),
            84 => 
            array (
                'id' => 87,
                'product_variation_id' => 87,
                'location_id' => 1,
                'stock_qty' => 15,
                'created_at' => '2023-09-21 09:15:46',
                'updated_at' => '2023-09-21 09:15:46',
                'deleted_at' => NULL,
            ),
            85 => 
            array (
                'id' => 88,
                'product_variation_id' => 88,
                'location_id' => 1,
                'stock_qty' => 12,
                'created_at' => '2023-09-21 09:15:46',
                'updated_at' => '2023-09-21 09:15:46',
                'deleted_at' => NULL,
            ),
            86 => 
            array (
                'id' => 89,
                'product_variation_id' => 89,
                'location_id' => 1,
                'stock_qty' => 15,
                'created_at' => '2023-09-21 09:15:46',
                'updated_at' => '2023-09-21 09:15:46',
                'deleted_at' => NULL,
            ),
            87 => 
            array (
                'id' => 90,
                'product_variation_id' => 90,
                'location_id' => 1,
                'stock_qty' => 9,
                'created_at' => '2023-09-21 09:15:46',
                'updated_at' => '2023-09-21 09:15:46',
                'deleted_at' => NULL,
            ),
            88 => 
            array (
                'id' => 91,
                'product_variation_id' => 91,
                'location_id' => 1,
                'stock_qty' => 20,
                'created_at' => '2023-09-21 09:22:58',
                'updated_at' => '2023-09-21 09:22:58',
                'deleted_at' => NULL,
            ),
            89 => 
            array (
                'id' => 92,
                'product_variation_id' => 92,
                'location_id' => 1,
                'stock_qty' => 25,
                'created_at' => '2023-09-21 09:22:58',
                'updated_at' => '2023-09-21 09:22:58',
                'deleted_at' => NULL,
            ),
            90 => 
            array (
                'id' => 93,
                'product_variation_id' => 93,
                'location_id' => 1,
                'stock_qty' => 20,
                'created_at' => '2023-09-21 09:22:58',
                'updated_at' => '2023-09-21 09:22:58',
                'deleted_at' => NULL,
            ),
            91 => 
            array (
                'id' => 94,
                'product_variation_id' => 94,
                'location_id' => 1,
                'stock_qty' => 15,
                'created_at' => '2023-09-21 09:27:18',
                'updated_at' => '2023-09-21 09:27:18',
                'deleted_at' => NULL,
            ),
            92 => 
            array (
                'id' => 95,
                'product_variation_id' => 95,
                'location_id' => 1,
                'stock_qty' => 20,
                'created_at' => '2023-09-21 09:27:18',
                'updated_at' => '2023-09-21 09:27:18',
                'deleted_at' => NULL,
            ),
            93 => 
            array (
                'id' => 96,
                'product_variation_id' => 96,
                'location_id' => 1,
                'stock_qty' => 14,
                'created_at' => '2023-09-21 09:27:18',
                'updated_at' => '2023-09-21 09:27:18',
                'deleted_at' => NULL,
            ),
            94 => 
            array (
                'id' => 97,
                'product_variation_id' => 97,
                'location_id' => 1,
                'stock_qty' => 21,
                'created_at' => '2023-09-21 09:30:45',
                'updated_at' => '2023-09-21 09:30:45',
                'deleted_at' => NULL,
            ),
            95 => 
            array (
                'id' => 98,
                'product_variation_id' => 98,
                'location_id' => 1,
                'stock_qty' => 20,
                'created_at' => '2023-09-21 09:30:45',
                'updated_at' => '2023-09-21 09:30:45',
                'deleted_at' => NULL,
            ),
            96 => 
            array (
                'id' => 99,
                'product_variation_id' => 99,
                'location_id' => 1,
                'stock_qty' => 11,
                'created_at' => '2023-09-21 09:34:15',
                'updated_at' => '2023-09-21 09:34:15',
                'deleted_at' => NULL,
            ),
            97 => 
            array (
                'id' => 100,
                'product_variation_id' => 100,
                'location_id' => 1,
                'stock_qty' => 12,
                'created_at' => '2023-09-21 09:34:15',
                'updated_at' => '2023-09-21 09:34:15',
                'deleted_at' => NULL,
            ),
            98 => 
            array (
                'id' => 101,
                'product_variation_id' => 101,
                'location_id' => 1,
                'stock_qty' => 11,
                'created_at' => '2023-09-21 09:34:15',
                'updated_at' => '2023-09-21 09:34:15',
                'deleted_at' => NULL,
            ),
            99 => 
            array (
                'id' => 102,
                'product_variation_id' => 102,
                'location_id' => 1,
                'stock_qty' => 15,
                'created_at' => '2023-09-21 09:38:17',
                'updated_at' => '2023-09-21 09:38:17',
                'deleted_at' => NULL,
            ),
            100 => 
            array (
                'id' => 103,
                'product_variation_id' => 103,
                'location_id' => 1,
                'stock_qty' => 20,
                'created_at' => '2023-09-21 09:38:17',
                'updated_at' => '2023-09-21 09:38:17',
                'deleted_at' => NULL,
            ),
            101 => 
            array (
                'id' => 104,
                'product_variation_id' => 104,
                'location_id' => 1,
                'stock_qty' => 11,
                'created_at' => '2023-09-21 09:38:17',
                'updated_at' => '2023-09-21 09:38:17',
                'deleted_at' => NULL,
            ),
            102 => 
            array (
                'id' => 105,
                'product_variation_id' => 105,
                'location_id' => 1,
                'stock_qty' => 15,
                'created_at' => '2023-09-21 09:38:17',
                'updated_at' => '2023-09-21 09:38:17',
                'deleted_at' => NULL,
            ),
            103 => 
            array (
                'id' => 106,
                'product_variation_id' => 106,
                'location_id' => 1,
                'stock_qty' => 53,
                'created_at' => '2023-09-21 09:43:23',
                'updated_at' => '2023-09-21 09:43:23',
                'deleted_at' => NULL,
            ),
            104 => 
            array (
                'id' => 107,
                'product_variation_id' => 107,
                'location_id' => 1,
                'stock_qty' => 45,
                'created_at' => '2023-09-21 09:45:58',
                'updated_at' => '2023-09-21 09:45:58',
                'deleted_at' => NULL,
            ),
            105 => 
            array (
                'id' => 108,
                'product_variation_id' => 108,
                'location_id' => 1,
                'stock_qty' => 61,
                'created_at' => '2023-09-21 09:48:46',
                'updated_at' => '2023-09-21 09:48:46',
                'deleted_at' => NULL,
            ),
            106 => 
            array (
                'id' => 109,
                'product_variation_id' => 109,
                'location_id' => 1,
                'stock_qty' => 53,
                'created_at' => '2023-09-21 09:52:14',
                'updated_at' => '2023-09-21 09:52:14',
                'deleted_at' => NULL,
            ),
            107 => 
            array (
                'id' => 110,
                'product_variation_id' => 110,
                'location_id' => 1,
                'stock_qty' => 20,
                'created_at' => '2023-09-21 10:01:19',
                'updated_at' => '2023-09-21 10:01:19',
                'deleted_at' => NULL,
            ),
            108 => 
            array (
                'id' => 111,
                'product_variation_id' => 111,
                'location_id' => 1,
                'stock_qty' => 21,
                'created_at' => '2023-09-21 10:01:19',
                'updated_at' => '2023-09-21 10:01:19',
                'deleted_at' => NULL,
            ),
            109 => 
            array (
                'id' => 112,
                'product_variation_id' => 112,
                'location_id' => 1,
                'stock_qty' => 20,
                'created_at' => '2023-09-21 10:01:19',
                'updated_at' => '2023-09-21 10:01:19',
                'deleted_at' => NULL,
            ),
            110 => 
            array (
                'id' => 113,
                'product_variation_id' => 113,
                'location_id' => 1,
                'stock_qty' => 30,
                'created_at' => '2023-09-21 10:33:44',
                'updated_at' => '2023-09-21 10:33:44',
                'deleted_at' => NULL,
            ),
            111 => 
            array (
                'id' => 114,
                'product_variation_id' => 114,
                'location_id' => 1,
                'stock_qty' => 31,
                'created_at' => '2023-09-21 10:33:44',
                'updated_at' => '2023-09-21 10:33:44',
                'deleted_at' => NULL,
            ),
            112 => 
            array (
                'id' => 115,
                'product_variation_id' => 115,
                'location_id' => 1,
                'stock_qty' => 21,
                'created_at' => '2023-09-22 06:01:17',
                'updated_at' => '2023-09-22 06:01:17',
                'deleted_at' => NULL,
            ),
            113 => 
            array (
                'id' => 116,
                'product_variation_id' => 116,
                'location_id' => 1,
                'stock_qty' => 22,
                'created_at' => '2023-09-22 06:01:17',
                'updated_at' => '2023-09-22 06:01:17',
                'deleted_at' => NULL,
            ),
            114 => 
            array (
                'id' => 117,
                'product_variation_id' => 117,
                'location_id' => 1,
                'stock_qty' => 11,
                'created_at' => '2023-09-22 06:01:17',
                'updated_at' => '2023-09-22 06:01:17',
                'deleted_at' => NULL,
            ),
            115 => 
            array (
                'id' => 118,
                'product_variation_id' => 118,
                'location_id' => 1,
                'stock_qty' => 30,
                'created_at' => '2023-09-22 06:05:24',
                'updated_at' => '2023-09-22 06:05:24',
                'deleted_at' => NULL,
            ),
            116 => 
            array (
                'id' => 119,
                'product_variation_id' => 119,
                'location_id' => 1,
                'stock_qty' => 31,
                'created_at' => '2023-09-22 06:05:24',
                'updated_at' => '2023-09-22 06:05:24',
                'deleted_at' => NULL,
            ),
            117 => 
            array (
                'id' => 120,
                'product_variation_id' => 120,
                'location_id' => 1,
                'stock_qty' => 51,
                'created_at' => '2023-09-22 06:10:12',
                'updated_at' => '2023-09-22 06:10:12',
                'deleted_at' => NULL,
            ),
            118 => 
            array (
                'id' => 121,
                'product_variation_id' => 121,
                'location_id' => 1,
                'stock_qty' => 31,
                'created_at' => '2023-09-22 06:13:26',
                'updated_at' => '2023-09-22 06:13:26',
                'deleted_at' => NULL,
            ),
            119 => 
            array (
                'id' => 122,
                'product_variation_id' => 122,
                'location_id' => 1,
                'stock_qty' => 35,
                'created_at' => '2023-09-22 06:13:26',
                'updated_at' => '2023-09-22 06:13:26',
                'deleted_at' => NULL,
            ),
            120 => 
            array (
                'id' => 123,
                'product_variation_id' => 123,
                'location_id' => 1,
                'stock_qty' => 25,
                'created_at' => '2023-09-22 06:17:13',
                'updated_at' => '2023-09-22 06:17:13',
                'deleted_at' => NULL,
            ),
            121 => 
            array (
                'id' => 124,
                'product_variation_id' => 124,
                'location_id' => 1,
                'stock_qty' => 26,
                'created_at' => '2023-09-22 06:17:13',
                'updated_at' => '2023-09-22 06:17:13',
                'deleted_at' => NULL,
            ),
            122 => 
            array (
                'id' => 125,
                'product_variation_id' => 125,
                'location_id' => 1,
                'stock_qty' => 45,
                'created_at' => '2023-09-22 06:19:40',
                'updated_at' => '2023-09-22 06:19:40',
                'deleted_at' => NULL,
            ),
            123 => 
            array (
                'id' => 126,
                'product_variation_id' => 126,
                'location_id' => 1,
                'stock_qty' => 31,
                'created_at' => '2023-09-22 06:22:26',
                'updated_at' => '2023-09-22 06:22:26',
                'deleted_at' => NULL,
            ),
            124 => 
            array (
                'id' => 127,
                'product_variation_id' => 127,
                'location_id' => 1,
                'stock_qty' => 31,
                'created_at' => '2023-09-22 06:22:26',
                'updated_at' => '2023-09-22 06:22:26',
                'deleted_at' => NULL,
            ),
            125 => 
            array (
                'id' => 128,
                'product_variation_id' => 128,
                'location_id' => 1,
                'stock_qty' => 25,
                'created_at' => '2023-09-22 06:22:26',
                'updated_at' => '2023-09-22 06:22:26',
                'deleted_at' => NULL,
            ),
            126 => 
            array (
                'id' => 129,
                'product_variation_id' => 129,
                'location_id' => 1,
                'stock_qty' => 40,
                'created_at' => '2023-09-22 06:26:59',
                'updated_at' => '2023-09-22 06:26:59',
                'deleted_at' => NULL,
            ),
            127 => 
            array (
                'id' => 130,
                'product_variation_id' => 130,
                'location_id' => 1,
                'stock_qty' => 43,
                'created_at' => '2023-09-22 06:26:59',
                'updated_at' => '2023-09-22 06:26:59',
                'deleted_at' => NULL,
            ),
            128 => 
            array (
                'id' => 131,
                'product_variation_id' => 131,
                'location_id' => 1,
                'stock_qty' => 25,
                'created_at' => '2023-09-22 06:35:59',
                'updated_at' => '2023-09-22 06:35:59',
                'deleted_at' => NULL,
            ),
            129 => 
            array (
                'id' => 132,
                'product_variation_id' => 132,
                'location_id' => 1,
                'stock_qty' => 22,
                'created_at' => '2023-09-22 06:35:59',
                'updated_at' => '2023-09-22 06:35:59',
                'deleted_at' => NULL,
            ),
            130 => 
            array (
                'id' => 133,
                'product_variation_id' => 133,
                'location_id' => 1,
                'stock_qty' => 17,
                'created_at' => '2023-09-22 06:35:59',
                'updated_at' => '2023-09-22 06:35:59',
                'deleted_at' => NULL,
            ),
            131 => 
            array (
                'id' => 134,
                'product_variation_id' => 134,
                'location_id' => 1,
                'stock_qty' => 21,
                'created_at' => '2023-09-22 06:39:10',
                'updated_at' => '2023-09-22 06:39:10',
                'deleted_at' => NULL,
            ),
            132 => 
            array (
                'id' => 135,
                'product_variation_id' => 135,
                'location_id' => 1,
                'stock_qty' => 26,
                'created_at' => '2023-09-22 06:39:10',
                'updated_at' => '2023-09-22 06:39:10',
                'deleted_at' => NULL,
            ),
            133 => 
            array (
                'id' => 136,
                'product_variation_id' => 136,
                'location_id' => 1,
                'stock_qty' => 11,
                'created_at' => '2023-09-22 06:39:10',
                'updated_at' => '2023-09-22 06:39:10',
                'deleted_at' => NULL,
            ),
            134 => 
            array (
                'id' => 137,
                'product_variation_id' => 137,
                'location_id' => 1,
                'stock_qty' => 31,
                'created_at' => '2023-09-22 06:43:34',
                'updated_at' => '2023-09-22 06:43:34',
                'deleted_at' => NULL,
            ),
            135 => 
            array (
                'id' => 138,
                'product_variation_id' => 138,
                'location_id' => 1,
                'stock_qty' => 35,
                'created_at' => '2023-09-22 06:43:34',
                'updated_at' => '2023-09-22 06:43:34',
                'deleted_at' => NULL,
            ),
            136 => 
            array (
                'id' => 139,
                'product_variation_id' => 139,
                'location_id' => 1,
                'stock_qty' => 15,
                'created_at' => '2023-09-22 06:46:20',
                'updated_at' => '2023-09-22 06:46:20',
                'deleted_at' => NULL,
            ),
            137 => 
            array (
                'id' => 140,
                'product_variation_id' => 140,
                'location_id' => 1,
                'stock_qty' => 25,
                'created_at' => '2023-09-22 06:46:20',
                'updated_at' => '2023-09-22 06:46:20',
                'deleted_at' => NULL,
            ),
            138 => 
            array (
                'id' => 141,
                'product_variation_id' => 141,
                'location_id' => 1,
                'stock_qty' => 13,
                'created_at' => '2023-09-22 06:46:20',
                'updated_at' => '2023-09-22 06:46:20',
                'deleted_at' => NULL,
            ),
            139 => 
            array (
                'id' => 142,
                'product_variation_id' => 142,
                'location_id' => 1,
                'stock_qty' => 21,
                'created_at' => '2023-09-22 06:50:26',
                'updated_at' => '2023-09-22 06:50:26',
                'deleted_at' => NULL,
            ),
            140 => 
            array (
                'id' => 143,
                'product_variation_id' => 143,
                'location_id' => 1,
                'stock_qty' => 25,
                'created_at' => '2023-09-22 06:50:26',
                'updated_at' => '2023-09-22 06:50:26',
                'deleted_at' => NULL,
            ),
            141 => 
            array (
                'id' => 144,
                'product_variation_id' => 144,
                'location_id' => 1,
                'stock_qty' => 22,
                'created_at' => '2023-09-22 06:50:26',
                'updated_at' => '2023-09-22 06:50:26',
                'deleted_at' => NULL,
            ),
            142 => 
            array (
                'id' => 145,
                'product_variation_id' => 145,
                'location_id' => 1,
                'stock_qty' => 55,
                'created_at' => '2023-09-22 06:53:22',
                'updated_at' => '2023-09-22 06:53:22',
                'deleted_at' => NULL,
            ),
            143 => 
            array (
                'id' => 146,
                'product_variation_id' => 146,
                'location_id' => 1,
                'stock_qty' => 60,
                'created_at' => '2023-09-22 06:56:35',
                'updated_at' => '2023-09-22 06:56:35',
                'deleted_at' => NULL,
            ),
            144 => 
            array (
                'id' => 147,
                'product_variation_id' => 147,
                'location_id' => 1,
                'stock_qty' => 55,
                'created_at' => '2023-09-22 07:02:23',
                'updated_at' => '2023-09-22 07:02:23',
                'deleted_at' => NULL,
            ),
            145 => 
            array (
                'id' => 148,
                'product_variation_id' => 148,
                'location_id' => 1,
                'stock_qty' => 50,
                'created_at' => '2023-09-22 07:05:05',
                'updated_at' => '2023-09-22 07:05:05',
                'deleted_at' => NULL,
            ),
            146 => 
            array (
                'id' => 149,
                'product_variation_id' => 149,
                'location_id' => 1,
                'stock_qty' => 35,
                'created_at' => '2023-09-22 07:08:21',
                'updated_at' => '2023-09-22 07:08:21',
                'deleted_at' => NULL,
            ),
            147 => 
            array (
                'id' => 150,
                'product_variation_id' => 150,
                'location_id' => 1,
                'stock_qty' => 65,
                'created_at' => '2023-09-22 07:10:57',
                'updated_at' => '2023-09-22 07:10:57',
                'deleted_at' => NULL,
            ),
            148 => 
            array (
                'id' => 151,
                'product_variation_id' => 151,
                'location_id' => 1,
                'stock_qty' => 21,
                'created_at' => '2023-09-22 07:13:24',
                'updated_at' => '2023-09-22 07:13:24',
                'deleted_at' => NULL,
            ),
            149 => 
            array (
                'id' => 152,
                'product_variation_id' => 152,
                'location_id' => 1,
                'stock_qty' => 25,
                'created_at' => '2023-09-22 07:13:24',
                'updated_at' => '2023-09-22 07:13:24',
                'deleted_at' => NULL,
            ),
            150 => 
            array (
                'id' => 153,
                'product_variation_id' => 153,
                'location_id' => 1,
                'stock_qty' => 20,
                'created_at' => '2023-09-22 07:13:24',
                'updated_at' => '2023-09-22 07:13:24',
                'deleted_at' => NULL,
            ),
            151 => 
            array (
                'id' => 154,
                'product_variation_id' => 154,
                'location_id' => 1,
                'stock_qty' => 30,
                'created_at' => '2023-09-22 07:18:47',
                'updated_at' => '2023-09-22 07:18:47',
                'deleted_at' => NULL,
            ),
            152 => 
            array (
                'id' => 155,
                'product_variation_id' => 155,
                'location_id' => 1,
                'stock_qty' => 25,
                'created_at' => '2023-09-22 07:18:47',
                'updated_at' => '2023-09-22 07:18:47',
                'deleted_at' => NULL,
            ),
            153 => 
            array (
                'id' => 156,
                'product_variation_id' => 156,
                'location_id' => 1,
                'stock_qty' => 15,
                'created_at' => '2023-09-22 07:18:47',
                'updated_at' => '2023-09-22 07:18:47',
                'deleted_at' => NULL,
            ),
            154 => 
            array (
                'id' => 157,
                'product_variation_id' => 157,
                'location_id' => 1,
                'stock_qty' => 21,
                'created_at' => '2023-09-22 07:22:08',
                'updated_at' => '2023-09-22 07:22:08',
                'deleted_at' => NULL,
            ),
            155 => 
            array (
                'id' => 158,
                'product_variation_id' => 158,
                'location_id' => 1,
                'stock_qty' => 25,
                'created_at' => '2023-09-22 07:22:08',
                'updated_at' => '2023-09-22 07:22:08',
                'deleted_at' => NULL,
            ),
            156 => 
            array (
                'id' => 159,
                'product_variation_id' => 159,
                'location_id' => 1,
                'stock_qty' => 20,
                'created_at' => '2023-09-22 07:22:08',
                'updated_at' => '2023-09-22 07:22:08',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}