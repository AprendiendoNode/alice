<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        /*Gate::define('viewLarecipe', function($user, $documentation) {
            return in_array($user->email, [
                'jcanul@sitwifi.com', //Solo los usuarios en el array tienen acceso a la documentación
                'jsierra@sitwifi.com',
                'jesquinca@sitwifi.com',
                'acauich@sitwifi.com',
                'rkuman@sitwifi.com',
                'cleon@sitwifi.com',
            ]);
        });*/
    //Permisos granulares.
    /*Gate::define('viewLarecipe', function($user, $documentation) {
    if($user->email == 'jcanul@sitwifi.com')//Si es este usuario
    {
        if($documentation->title == 'Bienvenido/a') {//y si accede solo a esta pagina la puede ver
            return true;
        }

        return false;//Si es otra pagina, no tendra acceso
    }

    return true;
});*/
        //
        Passport::routes();

        //Passport::tokensExpireIn(now()->addDays(15));

        //Passport::refreshTokensExpireIn(now()->addDays(30));

        //Passport::personalAccessTokensExpireIn(now()->addMonths(6));

    }
}
