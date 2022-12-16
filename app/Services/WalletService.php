<?php

namespace App\Services;

use App\Interfaces\NotificationInterface;
use App\Models\Wallet;

class WalletService
{
    protected $transactionService;
    protected $notificationInterface;
    protected $commissionService;

    public function __construct(
        TransactionService $transactionService, NotificationInterface $notificationInterface,
        CommissionService $commissionService)
    {
        $this->transactionService = $transactionService;
        $this->notificationInterface = $notificationInterface;
        $this->commissionService = $commissionService;
    }

    public function createWallet($request)
    {
        $wallet = Wallet::create($request->validated());
        return $wallet;
    }

    public function addCommissions($order)
    {
        $associatePromos = $order->associatePromos;
        foreach ($associatePromos as $associatePromo) {
            $associate = $associatePromo->user;

            $commission = $this->commissionService->createCommission($order, $associate);
            $commissionAmount = $commission->amount;

            $this->addCommissionToWallet($commissionAmount, $associate);

            $transaction = $this->transactionService->createCommissionTransaction($order, $associate, $commissionAmount);
            $this->notificationInterface->commissionAdded($transaction);
        }
    }

    public function reverseCommissions($order)
    {
        $commissions = $order->commissions;
        foreach ($commissions as $commission) {
            $associate = $commission->user;

            $commissionAmount = $commission->amount;
            $commission->delete();

            $this->deductCommissionFromWallet($commissionAmount, $associate);

            $transaction = $this->transactionService->createReversionTransaction($order, $associate, $commissionAmount);
            $this->notificationInterface->commissionReversed($transaction);
        }
    }

    private function addCommissionToWallet($commissionAmount, $associate)
    {
        $wallet = Wallet::firstorCreate(["user_id" => $associate->id]);
        $wallet->balance += $commissionAmount;
        $wallet->save();
    }

    private function deductCommissionFromWallet($commissionAmount, $associate)
    {
        $wallet = $associate->wallet;
        $wallet->balance -= $commissionAmount;
        $wallet->save();
    }

}
