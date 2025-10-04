<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Cms\Api\Http\Requests\Page;

use Playground\Cms\Api\Http\Requests\FormRequest;

/**
 * \Playground\Cms\Api\Http\Requests\Page\RestoreRequest
 */
class RestoreRequest extends FormRequest
{
    /**
     * @var array<string, string|array<mixed>>
     */
    public const RULES = [
        '_return_url' => ['nullable', 'url'],
    ];
}
