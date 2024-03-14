<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Unit\Playground\Cms\Api;

use Playground\Test\OrchestraTestCase;

/**
 * \Tests\Unit\Playground\Cms\Api\TestCase
 */
class TestCase extends OrchestraTestCase
{
    use TestTrait;

    /**
     * Set up the environment.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.providers.users.model', 'Playground\\Test\\Models\\User');
        $app['config']->set('playground-auth.verify', 'user');
        $app['config']->set('auth.testing.password', 'password');
        $app['config']->set('auth.testing.hashed', false);

        $app['config']->set('playground-cms.load.migrations', true);
    }
}
