<?php

namespace App\Http\Controllers\API;

use App\Events\TaskUpdated;
use App\Team;
use App\Task;
use App\Http\Requests;
use App\Events\TaskCreated;
use App\Events\TaskDeleted;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * Get all of the tasks assigned to the team.
     *
     * @param  Request  $request
     * @param  Team  $team
     * @return Response
     */
    public function all(Request $request, Team $team)
    {
        abort_unless($request->user()->onTeam($team), 403);
        return $team->tasks()->with('creator')->get();
    }
    
    /**
     * show the task details
     *
     * @param  Request  $request
     * @param  Team  $team
     * @param  Task  $task
     * @return Response
     */
    public function show(Request $request, Team $team, Task $task)
    {
        abort_unless($request->user()->onTeam($team), 403);
        abort_unless($team->id === $task->team->id, 403);
        
        return $task->load('creator', 'photos', 'information', 'comments', 'tags');
    }
    
    /**
     * Create a new task for the team.
     *
     * @param  Request  $request
     * @param  Team  $team
     * @return Response
     */
    public function store(Request $request, Team $team)
    {
        $user = $request->user();
        
        abort_unless($user->onTeam($team), 403);
        $this->authorizeForUser($user, 'store-task');
        
        $task = $team->tasks()->create([
            'user_id' => $user->id,
            'name' => $request->name,
        ]);
        
        event(new TaskCreated($task));
        return $task;
    }

    /**
     * Create a new task for the team.
     *
     * @param  Request  $request
     * @param  Team  $team
     * @param  Task  $task
     * @return Response
     */
    public function update(Request $request, Team $team, Task $task)
    {
        $user = $request->user();

        abort_unless($team->id === $task->team->id, 403);
        abort_unless($user->onTeam($team), 403);
        $this->authorizeForUser($user, 'update-task', $task);
        
        $task->update(
            $request->only(
                $task->getFillable()
            )
        );
        
        event(new TaskUpdated($task));
        return $task;
    }


    /**
     * Delete the given task.
     *
     * @param  Request  $request
     * @param  Team  $team
     * @param  Team  $Task
     * @return Response
     */
    public function destroy(Request $request, Team $team, Task $task)
    {
        $user = $request->user();

        abort_unless($team->id === $task->team->id, 403);
        abort_unless($user->onTeam($team), 403);
        $this->authorizeForUser($user, 'store-task');

        event(new TaskDeleted($team->id, $task->id));
        $task->delete();
    }
}