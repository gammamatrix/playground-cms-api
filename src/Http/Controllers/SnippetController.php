<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Cms\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Playground\Cms\Api\Http\Requests;
use Playground\Cms\Api\Http\Resources;
use Playground\Cms\Models\Snippet;
use Playground\Cms\Models\SnippetRevision;

/**
 * \Playground\Cms\Api\Http\Controllers\SnippetController
 */
class SnippetController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Snippet',
        'model_label_plural' => 'Snippets',
        'model_route' => 'playground.cms.api.snippets',
        'model_slug' => 'snippet',
        'model_slug_plural' => 'snippets',
        'module_label' => 'CMS',
        'module_label_plural' => 'CMS',
        'module_route' => 'playground.cms.api',
        'module_slug' => 'cms',
        'privilege' => 'playground-cms-api:snippet',
        'table' => 'cms_snippets',
    ];

    /**
     * Create the Snippet resource in storage.
     *
     * @route GET /api/cms/snippets/create playground.cms.api.snippets.create
     */
    public function create(
        Requests\Snippet\CreateRequest $request
    ): JsonResponse|Resources\Snippet {

        $validated = $request->validated();

        $user = $request->user();

        $snippet = new Snippet($validated);

        return (new Resources\Snippet($snippet))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Snippet resource in storage.
     *
     * @route GET /api/cms/snippets/edit/{snippet} playground.cms.api.snippets.edit
     */
    public function edit(
        Snippet $snippet,
        Requests\Snippet\EditRequest $request
    ): JsonResponse|Resources\Snippet {
        return (new Resources\Snippet($snippet))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Snippet resource from storage.
     *
     * @route DELETE /api/cms/snippets/{snippet} playground.cms.api.snippets.destroy
     */
    public function destroy(
        Snippet $snippet,
        Requests\Snippet\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $snippet->modified_by_id = $user->id;
        }

        if (empty($validated['force'])) {
            $snippet->delete();
        } else {
            $snippet->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Snippet resource in storage.
     *
     * @route PUT /api/cms/snippets/{snippet} playground.cms.api.snippets.lock
     */
    public function lock(
        Snippet $snippet,
        Requests\Snippet\LockRequest $request
    ): JsonResponse|Resources\Snippet {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $snippet->modified_by_id = $user->id;
        }

        $snippet->locked = true;

        $snippet->save();

        return (new Resources\Snippet($snippet))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Snippet resources.
     *
     * @route GET /api/cms/snippets playground.cms.api.snippets
     */
    public function index(
        Requests\Snippet\IndexRequest $request
    ): JsonResponse|Resources\SnippetCollection {

        $user = $request->user();

        $validated = $request->validated();

        $query = Snippet::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

        $query->sort($validated['sort'] ?? null);

        if (! empty($validated['filter']) && is_array($validated['filter'])) {

            $query->filterTrash($validated['filter']['trash'] ?? null);

            $query->filterIds(
                $request->getPaginationIds(),
                $validated
            );

            $query->filterFlags(
                $request->getPaginationFlags(),
                $validated
            );

            $query->filterDates(
                $request->getPaginationDates(),
                $validated
            );

            $query->filterColumns(
                $request->getPaginationColumns(),
                $validated
            );
        }

        $perPage = ! empty($validated['perPage']) && is_int($validated['perPage']) ? $validated['perPage'] : null;
        $paginator = $query->paginate($perPage);

        $paginator->appends($validated);

        return (new Resources\SnippetCollection($paginator))->response($request);
    }

    /**
     * Restore the Snippet resource from the trash.
     *
     * @route PUT /api/cms/snippets/restore/{snippet} playground.cms.api.snippets.restore
     */
    public function restore(
        Snippet $snippet,
        Requests\Snippet\RestoreRequest $request
    ): JsonResponse|Resources\Snippet {

        $user = $request->user();

        if ($user?->id) {
            $snippet->modified_by_id = $user->id;
        }

        $snippet->restore();

        return (new Resources\Snippet($snippet))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Restore the Snippet resource from the trash.
     *
     * @route PUT /api/cms/snippets/revision/{snippet_revision} playground.cms.api.snippets.revision.restore
     */
    public function restoreRevision(
        SnippetRevision $snippet_revision,
        Requests\Snippet\RestoreRevisionRequest $request
    ): JsonResponse|Resources\Snippet {
        $validated = $request->validated();

        /**
         * @var Snippet $snippet
         */
        $snippet = Snippet::where(
            'id',
            $snippet_revision->snippet_id
        )->firstOrFail();

        $this->saveRevision($snippet);

        $user = $request->user();

        foreach ($snippet->getFillable() as $column) {
            $snippet->setAttribute(
                $column,
                $snippet_revision->getAttributeValue($column)
            );
        }

        $snippet->save();

        return (new Resources\Snippet($snippet))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Snippet revision.
     *
     * @route GET /api/cms/snippets/revision/{snippet_revision} playground.cms.api.snippets.revision
     */
    public function revision(
        SnippetRevision $snippet_revision,
        Requests\Snippet\ShowRevisionRequest $request
    ): JsonResponse|Resources\SnippetRevision {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $snippet_revision->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        return (new Resources\SnippetRevision($snippet_revision))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Snippet resources.
     *
     * @route GET /api/cms/snippets/{snippet}/revisions playground.cms.api.snippets.revisions
     */
    public function revisions(
        Snippet $snippet,
        Requests\Snippet\RevisionsRequest $request
    ): JsonResponse|Resources\SnippetRevisionCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = $snippet->revisions();

        $query->sort($validated['sort'] ?? null);

        if (! empty($validated['filter']) && is_array($validated['filter'])) {
            $query->filterTrash($validated['filter']['trash'] ?? null);

            $query->filterIds(
                $request->getPaginationIds(),
                $validated
            );

            $query->filterFlags(
                $request->getPaginationFlags(),
                $validated
            );

            $query->filterDates(
                $request->getPaginationDates(),
                $validated
            );

            $query->filterColumns(
                $request->getPaginationColumns(),
                $validated
            );
        }

        $perPage = ! empty($validated['perPage']) && is_int($validated['perPage']) ? $validated['perPage'] : null;
        $paginator = $query->paginate($perPage);

        $paginator->appends($validated);

        return (new Resources\SnippetRevisionCollection($paginator))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Save a revision of a Snippet.
     */
    public function saveRevision(Snippet $snippet): SnippetRevision
    {
        $revision = new SnippetRevision($snippet->toArray());

        $revision->created_by_id = $snippet->created_by_id;
        $revision->modified_by_id = $snippet->modified_by_id;
        $revision->owned_by_id = $snippet->owned_by_id;
        $revision->snippet_id = $snippet->id;

        $r = SnippetRevision::where('snippet_id', $snippet->id)->max('revision');
        $r = ! is_numeric($r) || empty($r) || $r < 0 ? 0 : (int) $r;
        $r++;

        $revision->revision = $r;
        $snippet->revision = $r;

        $revision->saveOrFail();

        return $revision;
    }

    /**
     * Display the Snippet resource.
     *
     * @route GET /api/cms/snippets/{snippet} playground.cms.api.snippets.show
     */
    public function show(
        Snippet $snippet,
        Requests\Snippet\ShowRequest $request
    ): JsonResponse|Resources\Snippet {
        return (new Resources\Snippet($snippet))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Snippet resource in storage.
     *
     * @route POST /api/cms/snippets playground.cms.api.snippets.post
     */
    public function store(
        Requests\Snippet\StoreRequest $request
    ): Response|JsonResponse|Resources\Snippet {
        $validated = $request->validated();

        $user = $request->user();

        $snippet = new Snippet($validated);

        $snippet->created_by_id = $user?->id;

        $snippet->save();

        return (new Resources\Snippet($snippet))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Snippet resource in storage.
     *
     * @route DELETE /api/cms/snippets/lock/{snippet} playground.cms.api.snippets.unlock
     */
    public function unlock(
        Snippet $snippet,
        Requests\Snippet\UnlockRequest $request
    ): JsonResponse|Resources\Snippet {

        $validated = $request->validated();

        $user = $request->user();

        $snippet->locked = false;

        if ($user?->id) {
            $snippet->modified_by_id = $user->id;
        }

        $snippet->save();

        return (new Resources\Snippet($snippet))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Snippet resource in storage.
     *
     * @route PATCH /api/cms/snippets/{snippet} playground.cms.api.snippets.patch
     */
    public function update(
        Snippet $snippet,
        Requests\Snippet\UpdateRequest $request
    ): JsonResponse {

        $this->saveRevision($snippet);

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $snippet->modified_by_id = $user->id;
        }

        $snippet->update($validated);

        return (new Resources\Snippet($snippet))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}
