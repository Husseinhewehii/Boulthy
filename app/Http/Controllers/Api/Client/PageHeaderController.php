<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageHeader\PageHeaderResource;
use App\Repositories\PageHeader\PageHeaderRepository;
use Illuminate\Http\Request;

/**
 * @group PageHeader Module
 */
class PageHeaderController extends Controller
{
    protected $pageHeaderRepository;

    public function __construct(PageHeaderRepository $pageHeaderRepository) {
        $this->pageHeaderRepository = $pageHeaderRepository;
    }

    /**
     * Get All PageHeaders
     *
     * @queryParam filter[key] Filter by key. Example: key
     *
     * @apiResourceCollection App\Http\Resources\PageHeader\PageHeaderResource
     * @apiResourceModel App\Models\PageHeader
     */
    public function index()
    {
        return ok_response(collectionFormat(PageHeaderResource::class, $this->pageHeaderRepository->getPageHeadersWithoutPagination()));
    }
}
