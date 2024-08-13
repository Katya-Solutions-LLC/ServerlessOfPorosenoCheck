<?php

namespace App\Models;

class Permission extends \Spatie\Permission\Models\Permission
{
    /**
     * Default Permissions of the Application.
     */
    public static function defaultPermissions()
    {
        return [
            
            'view_booking' => 'View booking',
            'add_booking' => 'Add booking',
            'edit_booking' => 'Edit booking',
            'delete_booking' => 'Delete booking',

            'view_boarding' => 'View Boarding',
            'add_boarding' => 'Add Boarding',
            'edit_boarding' => 'Edit Boarding',
            'delete_boarding' => 'Delete Boarding',

            'view_boarding' => 'View Boarding',
            'add_boarding' => 'Add Boarding',
            'edit_boarding' => 'Edit Boarding',
            'delete_boarding' => 'Delete Boarding',

            'view_boarding_booking' => 'View Boarding Booking',
            'add_boarding_booking' => 'Add Boarding Booking',
            'edit_boarding_booking' => 'Edit Boarding Booking',
            'delete_boarding_booking' => 'Delete Boarding Booking',

            'view_boarder' => 'View Boarder',
            'add_boarder' => 'Add Boarder',
            'edit_boarder' => 'Edit Boarder',
            'delete_boarder' => 'Delete Boarder',

            'view_facility' => 'View Facility',
            'add_facility' => 'Add Facility',
            'edit_facility' => 'Edit Facility',
            'delete_facility' => 'Delete Facility',

            'view_veterinary' => 'View Veterinary',
            'add_veterinary' => 'Add Veterinary',
            'edit_veterinary' => 'Edit Veterinary',
            'delete_veterinary' => 'Delete Veterinary',

            'view_veterinary_booking' => 'View Veterinary Booking',
            'add_veterinary_booking' => 'Add Veterinary Booking',
            'edit_veterinary_booking' => 'Edit Veterinary Booking',
            'delete_veterinary_booking' => 'Delete Veterinary Booking',

            'view_veterinarian' => 'View Veterinarian',
            'add_veterinarian' => 'Add Veterinarian',
            'edit_veterinarian' => 'Edit Veterinarian',
            'delete_veterinarian' => 'Delete Veterinarian',

            'view_veterinary_category' => 'View Veterinary Category',
            'add_veterinary_category' => 'Add Veterinary Category',
            'edit_veterinary_category' => 'Edit Veterinary Category',
            'delete_veterinary_category' => 'Delete Veterinary Category',

            'view_veterinary_service' => 'View Veterinary Service',
            'add_veterinary_service' => 'Add Veterinary Service',
            'edit_veterinary_service' => 'Edit Veterinary Service',
            'delete_veterinary_service' => 'Delete Veterinary Service',


            'view_grooming' => 'View Grooming',
            'add_grooming' => 'Add Grooming',
            'edit_grooming' => 'Edit Grooming',
            'delete_grooming' => 'Delete Grooming',

            'view_grooming_booking' => 'View Grooming Booking',
            'add_grooming_booking' => 'Add Grooming Booking',
            'edit_grooming_booking' => 'Edit Grooming Booking',
            'delete_grooming_booking' => 'Delete Grooming Booking',

            'view_groomer' => 'View Groomer',
            'add_groomer' => 'Add Groomer',
            'edit_groomer' => 'Edit Groomer',
            'delete_groomer' => 'Delete Groomer',

            'view_grooming_category' => 'View Grooming Category',
            'add_grooming_category' => 'Add Grooming Category',
            'edit_grooming_category' => 'Edit Grooming Category',
            'delete_grooming_category' => 'Delete Grooming Category',

            'view_grooming_service' => 'View Grooming Service',
            'add_grooming_service' => 'Add Grooming Service',
            'edit_grooming_service' => 'Edit Grooming Service',
            'delete_grooming_service' => 'Delete Grooming Service',

            'view_traning' => 'View Traning',
            'add_traning' => 'Add Traning',
            'edit_traning' => 'Edit Traning',
            'delete_traning' => 'Delete Traning',

            'view_training_booking' => 'View Traning Booking',
            'add_training_booking' => 'Add Traning Booking',
            'edit_training_booking' => 'Edit Traning Booking',
            'delete_training_booking' => 'Delete Traning Booking',

            'view_trainer' => 'View Trainer',
            'add_trainer' => 'Add Trainer',
            'edit_trainer' => 'Edit Trainer',
            'delete_trainer' => 'Delete Trainer',

            'view_training_type' => 'View Traning Type',
            'add_training_type' => 'Add Traning Type',
            'edit_training_type' => 'Edit Traning Type',
            'delete_training_type' => 'Delete Traning Type',

            'view_traning_duration' => 'View Traning Duration',
            'add_traning_duration' => 'Add Traning Duration',
            'edit_traning_duration' => 'Edit Traning Duration',
            'delete_traning_duration' => 'Delete Traning Duration',


            'view_walking' => 'View Walking',
            'add_walking' => 'Add Walking',
            'edit_walking' => 'Edit Walking',
            'delete_walking' => 'Delete Walking',

            'view_walking_booking' => 'View Walking Booking',
            'add_walking_booking' => 'Add Walking Booking',
            'edit_walking_booking' => 'Edit Walking Booking',
            'delete_walking_booking' => 'Delete Walking Booking',

            'view_booking_request' => 'View Booking Request',
            'add_booking_request' => 'Add Booking Request',
            'edit_booking_request' => 'Edit Booking Request',
            'delete_booking_request' => 'Delete Booking Request',


            'view_walker' => 'View Walker',
            'add_walker' => 'Add Walker',
            'edit_walker' => 'Edit Walker',
            'delete_walker' => 'Delete Walker',

            'view_walking_duration' => 'View Walking Duration',
            'add_walking_duration' => 'Add Walking Duration',
            'edit_walking_duration' => 'Edit Walking Duration',
            'delete_walking_duration' => 'Delete Walking Duration',

            'view_daycare' => 'View DayCare',
            'add_daycare' => 'Add DayCare',
            'edit_daycare' => 'Edit DayCare',
            'delete_daycare' => 'Delete DayCare',

            'view_daycare_booking' => 'View DayCare Booking',
            'add_daycare_booking' => 'Add DayCare Booking',
            'edit_daycare_booking' => 'Edit DayCare Booking',
            'delete_daycare_booking' => 'Delete DayCare Booking',

            'view_care_taker' => 'View Care Taker',
            'add_care_taker' => 'Add Care Taker',
            'edit_care_taker' => 'Edit Care Taker',
            'delete_care_taker' => 'Delete Care Taker',

            'view_pet_sitter' => 'View Pet Sitter',
            'add_pet_sitter' => 'Add Pet Sitter',
            'edit_pet_sitter' => 'Edit Pet Sitter',
            'delete_pet_sitter' => 'Delete Pet Sitter',

            'view_pet_store' => 'View Pet Store',
            'add_pet_store' => 'Add Pet Store',
            'edit_pet_store' => 'Edit Pet Store',
            'delete_pet_store' => 'Delete Pet Store',

            'view_service' => 'View Service',
            'add_service' => 'Add Service',
            'edit_service' => 'Edit Service',
            'delete_service' => 'Delete Service',
            'add_assign_service' => 'Add Asign Service',

            'view_category' => 'View Category',
            'add_category' => 'Add Category',
            'edit_category' => 'Edit Category',
            'delete_category' => 'Delete Category',

            'view_subcategory' => 'View Subcategory',
            'add_subcategory' => 'Add Subcategory',
            'edit_subcategory' => 'Edit Subcategory',
            'delete_subcategory' => 'Delete Subcategory',

            'view_employees' => 'View Employees',
            'add_employees' => 'Add Employees',
            'edit_employees' => 'Edit Employees',
            'delete_employees' => 'Delete Employees',

            'view_pending_employees' => 'View Pending Employees',
            
            'edit_employee_password'=>'Edit Employee Password',

            'view_employee_earning' => 'View Employee Earning',
            'add_employee_earning' => 'Add Employee Earning',
            'edit_employee_earning' => 'Edit Employee Earning',
            'delete_employee_earning' => 'Delete Employee Earning',

            'view_employee_payout' => 'View Employee Payout',
            'add_employee_payout' => 'Add Employee Payout',
            'edit_employee_payout' => 'Edit Employee Payout',
            'delete_employee_payout' => 'Delete Employee Payout',

            'view_owners' => 'View Owners',
            'add_owners' => 'Add Owners',
            'edit_owners' => 'Edit Owners',
            'delete_owners' => 'Delete Owners',

            "view_owner's_pet" => "View Owner's Pet",
            "add_owner's_pet" => "Add Owner's Pet",
            "edit_owner's_pet" => "Edit Owner's Pet",
            "delete_owner's_pet" => "Delete Owner's Pet",

            'edit_user_password' => 'Edit user Password',

            'view_review' => 'View Review',
            'add_review' => 'Add Review',
            'edit_review' => 'Edit Review',
            'delete_review' => 'Delete Review',

            'view_order_review' => 'View Order Review',
            'add_order_review' => 'Add Order Review',
            'edit_order_review' => 'Edit Order Review',
            'delete_order_review' => 'Delete Order Review',

            'view_tax' => 'View Tax',
            'add_tax' => 'Add Tax',
            'edit_tax' => 'Edit Tax',
            'delete_tax' => 'Delete Tax',

            'view_events' => 'View Events',
            'add_events' => 'Add Events',
            'edit_events' => 'Edit Events',
            'delete_events' => 'Delete Events',

            'view_blogs' => 'View Blogs',
            'add_blogs' => 'Add Blogs',
            'edit_blogs' => 'Edit Blogs',
            'delete_blogs' => 'Delete Blogs',

            'view_syetem_service' => 'View System Service',
            'add_syetem_service' => 'Add System Service',
            'edit_syetem_service' => 'Edit System Service',
            'delete_syetem_service' => 'Delete System Service',

            'view_pet' => 'View Pet',
            'add_pet' => 'Add Pet',
            'edit_pet' => 'Edit Pet',
            'delete_pet' => 'Delete Pet',

            'view_pet_type' => 'View Pet Type',
            'add_pet_type' => 'Add Pet Type',
            'edit_pet_type' => 'Edit Pet Type',
            'delete_pet_type' => 'Delete Pet Type',

            'view_breed' => 'View Breed',
            'add_breed' => 'Add Breed',
            'edit_breed' => 'Edit Breed',
            'delete_breed' => 'Delete Breed',

            'view_reports' => 'View Reports',
            'add_reports' => 'Add Reports',
            'edit_reports' => 'Edit Reports',
            'delete_reports' => 'Delete Reports',

            'view_daily_bookings' => 'View Daily Booking',
            'add_daily_bookings' => 'Add Daily Booking',
            'edit_daily_bookings' => 'Edit Daily Booking',
            'delete_daily_bookings' => 'Delete Daily Booking',

            'view_overall_bookings' => 'View Daily Booking',
            'add_overall_bookings' => 'Add Overall Booking',
            'edit_overall_bookings' => 'Edit Overall Booking',
            'delete_overall_bookings' => 'Delete Overall Booking',

            'view_order_reports' => 'View Oreder Reports',
            'add_order_reports' => 'Add Oreder Reports',
            'edit_order_reports' => 'Edit Oreder Reports',
            'delete_order_reports' => 'Delete Oreder Reports',



            'view_page' => 'View Pages',
            'add_page' => 'Add Page',
            'edit_page' => 'Edit Page',
            'delete_page' => 'Delete Page',


            'view_setting' => 'View Setting',
            'add_setting' => 'Add Setting',
            'edit_setting' => 'Edit Setting',
            'delete_setting' => 'Delete Setting',

            'view_notification' => 'View Notification',
            'add_notification' => 'Add Notification',
            'edit_notification' => 'Edit Notification',
            'delete_notification' => 'Delete Notification',

            'view_notification_template' => 'View Notification Template',
            'add_notification_template' => 'Add Notification Template',
            'edit_notification_template' => 'Edit Notification Template',
            'delete_notification_template' => 'Delete Notification Template',

            'view_app_banner' => 'View App Banner',
            'add_app_banner' => 'Add App Banner',
            'edit_app_banner' => 'Edit App Banner',
            'delete_app_banner' => 'Delete App Banner',

            'view_constant' => 'View Constant',
            'add_constant' => 'Add Constant',
            'edit_constant' => 'Edit Constant',
            'delete_constant' => 'Delete Constant',

            'view_permission' => 'View Permission',
            'add_permission' => 'Add Permission',
            'edit_permission' => 'Edit Permission',
            'delete_permission' => 'Delete Permission',

            'view_modules' => 'View Modules',
            'add_modules' => 'Add Modules',
            'edit_modules' => 'Edit Modules',
            'delete_modules' => 'Delete Modules', 

            'view_product' => 'View Product',
            'add_product' => 'Add Product',
            'edit_product' => 'Edit Product',
            'delete_product' => 'Delete Product', 

            'view_product_category' => 'View Product Category',
            'add_product_category' => 'Add Product Category',
            'edit_product_category' => 'Edit Product Category',
            'delete_product_category' => 'Delete Product Category', 

            'view_product_subcategory' => 'View Product SubCategory',
            'add_product_subcategory' => 'Add Product SubCategory',
            'edit_product_subcategory' => 'Edit Product SubCategory',
            'delete_product_subcategory' => 'Delete Product SubCategory', 

            'view_brand' => 'View Brand',
            'add_brand' => 'Add Brand',
            'edit_brand' => 'Edit Brand',
            'delete_brand' => 'Delete Brand', 

            'view_unit' => 'View Unit',
            'add_unit' => 'Add Unit',
            'edit_unit' => 'Edit Unit',
            'delete_unit' => 'Delete Unit', 

            'view_tag' => 'View Tag',
            'add_tag' => 'Add Tag',
            'edit_tag' => 'Edit Tag',
            'delete_tag' => 'Delete Tag', 

            'view_product_variation' => 'View Product Variation',
            'add_product_variation' => 'Add Product Variation',
            'edit_product_variation' => 'Edit Product Variation',
            'delete_product_variation' => 'Delete Product Variation', 

            'view_order' => 'View Order',
            'add_order' => 'Add Order',
            'edit_order' => 'Edit Order',
            'delete_order' => 'Delete Order', 

            'view_supply' => 'View Supply',
            'add_supply' => 'Add Supply',
            'edit_supply' => 'Edit Supply',
            'delete_supply' => 'Delete Supply', 

            'view_logistics' => 'View Logistics',
            'add_logistics' => 'Add Logistics',
            'edit_logistics' => 'Edit Logistics',
            'delete_logistics' => 'Delete Logistics', 

            'view_shipping_zones' => 'View Shipping zones',
            'add_shipping_zones' => 'Add Shipping zones',
            'edit_shipping_zones' => 'Edit Shipping zones',
            'delete_shipping_zones' => 'Delete Shipping zones', 

            'view_location' => 'View Location',
            'add_location' => 'Add Location',
            'edit_location' => 'Edit Location',
            'delete_location' => 'Delete Location', 

            'view_city' => 'View City',
            'add_city' => 'Add City',
            'edit_city' => 'Edit City',
            'delete_city' => 'Delete City', 

            'view_state' => 'View State',
            'add_state' => 'Add State',
            'edit_state' => 'Edit State',
            'delete_state' => 'Delete State', 

            'view_country' => 'View Country',
            'add_country' => 'Add Country',
            'edit_country' => 'Edit Country',
            'delete_country' => 'Delete Country', 

        ];
    }

    /**
     * Name should be lowercase.
     *
     * @param  string  $value  Name value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }
}
