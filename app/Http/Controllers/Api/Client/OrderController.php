<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Order\CheckoutRequest;
use App\Http\Requests\Client\Order\OrderCancelRequest;
use App\Http\Requests\Client\Order\OrderUpdate;
use App\Http\Requests\Client\Order\OrderPromoRequest;
use App\Http\Resources\Order\OrderResource;
use App\Interfaces\PaymentInterface;
use App\Jobs\CancelOrderJob;
use App\Jobs\SendOrderJob;
use App\Models\Order;
use App\Repositories\Order\OrderRepository;
use App\Services\OrderItemService;
use App\Services\OrderService;
use App\Services\TransactionService;
use Illuminate\Http\Request;

/**
 * @group Order Module
 */
class OrderController extends Controller
{
    protected $orderRepository;
    protected $orderService;
    protected $orderItemService;

    public function __construct(OrderRepository $orderRepository, OrderService $orderService, OrderItemService $orderItemService)
    {
        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
        $this->orderItemService = $orderItemService;
    }

    /**
     * Get All Orders Authenticated Client
     *
     * @header Authorization Bearer Token
     * @queryParam filter[status] Filter by status values: 1,2,3,4 which are pending, in_transit, delivered and cancelled respectively . Example: 1
     * @queryParam filter[email] Filter by email. Example: beaulthy@green.com
     * @queryParam filter[phone] Filter by phone. Example: 01123758532
     * @queryParam filter[city_id] Filter by city id. Example: 2
     * @queryParam filter[district_id] Filter by district id. Example: 2
     * @queryParam filter[payment_method] Filter by payment_method values: 1 or 2 or 3 which are card payment, cash on delivery and card on delivery respectively. Example: 1
     * @queryParam sort Sort Field by status, email, payment_method, city_id, district_id. Example: 1, beaulthy@green.com, 1, 1, 2
     *
     * @apiResourceCollection App\Http\Resources\Order\OrderResource
     * @apiResourceModel App\Models\Order
     */
    public function index(Request $request)
    {
        $filter = $request->filter;
        $filter['user_id'] = auth()->id();
        $request->request->add(['filter' => $filter]);

        return ok_response(paginatedCollectionFormat(OrderResource::class, $this->orderRepository->getOrders()));
    }

    /**
     * Update Order
     *
     * @header Authorization Bearer Token
     *
     * @apiResourceCollection App\Http\Resources\Order\OrderResource
     * @apiResourceModel App\Models\Order paginate=10
     * @responseFile 401 scenario="unauthorized" responses/unauthorized.json
     * @responseFile 403 scenario="not allowed to perform this action" responses/forbidden.json
     * @responseFile 404 scenario="not found Order " responses/not_found.json
     * */
    public function update(OrderUpdate $request, Order $order)
    {
        $this->orderService->updateOrder($request, $order);
        return ok_response($order);
    }

    /**
     * Shows Order an order of the authenticated user
     *
     * @header Authorization Bearer Token
     *
     * @apiResource App\Http\Resources\Order\OrderResource
     * @apiResourceModel App\Models\Order
     * @responseFile 404 scenario="not found Order" responses/not_found.json
     * */
    public function show(Order $order)
    {
        if(!$order->belongsToThis(auth()->user())){
            return forbidden_response();
        }

        if($order->hasOrderItems()){
            $this->orderItemService->reUpdateCart($order->orderItems);
        }

        return ok_response(new OrderResource($order));
    }

    public function addPromo(OrderPromoRequest $request, Order $order)
    {
        $order = $this->orderService->addPromoToOrder($request, $order);
        return ok_response(new OrderResource($order));
    }

    public function cancel(OrderCancelRequest $request, Order $order)
    {
        $order = $this->orderService->cancelOrder($order);
        return ok_response([], "Your Order Has Been Cancelled");
    }


    /**
     * Checkout
     *
     * @urlParam order integer required The ID of the Order.
     * @header Authorization Bearer Token
     *
     * @apiResource App\Http\Resources\Order\OrderResource
     * @apiResourceModel App\Models\Order
     * @responseFile 404 scenario="not found Order" responses/not_found.json
     * */
    public function checkout(CheckoutRequest $request, Order $order)
    {
        $order->update($request->validated());

        if($order->isCardPayment()){
            $paymentLink = $this->orderService->getPaymentLink($order);
            return ok_response($paymentLink);
        }
        $this->orderService->sendOrder($order);
        return ok_response(new OrderResource($order), "Your Order Is In Transit");
    }
}
