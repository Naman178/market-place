<?php

namespace App\Providers;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        View::composer('*', function ($view) {
            $categories = Category::where('sys_state', '0')->with(['subcategories', 'items.item.pricing', 'items.subcategory'])->orderBy('id', 'desc')->get();
            $ipAddress = request()->ip();
            // $ipAddress = '103.206.136.170';
            // $ipAddress = '8.8.8.8';
            try {
                $response = Http::get("http://ip-api.com/json/{$ipAddress}");
                $locationData = $response->json();

                $country = $locationData['country'] ?? 'Unknown';
                $city = $locationData['city'] ?? 'Unknown';
            } catch (\Exception $e) {
                $country = 'Unknown';
                $city = 'Unknown';
            }
            $view->with([
                'headerCategories' => $categories,
                'country' => $country,
                'userCity' => $city,
                'ipAddress' => $ipAddress,
            ]);
        });
    }
}
