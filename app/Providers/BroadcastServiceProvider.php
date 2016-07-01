<?php

namespace App\Providers;

use App\Task;
use App\User;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::route(['middleware' => ['web']]);
        /**
         * Authenticate the team task list channel.
         */
        Broadcast::auth('teams.*.tasks', function (User $user, int $teamId) {
            return ! is_null($user->teams->find($teamId));
        });
        /**
         * Authenticate the task channel.
         */
        Broadcast::auth('task.*', function (User $user, int $taskId) {
            $task = Task::find($taskId);
            if ($task && $user->onTeam($task->team)) {
                return ['id' => $user->id, 'name' => $user->name, 'avatar' => $user->avatar_url];
            }
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
