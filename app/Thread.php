<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model {

    /**
     * Guard fields
     * @var array
     */
    protected $guarded = [];

    /**
     * Booting class
     */
    protected static function boot()
    {
        parent::boot();
        // return the replies count fore each record
        static::addGlobalScope('replyCount', function ($builder) {
           return  $builder->withCount('replies');
        });
    }

    /**
     * Path of the thread
     * @return string
     */
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    /**
     * Relationship of replies
     * @return mixed
     */
    public function replies()
    {
        return $this->hasMany(Reply::class)
            ->withCount('favorites');
    }

    /**
     * Relationship with the owner
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship with channel
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * Adding reply
     * @param $reply
     */
    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }

    /**
     * Begin the process of the filtration
     *
     * @param $query
     * @param $filters
     * @return mixed
     */
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
