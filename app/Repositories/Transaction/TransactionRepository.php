<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TransactionRepository
{
    public function getTransactions()
    {
        return QueryBuilder::for(Transaction::class)
        ->allowedFilters(["id", "user_id", "order_id", "entry", "type", "amount"])
        ->allowedSorts(["id", "user_id", "order_id", "type", "entry", "amount"])
        ->paginate(10);
    }

}
