<?php namespace HynMe\Framework;

use HynMe\Framework\Testing\TestCase;

class FrameworkInstantiatesTest extends TestCase
{
    public function testProvider()
    {
        $this->assertTrue(in_array(FrameworkServiceProvider::class, $this->app->getLoadedProviders()));
    }
}