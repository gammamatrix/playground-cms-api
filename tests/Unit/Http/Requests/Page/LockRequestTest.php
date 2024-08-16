<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Cms\Api\Http\Requests\Page;

use Tests\Unit\Playground\Cms\Api\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Cms\Api\Http\Requests\Page\LockRequestTest
 */
class LockRequestTest extends RequestTestCase
{
    protected string $requestClass = \Playground\Cms\Api\Http\Requests\Page\LockRequest::class;
}
