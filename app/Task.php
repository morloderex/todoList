<?php

namespace App;

use App\Traits\Model\Forgetable;
use App\Traits\Model\hasInformation;
use App\Traits\Model\hasPhotos;
use App\Traits\Model\isCommentable;
use App\Traits\Model\isTaggable;
use App\Traits\Model\RecordsActivity;
use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class Task extends Model
{
    use Rememberable, Forgetable, RecordsActivity,
        hasInformation, hasPhotos, isCommentable, isTaggable;
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    /**
     * Get the team that the task belongs to.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    /**
     * Get the user that created the task.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
