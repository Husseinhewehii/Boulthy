<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Transaction\TransactionUpdate;
use App\Http\Resources\Transaction\TransactionResource;
use App\Models\Transaction;
use App\Repositories\Transaction\TransactionRepository;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $transactionRepository;
    protected $transactionService;

    public function __construct(TransactionRepository $transactionRepository, TransactionService $transactionService) {
        $this->authorizeResource(Transaction::class, "transaction");
        $this->transactionRepository = $transactionRepository;
        $this->transactionService = $transactionService;
    }

    public function index()
    {
        return ok_response(collectionFormat(TransactionResource::class, $this->transactionRepository->getTransactions()));
    }

    public function show(Transaction $transaction)
    {
        return ok_response(new TransactionResource($transaction));
    }
}
