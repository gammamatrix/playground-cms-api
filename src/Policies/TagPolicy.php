<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Cms\Api\Policies;

use Playground\Auth\Policies\ModelPolicy;

/**
 * \Playground\Cms\Api\Policies\TagPolicy
 */
class TagPolicy extends ModelPolicy
{
    protected string $package = 'playground-cms-api';

    /**
     * @var array<int, string> The roles allowed to view the MVC.
     */
    protected $rolesToView = [
        'user',
        'staff',
        'publisher',
        'manager',
        'admin',
        'root',
    ];

    /**
     * @var array<int, string> The roles allowed for actions in the MVC.
     */
    protected $rolesForAction = [
        'publisher',
        'manager',
        'admin',
        'root',
    ];
}
