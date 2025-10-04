<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Feature\Playground\Cms\Api\Console\Commands\About;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Cms\Api\ServiceProvider;
use Symfony\Component\Console\Command\Command;
use Tests\Feature\Playground\Cms\Api\TestCase;

/**
 * \Tests\Feature\Playground\Cms\Api\Console\Commands\About\CommandTest
 */
#[CoversClass(ServiceProvider::class)]
class CommandTest extends TestCase
{
    public function test_command_about_displays_package_information_and_succeed(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('about');
        $result->assertExitCode(Command::SUCCESS);
        $result->expectsOutputToContain('Playground: CMS API');
    }
}
