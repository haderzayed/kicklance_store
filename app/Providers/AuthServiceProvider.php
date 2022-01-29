<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

      /*  Gate::before(function($user ,$ability){
            if($user->type == 'super_admin'){
                return true ;
            }
        });*/
        foreach(config('permissions') as $code =>$label){
            Gate::define($code,function ($user) use($code){
                return $user->role->permissions()->where('permission',$code)->exists();
            });
        }


    }
}
