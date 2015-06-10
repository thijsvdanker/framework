<?php namespace HynMe\Framework;

use HynMe\Framework\Validation\ExtendedValidation;
use Validator;
use DB;
use Illuminate\Support\ServiceProvider;

class FrameworkServiceProvider extends ServiceProvider {

    protected $service_providers = [
        'HynMe\MultiTenant\MultiTenantServiceProvider',

        'HynMe\Webserver\WebserverServiceProvider',
        'HynMe\ManagementInterface\ManagementInterfaceServiceProvider',
        'HynMe\Distribution\DistributionServiceProvider',
    ];

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
        /*
         * register additional service providers if they exist
         */
		foreach($this->service_providers as $service_provider)
        {
            if(class_exists($service_provider))
                $this->app->register($service_provider);
        }
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
