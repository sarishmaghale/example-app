<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Billing;
use App\Models\Product;
use App\Models\Station;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $station_id = $request->station_id;
        $product_id = $request->product_id;
        $quantity = $request->quantity;
        $stationInfo = Station::findOrFail($station_id);
        $productInfo = Product::findOrFail($product_id);
        // check if station was already occupied of not: 0=empty, 1=occupied
        if ($stationInfo->status == 0) {
            //if station empty, create new billing_id
            $billing = Billing::create([
                'station_id' =>  $station_id,
                'total' => 0,
            ]);
            //add orders including that billing_id
            $orders = Order::create([
                'quantity' => $quantity,
                'billing_id' => $billing->id,
                'product_id' => $product_id,
                'sum' => $quantity * $productInfo->product_price,
            ]);

            $stationInfo->update(['status' => 1]); //change the status to occupied
        }
        //if station occupied, update the order
        else {
            $billings = $stationInfo->bills()->latest()->first();
            Order::create([
                'quantity' => $quantity,
                'billing_id' => $billings->id,
                'product_id' => $product_id,
                'sum' => $quantity * $productInfo->product_price,
            ]);
        }
        return redirect()->route('stations.show', ['station' => $stationInfo]);
    }

    //remove item from Orders
    public function delete(Request $request)
    {
        $request->validate([
            'id',

        ]);
        $stationInfo = Station::findOrFail($request->station_id);
        $order = Order::findOrFail($request->id);
        $order->delete();
        return redirect()->route('stations.show', ['station' => $stationInfo]);
    }
}
