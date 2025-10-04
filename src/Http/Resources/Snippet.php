<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Cms\Api\Http\Resources;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Playground\Cms\Api\Http\Requests\FormRequest;
use Playground\Cms\Models\Snippet as SnippetModel;

/**
 * \Playground\Cms\Api\Http\Resources\Snippet
 */
class Snippet extends JsonResource
{
    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  Request&FormRequest  $request
     * @return array<string, mixed>
     */
    public function with(Request $request): array
    {
        /**
         * @var ?SnippetModel $snippet
         */
        $snippet = $request->route('snippet');

        /**
         * @var ?Authenticatable $user;
         */
        $user = $request->user();

        return [
            'meta' => [
                'id' => $snippet?->id,
                'rules' => $request->rules(),
                'session_user_id' => $user?->getAttributeValue('id'),
                'timestamp' => Carbon::now()->toJson(),
            ],
        ];
    }
}
