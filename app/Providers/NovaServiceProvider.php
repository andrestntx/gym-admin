<?php

namespace App\Providers;

use App\Balance;
use App\Client;
use App\Membership;
use App\MembershipDetail;
use App\Observers\BalanceObserver;
use App\Observers\ClientObserver;
use App\Observers\MembershipDetailObserver;
use App\Observers\MembershipObserver;
use App\Observers\SellObserver;
use App\Sell;
use Laravel\Nova\Nova;
use Laravel\Nova\Cards\Help;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //Nova::serving(function () {
        Sell::observe(SellObserver::class);
        Client::observe(ClientObserver::class);
        Membership::observe(MembershipObserver::class);
        MembershipDetail::observe(MembershipDetailObserver::class);
        Balance::observe(BalanceObserver::class);
        //});
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                'andresmaopinzon@gmail.com',
                'emerson@gimnasiobodypeople.com',
                'mariano@gimnasiobodypeople.com',
                'leidy@gimnasiobodypeople.com',
                'maria@gimnasiobodypeople.com',
                'julian@gimnasiobodypeople.com',
                'luisa@gimnasiobodypeople.com'
            ]);
        });
    }

    /**
     * Get the cards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            new Help,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
