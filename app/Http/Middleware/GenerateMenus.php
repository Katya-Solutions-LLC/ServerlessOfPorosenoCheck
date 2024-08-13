<?php

namespace App\Http\Middleware;

use App\Trait\Menu;
use Illuminate\Support\Facades\Request;

class GenerateMenus
{
    use Menu;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle()
    {
        return \Menu::make('menu', function ($menu) {

     if(auth()->user()->hasRole('admin')|| auth()->user()->hasRole('demo_admin')){

          $this->staticMenu($menu, ['title' => 'MAIN', 'order' => 0]);

           // main
            $this->mainRoute($menu, [
                'icon' => 'icon-dashboard',
                'title' => __('menu.dashboard'),
                'route' => 'backend.home',
                'active' => ['app', 'app/dashboard'],
                'order' => 0,
            ]);

            //Petcare
            $this->mainRoute($menu, [
                'icon' => 'icon-all-booking',
                'title' => __('menu.bookings'),
                'route' => 'backend.booking.datatable_view',
                'active' => ['app/booking-table-view'],
                'permission' => 'view_booking',
                'order' => 0,
                'url_name' => 'petcenter',
            ]);

        }

    if(auth()->user()->hasRole('pet_sitter')){

        $this->mainRoute($menu, [
            'icon' => 'icon-Employee-Services',
            'title' => __('menu.profile'),
            'url' => 'app/my-profile', 
            'active' => ['app', 'app/my-profile'],
            'order' => 0,
        ]);

    }
    

    if (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('demo_admin') && !auth()->user()->hasRole('user') && !auth()->user()->hasRole('pet_sitter')) {
        $this->mainRoute($menu, [
            'icon' => 'icon-dashboard',
            'title' => __('menu.dashboard'),
            'route' => 'backend.employee-dashboard',
            'active' => ['app', 'app/employee-dashboard'],
            'order' => 0,
        ]);

    }

    if(enableMultivendor() == true || auth()->user()->hasRole('admin') || auth()->user()->hasRole('demo_admin')){
        $this->mainRoute($menu, [
            'icon' => 'icon-Orders',
            'title' => __('sidebar.orders'),
            'route' => ['backend.orders.index'],
            'permission' => 'view_order',
            'active' => ['app/orders'],
            'order' => 0,
        ]);
    }
            

            $permissionsToCheck = [
                'view_boarding','view_boarding_booking','view_boarder', 'view_facility','view_veterinary',
                'view_veterinary_booking','view_veterinarian','view_veterinary_category','view_veterinary_service', 'view_grooming',
                'view_grooming_booking','view_groomer','view_grooming_category','view_grooming_service','view_traning',
                'view_training_booking','view_trainer','view_training_type','view_traning_duration','view_walking',
                'view_walking_booking','view_walker','view_walking_duration','view_daycare','view_daycare_booking','view_care_taker',
                'view_pet_sitter','view_booking_request','view_pet_store'
            ];
            
            if (collect($permissionsToCheck)->contains(fn ($permission) => auth()->user()->hasPermission($permission))) {
                $this->staticMenu($menu, ['title' => __('sidebar.services'), 'order' => 0]);
            }

            //Boarding
            if (check_system_service('boarding') == 1) {
                $boarding = $this->parentMenu($menu, [
                    'icon' => 'icon-Boarding',
                    'title' => __('booking.lbl_boarding'),
                    'nickname' => 'boarding',
                    'permission' => 'view_boarding',
                    'order' => 0,
                ]);
                $this->childMain($boarding, [
                    'icon' => 'icon-Filter',
                    'title' => __('menu.boarding_booking'),
                    'route' => 'backend.bookings.datatable_view',
                    'shortTitle' => 'BB',
                    'active' => ['app/bookings-table-view'],
                    'permission' => 'view_boarding_booking',
                    'order' => 0,
                ]);

                $this->childMain($boarding, [
                    'title' => __('menu.boarder_list'),
                    'icon' => 'icon-Employee',
                    'route' => ['backend.employees.index', 'employee_type' => 'boarder'],
                    'shortTitle' => 'BL',
                    'active' => ['app/employees?employee_type=boarder'],
                    'permission' => 'view_boarder',
                    'order' => 0,
                ]);

                $this->childMain($boarding, [
                    'icon' => 'icon-Filter',
                    'title' => __('menu.facility_list'),
                    'route' => 'backend.service-facility.index',
                    'shortTitle' => 'FL',
                    'active' => ['app/service-facility'],
                    'permission' => 'view_facility',
                    'order' => 0,
                ]);
            }
            if (check_system_service('veterinary') == 1) {
                //Veterinary
                $veterinary = $this->parentMenu($menu, [
                    'icon' => 'icon-Veterinary',
                    'title' => __('booking.lbl_veterinary'),
                    'nickname' => 'veterinary',
                    'permission' => 'view_veterinary',
                    'order' => 0,
                ]);
                $this->childMain($veterinary, [
                    'icon' => 'icon-Filter',
                    'title' => __('menu.veterinary_booking'),
                    'route' => 'backend.veterinary.datatable_view',
                    'shortTitle' => 'VB',
                    'active' => ['app/veterinary-table-view'],
                    'permission' => 'view_veterinary_booking',
                    'order' => 0,
                ]);
                $this->childMain($veterinary, [
                    'title' => __('menu.veterinarian_list'),
                    'icon' => 'icon-Employee',
                    'route' => ['backend.employees.index', 'employee_type' => 'vet'],
                    'shortTitle' => 'VL',
                    'active' => ['app/employees?employee_type=vet'],
                    'permission' => 'view_veterinarian',
                    'order' => 0,
                ]);
                $this->childMain($veterinary, [
                    'icon' => 'icon-Filter',
                    'title' => __('menu.category_list'),
                    'route' => ['backend.categories.index', 'category_type' => 'veterinary'],
                    'shortTitle' => 'CL',
                    'active' => ['app/categories?category_type=veterinary'],
                    'permission' => 'view_veterinary_category',
                    'order' => 0,
                ]);
                $this->childMain($veterinary, [
                    'icon' => 'icon-Filter',
                    'title' => __('menu.service_list'),
                    'route' => ['backend.services.index', 'service_type' => 'veterinary'],
                    'shortTitle' => 'SL',
                    'active' => ['app/services?service_type=veterinary'],
                    'permission' => 'view_veterinary_service',
                    'order' => 0,
                ]);
            }
            if (check_system_service('grooming') == 1) {
                //Grooming
                $grooming = $this->parentMenu($menu, [
                    'icon' => 'icon-Grooming',
                    'title' => __('booking.lbl_grooming'),
                    'nickname' => 'grooming',
                    'permission' => 'view_grooming',
                    'order' => 0,
                ]);
                $this->childMain($grooming, [
                    'icon' => 'icon-Filter',
                    'title' => __('menu.grooming_booking'),
                    'route' => 'backend.grooming.datatable_view',
                    'shortTitle' => 'GB',
                    'active' => ['app/grooming-table-view'],
                    'permission' => 'view_grooming_booking',
                    'order' => 0,
                ]);
                $this->childMain($grooming, [
                    'title' => __('menu.groomer_list'),
                    'icon' => 'icon-Employee',
                    'route' => ['backend.employees.index', 'employee_type' => 'groomer'],
                    'shortTitle' => 'GL',
                    'active' => ['app/employees?employee_type=groomer'],
                    'permission' => 'view_groomer',
                    'order' => 0,
                ]);
                $this->childMain($grooming, [
                    'icon' => 'icon-Filter',
                    'title' => __('menu.category_list'),
                    'route' => ['backend.categories.index', 'category_type' => 'grooming'],
                    'shortTitle' => 'CL',
                    'active' => ['app/categories?category_type=grooming'],
                    'permission' => 'view_grooming_category',
                    'order' => 0,
                ]);
                $this->childMain($grooming, [
                    'icon' => 'icon-Filter',
                    'title' => __('menu.service_list'),
                    'route' => ['backend.services.index', 'service_type' => 'grooming'],
                    'shortTitle' => 'SL',
                    'active' => ['app/services?service_type=grooming'],
                    'permission' => 'view_grooming_service',
                    'order' => 0,
                ]);
            }
            if (check_system_service('training') == 1) {
                //Training
                $training = $this->parentMenu($menu, [
                    'icon' => 'icon-Training',
                    'title' => __('booking.lbl_training'),
                    'nickname' => 'training',
                    'permission' => 'view_traning',
                    'order' => 0,
                ]);
                $this->childMain($training, [
                    'icon' => 'icon-Filter',
                    'title' => __('menu.training_booking'),
                    'route' => 'backend.training.datatable_view',
                    'shortTitle' => 'TB',
                    'active' => ['app/training-table-view'],
                    'permission' => 'view_training_booking',
                    'order' => 0,
                ]);
                $this->childMain($training, [
                    'title' => __('menu.trainer_list'),
                    'icon' => 'icon-Employee',
                    'route' => ['backend.employees.index', 'employee_type' => 'trainer'],
                    'shortTitle' => 'TL',
                    'active' => ['app/employees?employee_type=trainer'],
                    'permission' => 'view_trainer',
                    'order' => 0,
                ]);
                $this->childMain($training, [
                    'icon' => 'icon-Filter',
                    'title' => __('menu.training_list'),
                    'route' => 'backend.service-training.index',
                    'shortTitle' => 'TT',
                    'active' => ['app/service-training'],
                    'permission' => 'view_training_type',
                    'order' => 0,
                ]);
                $this->childMain($training, [
                    'icon' => 'icon-Filter',
                    'title' => __('menu.duration_list'),
                    'route' => ['backend.service-duration.index', 'type' => 'training'],
                    'shortTitle' => 'DL',
                    'active' => ['app/service-duration?type=training'],
                    'permission' => 'view_traning_duration',
                    'order' => 0,
                ]);
            }
            //Walking
            if (check_system_service('walking') == 1) {
                $walking = $this->parentMenu($menu, [
                    'icon' => 'icon-Walking',
                    'title' => __('booking.lbl_walking'),
                    'permission' => 'view_walking',
                    'nickname' => 'walking',
                    'order' => 0,
                ]);
                $this->childMain($walking, [
                    'icon' => 'icon-Filter',
                    'title' => __('menu.walking_booking'),
                    'route' => 'backend.walking.datatable_view',
                    'shortTitle' => 'WB',
                    'active' => ['app/walking-table-view'],
                    'permission' => 'view_walking_booking',
                    'order' => 0,
                ]);

                $this->childMain($walking, [
                    'icon' => 'icon-Filter',
                    'title' => __('menu.walking_booking_request'),
                    'route' => ['backend.walking.booking_request_datatable'],
                    'shortTitle' => 'BR',
                    'active' => ['app/booking-request-datatable'],
                    'permission' => 'view_booking_request',
                    'order' => 0,
                ]);
                $this->childMain($walking, [
                    'title' => __('menu.walker_list'),
                    'icon' => 'icon-Employee',
                    'route' => ['backend.employees.index', 'employee_type' => 'walker'],
                    'shortTitle' => 'WL',
                    'active' => ['app/employees?employee_type=walker'],
                    'permission' => 'view_walker',
                    'order' => 0,
                ]);
                $this->childMain($walking, [
                    'icon' => 'icon-Filter',
                    'title' => __('menu.duration_list'),
                    'route' => ['backend.service-duration.index', 'type' => 'walking'],
                    'shortTitle' => 'DL',
                    'active' => ['app/service-duration?type=walking'],
                    'permission' => 'view_walking_duration',
                    'order' => 0,
                ]);
            }

            //Day Care
            if (check_system_service('daycare') == 1) {

                $daycare = $this->parentMenu($menu, [
                    'icon' => 'icon-icon-day-care',
                    'title' => __('booking.lbl_day_care'),
                    'nickname' => 'daycare',
                    'permission' => 'view_daycare',
                    'order' => 0,
                ]);
                $this->childMain($daycare, [
                    'icon' => 'icon-Filter',
                    'title' => __('menu.daycare_booking'),
                    'route' => 'backend.daycare.datatable_view',
                    'shortTitle' => 'DB',
                    'active' => ['app/daycare-table-view'],
                    'permission' => 'view_daycare_booking',
                    'order' => 0,
                ]);
                $this->childMain($daycare, [
                    'title' => __('menu.daycare_taker_list'),
                    'icon' => 'icon-Employee',
                    'route' => ['backend.employees.index', 'employee_type' => 'day_taker'],
                    'shortTitle' => 'DT',
                    'active' => ['app/employees?employee_type=day_care'],
                    'permission' => 'view_care_taker',
                    'order' => 0,
                ]);
            }

             //Pet Sitter
             $this->mainRoute($menu, [
                'icon' => 'icon-Employee',
                'title' => __('menu.pet_sitter_list'),
                'permission' => 'view_tag',
                'route' => ['backend.employees.index', 'employee_type' => 'pet_sitter'],
                'permission' => 'view_pet_sitter',
                'active' => ['app/employees?employee_type=pet_sitter'],
                'order' => 0,
            ]);

            //Pet Store
            if(enableMultivendor() == true){
            $this->mainRoute($menu, [
                'icon' => 'icon-Product',
                'title' => __('menu.pet_store_list'),
                'permission' => 'view_tag',
                'route' => ['backend.employees.index', 'employee_type' => 'pet_store'],
                'permission' => 'view_pet_store',
                'active' => ['app/employees?employee_type=pet_store'],
                'order' => 0,
            ]);
            }

         
            // if (auth()->user()->can(['view_product', 'view_brand', 'view_product_category', 'view_product_subcategory', 'view_unit','view_tag','view_unit','view_product_variation','view_supply','view_logistics','view_shipping_zones'])) {
            //     $this->staticMenu($menu, ['title' => __('sidebar.shop'), 'order' => 0]);
            // }

            $permissionsToCheck = [
                'view_product','view_brand','view_product_category', 'view_product_subcategory','view_unit',
                'view_tag','view_product_variation','view_supply','view_logistics', 'view_shipping_zones'];
            
            if(enableMultivendor() == true || auth()->user()->hasRole('admin') || auth()->user()->hasRole('demo_admin')){

            if (collect($permissionsToCheck)->contains(fn ($permission) => auth()->user()->hasPermission($permission))) {
                $this->staticMenu($menu, ['title' => __('sidebar.shop'), 'order' => 0]);
            }

            $product = $this->parentMenu($menu, [
                'icon' => 'icon-Product',
                'title' => __('sidebar.product'),
                'nickname' => 'pets',
                'permission' => 'view_product',
                'order' => 0,
            ]);

            $this->childMain($product, [
                'title' => __('sidebar.all_product'),
                'route' => 'backend.products.index',
                'shortTitle' => 'AP',
                'permission' => 'view_product',
                'active' => ['app/products'],
                'order' => 0,
            ]);

            $this->childMain($product, [
                'title' => __('sidebar.brand'),
                'route' => 'backend.brands.index',
                'shortTitle' => 'BR',
                'permission' => 'view_brand',
                'active' => ['app/brands'],
                'order' => 0,
            ]);

            $this->childMain($product, [
                'title' => __('sidebar.categories'),
                'route' => 'backend.products-categories.index',
                'shortTitle' => 'C',
                'permission' => 'view_product_category',
                'active' => ['app/products-categories'],
                'order' => 0,
            ]);

            $this->childMain($product, [
                'title' => __('sidebar.sub_categories'),
                'route' => 'backend.products-categories.index_nested',
                'shortTitle' => 'SC',
                'permission' => 'view_product_subcategory',
                'active' => ['app/products-sub-categories'],
                'order' => 0,
            ]);

            $this->childMain($product, [
                'title' => __('sidebar.units'),
                'route' => 'backend.units.index',
                'shortTitle' => 'U',
                'permission' => 'view_unit',
                'active' => ['app/units'],
                'order' => 0,
            ]);

            $this->childMain($product, [
                'title' => __('sidebar.tag'),
                'route' => 'backend.tags.index',
                'shortTitle' => 'T',
                'permission' => 'view_tag',
                'active' => ['app/tags'],
                'order' => 0,
            ]);

            $this->mainRoute($menu, [
                'icon' => 'icon-Product-Variations',
                'title' => __('sidebar.variations'),
                'route' => ['backend.variations.index'],
                'active' => ['app/variations'],
                'permission' => 'view_product_variation',
                'order' => 0,
            ]);

            // $this->mainRoute($menu, [
            //     'icon' => 'icon-Orders',
            //     'title' => __('sidebar.orders'),
            //     'permission' => 'view_tag',
            //     'route' => ['backend.orders.index'],
            //     'permission' => 'view_order',
            //     'active' => ['app/orders'],
            //     'order' => 0,
            // ]);

            $supply = $this->parentMenu($menu, [
                'icon' => 'icon-supply',
                'title' => __('sidebar.supply'),
                'nickname' => 'supply',
                'permission' => 'view_supply',
                'order' => 0,
            ]);

            $this->childMain($supply, [
                'title' => __('sidebar.logistics'),
                'route' => 'backend.logistics.index',
                'shortTitle' => 'AP',
                'active' => ['app/logistics'],
                'permission' => 'view_logistics',
                'order' => 0,
            ]);

            $this->childMain($supply, [
                'title' => __('sidebar.logistic_zone'),
                'route' => 'backend.logistic-zones.index',
                'permission' => 'view_shipping_zones',
                'shortTitle' => 'AP',
                'active' => ['app/logistic-zones'],
                'order' => 0,
            ]);

            }

            // USERS Static



         $permissionsToCheck = ['view_employees','view_pending_employees','view_owners', 'view_review', 'view_order_review'];

          if (collect($permissionsToCheck)->contains(fn ($permission) => auth()->user()->can($permission))) {
              $this->staticMenu($menu, ['title' => 'USERS', 'order' => 0]);
          }

            $this->mainRoute($menu, [
                'icon' => 'icon-Employee',
                'title' => __('menu.lbl_employees'),
                'route' => ['backend.employees.all'],
                'active' => ['app/all-employees/'],
                'permission' => 'view_employees',
                'order' => 0,
            ]);


            $this->mainRoute($menu, [
                'icon' => 'icon-Employee',
                'title' => __('menu.employee_request_list'),
                'route' => ['backend.employees.index', 'employee_type' => 'pending_employee'],
                'shortTitle' => 'PE',
                'active' => ['app/employees?employee_type=pending_employee'],
                'permission' => 'view_pending_employees',
                'order' => 0,
            ]);

            $this->mainRoute($menu, [
                'icon' => 'icon-pet',
                'title' => __('menu.lbl_employee_pets'),
                'route' => ['backend.pets.index'],
                'active' => ['app/pets'],
                'permission' => 'view_owners',
                'order' => 0,
            ]);

            $this->mainRoute($menu, [
                'icon' => ' icon-Reviews',
                'title' => __('menu.lbl_review'),
                'route' => ['backend.employees.review'],
                'active' => ['app/employees-review'],
                'permission' => 'view_review',
                'order' => 0,
            ]);

            if(enableMultivendor() == true || auth()->user()->hasRole('admin') || auth()->user()->hasRole('demo_admin')){
                $this->mainRoute($menu, [
                    'icon' => ' icon-Reviews',
                    'title' => __('menu.lbl_order_review'),
                    'route' => ['backend.employees.order-review'],
                    'active' => ['app/employees-order-review'],
                    'permission' => 'view_order_review',
                    'order' => 0,
                ]);
            }

            // FINANCE Static

            $permissionsToCheck = ['view_tax', 'view_employee_earning'];

            if (collect($permissionsToCheck)->contains(fn ($permission) => auth()->user()->can($permission))) {
                $this->staticMenu($menu, ['title' => 'FINANCE', 'order' => 0]);
            }

            $this->mainRoute($menu, [
                'icon' => 'icon-tex',
                'title' => __('menu.tax'),
                'route' => 'backend.tax.index',
                'active' => ['app/tax'],
                'permission' => 'view_tax',
                'order' => 0,
            ]);

            $this->mainRoute($menu, [
                'icon' => ' icon-Employee-Earnings',
                'title' => 'Employee Earnings',
                'route' => 'backend.earnings.index',
                'active' => ['app/earnings'],
                'permission' => 'view_employee_earning',
                'order' => 0,
            ]);

            if(enableMultivendor() == true){
            $this->mainRoute($menu, [
                'icon' => ' icon-Employee-Earnings',
                'title' => 'Employee Order Earnings',
                'route' => 'backend.order-earnings.index',
                'active' => ['app/order-earnings'],
                'permission' => 'view_employee_earning',
                'order' => 0,
            ]);
            }

            $permissionsToCheck = ['view_daily_bookings', 'view_overall_bookings', 'view_employee_payout', 'view_order_reports'];

            if (collect($permissionsToCheck)->contains(fn ($permission) => auth()->user()->can($permission))) {
                $this->staticMenu($menu, ['title' => 'REPORTS', 'order' => 0]);
            }

            $this->mainRoute($menu, [
                'icon' => ' icon-Daily-Bookings',
                'title' => __('menu.daily_booking_report'),
                'route' => 'backend.reports.daily-booking-report',
                'active' => ['app/daily-booking-report'],
                'permission' => 'view_daily_bookings',
                'order' => 0,
            ]);

            $this->mainRoute($menu, [
                'icon' => ' icon-all-booking',
                'title' => __('menu.overall_booking_report'),
                'route' => 'backend.reports.overall-booking-report',
                'active' => ['app/overall-booking-report'],
                'permission' => 'view_overall_bookings',
                'order' => 0,
            ]);

            $this->mainRoute($menu, [
                'icon' => ' icon-Employee-Payouts',
                'title' => __('menu.payout_report'),
                'route' => 'backend.reports.payout-report',
                'active' => ['app/payout-report'],
                'permission' => 'view_employee_payout',
                'order' => 0,
            ]);

            $this->mainRoute($menu, [
                'icon' => ' icon-order-report',
                'title' => __('sidebar.orders_report'),
                'route' => 'backend.reports.order-report',
                'active' => ['app/order-report'],
                'permission' => 'view_order_reports',
                'order' => 0,
            ]);

            // OTHER Static

            $permissionsToCheck = ['view_events', 'view_blogs'];

            if (collect($permissionsToCheck)->contains(fn ($permission) => auth()->user()->can($permission))) {
                $this->staticMenu($menu, ['title' => 'OTHER', 'order' => 0]);
              }
          

            $this->mainRoute($menu, [
                'icon' => 'icon-Daily-Bookings',
                'title' => __('event.title'),
                'route' => 'backend.events.index',
                'active' => ['app/events'],
                'permission' => 'view_events',
                'order' => 0,
            ]);

            $this->mainRoute($menu, [
                'icon' => ' icon-Daily-Bookings',
                'title' => __('menu.lbl_blog'),
                'route' => 'backend.blogs.index',
                'active' => ['app/blogs'],
                'permission' => 'view_blogs',
                'order' => 0,
            ]);

            // System Static
            $permissionsToCheck = [
                'view_setting','view_location','view_syetem_service','view_pet', 'view_page', 
                'view_notification','view_app_banner','view_app_banner','view_constant', 
                'view_permission','view_modules'
            ];
            
            if (collect($permissionsToCheck)->contains(fn ($permission) => auth()->user()->can($permission))) {
                $this->staticMenu($menu, ['title' => 'SYSTEM', 'order' => 0]);
            }

            $this->mainRoute($menu, [
                'icon' => 'icon-Setting',
                'title' => __('menu.settings'),
                'route' => 'backend.settings',
                'active' => 'app/settings',
                'permission' => 'view_setting',
                'order' => 0,
            ]);


            //Location
            $location = $this->parentMenu($menu, [
                'icon' => 'icon-location',
                'title' => __('menu.location'),
                'nickname' => 'location',
                'permission' => 'view_location',
                'order' => 0,
            ]);

            $this->childMain($location, [
                'title' => __('menu.city'),
                'route' => 'backend.city.index',
                'shortTitle' => 'CT',
                'active' => ['app/city'],
                'permission' => 'view_city',
                'order' => 0,
                'icon' => 'icon-Filter',
            ]);
            $this->childMain($location, [
                'title' => __('menu.state'),
                'route' => 'backend.state.index',
                'shortTitle' => 'CT',
                'permission' => 'view_state',
                'active' => ['app/state'],
                'order' => 0,
                'icon' => 'icon-Filter',
            ]);
            $this->childMain($location, [
                'title' => __('menu.country'),
                'route' => 'backend.country.index',
                'shortTitle' => 'CT',
                'active' => ['app/country'],
                'permission' => 'view_country',
                'order' => 0,
                'icon' => 'icon-Filter',
            ]);
             

            //system service
            $this->mainRoute($menu, [
                'icon' => ' icon-Employee-Services',
                'title' => __('menu.system_service'),
                'route' => ['backend.service.systemservice.index'],
                'active' => ['app/service/systemservice'],
                'permission' => 'view_syetem_service',
                'order' => 0,
            ]);

            //Pet
            $pet = $this->parentMenu($menu, [
                'icon' => 'icon-pet',
                'title' => __('pet.title'),
                'nickname' => 'pets',
                'permission' => 'view_pet',
                'order' => 0,
            ]);

            $this->childMain($pet, [
                'title' => __('pet.lbl_pettype'),
                'route' => 'backend.pet.pettype.index',
                'shortTitle' => 'PT',
                'active' => ['app/pet/pettype'],
                'permission' => 'view_pet_type',
                'order' => 0,
                'icon' => 'icon-Filter',
            ]);
            $this->childMain($pet, [
                'icon' => 'icon-Filter',
                'title' => __('pet.lbl_breed'),
                'route' => 'backend.pet.breed.index',
                'shortTitle' => 'BR',
                'active' => ['app/pet/breed'],
                'permission' => 'view_breed',
                'order' => 0,
            ]);

            $this->mainRoute($menu, [
                'icon' => ' icon-page',
                'title' => __('page.title'),
                'route' => ['backend.pages.index'],
                'active' => ['app/pages'],
                'permission' => 'view_page',
                'order' => 0,
            ]);

            $notification = $this->parentMenu($menu, [
                'icon' => 'icon-Notification',
                'title' => __('notification.title'),
                'nickname' => 'notifications',
                'permission' => 'view_notification',
                'order' => 0,
            ]);

            $this->childMain($notification, [
                'title' => __('notification.list'),
                'route' => 'backend.notifications.index',
                'shortTitle' => 'Li',
                'active' => 'app/notifications',
                'permission' => 'view_notification',
                'order' => 0,
                'icon' => 'icon-Filter',
            ]);

            $this->childMain($notification, [
                'title' => __('notification.template'),
                'route' => 'backend.notification-templates.index',
                'shortTitle' => 'TE',
                'active' => 'app/notification-templates*',
                'permission' => 'view_notification_template',
                'order' => 0,
                'icon' => 'icon-Filter',
            ]);

            $this->mainRoute($menu, [
                'icon' => 'icon-app-banner',
                'title' => __('menu.app_banner'),
                'route' => 'backend.app-banners.index',
                'active' => 'app/app-banners',
                'permission' => 'view_app_banner',
                'order' => 0,
            ]);

            //  $this->mainRoute($menu, [
            //      'icon' => ' fa-solid fa-id-badge',
            //      'title' => __('menu.lbl_constants'),
            //      'route' => 'backend.constants.index',
            //      'active' => ['app/constants*'],
            //      'permission' => 'view_constant',
            //      'order' => 0,
            //  ]);

            $this->mainRoute($menu, [
                'icon' => 'icon-Access-Control',
                'title' => __('menu.access_control'),
                'route' => 'backend.permission-role.list',
                'active' => ['app/permission-role'],
                'permission' => 'view_permission',
                'order' => 0,
            ]);

            //  $this->mainRoute($menu, [
            //      'icon' => 'icon-Modules',
            //      'title' => __('menu.modules'),
            //      'route' => 'backend.module.index',
            //      'active' => ['app/module'],
            //      'permission' => 'view_modules',
            //      'order' => 0,
            //  ]);

            // Access Permission Check
            $menu->filter(function ($item) {
                if ($item->data('permission')) {
                    if (auth()->check()) {
                        if (\Auth::getDefaultDriver() == 'admin') {
                            return true;
                        }
                        if (auth()->user()->hasAnyPermission($item->data('permission'), \Auth::getDefaultDriver())) {
                            return true;
                        }
                    }

                    return false;
                } else {
                    return true;
                }
            });
            // Set Active Menu
            $menu->filter(function ($item) {
                if ($item->activematches) {
                    $activematches = (is_string($item->activematches)) ? [$item->activematches] : $item->activematches;
                    foreach ($activematches as $pattern) {
                        if (request()->is($pattern)) {
                            $item->active();
                            $item->link->active();
                            if ($item->hasParent()) {
                                $item->parent()->active();
                            }
                        }
                    }
                }

                return true;
            });
        })->sortBy('order');
    }
}
