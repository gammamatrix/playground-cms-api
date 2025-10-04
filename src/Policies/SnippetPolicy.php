<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Cms\Api\Policies;

use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Auth\Authenticatable;
use Playground\Auth\Policies\ModelPolicy;
use Playground\Cms\Models\Snippet;
use Playground\Cms\Models\SnippetRevision;

/**
 * \Playground\Cms\Api\Policies\SnippetPolicy
 */
class SnippetPolicy extends ModelPolicy
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

    /**
     * Determine whether the user can view the revision index.
     */
    public function revisions(Authenticatable $user): bool|Response
    {
        return $this->verify($user, 'viewAny');
    }

    /**
     * Determine whether the user can view a revision.
     */
    public function viewRevision(Authenticatable $user, SnippetRevision $snippet_revision): bool|Response
    {
        return $this->verify($user, 'view');
    }

    /**
     * Determine whether the user can restore the Snippet Revision.
     */
    public function restoreRevision(Authenticatable $user, SnippetRevision $snippet_revision): bool|Response
    {
        return $this->verify($user, 'restore');
    }
}
