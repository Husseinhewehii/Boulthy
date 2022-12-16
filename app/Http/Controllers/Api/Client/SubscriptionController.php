<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Subscription\SubscriptionStore;
use App\Interfaces\EmailInterface;
use App\Mail\SendSubscription;
use App\Services\SubscriptionService;

/**
 * @group Subscription
 */
class SubscriptionController extends Controller
{
    protected $emailInterface;
    protected $subscriptionService;

    public function __construct(EmailInterface $emailInterface, SubscriptionService $subscriptionService) {
        $this->emailInterface = $emailInterface;
        $this->subscriptionService = $subscriptionService;
    }

    /**
 * Subscribe
 *
 * Subscribe
 *
 * @responseFile 200 scenario="success" responses/ok.json
 * @responseFile 422 scenario="invalid data passed" responses/unprocessable_entity.json
 */
    public function subscribe(SubscriptionStore $request)
    {
        $this->subscriptionService->createSubscription($request);
        $this->emailInterface->sendEmail($request->email, SendSubscription::class, $request->validated());
        return ok_response();
    }
}
