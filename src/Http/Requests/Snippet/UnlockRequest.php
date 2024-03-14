<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Cms\Api\Http\Requests\Snippet;

use Playground\Cms\Api\Http\Requests\FormRequest;

/**
 * \Playground\Cms\Api\Http\Requests\Snippet\UnlockRequest
 */
class UnlockRequest extends FormRequest
{
    /**
     * @var array<string, string|array<mixed>>
     */
    public const RULES = [
        '_return_url' => ['nullable', 'url'],
    ];
}
