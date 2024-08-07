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
use Playground\Cms\Models\SnippetRevision as SnippetRevisionModel;

/**
 * \Playground\Cms\Api\Http\Resources\SnippetRevision
 */
class SnippetRevision extends JsonResource
{
    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param Request&FormRequest $request
     * @return array<string, mixed>
     */
    public function with(Request $request): array
    {
        /**
         * @var ?SnippetRevisionModel $snippet_revision
         */
        $snippet_revision = $request->route('snippet_revision');

        /**
         * @var ?Authenticatable $user;
         */
        $user = $request->user();

        return [
            'meta' => [
                'id' => $snippet_revision?->id,
                'rules' => $request->rules(),
                'session_user_id' => $user?->getAttributeValue('id'),
                'timestamp' => Carbon::now()->toJson(),
                'validated' => $request->validated(),
            ],
        ];
    }
}
