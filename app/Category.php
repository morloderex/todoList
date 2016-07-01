<?php

namespace App;

use App\Traits\Model\hasInformation;
use App\Traits\Model\isTaggable;
use App\Scopes\Traits\scopePopular;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Traits\Model\Forgetable,
    Watson\Rememberable\Rememberable;

/**
 * Class Category
 * @package App
 */
class Category extends Model
{
    use hasInformation,
        Rememberable,
        Forgetable,
        scopePopular,
        isTaggable;

    /**
     * Remember all queries forever by default.
     *
     * @var string
     */
    #protected $rememberFor = '-1';

    /**
     * @inheritdoc
     */
    #protected $with = ['user', 'tags'];

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
    ];

    /**
     * @inheritdoc
     */
    protected $casts = [
        'user_id'       =>  'object',
        'visits'        =>  'integer',
        'name'          =>  'string',
        'description'   =>  'string'
    ];

    public function __construct(array $attributes = [])
    {
        $this->setPopularAttribute('visits');
        parent::__construct($attributes);
    }

    /**
     * @return User
     */
    public function user() : User
    {
        return $this->belongsTo(User::class)->firstOrFail();
    }

    /**
     * Polymorphic relationship
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function categorize()
    {
        return $this->morphTo();
    }

    public function scopeLatestChangelog($query, int $take = 10)
    {
        return $query->with(['posts', 'tags'])
            ->where('name', '=', 'changelog')
            ->orderBy('updated_at', 'DESC')
            ->take($take)
            ->get();
    }
}