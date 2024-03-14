<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Cms\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Playground\Cms\Api\Http\Requests\Snippet\CreateRequest;
use Playground\Cms\Api\Http\Requests\Snippet\DestroyRequest;
use Playground\Cms\Api\Http\Requests\Snippet\EditRequest;
use Playground\Cms\Api\Http\Requests\Snippet\IndexRequest;
use Playground\Cms\Api\Http\Requests\Snippet\LockRequest;
use Playground\Cms\Api\Http\Requests\Snippet\RestoreRequest;
use Playground\Cms\Api\Http\Requests\Snippet\RestoreRevisionRequest;
use Playground\Cms\Api\Http\Requests\Snippet\RevisionsRequest;
use Playground\Cms\Api\Http\Requests\Snippet\ShowRequest;
use Playground\Cms\Api\Http\Requests\Snippet\ShowRevisionRequest;
use Playground\Cms\Api\Http\Requests\Snippet\StoreRequest;
use Playground\Cms\Api\Http\Requests\Snippet\UnlockRequest;
use Playground\Cms\Api\Http\Requests\Snippet\UpdateRequest;
use Playground\Cms\Api\Http\Resources\Snippet as SnippetResource;
use Playground\Cms\Api\Http\Resources\SnippetCollection;
use Playground\Cms\Api\Http\Resources\SnippetRevision as SnippetRevisionResource;
use Playground\Cms\Api\Http\Resources\SnippetRevisionCollection;
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
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.cms.api',
        'module_slug' => 'cms',
        'privilege' => 'playground-cms-api:snippet',
        'table' => 'cms_snippets',
    ];

    /**
     * CREATE the Snippet resource in storage.
     *
     * @route GET /api/cms/snippets/create playground.cms.api.snippets.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|SnippetResource {

        $validated = $request->validated();

        $user = $request->user();

        $snippet = new Snippet($validated);

        return (new SnippetResource($snippet))->response($request);
    }

    /**
     * Edit the Snippet resource in storage.
     *
     * @route GET /api/cms/snippets/snippets/edit playground.cms.api.snippets.edit
     */
    public function edit(
        Snippet $snippet,
        EditRequest $request
    ): JsonResponse {
        return (new SnippetResource($snippet))->response($request);
    }

    /**
     * Remove the Snippet resource from storage.
     *
     * @route DELETE /api/cms/snippets/{snippet} playground.cms.api.snippets.destroy
     */
    public function destroy(
        Snippet $snippet,
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

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
        LockRequest $request
    ): JsonResponse|SnippetResource {
        $validated = $request->validated();

        $user = $request->user();

        $snippet->setAttribute('locked', true);

        $snippet->save();

        return (new SnippetResource($snippet))->response($request);
    }

    /**
     * Display a listing of Snippet resources.
     *
     * @route GET /api/cms/snippets playground.cms.api.snippets
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|SnippetCollection {
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
        $paginator = $query->paginate( $perPage);

        $paginator->appends($validated);

        return (new SnippetCollection($paginator))->response($request);
    }

    /**
     * Restore the Snippet resource from the trash.
     *
     * @route PUT /api/cms/snippets/restore/{snippet} playground.cms.api.snippets.restore
     */
    public function restore(
        Snippet $snippet,
        RestoreRequest $request
    ): JsonResponse|SnippetResource {

        $snippet->restore();

        return (new SnippetResource($snippet))->response($request);
    }

    /**
     * Restore the Snippet resource from the trash.
     *
     * @route PUT /api/cms/snippets/revision/{snippet_revision} playground.cms.api.snippets.revision.restore
     */
    public function restoreRevision(
        SnippetRevision $snippet_revision,
        RestoreRevisionRequest $request
    ): JsonResponse|SnippetResource {
        $validated = $request->validated();

        /**
         * @var Snippet $snippet
         */
        $snippet = Snippet::where(
            'id',
            $snippet_revision->getAttributeValue('snippet_id')
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

        return (new SnippetResource($snippet))->response($request);
    }

    /**
     * Display the Snippet revision.
     *
     * @route GET /api/cms/snippets/revision/{snippet_revision} playground.cms.api.snippets.revision
     */
    public function revision(
        SnippetRevision $snippet_revision,
        ShowRevisionRequest $request
    ): JsonResponse|SnippetRevisionResource {
        return (new SnippetRevisionResource($snippet_revision))->response($request);
    }

    /**
     * Display a listing of Snippet resources.
     *
     * @route GET /api/cms/snippets/{snippet}/revisions playground.cms.api.snippets.revisions
     */
    public function revisions(
        Snippet $snippet,
        RevisionsRequest $request
    ): JsonResponse|SnippetRevisionCollection {
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

        return (new SnippetRevisionCollection($paginator))->response($request);
    }

    /**
     * Save a revision of a Snippet.
     */
    public function saveRevision(Snippet $snippet): SnippetRevision
    {
        $revision = new SnippetRevision($snippet->toArray());

        $revision->setAttribute('created_by_id', $snippet->getAttributeValue('created_by_id'));
        $revision->setAttribute('modified_by_id', $snippet->getAttributeValue('modified_by_id'));
        $revision->setAttribute('owned_by_id', $snippet->getAttributeValue('owned_by_id'));
        $revision->setAttribute('snippet_id', $snippet->getAttributeValue('id'));

        $r = SnippetRevision::where('snippet_id', $snippet->id)->max('revision');
        $r = ! is_numeric($r) || empty($r) || $r < 0 ? 0 : (int) $r;
        $r++;

        $revision->setAttribute('revision', $r);
        $snippet->setAttribute('revision', $r);

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
        ShowRequest $request
    ): JsonResponse|SnippetResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $snippet->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        return (new SnippetResource($snippet))->response($request);
    }

    /**
     * Store a newly created API Snippet resource in storage.
     *
     * @route POST /api/cms playground.cms.api.snippets.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|SnippetResource {
        $validated = $request->validated();

        $user = $request->user();

        $snippet = new Snippet($validated);

        $snippet->save();

        return (new SnippetResource($snippet))
            ->response($request)
            ->setStatusCode(201);
    }

    /**
     * Unlock the Snippet resource in storage.
     *
     * @route DELETE /api/cms/snippets/lock/{snippet} playground.cms.api.snippets.unlock
     */
    public function unlock(
        Snippet $snippet,
        UnlockRequest $request
    ): JsonResponse|SnippetResource {
        $validated = $request->validated();

        $user = $request->user();

        $snippet->setAttribute('locked', false);

        $snippet->save();

        return (new SnippetResource($snippet))->response($request);
    }

    /**
     * Update the Snippet resource in storage.
     *
     * @route PATCH /api/cms/snippets/{snippet} playground.cms.api.snippets.patch
     */
    public function update(
        Snippet $snippet,
        UpdateRequest $request
    ): JsonResponse|SnippetResource {
        $validated = $request->validated();

        $user = $request->user();

        $this->saveRevision($snippet);

        $snippet->update($validated);

        return (new SnippetResource($snippet))->response($request);
    }
}
