<?php namespace HynMe\Framework\Testing;

use Config;
use HynMe\Framework\FrameworkServiceProvider;
use Illuminate\Foundation\Testing\TestCase as IlluminateTestCase;

class TestCase extends IlluminateTestCase
{

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../../../../../../../bootstrap/app.php';

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        Config::set('database.connections.hyn', Config::get('database.connections.mysql'));

        // register framework service provider and all dependancies
        $provider = $app->register(FrameworkServiceProvider::class);

        // register testing routes
        $app['router']->any('/tenant/view', function () {
            return \Response::json($app->make('tenant.view'));
        });

        if(!$provider)
            throw new \Exception('Required framework service provider not registered/booted for use during unit testing');

        return $app;
    }
}