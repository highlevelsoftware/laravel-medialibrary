<?php

namespace Feature;

use Config;
use Spatie\MediaLibrary\Tests\TestCase;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;

class ServiceProviderTest extends TestCase
{
    /** @test */
    public function it_has_fallback_for_disk_name()
    {
        $app = app();

        $app['config']->set('medialibrary.disk_name', null);
        $app['config']->set('medialibrary.default_filesystem', 'test');

        $provider = new MediaLibraryServiceProvider($app);

        $provider->register();

        $this->assertEquals(Config::get('medialibrary.default_filesystem'), Config::get('medialibrary.disk_name'));
    }
}
