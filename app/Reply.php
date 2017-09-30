<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model {

    /**
     * Guard fields.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * A Relationship with user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        // The second parameter is the foreign key
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Polymorphic relation with favorites
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    /**
     * attach to favorite relationship.
     *
     * @return Model
     */
    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];
        if (! $this->favorites()->where($attributes)->exists())
        {
            return $this->favorites()->create($attributes);
        }
    }

    /**
     * Check is favorite or not.
     *
     * @return bool
     */
    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->exists();
    }

}