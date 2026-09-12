<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Cms\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Playground\Cms\Api\Http\Requests;
use Playground\Cms\Api\Http\Resources;
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
        'model_variable' => 'page',
        'model_variable_plural' => 'pages',
        'module_label' => 'CMS',
        'module_label_plural' => 'CMSs',
        'module_route' => 'playground.cms.api',
        'module_slug' => 'cms',
        'privilege' => 'playground-cms-api:page',
        'table' => 'cms_pages',
    ];

    /**
     * Create the Page resource in storage.
     *
     * @route GET /api/cms/pages/create playground.cms.api.pages.create
     */
    public function create(
        Requests\Page\CreateRequest $request
    ): JsonResponse|Resources\Page {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $page = new Page($validated);

        return new Resources\Page($page)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Page resource in storage.
     *
     * @route GET /api/cms/pages/edit/{page} playground.cms.api.pages.edit
     */
    public function edit(
        Page $page,
        Requests\Page\EditRequest $request
    ): JsonResponse|Resources\Page {

        $packageInfo = $this->packageInfo();

        return new Resources\Page($page)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Page resource from storage.
     *
     * @route DELETE /api/cms/pages/{page} playground.cms.api.pages.destroy
     */
    public function destroy(
        Page $page,
        Requests\Page\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $page->modified_by_id = $user->id;
        }

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
        Requests\Page\LockRequest $request
    ): JsonResponse|Resources\Page {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        if ($user?->id) {
            $page->modified_by_id = $user->id;
        }

        $page->locked = true;

        $page->save();

        return new Resources\Page($page)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Page resources.
     *
     * @route GET /api/cms/pages playground.cms.api.pages
     */
    public function index(
        Requests\Page\IndexRequest $request
    ): JsonResponse|Resources\PageCollection {

        $packageInfo = $this->packageInfo();

        /**
         * @var array{
         *     sort: string|array<mixed>,
         *     filter: array{
         *         trash: string
         *     },
         *     perPage: int
         * } $validated
         */
        $validated = $request->validated();

        $query = Page::addSelect(sprintf('%1$s.*', $packageInfo->table()));

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

        return new Resources\PageCollection($paginator)->response($request);
    }

    /**
     * Restore the Page resource from the trash.
     *
     * @route PUT /api/cms/pages/restore/{page} playground.cms.api.pages.restore
     */
    public function restore(
        Page $page,
        Requests\Page\RestoreRequest $request
    ): JsonResponse|Resources\Page {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        $page->modified_by_id = $user?->id;

        $page->restore();

        return new Resources\Page($page)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Restore the Page resource from the trash.
     *
     * @route PUT /api/cms/pages/revision/{page_revision} playground.cms.api.pages.revision.restore
     */
    public function restoreRevision(
        PageRevision $page_revision,
        Requests\Page\RestoreRevisionRequest $request
    ): JsonResponse|Resources\Page {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        /**
         * @var Page $page
         */
        $page = Page::where(
            'id',
            $page_revision->page_id
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

        return new Resources\Page($page)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Page revision.
     *
     * @route GET /api/cms/pages/revision/{page_revision} playground.cms.api.pages.revision
     */
    public function revision(
        PageRevision $page_revision,
        Requests\Page\ShowRevisionRequest $request
    ): JsonResponse|Resources\PageRevision {

        $packageInfo = $this->packageInfo();

        return new Resources\PageRevision($page_revision)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Page resources.
     *
     * @route GET /api/cms/pages/{page}/revisions playground.cms.api.pages.revisions
     */
    public function revisions(
        Page $page,
        Requests\Page\RevisionsRequest $request
    ): JsonResponse|Resources\PageRevisionCollection {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        /**
         * @var array{
         *     sort: string|array<mixed>,
         *     filter: array{
         *         trash: string
         *     },
         *     perPage: int
         * } $validated
         */
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

        return new Resources\PageRevisionCollection($paginator)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Save a revision of a Page.
     */
    public function saveRevision(Page $page): PageRevision
    {
        /**
         * @var array<string, mixed> $data
         */
        $data = $page->toArray();

        $revision = new PageRevision($data);

        $revision->created_by_id = $page->created_by_id;
        $revision->modified_by_id = $page->modified_by_id;
        $revision->owned_by_id = $page->owned_by_id;
        $revision->page_id = $page->id;

        $r = PageRevision::where('page_id', $page->id)->max('revision');
        $r = ! is_numeric($r) || empty($r) || $r < 0 ? 0 : (int) $r;
        $r++;

        $revision->revision = $r;
        $page->revision = $r;

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
        Requests\Page\ShowRequest $request
    ): JsonResponse|Resources\Page {

        $packageInfo = $this->packageInfo();

        return new Resources\Page($page)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Page resource in storage.
     *
     * @route POST /api/cms/pages playground.cms.api.pages.post
     */
    public function store(
        Requests\Page\StoreRequest $request
    ): Response|JsonResponse|Resources\Page {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $page = new Page($validated);

        $page->created_by_id = $user?->id;

        $page->save();

        return new Resources\Page($page)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Page resource in storage.
     *
     * @route DELETE /api/cms/pages/lock/{page} playground.cms.api.pages.unlock
     */
    public function unlock(
        Page $page,
        Requests\Page\UnlockRequest $request
    ): JsonResponse|Resources\Page {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        $page->locked = false;

        $page->modified_by_id = $user?->id;

        $page->save();

        return new Resources\Page($page)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Page resource in storage.
     *
     * @route PATCH /api/cms/pages/{page} playground.cms.api.pages.patch
     */
    public function update(
        Page $page,
        Requests\Page\UpdateRequest $request
    ): JsonResponse {

        $packageInfo = $this->packageInfo();

        $this->saveRevision($page);

        $validated = $request->validated();

        $user = $request->user();

        $page->modified_by_id = $user?->id;

        $page->update($validated);

        return new Resources\Page($page)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }
}
