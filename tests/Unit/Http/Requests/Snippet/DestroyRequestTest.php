<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Cms\Api\Http\Requests\Snippet;

use Tests\Unit\Playground\Cms\Api\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Cms\Api\Http\Requests\Snippet\DestroyRequestTest
 */
class DestroyRequestTest extends RequestTestCase
{
    protected string $requestClass = \Playground\Cms\Api\Http\Requests\Snippet\DestroyRequest::class;
}
