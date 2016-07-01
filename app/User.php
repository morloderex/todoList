<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mpociot\Teamwork\Traits\UserHasTeams;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use SoftDeletes, EntrustUserTrait, UserHasTeams;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'oauth_token', 'avatar_url'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Checks whether a user is a member of a given team or not.
     * 
     * @param mixed $team
     * @return bool
     */
    public function onTeam($team) : bool
    {
        switch (gettype($team))
        {
            // Assume team name
            case 'string':
                $team = Team::where('name', $team)->firstOrFail();
                break;
            
            case 'integer':
                $team = Team::firstOrfail($team);
                break;
            
            case 'object' && $team instanceof Team:
                // Do nothing.
                break;
        }
        
        return $team->hasUser($this);
    }
}

