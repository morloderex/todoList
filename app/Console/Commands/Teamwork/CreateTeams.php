<?php

namespace App\Console\Commands\Teamwork;

use App\Team;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateTeams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'teamwork:teams:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates the teams as defined in teams.php config file.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $teams = config('teams');
        
        if(is_null($teams))
        {
            throw new \RuntimeException("Forgot to define teams.php config file?");
        }

        foreach ($teams as $name => $team)
        {
            // If the team exists then do nothing and skip it.
            if (!Team::where('name', $name)->isEmpty())
            {
                continue;
            }

            $team['owner'] = $this->findUserBy($team['owner'])->id;

            $team = Team::create([
                'user_id'   =>  $team['owner'],
                'name'      =>  $name
            ]);

            // Attach the owner
            User::find($team['owner'])->first()->teams()->attach($team->getKey());

            if (isset($team['members']) && is_array($team['members']))
            {
                foreach ($team['members'] as $member) {

                    $user = $this->findUserBy($member);

                    // Attach the member to the team.
                    $user->teams()->attach($team->getKey());
                }
            }
        }
    }

    /**
     * Finds a User by the given identifier or fails.
     *
     * @param $identifier
     * @throws ModelNotFoundException
     * @return User
     */
    protected function findUserBy($identifier) : User
    {
        if (!is_numeric($identifier) && !is_int($identifier))
        {
            if (filter_var($identifier, FILTER_VALIDATE_EMAIL))
            {
                $user = User::where('email', $identifier)->firstOrFail();
            } else {
                $user = User::where('name', $identifier)->firstOrFail();
            }
        } else {
            $user = User::firstOrFail($identifier);
        }

        return $user;
    }
}
