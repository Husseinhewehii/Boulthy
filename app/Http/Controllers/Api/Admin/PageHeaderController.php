<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PageHeader\UpdatePageHeader;
use App\Http\Resources\PageHeader\PageHeaderResource;
use App\Models\PageHeader;
use App\Repositories\PageHeader\PageHeaderRepository;
use App\Services\PageHeaderService;


/**
 * @group Admin PageHeader Module
 */
class PageHeaderController extends Controller
{
    protected $pageHeaderRepository;
    protected $pageHeaderService;

    public function __construct(PageHeaderRepository $pageHeaderRepository, PageHeaderService $pageHeaderService) {
        $this->authorizeResource(PageHeader::class, "pageHeader");
        $this->pageHeaderRepository = $pageHeaderRepository;
        $this->pageHeaderService = $pageHeaderService;
    }

    /**
     * Get All PageHeaders
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\PageHeader\PageHeaderResource
     * @apiResourceModel App\Models\PageHeader paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     */
    public function index()
    {
        return ok_response($this->all());
    }

    /**
     * Show PageHeader
     *
     * @header Authorization Bearer Token
     *
     * @apiResource App\Http\Resources\PageHeader\PageHeaderResource
     * @apiResourceModel App\Models\PageHeader paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found PageHeader" responses/not_found.json
     * */
    public function show(PageHeader $pageHeader)
    {
        return ok_response(new PageHeaderResource($pageHeader));
    }

    /**
     * Update PageHeader
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\PageHeader\PageHeaderResource
     * @apiResourceModel App\Models\PageHeader paginate=10
     * @responseFile 422 scenario="invalid data passed" responses/unprocessable_entity.json
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found PageHeader" responses/not_found.json
     * */
    public function update(UpdatePageHeader $request, PageHeader $pageHeader)
    {
        $this->pageHeaderService->updatePageHeader($request, $pageHeader);
        return ok_response($this->all());
    }

    private function all(){
        return paginatedCollectionFormat(PageHeaderResource::class, $this->pageHeaderRepository->getPageHeaders());
    }
}
