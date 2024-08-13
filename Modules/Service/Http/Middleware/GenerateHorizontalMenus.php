<?php

namespace Modules\Service\Http\Middleware;

use App\Trait\HorizontalMenu;
use Closure;
use Illuminate\Http\Request;

class GenerateHorizontalMenus
{
    use HorizontalMenu;

    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        //     \Menu::make('horizontal_menu', function ($menu) {

        //         $company = $this->createCompanyMenu($menu);

        //         // Service
        //         $service = $this->parentMenu($company, [
        //             'title' => 'Services',
        //             'nickname' => 'service',
        //             'order' => 240,
        //         ]);

        //         $this->childMain($service, [
        //             'title' => 'Category',
        //             'route' => 'backend.categories.index',
        //             'active' => ['app/categories'],
        //             'order' => 140,
        //         ]);

        //         $this->childMain($service, [
        //             'title' => 'Sub-Category',
        //             'route' => 'backend.categories.index_nested',
        //             'active' => ['app/sub-categories'],
        //             'order' => 140,
        //         ]);

        //         $this->childMain($service, [
        //             'title' => 'Service List',
        //             'route' => 'backend.services.index',
        //             'active' => 'app/services',
        //             'order' => 140,
        //         ]);
        //         $this->childMain($service, [
        //             'title' => 'Service Package',
        //             'route' => 'backend.service.servicepackage.index',
        //             'active' => 'app/service/servicepackage',
        //             'order' => 140,
        //         ]);

        //     });

        //     return $next($request);
    }
}
