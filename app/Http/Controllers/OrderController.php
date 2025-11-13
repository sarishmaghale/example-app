<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\Billing;
use App\Models\Product;
use App\Models\Station;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService) {}

    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();
        $stationInfo = $this->orderService->addOrdersToStation($data);
        return redirect()->route('stations.show', ['station' => $stationInfo]);
    }

    //remove item from Orders
    public function delete(DeleteOrderRequest $request)
    {
        $data = $request->validatedData();
        $stationInfo = $this->orderService->removeOrderFromStation($data);
        return redirect()->route('stations.show', ['station' => $stationInfo]);
    }
}
