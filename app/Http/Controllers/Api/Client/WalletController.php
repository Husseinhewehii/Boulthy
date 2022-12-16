<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Wallet\WalletResource;
use App\Models\Wallet;

class WalletController extends Controller
{
    public function show(Wallet $wallet)
    {
        return $wallet->belongsToThis(auth()->user()) ? ok_response(new WalletResource($wallet)) : forbidden_response();
    }
}
