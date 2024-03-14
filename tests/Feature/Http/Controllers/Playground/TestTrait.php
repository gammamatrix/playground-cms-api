<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Feature\Playground\Cms\Api\Http\Controllers\Playground;

/**
 * \Tests\Unit\Playground\Cms\Api\Playground\TestTrait
 */
trait TestTrait
{
    /**
     * Set up the environment.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.providers.users.model', '\\Playground\\Test\\Models\\AppPlaygroundUser');

        $app['config']->set('playground-cms.load.migrations', true);

        $app['config']->set('app.debug', true);
        $app['config']->set('playground-auth.debug', true);

        $app['config']->set('playground-auth.verify', 'roles');
        // $app['config']->set('playground-auth.verify', 'privileges');
        $app['config']->set('playground-auth.sanctum', false);
        $app['config']->set('playground-auth.hasPrivilege', true);
        $app['config']->set('playground-auth.userPrivileges', true);
        $app['config']->set('playground-auth.hasRole', true);
        $app['config']->set('playground-auth.userRole', true);
        $app['config']->set('playground-auth.userRoles', true);

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '__FILE__' => __FILE__,
        //     '__LINE__' => __LINE__,
        //     'config(playground-auth)' => config('playground-auth'),
        // ]);

        // $app['config']->set('playground-auth.token.roles', true);
        // $app['config']->set('playground-auth.token.sanctum', true);

        // $middleware = [];
        // api,auth:sanctum,web

        // $app['config']->set('playground-cms-api.routes.cms', true);
        // $app['config']->set('playground-cms-api.routes.pages', true);
        // $app['config']->set('playground-cms-api.routes.routes', true);

        // $app['config']->set('playground-cms-api.sitemap.enable', true);
        // $app['config']->set('playground-cms-api.sitemap.guest', true);
        // $app['config']->set('playground-cms-api.sitemap.user', true);

    }
}
