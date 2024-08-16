<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Cms\Api\Http\Requests\Page;

use Tests\Unit\Playground\Cms\Api\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Cms\Api\Http\Requests\Page\ShowRequestTest
 */
class ShowRequestTest extends RequestTestCase
{
    protected string $requestClass = \Playground\Cms\Api\Http\Requests\Page\ShowRequest::class;
}
