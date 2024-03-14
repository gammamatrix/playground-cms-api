<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Feature\Playground\Cms\Api\Http\Requests\FormRequest;

use Illuminate\Support\Facades\Auth;
use Playground\Cms\Api\Http\Requests\FormRequest;
use Playground\Test\Models\PlaygroundUser as User;
use Tests\Feature\Playground\Cms\Api\TestCase;

/**
 * \Tests\Feature\Playground\Cms\Api\Http\Requests\FormRequest\InstanceTest
 */
class InstanceTest extends TestCase
{
    protected bool $load_migrations_playground = true;

    public function test_FormRequest_authorize_with_admin(): void
    {
        /**
         * @var User $user
         */
        $user = User::factory()->admin()->create();

        Auth::setUser($user);

        $instance = new FormRequest;
        $instance->setUserResolver(function () use ($user) {
            return $user;
        });
        $this->assertTrue($instance->authorize());
    }
}
