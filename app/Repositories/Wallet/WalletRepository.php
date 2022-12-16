<?php

namespace App\Repositories\Wallet;

use App\Models\Wallet;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class WalletRepository
{
    public function getWallets()
    {
        return QueryBuilder::for(Wallet::class)
        ->allowedFilters(["user_id", "order_id"])
        ->allowedSorts(["user_id", "order_id"])
        ->paginate(10);
    }

}
