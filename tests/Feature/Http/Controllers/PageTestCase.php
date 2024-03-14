<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Feature\Playground\Cms\Api\Http\Controllers;

/**
 * \Tests\Feature\Playground\Cms\Api\Http\Controllers\PageTestCase
 */
class PageTestCase extends TestCase
{
    public string $fqdn = \Playground\Cms\Models\Page::class;

    public string $fqdnRevision = \Playground\Cms\Models\PageRevision::class;

    public string $revisionId = 'page_id';

    public string $revisionRouteParameter = 'page_revision';

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Page',
        'model_label_plural' => 'Pages',
        'model_route' => 'playground.cms.api.pages',
        'model_slug' => 'page',
        'model_slug_plural' => 'pages',
        'module_label' => 'CMS',
        'module_label_plural' => 'CMS',
        'module_route' => 'playground.cms.api',
        'module_slug' => 'cms',
        'privilege' => 'playground-cms-api:page',
        'table' => 'cms_pages',
        'view' => 'playground-cms-api::page',
    ];

    /**
     * @var array<int, string>
     */
    protected $structure_model = [
        'id',
        'created_by_id',
        'modified_by_id',
        'owned_by_id',
        'parent_id',
        'page_type',
        'created_at',
        'deleted_at',
        'updated_at',
        'start_at',
        'planned_start_at',
        'end_at',
        'planned_end_at',
        'canceled_at',
        'closed_at',
        'embargo_at',
        'fixed_at',
        'postponed_at',
        'published_at',
        'released_at',
        'resumed_at',
        'resolved_at',
        'suspended_at',
        'gids',
        'po',
        'pg',
        'pw',
        'only_admin',
        'only_user',
        'only_guest',
        'allow_public',
        'status',
        'rank',
        'size',
        'active',
        'canceled',
        'closed',
        'completed',
        'fixed',
        'flagged',
        'internal',
        'locked',
        'pending',
        'planned',
        'problem',
        'published',
        'released',
        'retired',
        'resolved',
        'sitemap',
        'suspended',
        'unknown',
        'label',
        'title',
        'byline',
        'slug',
        'url',
        'description',
        'introduction',
        'content',
        'summary',
        'icon',
        'image',
        'avatar',
        'ui',
        'assets',
        'meta',
        'options',
        'sources',
    ];
}
