<?php

namespace App\Events;

use App\Events\Event;
use App\Task;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TaskUpdated extends Event
{
    use InteractsWithSockets, SerializesModels;
    public $task;
    /**
     * Create a new event instance.
     *
     * @param  Task  $task
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
        $this->dontBroadcastToCurrentUser();
    }
    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['private-teams.'.$this->task->team_id.'.tasks'];
    }
}
