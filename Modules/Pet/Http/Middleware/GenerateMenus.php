<?php

namespace Modules\Pet\Http\Middleware;

use Closure;
use App\Trait\Menu;

class GenerateMenus
{
    use Menu;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*
         *
         * Module Menu for Admin Backend
         *
         * *********************************************************************
         */
        \Menu::make('menu', function ($menu) {
            // Pets
            // $this->childMain($menu, [
            //     'icon' => '<i class="nav-icon fa-regular fa-sun"></i>',
            //     'title' => 'Staff',
            //     'route' => ['backend.pets.index'],
            //     'active' => 'app/pets*',
            //     'order' => 250,
            // ]);
        })->sortBy('order');

        return $next($request);
    }
}
