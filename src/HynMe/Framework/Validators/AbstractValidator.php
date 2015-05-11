<?php namespace HynMe\Framework\Validators;

use Validator;
use HynMe\Framework\Models\AbstractModel;
use Illuminate\Http\Request;

abstract class AbstractValidator
{
    /**
     * @param AbstractModel $model
     * @param Request       $request
     * @return bool
     */
    public function create(AbstractModel $model, Request $request)
    {
        if(is_null($this->rules))
            return false;
        // replicate the model if it exists
        if($model->exists)
            $model = $model->replicate(['id']);

        $values = $this->parseRequestValues($request, $model);

        $validator = $this->make($values, $this->rules);

        if($validator->fails())
            return $validator;

        $model->fill($values);

        return $model;
    }

    /**
     * @param AbstractModel $model
     * @param Request       $request
     * @return bool
     */
    public function updating(AbstractModel $model, Request $request)
    {
        if(is_null($this->rules))
            return false;

        // if not yet existing, forward to create method
        if(!$model->exists)
            return $this->create($model, $request);

        // get the rules for only those attributes that have been changed
        $rules = array_only($this->rules, array_keys($request->all()));

        // no rules available
        if(empty($rules))
            return false;

        $values = $this->parseRequestValues($request, $model);

        $validator = $this->make($values, $rules);

        if($validator->fails())
            return $validator;

        $model->fill($values);

        return $model;
    }

    /**
     * @param AbstractModel $model
     * @param Request       $request
     * @return AbstractModel|\Illuminate\Validation\Validator
     */
    public function deleting(AbstractModel $model, Request $request)
    {
        $values = $this->parseRequestValues($request, $model);

        $values = array_merge($values, ['id' => $model->id]);

        $validator = $this->make($values, [
            'id' => ["exists:{$model->getTable()},id", "required", "numeric", "min:1"],
            'confirm' => ['required', 'boolean', 'accepted']
        ]);

        if($validator->fails())
            return $validator;

        $model->delete();

        return $model;
    }

    /**
     * Loads a validator object
     * @param $values
     * @param $rules
     * @return \Illuminate\Validation\Validator
     */
    protected function make($values, $rules)
    {
        return Validator::make($values, $rules);
    }

    /**
     * Parses request values, without the token
     * @param Request $request
     * @return array
     */
    protected function parseRequestValues(Request $request, AbstractModel $model)
    {

        $values = array_merge($model->getAttributes(), $request->all());

        return array_except($values, ['_token']);
    }
}