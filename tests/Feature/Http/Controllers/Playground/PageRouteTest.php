<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Feature\Playground\Cms\Api\Http\Controllers\Playground;

use Tests\Feature\Playground\Cms\Api\Http\Controllers\PageTestCase;

/**
 * \Tests\Feature\Playground\Cms\Api\Http\Controllers\Playground\PageRouteTest
 */
class PageRouteTest extends PageTestCase
{
    use TestTrait;

    protected bool $load_migrations_playground = true;

    protected bool $load_migrations_cms = true;
}
