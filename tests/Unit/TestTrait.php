<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Unit\Playground\Cms\Api;

use Playground\Auth\ServiceProvider as PlaygroundAuthServiceProvider;
use Playground\Cms\Api\ServiceProvider;
use Playground\Cms\ServiceProvider as PlaygroundCmsServiceProvider;
use Playground\Http\ServiceProvider as PlaygroundHttpServiceProvider;
use Playground\ServiceProvider as PlaygroundServiceProvider;

/**
 * \Tests\Unit\Playground\Cms\Api\TestTrait
 */
trait TestTrait
{
    protected function getPackageProviders($app)
    {
        return [
            PlaygroundAuthServiceProvider::class,
            PlaygroundHttpServiceProvider::class,
            PlaygroundCmsServiceProvider::class,
            PlaygroundServiceProvider::class,
            ServiceProvider::class,
        ];
    }
}
