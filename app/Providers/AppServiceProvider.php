<?php

namespace App\Providers;

use App\Helpers\MenuHelper;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\company_info;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        app()->bind('GetDateFormat',function(){
            return new \App\Facades\GetOriginalDate;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $menus = MenuHelper::Menu();

        if (!empty($menus)){
            View::composer('*', function ($view) use ($menus) {
                $view->with(['side_menus' => $menus]);
            });
        }

        View::composer('*',function($view){
            $view->with('website_info',company_info::where('id',1)->first());
        });

        Paginator::useBootstrapFive();
    }
}
