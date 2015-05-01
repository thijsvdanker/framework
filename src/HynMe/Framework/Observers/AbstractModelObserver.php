<?php namespace HynMe\Framework\Observers;

class AbstractModelObserver
{
    public function creating($model)
    {
        if(env('HYN_READ_ONLY', false))
            return false;
    }
    public function saving($model)
    {
        if(env('HYN_READ_ONLY', false))
            return false;
    }
    public function deleting($model)
    {
        if(env('HYN_READ_ONLY', false))
            return false;
    }
}