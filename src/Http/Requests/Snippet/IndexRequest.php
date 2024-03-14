<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Cms\Api\Http\Requests\Snippet;

use Playground\Http\Requests\IndexRequest as BaseIndexRequest;

/**
 * \Playground\Cms\Api\Http\Requests\Snippet\IndexRequest
 */
class IndexRequest extends BaseIndexRequest
{
    /**
     * @var array<string, mixed>
     */
    protected array $paginationDates = [
        'created_at' => ['column' => 'created_at', 'label' => 'Created At', 'nullable' => true],
        'updated_at' => ['column' => 'updated_at', 'label' => 'Updated At', 'nullable' => true],
        'deleted_at' => ['column' => 'deleted_at', 'label' => 'Deleted At', 'nullable' => true],
        'start_at' => ['column' => 'start_at', 'label' => 'Start At', 'nullable' => true],
        'planned_start_at' => ['column' => 'planned_start_at', 'label' => 'Planned Start At', 'nullable' => true],
        'end_at' => ['column' => 'end_at', 'label' => 'End At', 'nullable' => true],
        'planned_end_at' => ['column' => 'planned_end_at', 'label' => 'Planned End At', 'nullable' => true],
        'canceled_at' => ['column' => 'canceled_at', 'label' => 'Canceled At', 'nullable' => true],
        'closed_at' => ['column' => 'closed_at', 'label' => 'Closed At', 'nullable' => true],
        'embargo_at' => ['column' => 'embargo_at', 'label' => 'Embargo At', 'nullable' => true],
        'fixed_at' => ['column' => 'fixed_at', 'label' => 'Fixed At', 'nullable' => true],
        'postponed_at' => ['column' => 'postponed_at', 'label' => 'Postponed At', 'nullable' => true],
        'published_at' => ['column' => 'published_at', 'label' => 'Published At', 'nullable' => true],
        'released_at' => ['column' => 'released_at', 'label' => 'Released At', 'nullable' => true],
        'resumed_at' => ['column' => 'resumed_at', 'label' => 'Resumed At', 'nullable' => true],
        'resolved_at' => ['column' => 'resolved_at', 'label' => 'Resolved At', 'nullable' => true],
        'suspended_at' => ['column' => 'suspended_at', 'label' => 'Suspended At', 'nullable' => true],
    ];

    /**
     * @var array<string, mixed>
     */
    protected array $paginationFlags = [
        'active' => ['column' => 'active', 'label' => 'Active', 'icon' => 'fa-solid fa-person-running'],
        'canceled' => ['column' => 'canceled', 'label' => 'Canceled', 'icon' => 'fa-solid fa-ban text-warning'],
        'closed' => ['column' => 'closed', 'label' => 'Closed', 'icon' => 'fa-solid fa-xmark'],
        'completed' => ['column' => 'completed', 'label' => 'Completed', 'icon' => 'fa-solid fa-check'],
        'duplicate' => ['column' => 'duplicate', 'label' => 'Duplicate', 'icon' => 'fa-solid fa-clone'],
        'fixed' => ['column' => 'fixed', 'label' => 'Fixed', 'icon' => 'fa-solid fa-wrench'],
        'flagged' => ['column' => 'flagged', 'label' => 'Flagged', 'icon' => 'fa-solid fa-flag'],
        'internal' => ['column' => 'internal', 'label' => 'Internal', 'icon' => 'fa-solid fa-server'],
        'locked' => ['column' => 'locked', 'label' => 'Locked', 'icon' => 'fa-solid fa-lock text-warning'],
        'pending' => ['column' => 'pending', 'label' => 'Pending', 'icon' => 'fa-solid fa-circle-pause text-warning'],
        'planned' => ['column' => 'planned', 'label' => 'Planned', 'icon' => 'fa-solid fa-circle-pause text-success'],
        'problem' => ['column' => 'problem', 'label' => 'Problem', 'icon' => 'fa-solid fa-triangle-exclamation text-danger'],
        'published' => ['column' => 'published', 'label' => 'Published', 'icon' => 'fa-solid fa-book'],
        'released' => ['column' => 'released', 'label' => 'Released', 'icon' => 'fa-solid fa-dove'],
        'retired' => ['column' => 'retired', 'label' => 'Retired', 'icon' => 'fa-solid fa-chair text-success'],
        'resolved' => ['column' => 'resolved', 'label' => 'Resolved', 'icon' => 'fa-solid fa-check-double text-success'],
        'suspended' => ['column' => 'suspended', 'label' => 'Suspended', 'icon' => 'fa-solid fa-hand text-danger'],
        'unknown' => ['column' => 'unknown', 'label' => 'Unknown', 'icon' => 'fa-solid fa-question text-warning'],
    ];

