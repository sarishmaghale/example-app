<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\DeleteOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

class OrderApiController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected OrderService $orderService) {}

    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();
        $ordersOfStation = $this->orderService->addOrdersToStation($data);
        if ($ordersOfStation) {
            return $this->successResponse($ordersOfStation, "Order added successfully");
        }
        return $this->errorResponse("failed to add");
    }

    public function show(int $id)
    {
        $order = $this->orderService->fetchOrderById($id);
        if ($order) {
            return $this->successResponse($order, "Order displayed successfully");
        }
        return $this->errorResponse();
    }

    public function destroy(DeleteOrderRequest $request)
    {
        $data = $request->validatedData();
        $renewedOrders = $this->orderService->removeOrderFromStation($data);
        if ($renewedOrders) {
            return $this->successResponse("Order removed successfully");
        }
        return $this->errorResponse();
    }

    public function update(UpdateOrderRequest $request, int $id)
    {
        $data = $request->validated();
        $updatedOrder = $this->orderService->updateOrder($data, $id);
        $response = $updatedOrder !== null ?
            $this->successResponse($updatedOrder, "Order updated successfully") :
            $this->errorResponse();
        return $response;
    }
}
