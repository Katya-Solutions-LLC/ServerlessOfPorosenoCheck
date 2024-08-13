<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Filesystem\Filesystem;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \Artisan::call('config:clear');
        \Artisan::call('cache:clear');
        Schema::disableForeignKeyConstraints();
        $file = new Filesystem;
        $file->cleanDirectory('storage/app/public');
        Setting::create(['name' => 'slot_duration', 'val' => '00:15', 'type' => 'text']);
        $this->call(BranchSeeder::class);
        $this->call(AuthTableSeeder::class);
        $this->call(ModulesSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(\Modules\Tax\database\seeders\TaxDatabaseSeeder::class);
        $this->call(\Modules\Constant\database\seeders\ConstantDatabaseSeeder::class);
        $this->call(\Modules\Commission\database\seeders\CommissionDatabaseSeeder::class);
        $this->call(\Modules\Currency\database\seeders\CurrencyDatabaseSeeder::class);
        $this->call(\Modules\Employee\database\seeders\EmployeeDatabaseSeeder::class);
        $this->call(\Modules\Category\database\seeders\CategoryDatabaseSeeder::class);
        $this->call(\Modules\Service\database\seeders\ServiceDatabaseSeeder::class);
        $this->call(\Modules\Pet\database\seeders\PetDatabaseSeeder::class);
        $this->call(\Modules\Booking\database\seeders\BookingDatabaseSeeder::class);
        $this->call(\Modules\NotificationTemplate\database\seeders\NotificationTemplateSeeder::class);
        $this->call(\Modules\CustomField\database\seeders\CustomFieldDatabaseSeeder::class);
        $this->call(\Modules\Slider\database\seeders\SliderDatabaseSeeder::class);
        $this->call(\Modules\Page\database\seeders\PageDatabaseSeeder::class);
        $this->call(\Modules\Event\database\seeders\EventDatabaseSeeder::class);
        $this->call(\Modules\Blog\database\seeders\BlogDatabaseSeeder::class);
        $this->call(\Modules\Tag\database\seeders\TagDatabaseSeeder::class);
        $this->call(\Modules\World\database\seeders\WorldDatabaseSeeder::class);
        // $this->call(\Modules\Logistic\database\seeders\LogisticZoneTableSeeder::class);
        $this->call(\Modules\Logistic\database\seeders\LogisticDatabaseSeeder::class);
        $this->call(\Modules\Location\database\seeders\LocationDatabaseSeeder::class);
        $this->call(\Modules\Product\database\seeders\ProductDatabaseSeeder::class);
        Schema::enableForeignKeyConstraints();
     
        // $this->call(EmployeeRatingTableSeeder::class);

        $this->call(TagsTableSeeder::class);
        \Artisan::call('config:clear');
        \Artisan::call('cache:clear');
    }
}
