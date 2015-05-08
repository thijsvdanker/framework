<?php namespace HynMe\Framework\Controllers;

use HynMe\Framework\Models\AbstractModel;
use HynMe\Framework\Validators\AbstractValidator;
use View;
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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

    /**
     * @param Request           $request
     * @param AbstractModel     $model
     * @param AbstractValidator $validation
     * @return $this|bool|AbstractModel|null
     */
    protected function catchFormRequest($closure, Request $request, AbstractModel $model, AbstractValidator $validation)
    {
        // use abstract validator
        if($request->method() != 'GET' && $validation instanceof AbstractValidator)
        {
            $model = $model->exists ? $validation->updating($model, $request) : $validation->create($model, $request);
            if($model instanceof Validator)
                return redirect()->back()->withErrors($model->errors())->withInput();

            $model->save();

            return $model;
        }

        return $closure();
    }
}