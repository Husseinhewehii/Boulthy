<?php

namespace App\Services;

use App\Constants\TransactionEntries;
use App\Constants\TransactionTypes;
use App\Models\Transaction;

class TransactionService
{
    public function createTransaction($data)
    {
        $transaction = Transaction::create($data);
        return $transaction;
    }

    public function createSalesTransaction($order)
    {
        $data = [
            "order_id" => $order->id,
            "user_id" => $order->user_id,
            "type" => TransactionTypes::SALES,
            "entry" => TransactionEntries::CREDIT,
            "amount" => $order->final_total,
        ];
        return $this->createTransaction($data);
    }

    public function createRefundTransaction($order)
    {
        $data = [
            "order_id" => $order->id,
            "user_id" => $order->user_id,
            "type" => TransactionTypes::REFUND,
            "entry" => TransactionEntries::DEBIT,
            "amount" => $order->final_total,
        ];
        return $this->createTransaction($data);
    }

    public function createCommissionTransaction($order, $user, $commission)
    {
        $data = [
            "order_id" => $order->id,
            "user_id" => $user->id,
            "type" => TransactionTypes::COMMISSION,
            "entry" => TransactionEntries::DEBIT,
            "amount" => $commission,
        ];
        return $this->createTransaction($data);
    }

    public function createReversionTransaction($order, $user, $commission)
    {
        $data = [
            "order_id" => $order->id,
            "user_id" => $user->id,
            "type" => TransactionTypes::REVERSION,
            "entry" => TransactionEntries::CREDIT,
            "amount" => $commission,
        ];
        return $this->createTransaction($data);
    }
}