    /**
     * @var array<string, mixed>
     */
    protected array $paginationIds = [
        'id' => ['column' => 'id', 'label' => 'Id', 'type' => 'uuid', 'nullable' => false],
        'created_by_id' => ['column' => 'created_by_id', 'label' => 'Created By Id', 'type' => 'uuid', 'nullable' => true],
        'modified_by_id' => ['column' => 'modified_by_id', 'label' => 'Modified By Id', 'type' => 'uuid', 'nullable' => true],
        'owned_by_id' => ['column' => 'owned_by_id', 'label' => 'Owned By Id', 'type' => 'uuid', 'nullable' => true],
        'parent_id' => ['column' => 'parent_id', 'label' => 'Parent Id', 'type' => 'uuid', 'nullable' => true],
        'snippet_type' => ['column' => 'snippet_type', 'label' => 'Snippet Type', 'type' => 'string', 'nullable' => true],
    ];

    /**
     * @var array<string, mixed>
     */
    protected array $paginationColumns = [
        'label' => ['column' => 'label', 'label' => 'Label', 'type' => 'string', 'nullable' => false],
        'title' => ['column' => 'title', 'label' => 'Title', 'type' => 'string', 'nullable' => false],
        'byline' => ['column' => 'byline', 'label' => 'Byline', 'type' => 'string', 'nullable' => false],
        'slug' => ['column' => 'slug', 'label' => 'Slug', 'type' => 'string', 'nullable' => true],
        'url' => ['column' => 'url', 'label' => 'Url', 'type' => 'string', 'nullable' => false],
        'description' => ['column' => 'description', 'label' => 'Description', 'type' => 'string', 'nullable' => false],
        'introduction' => ['column' => 'introduction', 'label' => 'Introduction', 'type' => 'string', 'nullable' => false],
        'content' => ['column' => 'content', 'label' => 'Content', 'type' => 'mediumText', 'nullable' => true],
        'summary' => ['column' => 'summary', 'label' => 'Summary', 'type' => 'mediumText', 'nullable' => true],
    ];

