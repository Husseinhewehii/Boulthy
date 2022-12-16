<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Wallet\WalletResource;
use App\Models\Wallet;
use App\Repositories\Wallet\WalletRepository;
use App\Services\WalletService;

class WalletController extends Controller
{
    protected $walletRepository;
    protected $walletService;

    public function __construct(WalletRepository $walletRepository, WalletService $walletService) {
        $this->authorizeResource(Wallet::class, "wallet");
        $this->walletRepository = $walletRepository;
        $this->walletService = $walletService;
    }

    public function index()
    {
        return ok_response($this->all());
    }

    public function show(Wallet $wallet)
    {
        return ok_response(new WalletResource($wallet));
    }

    public function all()
    {
        return collectionFormat(WalletResource::class, $this->walletRepository->getWallets());
    }
}
