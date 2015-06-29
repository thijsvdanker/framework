<?php namespace HynMe\Framework\Testing;

use Config;
use Illuminate\Foundation\Testing\TestCase as IlluminateTestCase;

class TestCase extends IlluminateTestCase
{
    public function setUp()
    {
        // run illuminate testCase setup
        parent::setUp();
        // register framework service provider and all dependancies
        $this->app->register('HynMe\Framework\FrameworkServiceProvider');
        Config::set('database.connections.hyn', Config::get('database.connections.sqlite'));
    }


    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../../../../../../../bootstrap/app.php';

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
    }
}