<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Unit\Playground\Cms\Api\Policies\SnippetPolicy;

use Playground\Cms\Api\Policies\SnippetPolicy;
use Tests\Unit\Playground\Cms\Api\TestCase;

/**
 * \ests\Unit\Playground\Cms\Api\Policies\SnippetPolicy\PolicyTest
 */
class PolicyTest extends TestCase
{
    public function test_policy_instance(): void
    {
        $instance = new SnippetPolicy;

        $this->assertInstanceOf(SnippetPolicy::class, $instance);
    }
}
