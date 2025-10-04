<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Cms\Api\Policies\SnippetPolicy;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Cms\Api\Policies\SnippetPolicy;
use Tests\Unit\Playground\Cms\Api\TestCase;

/**
 * \Tests\Unit\Playground\Cms\Api\Policies\SnippetPolicy\PolicyTest
 */
#[CoversClass(SnippetPolicy::class)]
class PolicyTest extends TestCase
{
    public function test_policy_instance(): void
    {
        $instance = new SnippetPolicy;

        /** @phpstan-ignore method.alreadyNarrowedType */
        $this->assertInstanceOf(SnippetPolicy::class, $instance);
    }
}
