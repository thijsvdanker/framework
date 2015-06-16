<?php namespace HynMe\Framework\Controllers;

use HynMe\Framework\Models\AbstractModel;
use HynMe\Framework\Validators\AbstractValidator;
use HynMe\MultiTenant\Validators\WebsiteValidator;
use View, Config;
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
     * Parses requests to the controller for interactions with models
     *
     * @param Request           $request
     * @param AbstractModel     $model
     * @param AbstractValidator $validation
     * @return $this|bool|AbstractModel|null
     */
    protected function catchFormRequest($closure, Request $request, AbstractModel $model, AbstractValidator $validation, $redirect = null)
    {
        // use abstract validator
        if($request->method() != 'GET' && $validation instanceof AbstractValidator) {
            switch($request->method())
            {

                case 'POST':
                case 'UPDATE':
                    $model = $model->exists ? $validation->updating($model, $request) : $validation->create($model,$request);
                    $action = 'save';
                    break;
                case 'DELETE':
                    $model = $validation->deleting($model, $request);
                    $action = 'delete';
                    break;
                default:
                    return $closure();
            }
            if ($model instanceof Validator) {
                return redirect()->back()->withErrors($model->errors())->withInput();
            }

            $model->{$action}();
            return $redirect ? $redirect : true;
        }
        else
            return $closure();
    }

    /**
     * Shows a confirmation page
     * @param AbstractModel $model
     * @param null|string   $view
     * @return View
     */
    protected function showConfirmMessage(Request $request, AbstractModel $model, $redirect, $view = null)
    {
        return $this->catchFormRequest(function() use ($view, $model)
        {
            return view($view ?: "management-interface::template.forms.confirm-delete", [
                'model' => $model
            ]);
        }, $request, $model, new WebsiteValidator, $redirect);


    }
}