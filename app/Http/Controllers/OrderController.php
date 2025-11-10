<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Billing;
use App\Models\Product;
use App\Models\Station;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function store(Request $request)
    {
        $data = [
            'station_id' => $request->station_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ];
        $stationInfo = $this->orderService->addOrdersToStation($data);
        return redirect()->route('stations.show', ['station' => $stationInfo]);
    }

    //remove item from Orders
    public function delete(Request $request)
    {
        $request->validate([
            'id',
        ]);
        $data = [
            'station_id' => $request->station_id,
            'order_id' => $request->id,
        ];
        $stationInfo = $this->orderService->removeOrderFromStation($data);
        return redirect()->route('stations.show', ['station' => $stationInfo]);
    }
}
