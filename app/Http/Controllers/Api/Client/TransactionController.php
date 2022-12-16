<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Transaction\TransactionResource;
use App\Models\Transaction;
use App\Repositories\Transaction\TransactionRepository;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository) {
        $this->transactionRepository = $transactionRepository;
    }

    public function index(Request $request)
    {
        $filter = $request->filter;
        $filter['user_id'] = auth()->id();
        $request->request->add(['filter' => $filter]);

        return ok_response(collectionFormat(TransactionResource::class, $this->transactionRepository->getTransactions()));
    }

    public function show(Transaction $transaction)
    {
        if(!$transaction->belongsToThis(auth()->user())){
            return forbidden_response();
        }

        return ok_response(new TransactionResource($transaction));
    }

}
