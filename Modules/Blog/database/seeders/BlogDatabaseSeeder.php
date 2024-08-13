<?php

namespace Modules\Blog\database\seeders;

use Illuminate\Database\Seeder;


class BlogDatabaseSeeder extends Seeder
{
   
  public function run()
    {
         $this->call(BlogTableSeeder::class);
      
    }
}
