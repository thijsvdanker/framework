<?php namespace HynMe\Framework\Controllers;

use View;
use App\Http\Controllers\Controller;

abstract class AbstractController extends Controller
{
    /**
     * Sets a variable into the views
     * @param $key
     * @param $value
     */
    protected function setViewVariable($key, $value)
    {
        View::share($key, $value);
    }
}