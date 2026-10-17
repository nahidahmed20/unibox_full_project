<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // if (env('APP_ENV') === 'production') {
        //     URL::forceScheme('https');
        // }
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        View::composer('frontend.partials.header', function ($view) {
            $categories = $view->getData()['categories'] ?? Category::where('status', 1)->whereNull('parent_id')->with('children.children')->orderBy('name')->get();
            $view->with('categories', $categories);
            $cart = session('cart', []);
            $view->with('cartCount', count($cart));
        });

    }
}

