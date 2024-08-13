<?php

namespace App\Http\Middleware;

use App\Trait\HorizontalMenu;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GenerateHorizontalMenus
{
    use HorizontalMenu;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        \Menu::make('horizontal_menu', function ($menu) {

            // MAIN
            $main = $this->parentMenu($menu, [
                'icon' => '',
                'title' => 'MAIN',
                'nickname' => 'main',
                'order' => 200,
            ]);

            // Main -Child
            $this->childMain($main, [
                'title' => 'Dashboard',
                'route' => 'backend.home',
                'active' => ['app', 'app/dashboard'],
                'order' => 10,
            ]);

          

            // COMPANY
            $company = $this->parentMenu($menu, [
                'icon' => '',
                'title' => 'COMPANY',
                'nickname' => 'company',
                'order' => 210,
            ]);

            // Company -Child
            $this->childMain($company, [
                'title' => 'Pet Center',
                'route' => 'backend.branch.index',
                'active' => 'app/branch',
                'permission' => 'view_branch',
                'order' => 10,
            ]);

            // Bookings
            $this->mainRoute($company, [
                'title' => 'Bookings',
                'route' => 'backend.bookings.datatable_view',
                'active' => ['app/bookings-table-view'],
                'permission' => 'tableview_booking',
                'order' => 20,
            ]);

            // Service
            $service = $this->parentMenu($company, [
                'title' => 'Services',
                'nickname' => 'service',
                'permission' => 'view_service',
                'order' => 230,
            ]);

            // Service -Child
            $this->childMain($service, [
                'title' => 'Category',
                'route' => 'backend.categories.index',
                'active' => ['app/categories'],
                'permission' => 'view_categories',
                'order' => 140,
            ]);

            $this->childMain($service, [
                'title' => 'Sub-Category',
                'route' => 'backend.categories.index_nested',
                'active' => ['app/sub-categories'],
                'permission' => 'view_subcategories',
                'order' => 140,
            ]);

            $this->childMain($service, [
                'title' => 'Service List',
                'route' => 'backend.services.index',
                'active' => 'app/services',
                'permission' => 'view_service_list',
                'order' => 140,
            ]);
            $this->childMain($service, [
                'title' => 'Service Package',
                'route' => 'backend.service.servicepackage.index',
                'active' => 'app/service/servicepackage',
                'permission' => 'view_service_package',
                'order' => 140,
            ]);

            // Subscriptions
            // $Plan = $this->parentMenu($company, [
            //     'title' => 'Subscriptions',
            //     'nickname' => 'subscriptions',
            //     'order' => 240,
            // ]);

            // $this->childMain($Plan, [
            //     'title' => 'Subscription List',
            //     'route' => 'backend.subscriptions.index',
            //     'active' => 'app/subscriptions',

            // ]);

            // //  Sub- Subscriptions -Child
            // $this->childMain($Plan, [
            //     'title' => 'Plan List',
            //     'route' => 'backend.subscription.plans.index',
            //     'active' => 'app/subscriptions/plans',
            // ]);

            // $this->childMain($Plan, [
            //     'title' => 'Plan Limitation',
            //     'route' => 'backend.subscription.planlimitation.index',
            //     'active' => 'app/subscriptions/planlimitation',
            // ]);

            // USERS
            $users = $this->parentMenu($menu, [
                'icon' => '',
                'title' => 'USERS',
                'nickname' => 'user',
                'order' => 230,
            ]);


            $this->childMain($users, [
                'title' => 'Employee',
                'route' => ['backend.employees.index'],
                'active' => ['app/employees'],
                'permission' => 'view_staff',
                'order' => 10,
            ]);

         
            $this->childMain($users, [
                'title' => 'Customers',
                'route' => ['backend.customers.index'],
                'active' => 'app/customers',
                'permission' => 'view_customer',
                'order' => 20,
            ]);

            $this->childMain($users, [
                'title' => 'Reviews',
                'route' => ['backend.employees.review'],
                'active' => ['app/employees'],
                'permission' => 'view_customer_reviews',
                'order' => 30,
            ]);

            // FINANCE
            $finance = $this->parentMenu($menu, [
                'icon' => '',
                'title' => 'FINANCE',
                'nickname' => 'finance',
                'order' => 240,
            ]);

            $this->childMain($finance, [
                'title' => 'Taxes',
                'route' => 'backend.tax.index',
                'active' => ['app/tax'],
                'permission' => 'view_tax',
                'order' => 10,
            ]);

            $this->mainRoute($finance, [
                'title' => 'Employee Earnings',
                'route' => 'backend.earnings.index',
                'active' => ['app/earnings'],
                'order' => 20,
            ]);

            // REPORTS
            $reports = $this->parentMenu($menu, [
                'icon' => '',
                'title' => 'REPORTS',
                'nickname' => 'reports',
                'order' => 250,
            ]);

            $this->mainRoute($reports, [
                'title' => 'Daily Bookings',
                'route' => 'backend.reports.daily-booking-report',
                'active' => ['app/daily-booking-report'],
                'order' => 0,
            ]);

            $this->mainRoute($reports, [
                'title' => 'Overall Bookings',
                'route' => 'backend.reports.overall-booking-report',
                'active' => ['app/overall-booking-report'],
                'order' => 0,
            ]);

            $this->mainRoute($reports, [
                'title' => 'Payouts',
                'route' => 'backend.reports.payout-report',
                'active' => ['app/payout-report'],
                'order' => 0,
            ]);

            $this->mainRoute($reports, [
                'title' => 'Employee',
                'route' => 'backend.reports.staff-report',
                'active' => ['app/staff-report'],
                'order' => 0,
            ]);

            // SYSTEM

            $sys = $this->parentMenu($menu, [
                'icon' => '<svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.0122 14.8299C10.4077 14.8299 9.10986 13.5799 9.10986 12.0099C9.10986 10.4399 10.4077 9.17993 12.0122 9.17993C13.6167 9.17993 14.8839 10.4399 14.8839 12.0099C14.8839 13.5799 13.6167 14.8299 12.0122 14.8299Z" fill="currentColor"></path><path opacity="0.4" d="M21.2301 14.37C21.036 14.07 20.76 13.77 20.4023 13.58C20.1162 13.44 19.9322 13.21 19.7687 12.94C19.2475 12.08 19.5541 10.95 20.4228 10.44C21.4447 9.87 21.7718 8.6 21.179 7.61L20.4943 6.43C19.9118 5.44 18.6344 5.09 17.6226 5.67C16.7233 6.15 15.5685 5.83 15.0473 4.98C14.8838 4.7 14.7918 4.4 14.8122 4.1C14.8429 3.71 14.7203 3.34 14.5363 3.04C14.1582 2.42 13.4735 2 12.7172 2H11.2763C10.5302 2.02 9.84553 2.42 9.4674 3.04C9.27323 3.34 9.16081 3.71 9.18125 4.1C9.20169 4.4 9.10972 4.7 8.9462 4.98C8.425 5.83 7.27019 6.15 6.38109 5.67C5.35913 5.09 4.09191 5.44 3.49917 6.43L2.81446 7.61C2.23194 8.6 2.55897 9.87 3.57071 10.44C4.43937 10.95 4.74596 12.08 4.23498 12.94C4.06125 13.21 3.87729 13.44 3.59115 13.58C3.24368 13.77 2.93709 14.07 2.77358 14.37C2.39546 14.99 2.4159 15.77 2.79402 16.42L3.49917 17.62C3.87729 18.26 4.58245 18.66 5.31825 18.66C5.66572 18.66 6.0745 18.56 6.40153 18.36C6.65702 18.19 6.96361 18.13 7.30085 18.13C8.31259 18.13 9.16081 18.96 9.18125 19.95C9.18125 21.1 10.1215 22 11.3069 22H12.6968C13.872 22 14.8122 21.1 14.8122 19.95C14.8429 18.96 15.6911 18.13 16.7029 18.13C17.0299 18.13 17.3365 18.19 17.6022 18.36C17.9292 18.56 18.3278 18.66 18.6855 18.66C19.411 18.66 20.1162 18.26 20.4943 17.62L21.2097 16.42C21.5776 15.75 21.6083 14.99 21.2301 14.37Z" fill="currentColor"></path></svg>',
                'title' => 'SYSTEM',
                'nickname' => 'system',
                'order' => 260,
            ]);

            $this->childMain($sys, [
                'title' => 'Settings',
                'route' => 'backend.settings',
                'active' => 'app/settings',
                'order' => 10,
            ]);

            $this->childMain($sys, [
                'title' => 'Pages',
                'route' => ['backend.pages.index'],
                'active' => 'app/pages',
                'permission' => 'view_page',
                'order' => 20,
            ]);

            $notification = $this->parentMenu($sys, [
                'title' => 'Notifications',
                'nickname' => 'system',
                'order' => 30,
            ]);

            $this->childMain($notification, [
                'title' => 'List',
                'route' => 'backend.notifications.index',
                'active' => 'app/notifications',
                'permission' => 'view_notification_list',
            ]);

            $this->childMain($notification, [
                'title' => 'Templates',
                'route' => 'backend.notification-templates.index',
                'active' => 'app/notification-templates*',
                'permission' => 'view_notification_template',
            ]);

            $this->childMain($sys, [
                'title' => 'App Banner',
                'route' => 'backend.app-banners.index',
                'active' => 'app/app-banners',
                'permission' => 'view_app_banner',
                'order' => 40,
            ]);

            // $access = $this->parentMenu($sys, [
            //   'title' => 'Access Control',
            //   'nickname' => 'access',
            //   'order' => 50,
            // ]);

            // Sub-Access Control -child
            // $this->childMain($access, [
            //   'title' => 'Users',
            //   'route' => 'backend.users.index',
            //   'active' => 'app/users',
            // ]);

            

            $this->childMain($sys, [
                'title' => 'Modules',
                'route' => 'backend.permission-role.list',
                'active' => 'permission-role',
                'order' => 50,
            ]);

            $this->childMain($sys, [
                'title' => 'Modules',
                'route' => 'backend.module.index',
                'active' => 'module',
                'order' => 60,
            ]);

            

            // $this->childMain($sys, [
            //     'title' => 'Constants',
            //     'route' => 'backend.constants.index',
            //     'active' => ['app/constants*'],
            //     'order' => 60,
            // ]);

            // // BACKUP
            // $this->childMain($sys, [
            //     'title' => 'Backups',
            //     'route' => 'backend.backups.index',
            //     'active' => 'app/backups',
            //     'order' => 70,
            // ]);

            // // LOG VIEWER UNDER SYSTEM
            // $log = $this->parentMenu($sys, [
            //     'title' => 'Log Viewer',
            //     'nickname' => 'logviewer',
            //     'order' => 80,
            // ]);

            // // Sub-Log Viewer -Child
            // $this->childMain($log, [
            //     'title' => 'Dashboard',
            //     'route' => 'log-viewer::dashboard',
            //     'active' => 'app/log-viewer',
            // ]);
            // $this->childMain($log, [
            //     'title' => 'Logs By Days',
            //     'route' => 'log-viewer::logs.list',
            //     'active' => 'app/log-viewer/logs',
            // ]);

            // Access Permission Check
            $menu->filter(function ($item) {
                if ($item->data('permission')) {
                    if (auth()->check()) {
                        if (auth()->user()->hasAnyPermission($item->data('permission')) || auth()->user()->hasRole('admin')) {
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
                            if ($item->hasParent()) {
                                $item->parent()->active();
                            }
                        }
                    }
                }

                return true;
            });
        })->sortBy('order');

        return $next($request);
    }
}
