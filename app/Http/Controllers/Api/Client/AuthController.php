<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\OTPController;
use App\Http\Requests\Client\Auth\ClientLogin;
use App\Http\Requests\Client\Auth\ClientRegister;
use App\Http\Resources\User\CustomUserResource;
use App\Interfaces\EmailInterface;
use App\Models\User;
use App\Notifications\OTPVerification;
use App\Traits\AuthenticationTrait;

/**
 * @group Auth Module
 * @unauthenticated
 */
class AuthController extends Controller
{
    use AuthenticationTrait{
        login as TraitLogin;
    }

    protected $emailInterface;
    protected $OTPController;

    public function __construct(EmailInterface $emailInterface, OTPController $OTPController)
    {
        $this->emailInterface = $emailInterface;
        $this->OTPController = $OTPController;
    }

    /**
     * Register
     *
     * @responseFile 200 scenario="login successful" responses/ok.json
     * @responseFile 422 scenario="invalid data passed" responses/unprocessable_entity.json
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * */
    public function register(ClientRegister $request) {
        $user = User::create($request->validated());
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        $this->OTPController->generateOTP($user);
        $user->notify(new OTPVerification());

        return ok_response(new CustomUserResource(['user' => $user, 'token' => $token]));
    }

    /**
     * Login
     *
     * @responseFile 200 scenario="login successful" responses/ok.json
     * @responseFile 422 scenario="invalid data passed" responses/unprocessable_entity.json
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * */
    public function login(ClientLogin $request) {
        return $this->TraitLogin($request);
    }
}
