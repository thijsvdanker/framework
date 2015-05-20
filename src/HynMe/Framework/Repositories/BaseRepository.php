<?php namespace HynMe\Framework\Repositories;

use HynMe\Framework\Models\AbstractModel;
use Input;

abstract class BaseRepository
{

    /**
     * @var AbstractModel
     */
    protected $model;

    public function __construct()
    {
        $args = func_get_args();
        foreach($args as $i => $argument)
        {
            if($argument instanceof AbstractModel)
            {
                $className = $argument->easyClassName;
                $this->{$className} = $argument;
                if($i == 0)
                    $this->model = $argument;
            }
        }
    }

    /**
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function newInstance($type=null)
    {
        if(is_null($type))
            return $this->model->newInstance();

        return $this->{$type}->newInstance();
    }

    /**
     * Starts a querybuilder
     * @param $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function queryBuilder($type=null)
    {
        if(is_null($type))
            return $this->model->query();

        return $this->{$type}->query();
    }

    /**
     * Query results for ajax
     * @param      $name
     * @param null $type
     * @param Closure|null $additionalWhere
     * @return mixed
     */
    public function ajaxQuery($name, $type = null, $additionalWhere = null)
    {
        $query = $this->queryBuilder($type);

        $search = (string) Input::get('query');

        // modifies query builder with additional where
        if(!is_null($additionalWhere))
            $query = $additionalWhere($query, $search);

        $items = $query->where($name, 'like', "%{$search}%")->orderBy($name)->take(10)->lists($name, 'id');

        $results = [];

        foreach($items as $id => $text)
            $results[] = compact('id','text');

        return $results;
        array_walk($items, function(&$item, $key)
        {
            $item = [
                'id' => $key,
                'text' => $item
            ];
        });
        return $items;
    }

    /**
     * Finds an object by Id
     * @param int $id
     * @param bool $softDeleted
     * @return \Illuminate\Support\Collection|null|void|static
     */
    public function findById($id, $softDeleted = true)
    {
        if($softDeleted && method_exists($this->model, 'withTrashed'))
            return $this->model->withTrashed()->find($id);
        return $this->model->find($id);
    }
}