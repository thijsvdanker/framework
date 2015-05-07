<?php namespace HynMe\Framework\Repositories;

use HynMe\Framework\Models\AbstractModel;

abstract class BaseRepository
{
    public function __construct()
    {
        $args = func_get_args();
        foreach($args as $argument)
        {
            if($argument instanceof AbstractModel)
            {
                $className = $argument->easyClassName;
                $this->{$className} = $argument;
            }
        }
    }

    /**
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function newInstance($type)
    {
        return $this->{$type}->newInstance();
    }
}