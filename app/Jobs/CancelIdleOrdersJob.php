<?php

namespace App\Jobs;

use App\Models\Order;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CancelIdleOrdersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */


    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(OrderService $orderService)
    {
        $expDate = Carbon::now()->subHours(24);
        $pendingOrders = Order::pending()->where('created_at', '<' , $expDate)->get();
        foreach ($pendingOrders as $pendingOrder) {
            $orderService->cancelOrder($pendingOrder);
        }
    }
}
