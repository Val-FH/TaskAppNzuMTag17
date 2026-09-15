<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Task;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;

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
    {     //regeln aufsetzten wer was sehen darf
        // Gate::define('view-admin', function(User $user){return true;}
        //return $user->id === 1; hieße nur der user mit der id 1 darf das sehen

        //zugangsberechtigung für die autorisierten bereiche
        Gate::define('task-view',function(User $user, Task $task){
        // return $user->id === $task->user_id? Response::allow() : Response::denyAsNotFound();        
        //return Response::denyAsNotFound;
        return true; 
        });

        Gate::define('view-admin', function(User $user ){
            if($user->id === 4){
                return Response::allow();
            }
        return Response::denyAsNotFound();
        });
    }
}
