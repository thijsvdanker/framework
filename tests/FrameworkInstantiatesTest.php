<?php namespace HynMe\Framework;

use HynMe\Framework\Testing\TestCase;
use Config;

class FrameworkInstantiatesTest extends TestCase
{
    public function testProvider()
    {
        $this->assertTrue(in_array(FrameworkServiceProvider::class, $this->app->getLoadedProviders()));
    }
    public function testConfigurationProviders()
    {
        $this->assertNotEmpty(Config::get('hyn.packages', []), 'no configuration available that lists the hyn packages');
    }
}