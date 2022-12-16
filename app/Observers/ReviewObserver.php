<?php

namespace App\Observers;

use DGvai\Review\Review;

class ReviewObserver
{
    public function saved(Review $review)
    {
        $model = $review->model_type::findOrFail($review->model_id);
        $model->rate = $model->rating;
        $model->save();
    }
}
