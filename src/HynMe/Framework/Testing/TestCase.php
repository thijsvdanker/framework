<?php namespace HynMe\Framework\Testing;

use Config;
use Illuminate\Foundation\Testing\TestCase as IlluminateTestCase;

class TestCase extends IlluminateTestCase
{
    /**
     * @var \HynMe\MultiTenant\Contracts\TenantRepositoryContract
     */
    protected $tenant;

    /**
     * @var \HynMe\MultiTenant\Contracts\HostnameRepositoryContract
     */
    protected $hostname;

    /**
     * @var \HynMe\MultiTenant\Contracts\WebsiteRepositoryContract
     */
    protected $website;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../../../../../../../bootstrap/app.php';

        // register framework service provider and all dependancies
        $provider = $app->register('HynMe\Framework\FrameworkServiceProvider');

        Config::set('database.connections.hyn', Config::get('database.connections.mysql'));

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        if(!$provider)
            throw new \Exception('Required framework service provider not registered/booted for use during unit testing');

        return $app;
    }
}