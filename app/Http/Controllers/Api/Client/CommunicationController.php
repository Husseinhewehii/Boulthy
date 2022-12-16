<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Communication\CommunicationStore;
use App\Interfaces\EmailInterface;
use App\Mail\SendCommunication;

class CommunicationController extends Controller
{
    protected $emailInterface;

    public function __construct(EmailInterface $emailInterface) {
        $this->emailInterface = $emailInterface;
    }

    public function communicate(CommunicationStore $request)
    {
        $this->emailInterface->sendEmail(env("CUSTOMER_SERVICE_EMAIL"), SendCommunication::class, $request->validated());
        return ok_response();
    }
}
