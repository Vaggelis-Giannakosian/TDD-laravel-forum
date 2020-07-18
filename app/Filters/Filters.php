<?php


namespace App\Filters;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class  Filters
{

    /**
     * @var Request
     */
    protected $request, $builder;
    protected $filters = [];


    public function __construct(Request $request)
    {

        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        collect($this->getFilters())
            ->filter(fn($value,$filter)=>method_exists($this,$filter))
            ->each(fn($value,$filter)=>$this->$filter($value));

//        foreach ($this->getFilters() as $filter => $value) {
//            if(method_exists($this, $filter)){
//                $this->$filter($value);
//            }
//        }

        return $builder;
    }


    /**
     * @return array
     */
    protected function getFilters(): array
    {
        return $this->request->only($this->filters);
    }

}
