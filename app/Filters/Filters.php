<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters {

    /**
     * Request, QueryBuilder.
     *
     * @var $builder
     * @var Request
     */
    protected $request, $builder;

    /**
     * Array of filters.
     *
     * @var array
     */
    protected $filters = [];

    /**
     * Filters constructor.
     *
     * Filters constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply the request filter.
     *
     * @param $builder
     * @return mixed
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value)
        {
            if (method_exists($this, $filter))
            {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    /**
     * getting the url wanted filtration.
     *
     * @return array
     */
    protected function getFilters()
    {
        // intersect here give you the filter only if it is exists, opposite of only
        return $this->request->intersect($this->filters);
    }

}
