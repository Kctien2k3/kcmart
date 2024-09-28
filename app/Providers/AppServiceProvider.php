<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Cart; // Đảm bảo đã import lớp Cart
use App\Models\Page; // Đảm bảo đã import lớp Page


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // khai báo dữ liệu toàn cục -> tất cả view đều nhận
        view()->composer('*', function ($view) {
            $cart = new Cart();
            $page = new Page();
            $view->with(compact('cart', 'page'));
        });
    }


}
Paginator::useBootstrap();