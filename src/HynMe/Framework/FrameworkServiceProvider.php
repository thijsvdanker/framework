<?php namespace HynMe\Framework;

use HynMe\Framework\Validation\ExtendedValidation;
use Validator;
use Illuminate\Support\ServiceProvider;

class FrameworkServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'hyn-framework');

        $this->app->validator->resolver(function($translator, $data, $rules, $messages)
        {
            return new ExtendedValidation($translator, $data, $rules, $messages);
        });
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
	}

}
