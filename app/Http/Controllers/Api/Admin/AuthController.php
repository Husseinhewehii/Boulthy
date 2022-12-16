<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\AdminLogin;
use App\Traits\AuthenticationTrait;

/**
 * @group Admin Auth Module
 * @unauthenticated
 */
class AuthController extends Controller
{
    use AuthenticationTrait{
        login as TraitLogin;
    }

    /**
     * Admin Login
     *
     * @responseFile 200 scenario="login successful" responses/ok.json
     * @responseFile 422 scenario="invalid data passed" responses/unprocessable_entity.json
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * */
    public function login(AdminLogin $request) {
        return $this->TraitLogin($request);
    }
}
