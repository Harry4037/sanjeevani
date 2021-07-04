<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\AuthorityMenuMapping;
use App\Models\MenuStructure;
use App\Models\UserBookingDetail;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        view()->composer('*', function($view) {
            if (Auth::guard("subadmin")->check()) {
                $allowedMenu = AuthorityMenuMapping::where("user_id", Auth::guard("subadmin")->user()->id)->pluck("menu_id")->toArray();
                $menus = MenuStructure::whereIn("id", $allowedMenu)->get();
                $userResort = UserBookingDetail::where("user_id", Auth::guard("subadmin")->user()->id)->first();
                $view->with(['allowed_menus'=> $menus, "user_resort" => $userResort]);
            } else {
                $view->with(['allowed_menus'=> null, "user_resort" => null]);
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
