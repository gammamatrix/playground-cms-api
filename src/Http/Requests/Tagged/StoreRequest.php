<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Cms\Api\Http\Requests\Tagged;

use Playground\Http\Requests\StoreRequest as BaseStoreRequest;

/**
 * \Playground\Cms\Api\Http\Requests\Tagged\StoreRequest
 */
class StoreRequest extends BaseStoreRequest
{
    /**
     * @var array<string, string|array<mixed>>
     */
    public const RULES = [
        'tag_id' => ['uuid', 'required'],
        'page_id' => ['nullable', 'uuid'],
        'snippet_id' => ['nullable', 'uuid'],
        '_return_url' => ['nullable', 'url'],
    ];

    protected string $slug_table = 'cms_tagged';

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        parent::prepareForValidation();

        $input = [];

        $this->filterContentFields($input);
        $this->filterCommonFields($input);
        $this->filterStatus($input);
        $this->filterSystemFields($input);

        if (! empty($input)) {
            $this->merge($input);
        }
    }
}
