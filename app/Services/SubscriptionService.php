<?php

namespace App\Services;

use App\Models\Subscription;

class SubscriptionService
{
    public function createSubscription($request)
    {
        $subscription = Subscription::create($request->validated());
        return $subscription;
    }
}
