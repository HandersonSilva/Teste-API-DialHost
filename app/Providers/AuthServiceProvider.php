<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
        //

        //setar validade do token
        Passport::tokensExpireIn(now()->addDays(15));
        //setar validade do refresh token
        Passport::refreshTokensExpireIn(now()->addDays(30));
        //definição de niveis de acesso
        Passport::tokensCan([
            'usuario' => 'Usuário comum',
            'administrador' => 'Administrador do sistema',
        ]);
    }
}
