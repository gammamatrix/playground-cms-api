<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Cms\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Playground\Cms\Api\Http\Requests\Page\CreateRequest;
use Playground\Cms\Api\Http\Requests\Page\DestroyRequest;
use Playground\Cms\Api\Http\Requests\Page\EditRequest;
use Playground\Cms\Api\Http\Requests\Page\IndexRequest;
use Playground\Cms\Api\Http\Requests\Page\LockRequest;
use Playground\Cms\Api\Http\Requests\Page\RestoreRequest;
use Playground\Cms\Api\Http\Requests\Page\RestoreRevisionRequest;
use Playground\Cms\Api\Http\Requests\Page\RevisionsRequest;
use Playground\Cms\Api\Http\Requests\Page\ShowRequest;
use Playground\Cms\Api\Http\Requests\Page\ShowRevisionRequest;
use Playground\Cms\Api\Http\Requests\Page\StoreRequest;
use Playground\Cms\Api\Http\Requests\Page\UnlockRequest;
use Playground\Cms\Api\Http\Requests\Page\UpdateRequest;
use Playground\Cms\Api\Http\Resources\Page as PageResource;
use Playground\Cms\Api\Http\Resources\PageCollection;
use Playground\Cms\Api\Http\Resources\PageRevision as PageRevisionResource;
use Playground\Cms\Api\Http\Resources\PageRevisionCollection;
use Playground\Cms\Models\Page;
use Playground\Cms\Models\PageRevision;

/**
 * \Playground\Cms\Api\Http\Controllers\PageController
 */
class PageController extends Controller
{
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
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.cms.api',
        'module_slug' => 'cms',
        'privilege' => 'playground-cms-api:page',
        'table' => 'cms_pages',
    ];

    /**
     * CREATE the Page resource in storage.
     *
     * @route GET /api/cms/pages/create playground.cms.api.pages.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|PageResource {

        $validated = $request->validated();

        $user = $request->user();

        $page = new Page($validated);

        return (new PageResource($page))->response($request);
    }

    /**
     * Edit the Page resource in storage.
     *
     * @route GET /api/cms/pages/pages/edit playground.cms.api.pages.edit
     */
    public function edit(
        Page $page,
        EditRequest $request
    ): JsonResponse|PageResource {
        return (new PageResource($page))->response($request);
    }

    /**
     * Remove the Page resource from storage.
     *
     * @route DELETE /api/cms/pages/{page} playground.cms.api.pages.destroy
     */
    public function destroy(
        Page $page,
        DestroyRequest $request
    ): Response {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $page->delete();
        } else {
            $page->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Page resource in storage.
     *
     * @route PUT /api/cms/pages/{page} playground.cms.api.pages.lock
     */
    public function lock(
        Page $page,
        LockRequest $request
    ): JsonResponse|PageResource {
        $validated = $request->validated();

        $user = $request->user();

        $page->setAttribute('locked', true);

        $page->save();

        return (new PageResource($page))->response($request);
    }

    /**
     * Display a listing of Page resources.
     *
     * @route GET /api/cms/pages playground.cms.api.pages
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|PageCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Page::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new PageCollection($paginator))->response($request);

    }

    /**
     * Restore the Page resource from the trash.
     *
     * @route PUT /api/cms/pages/restore/{page} playground.cms.api.pages.restore
     */
    public function restore(
        Page $page,
        RestoreRequest $request
    ): JsonResponse|PageResource {

        $page->restore();

        return (new PageResource($page))->response($request);
    }

    /**
     * Restore the Page resource from the trash.
     *
     * @route PUT /api/cms/pages/revision/{page_revision} playground.cms.api.pages.revision.restore
     */
    public function restoreRevision(
        PageRevision $page_revision,
        RestoreRevisionRequest $request
    ): JsonResponse|PageResource {
        $validated = $request->validated();

        /**
         * @var Page $page
         */
        $page = Page::where(
            'id',
            $page_revision->getAttributeValue('page_id')
        )->firstOrFail();

        $this->saveRevision($page);

        $user = $request->user();

        foreach ($page->getFillable() as $column) {
            $page->setAttribute(
                $column,
                $page_revision->getAttributeValue($column)
            );
        }

        $page->save();

        return (new PageResource($page))->response($request);
    }

    /**
     * Display the Page revision.
     *
     * @route GET /api/cms/pages/revision/{page_revision} playground.cms.api.pages.revision
     */
    public function revision(
        PageRevision $page_revision,
        ShowRevisionRequest $request
    ): JsonResponse|PageRevisionResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $page_revision->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        return (new PageRevisionResource($page_revision))->response($request);
    }

    /**
     * Display a listing of Page resources.
     *
     * @route GET /api/cms/pages/{page}/revisions playground.cms.api.pages.revisions
     */
    public function revisions(
        Page $page,
        RevisionsRequest $request
    ): JsonResponse|PageRevisionCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = $page->revisions();

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

        return (new PageRevisionCollection($paginator))->response($request);
    }

    /**
     * Save a revision of a Page.
     */
    public function saveRevision(Page $page): PageRevision
    {
        $revision = new PageRevision($page->toArray());

        $revision->setAttribute('created_by_id', $page->getAttributeValue('created_by_id'));
        $revision->setAttribute('modified_by_id', $page->getAttributeValue('modified_by_id'));
        $revision->setAttribute('owned_by_id', $page->getAttributeValue('owned_by_id'));
        $revision->setAttribute('page_id', $page->getAttributeValue('id'));

        $r = PageRevision::where('page_id', $page->id)->max('revision');
        $r = ! is_numeric($r) || empty($r) || $r < 0 ? 0 : (int) $r;
        $r++;

        $revision->setAttribute('revision', $r);
        $page->setAttribute('revision', $r);

        $revision->saveOrFail();

        return $revision;
    }

    /**
     * Display the Page resource.
     *
     * @route GET /api/cms/pages/{page} playground.cms.api.pages.show
     */
    public function show(
        Page $page,
        ShowRequest $request
    ): JsonResponse|PageResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $page->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        return (new PageResource($page))->response($request);
    }

    /**
     * Store a newly created API Page resource in storage.
     *
     * @route POST /api/cms playground.cms.api.pages.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|PageResource {
        $validated = $request->validated();

        $user = $request->user();

        $page = new Page($validated);

        $page->save();

        return (new PageResource($page))
            ->response($request)
            ->setStatusCode(201);
    }

    /**
     * Unlock the Page resource in storage.
     *
     * @route DELETE /api/cms/pages/lock/{page} playground.cms.api.pages.unlock
     */
    public function unlock(
        Page $page,
        UnlockRequest $request
    ): JsonResponse|PageResource {
        $validated = $request->validated();

        $user = $request->user();

        $page->setAttribute('locked', false);

        $page->save();

        return (new PageResource($page))->response($request);
    }

    /**
     * Update the Page resource in storage.
     *
     * @route PATCH /api/cms/pages/{page} playground.cms.api.pages.patch
     */
    public function update(
        Page $page,
        UpdateRequest $request
    ): JsonResponse|PageResource {
        $validated = $request->validated();

        $user = $request->user();

        $this->saveRevision($page);

        $page->update($validated);

        return (new PageResource($page))->response($request);
    }
}
