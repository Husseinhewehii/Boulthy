<?php

namespace App\Services;

use App\Constants\Media_Collections;
use App\Models\Partition;

class PartitionService
{
    public function createPartition($request)
    {
        $partition = Partition::create($request->validated());
        add_media_item($partition, $request->photo, Media_Collections::PARTITION);
    }

    public function updatePartition($request, $partition)
    {
        $partition->update($request->validated());
        add_media_item($partition, $request->photo, Media_Collections::PARTITION);
    }
}
