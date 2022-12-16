<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Partition\UpdatePartition;
use App\Http\Resources\Partition\PartitionResource;
use App\Http\Resources\Partition\PartitionWithTranslatablesResource;
use App\Models\Partition;
use App\Repositories\Partition\PartitionRepository;
use App\Services\PartitionService;

/**
 * @group Admin Partition Module
 */
class PartitionController extends Controller
{
    protected $partitionRepository;
    protected $partitionService;

    public function __construct(PartitionRepository $partitionRepository, PartitionService $partitionService) {
        $this->authorizeResource(Partition::class, "partition");
        $this->partitionRepository = $partitionRepository;
        $this->partitionService = $partitionService;
    }

    /**
     * Get All Partitions
     *
     * @header Authorization Bearer Token
     *
     * @queryParam sort Sort Field by key, group, title, active. Example: key,group,title,active
     * @queryParam filter[key] Filter by key. Example: key
     * @queryParam filter[group] Filter by group. Example: group
     * @queryParam filter[title] Filter by title. Example: title
     * @queryParam filter[active] Filter by active. Example: active
     *
     * @apiResourceCollection App\Http\Resources\Partition\PartitionResource
     * @apiResourceModel App\Models\Partition paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     */
    public function index()
    {
        return ok_response($this->all());
    }

    /**
     * Show Partition
     *
     * @header Authorization Bearer Token
     *
     * @apiResource App\Http\Resources\Partition\PartitionWithTranslatablesResource
     * @apiResourceModel App\Models\Partition paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found Partition" responses/not_found.json
     * */
    public function show(Partition $partition)
    {
        return ok_response(new PartitionWithTranslatablesResource($partition));
    }

    /**
     * Update Partition
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\Partition\PartitionResource
     * @apiResourceModel App\Models\Partition paginate=10
     * @responseFile 422 scenario="invalid data passed" responses/unprocessable_entity.json
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found Partition" responses/not_found.json
     * */
    public function update(UpdatePartition $request, Partition $partition)
    {
        $this->partitionService->updatePartition($request, $partition);
        return ok_response($this->all());
    }

    private function all(){
        return paginatedCollectionFormat(PartitionResource::class, $this->partitionRepository->getPartitions());
    }
}
