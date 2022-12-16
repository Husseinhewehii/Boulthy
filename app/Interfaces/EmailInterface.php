<?php

namespace App\Interfaces;


interface EmailInterface{
    public function sendEmail($email, $mailer, $data);
}