    /**
     * @var array<string, mixed>
     */
    protected array $sortable = [
        'id' => ['column' => 'id', 'label' => 'Id', 'type' => 'string'],
        'created_by_id' => ['column' => 'created_by_id', 'label' => 'Created By Id', 'type' => 'string'],
        'modified_by_id' => ['column' => 'modified_by_id', 'label' => 'Modified By Id', 'type' => 'string'],
        'owned_by_id' => ['column' => 'owned_by_id', 'label' => 'Owned By Id', 'type' => 'string'],
        'parent_id' => ['column' => 'parent_id', 'label' => 'Parent Id', 'type' => 'string'],
        'snippet_type' => ['column' => 'snippet_type', 'label' => 'Snippet Type', 'type' => 'string'],
        'created_at' => ['column' => 'created_at', 'label' => 'Created At', 'type' => 'string'],
        'updated_at' => ['column' => 'updated_at', 'label' => 'Updated At', 'type' => 'string'],
        'deleted_at' => ['column' => 'deleted_at', 'label' => 'Deleted At', 'type' => 'string'],
        'start_at' => ['column' => 'start_at', 'label' => 'Start At', 'type' => 'string'],
        'planned_start_at' => ['column' => 'planned_start_at', 'label' => 'Planned Start At', 'type' => 'string'],
        'end_at' => ['column' => 'end_at', 'label' => 'End At', 'type' => 'string'],
        'planned_end_at' => ['column' => 'planned_end_at', 'label' => 'Planned End At', 'type' => 'string'],
        'canceled_at' => ['column' => 'canceled_at', 'label' => 'Canceled At', 'type' => 'string'],
        'closed_at' => ['column' => 'closed_at', 'label' => 'Closed At', 'type' => 'string'],
        'embargo_at' => ['column' => 'embargo_at', 'label' => 'Embargo At', 'type' => 'string'],
        'fixed_at' => ['column' => 'fixed_at', 'label' => 'Fixed At', 'type' => 'string'],
        'postponed_at' => ['column' => 'postponed_at', 'label' => 'Postponed At', 'type' => 'string'],
        'published_at' => ['column' => 'published_at', 'label' => 'Published At', 'type' => 'string'],
        'released_at' => ['column' => 'released_at', 'label' => 'Released At', 'type' => 'string'],
        'resumed_at' => ['column' => 'resumed_at', 'label' => 'Resumed At', 'type' => 'string'],
        'resolved_at' => ['column' => 'resolved_at', 'label' => 'Resolved At', 'type' => 'string'],
        'suspended_at' => ['column' => 'suspended_at', 'label' => 'Suspended At', 'type' => 'string'],
        'gids' => ['column' => 'gids', 'label' => 'Gids', 'type' => 'integer'],
        'po' => ['column' => 'po', 'label' => 'Po', 'type' => 'integer'],
        'pg' => ['column' => 'pg', 'label' => 'Pg', 'type' => 'integer'],
        'pw' => ['column' => 'pw', 'label' => 'Pw', 'type' => 'integer'],
        'only_admin' => ['column' => 'only_admin', 'label' => 'Only Admin', 'type' => 'boolean'],
        'only_user' => ['column' => 'only_user', 'label' => 'Only User', 'type' => 'boolean'],
        'only_guest' => ['column' => 'only_guest', 'label' => 'Only Guest', 'type' => 'boolean'],
        'allow_public' => ['column' => 'allow_public', 'label' => 'Allow Public', 'type' => 'boolean'],
        'status' => ['column' => 'status', 'label' => 'Status', 'type' => 'integer'],
        'rank' => ['column' => 'rank', 'label' => 'Rank', 'type' => 'integer'],
        'size' => ['column' => 'size', 'label' => 'Size', 'type' => 'integer'],
        'active' => ['column' => 'active', 'label' => 'Active', 'type' => 'boolean'],
        'canceled' => ['column' => 'canceled', 'label' => 'Canceled', 'type' => 'boolean'],
        'closed' => ['column' => 'closed', 'label' => 'Closed', 'type' => 'boolean'],
        'completed' => ['column' => 'completed', 'label' => 'Completed', 'type' => 'boolean'],
        'duplicate' => ['column' => 'duplicate', 'label' => 'Duplicate', 'type' => 'boolean'],
        'fixed' => ['column' => 'fixed', 'label' => 'Fixed', 'type' => 'boolean'],
        'flagged' => ['column' => 'flagged', 'label' => 'Flagged', 'type' => 'boolean'],
        'internal' => ['column' => 'internal', 'label' => 'Internal', 'type' => 'boolean'],
        'locked' => ['column' => 'locked', 'label' => 'Locked', 'type' => 'boolean'],
        'pending' => ['column' => 'pending', 'label' => 'Pending', 'type' => 'boolean'],
        'planned' => ['column' => 'planned', 'label' => 'Planned', 'type' => 'boolean'],
        'problem' => ['column' => 'problem', 'label' => 'Problem', 'type' => 'boolean'],
        'published' => ['column' => 'published', 'label' => 'Published', 'type' => 'boolean'],
        'released' => ['column' => 'released', 'label' => 'Released', 'type' => 'boolean'],
        'retired' => ['column' => 'retired', 'label' => 'Retired', 'type' => 'boolean'],
        'resolved' => ['column' => 'resolved', 'label' => 'Resolved', 'type' => 'boolean'],
        'suspended' => ['column' => 'suspended', 'label' => 'Suspended', 'type' => 'boolean'],
        'unknown' => ['column' => 'unknown', 'label' => 'Unknown', 'type' => 'boolean'],
        'label' => ['column' => 'label', 'label' => 'Label', 'type' => 'string'],
        'title' => ['column' => 'title', 'label' => 'Title', 'type' => 'string'],
        'byline' => ['column' => 'byline', 'label' => 'Byline', 'type' => 'string'],
        'slug' => ['column' => 'slug', 'label' => 'Slug', 'type' => 'string'],
        'url' => ['column' => 'url', 'label' => 'Url', 'type' => 'string'],
        'description' => ['column' => 'description', 'label' => 'Description', 'type' => 'string'],
        'introduction' => ['column' => 'introduction', 'label' => 'Introduction', 'type' => 'string'],
        'content' => ['column' => 'content', 'label' => 'Content', 'type' => 'string'],
        'summary' => ['column' => 'summary', 'label' => 'Summary', 'type' => 'string'],
        'icon' => ['column' => 'icon', 'label' => 'Icon', 'type' => 'string'],
        'image' => ['column' => 'image', 'label' => 'Image', 'type' => 'string'],
        'avatar' => ['column' => 'avatar', 'label' => 'Avatar', 'type' => 'string'],
    ];
}
