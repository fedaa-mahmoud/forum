<?php

namespace App\Filters;

use App\Filters\Filters;
use App\User;
use Illuminate\Http\Request;

class ThreadFilters extends Filters {

    /**
     * Filters
     * @var array
     */
    protected $filters = ['by', 'popular'];

    /**
     * Filter the query by a given username.
     * @param $username
     * @return mixed
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter the query according to most popular threads.
     * @return mixed
     */
    public function popular()
    {
        // remove the default order by which is [desc]
        $this->builder->getQuery()->orders = [];

        return $this->builder->orderBy('replies_count', 'desc');
    }

}