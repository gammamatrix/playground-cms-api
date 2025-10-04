<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Cms\Api\Http\Requests\Page;

use Playground\Cms\Api\Http\Requests\FormRequest;

/**
 * \Playground\Cms\Api\Http\Requests\Page\EditRequest
 */
class EditRequest extends FormRequest
{
    /**
     * @var array<string, string|array<mixed>>
     */
    public const RULES = [
        'page_type' => ['nullable', 'string'],
        'owned_by_id' => ['nullable', 'uuid'],
        'parent_id' => ['nullable', 'uuid'],
        'matrix_id' => ['nullable', 'uuid'],
        'canceled_at' => ['nullable', 'string'],
        'closed_at' => ['nullable', 'string'],
        'embargo_at' => ['nullable', 'string'],
        'fixed_at' => ['nullable', 'string'],
        'planned_end_at' => ['nullable', 'string'],
        'planned_start_at' => ['nullable', 'string'],
        'postponed_at' => ['nullable', 'string'],
        'published_at' => ['nullable', 'string'],
        'released_at' => ['nullable', 'string'],
        'resumed_at' => ['nullable', 'string'],
        'resolved_at' => ['nullable', 'string'],
        'suspended_at' => ['nullable', 'string'],
        'timer_end_at' => ['nullable', 'string'],
        'timer_start_at' => ['nullable', 'string'],
        'gids' => ['integer'],
        'po' => ['integer'],
        'pg' => ['integer'],
        'pw' => ['integer'],
        'only_admin' => ['boolean'],
        'only_user' => ['boolean'],
        'only_guest' => ['boolean'],
        'allow_public' => ['boolean'],
        'status' => ['integer'],
        'rank' => ['integer'],
        'size' => ['integer'],
        'redirect_delay' => ['integer'],
        'status_code' => ['integer'],
        'route' => ['nullable', 'string'],
        'matrix' => ['nullable', 'array'],
        'x' => ['nullable', 'integer'],
        'y' => ['nullable', 'integer'],
        'z' => ['nullable', 'integer'],
        'r' => ['nullable', 'numeric'],
        'theta' => ['nullable', 'numeric'],
        'rho' => ['nullable', 'numeric'],
        'phi' => ['nullable', 'numeric'],
        'elevation' => ['nullable', 'numeric'],
        'latitude' => ['nullable', 'numeric'],
        'longitude' => ['nullable', 'numeric'],
        'active' => ['boolean'],
        'canceled' => ['boolean'],
        'closed' => ['boolean'],
        'completed' => ['boolean'],
        'cron' => ['boolean'],
        'duplicate' => ['boolean'],
        'fixed' => ['boolean'],
        'flagged' => ['boolean'],
        'internal' => ['boolean'],
        'is_external' => ['boolean'],
        'is_redirect' => ['boolean'],
        'locked' => ['boolean'],
        'pending' => ['boolean'],
        'planned' => ['boolean'],
        'prioritized' => ['boolean'],
        'problem' => ['boolean'],
        'published' => ['boolean'],
        'released' => ['boolean'],
        'resolved' => ['boolean'],
        'retired' => ['boolean'],
        'sitemap' => ['boolean'],
        'suspended' => ['boolean'],
        'unknown' => ['boolean'],
        'locale' => ['string'],
        'label' => ['string'],
        'title' => ['string'],
        'byline' => ['string'],
        'slug' => ['nullable', 'string'],
        'url' => ['string'],
        'description' => ['string'],
        'introduction' => ['string'],
        'content' => ['nullable', 'string'],
        'summary' => ['nullable', 'string'],
        'icon' => ['string'],
        'image' => ['string'],
        'avatar' => ['string'],
        'ui' => ['nullable', 'array'],
        'assets' => ['nullable', 'array'],
        'meta' => ['nullable', 'array'],
        'options' => ['nullable', 'array'],
        'params' => ['nullable', 'array'],
        'sources' => ['nullable', 'array'],
        '_return_url' => ['nullable', 'url'],
    ];
}
