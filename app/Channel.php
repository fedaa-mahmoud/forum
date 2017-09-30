<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{

    /**
     * setting the route name key.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Threads relationships.
     *
     * @return mixed
     */
    public function threads()
    {
        return $this->hasMany('App\Thread');
    }
}
