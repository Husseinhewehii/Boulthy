<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OTPRequest;
use App\Http\Resources\User\UserResource;
use App\Interfaces\EmailInterface;
use App\Interfaces\NotificationInterface;
use App\Mail\RegistrationPromo;
use App\Notifications\OTPVerification;
use App\Services\PromoService;

class OTPController extends Controller
{
    protected $notificationInterface;
    protected $promoService;

    public function __construct(NotificationInterface $notificationInterface, PromoService $promoService)
    {
        $this->notificationInterface = $notificationInterface;
        $this->promoService = $promoService;
    }

    public function verify(OTPRequest $request)
    {
        $user = auth()->user();

        if($request->input('otp') == $user->otp)
        {
            $user->resetOTP();
            $user->email_verified_at = now();
            $user->save();

            // $promo = $this->promoService->createPromoForNewUser($user);
            // $this->notificationInterface->registrationPromo(["user" => $user, "promo" => $promo]);

            return ok_response(new UserResource($user), "Verified");
        }
        return unauthorized_response("Code InCorrect");
    }

    public function sendVerificationCode()
    {
        $user = auth()->user();
        $this->generateOTP($user);
        $user->notify(new OTPVerification());
        return ok_response("Verification Code Sent");
    }

    public function generateOTP($user)
    {
        $user->timestamps = false;
        $user->otp = rand(100000, 999999);
        $user->otp_expiration = now()->addMinutes(10);
        $user->save();
    }
}
