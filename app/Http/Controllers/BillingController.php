<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Order;
use App\Models\Product;
use App\Models\Station;
use Illuminate\Http\Request;

class BillingController extends Controller
{

    public function getOrders($billId)
    {
        $orders = Order::with('product')->where('billing_id', $billId)->get();
        return $orders;
    }
    public function show(Billing $billings)
    {
        $billId = $billings->id;
        $orders = $this->getOrders($billings->id);

        return view('display-bills', compact('billings', 'orders'));
    }

    public function update(Request $request, Billing $billings)
    {

        $billings->update([
            'status' => 1,
            'customer_name' => $request->customer_name,
            'total' => $request->total,
        ]);
        $station_id = $billings->station_id;

        $billings->station->update(['status' => 0]);
        return redirect()->route('stations.index');
    }
}
