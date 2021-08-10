<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\RoleMstRepository::class, \App\Repositories\RoleMstRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CoinExchangeMstRepository::class, \App\Repositories\CoinExchangeMstRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\WithdrawMstRepository::class, \App\Repositories\WithdrawMstRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PackagePriceMstRepository::class, \App\Repositories\PackagePriceMstRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ActionTypeMstRepository::class, \App\Repositories\ActionTypeMstRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\NotificationMstRepository::class, \App\Repositories\NotificationMstRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UserMstRepository::class, \App\Repositories\UserMstRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PaymentDtlMstRepository::class, \App\Repositories\PaymentDtlMstRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PaymentDtlRepository::class, \App\Repositories\PaymentDtlRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\VideoCallDtlRepository::class, \App\Repositories\VideoCallDtlRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MessageDtlRepository::class, \App\Repositories\MessageDtlRepositoryEloquent::class);
        //:end-bindings:
    }
}
