<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\FinalizeRequest;
use App\Http\Requests\Admin\Order\ShipRequest;
use App\Http\Resources\Order\OrderResource;
use App\Jobs\CancelIdleOrdersJob;
use App\Models\Order;
use App\Repositories\Order\OrderRepository;
use App\Services\OrderService;
use Illuminate\Http\Request;

/**
 * @group Admin Order Module
 */
class OrderController extends Controller
{
    protected $orderRepository;
    protected $orderService;

    public function __construct(OrderRepository $orderRepository, OrderService $orderService)
    {
        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
    }

    /**
     * Get All Orders
     *
     * @header Authorization Bearer Token
     * @queryParam filter[status] Filter by status values: 1,2,3,4 which are pending, in_transit, delivered and cancelled respectively . Example: 1
     * @queryParam filter[email] Filter by email. Example: beaulthy@green.com
     * @queryParam filter[user_id] Filter by user ID. Example: 2
     * @queryParam filter[phone] Filter by phone. Example: 01123758532
     * @queryParam filter[city_id] Filter by city id. Example: 2
     * @queryParam filter[district_id] Filter by district id. Example: 2
     * @queryParam filter[payment_method] Filter by payment_method values: 1 or 2 or 3 which are card payment, cash on delivery and card on delivery  respectively. Example: 1
     * @queryParam sort Sort Field by status, email, payment_method, city_id, district_id. Example: 1, beaulthy@green.com, 1, 1, 2
     *
     * @apiResourceCollection App\Http\Resources\Order\OrderResource
     * @apiResourceModel App\Models\Order
     */
    public function index(Request $request)
    {
        return ok_response(paginatedCollectionFormat(OrderResource::class, $this->orderRepository->getOrders()));
    }

    /**
     * Shows Order
     *
     * @header Authorization Bearer Token
     *
     * @apiResource App\Http\Resources\Order\OrderResource
     * @apiResourceModel App\Models\Order
     * @responseFile 404 scenario="not found Order" responses/not_found.json
     * */
    public function show(Order $order)
    {
        return ok_response(new OrderResource($order));
    }

    public function sendOrder(Order $order){
        $this->orderService->sendOrder($order);
        return ok_response(new OrderResource($order), "Your Order Is In Transit");
    }

    public function ship(ShipRequest $request, Order $order)
    {
        if(!auth()->user()->can("update orders")){
            return forbidden_response();
        }

        $this->orderService->shipOrder($order);
        return ok_response(new OrderResource($order));
    }

    /**
     * Finalize Order
     *
     * @header Authorization Bearer Token
     *
     * @apiResource App\Http\Resources\Order\OrderResource
     * @apiResourceModel App\Models\Order
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found Order " responses/not_found.json
     * */
    public function finalize(FinalizeRequest $request, Order $order)
    {
        if(!auth()->user()->can("update orders")){
            return forbidden_response();
        }

        $this->orderService->finalizeOrder($order);
        return ok_response(new OrderResource($order));
    }

    public function manage()
    {
        // $expDate = Carbon::now()->subMinutes(10);
        // $pendingOrders = Order::pending()->where('created_at', '<' , $expDate)->get();
        // dd($pendingOrders);
        dispatch(new CancelIdleOrdersJob());
    }
}
