<?php

namespace App\Services;

use App\Interfaces\EmailInterface;
use App\Jobs\SendEmailJob;

class EmailService implements EmailInterface{
    public function sendEmail($email, $mailer, $data)
    {
        dispatch(new SendEmailJob($email, $mailer, $data));
    }
}
