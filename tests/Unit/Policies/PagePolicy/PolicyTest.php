<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Cms\Api\Policies\PagePolicy;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Cms\Api\Policies\PagePolicy;
use Tests\Unit\Playground\Cms\Api\TestCase;

/**
 * \Tests\Unit\Playground\Cms\Api\Policies\PagePolicy\PolicyTest
 */
#[CoversClass(PagePolicy::class)]
class PolicyTest extends TestCase
{
    public function test_policy_instance(): void
    {
        $instance = new PagePolicy;

        /** @phpstan-ignore method.alreadyNarrowedType */
        $this->assertInstanceOf(PagePolicy::class, $instance);
    }
}
