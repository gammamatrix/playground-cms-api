<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Cms\Api;

/**
 * \Tests\Unit\Playground\Cms\Api\PackageProviders
 */
trait PackageProviders
{
    protected function getPackageProviders($app)
    {
        return [
            \Playground\Test\ServiceProvider::class,
            \Playground\ServiceProvider::class,
            \Playground\Auth\ServiceProvider::class,
            \Playground\Http\ServiceProvider::class,
            \Playground\Cms\ServiceProvider::class,
            \Playground\Cms\Api\ServiceProvider::class,
            \Laravel\Sanctum\SanctumServiceProvider::class,
        ];
    }
}
