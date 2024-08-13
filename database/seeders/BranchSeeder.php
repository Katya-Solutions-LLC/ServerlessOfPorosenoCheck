<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Branch;
use Illuminate\Database\Seeder;
use Modules\BussinessHour\Models\BussinessHour;
use Illuminate\Support\Arr;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('IS_DUMMY_DATA')) {
            $days = [
                ['day' => 'monday', 'start_time' => '09:00:00', 'end_time' => '18:00:00', 'is_holiday' => false, 'breaks' => []],
                ['day' => 'tuesday', 'start_time' => '09:00:00', 'end_time' => '18:00:00', 'is_holiday' => false, 'breaks' => []],
                ['day' => 'wednesday', 'start_time' => '09:00:00', 'end_time' => '18:00:00', 'is_holiday' => false, 'breaks' => []],
                ['day' => 'thursday', 'start_time' => '09:00:00', 'end_time' => '18:00:00', 'is_holiday' => false, 'breaks' => []],
                ['day' => 'friday', 'start_time' => '09:00:00', 'end_time' => '18:00:00', 'is_holiday' => false, 'breaks' => []],
                ['day' => 'saturday', 'start_time' => '09:00:00', 'end_time' => '18:00:00', 'is_holiday' => false, 'breaks' => []],
                ['day' => 'sunday', 'start_time' => '09:00:00', 'end_time' => '18:00:00', 'is_holiday' => true, 'breaks' => []],
            ];
            $branches = [
                [
                    'address' => [
                        'postal_code' => '544512',
                        'address_line_1' => '123 Main St',
                        'address_line_2' => '',
                        'city' => 'London',
                        'state' => 'Central Square',
                        'country' => 'United Kingdom',
                    ],
                    'name' => 'Pet Care Center',
                    'manager_id' => null,
                    'feature_image' => public_path('/dummy-images/branches/1.png'),
                    'contact_email' => '',
                    'contact_number' => '',
                    'payment_method' => ['cash', 'debit_card', 'credit_card', 'upi'],
                    'branch_for' => 'unisex',
                    'contact_number' => '2012345678',
                    'contact_email' => 'info@glamourcuts.co.uk',
                ]
            ];

            foreach ($branches as $branch) {
                $address = $branch['address'];
                $featureImage = $branch['feature_image'] ?? null;
                $branchData = Arr::except($branch, ['feature_image', 'address']);
                $br = Branch::create($branchData);
                $this->attachFeatureImage($br, $featureImage);
                $br->address()->save(new Address($address));
                foreach ($days as $key => $val) {
                    $val['branch_id'] = $br->id;
                    BussinessHour::create($val);
                }
            }
        }
    }
    private function attachFeatureImage($model, $publicPath)
    {
        if(!env('IS_DUMMY_DATA_IMAGE')) return false;

        $file = new \Illuminate\Http\File($publicPath);

        $media = $model->addMedia($file)->preservingOriginal()->toMediaCollection('feature_image');

        return $media;
    }
}
