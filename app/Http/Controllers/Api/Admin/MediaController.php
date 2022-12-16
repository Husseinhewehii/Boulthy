<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
    public function destroy(Media $media)
    {
        $model = $media->model_type::findOrFail($media->model_id);
        $tableName = $model->getTable();

        if(!auth()->user()->can("update $tableName")){
            return forbidden_response();
        }

        $collection = $media->collection_name;
        $media->delete();
        return ok_response(get_media_gallery_filtered($model, $collection));
    }
}
