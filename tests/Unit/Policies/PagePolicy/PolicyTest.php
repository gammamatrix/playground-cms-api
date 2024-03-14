<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Unit\Playground\Cms\Api\Policies\PagePolicy;

use Playground\Cms\Api\Policies\PagePolicy;
use Tests\Unit\Playground\Cms\Api\TestCase;

/**
 * \ests\Unit\Playground\Cms\Api\Policies\PagePolicy\PolicyTest
 */
class PolicyTest extends TestCase
{
    public function test_policy_instance(): void
    {
        $instance = new PagePolicy;

        $this->assertInstanceOf(PagePolicy::class, $instance);
    }
}
