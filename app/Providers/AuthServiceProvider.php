<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Carbon\Carbon;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        // User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('superAdmin', function($user){
        //     return $user->isSuperAdmin();
        // });

        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addHours(24));   // 访问令牌有效期，1小时
        Passport::refreshTokensExpireIn(Carbon::now()->addHours(24));    // 刷新令牌 有效期，24小时
    }
}
