<?php

namespace HynMe\Framework;

use Config;
use HynMe\Framework\Testing\TestCase;

class FrameworkInstantiatesTest extends TestCase
{
    public function testProvider()
    {
        $this->assertTrue(in_array(FrameworkServiceProvider::class, $this->app->getLoadedProviders()));
        $this->assertTrue($this->app->isBooted());
    }

    public function testConfigurationProviders()
    {
        $this->assertNotEmpty(Config::get('hyn.packages', []), 'no configuration available that lists the hyn packages');
    }

    public function testMultiTenantMissingProvider()
    {
        $this->assertFalse($this->app->make('hyn.package.multi-tenant'));
    }
}
