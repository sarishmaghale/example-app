<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;

use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\OrderInterface;

class OrderRepository implements OrderInterface
{
    public function getOrdersByBillingId(int $billId): Collection
    {
        return Order::with('product')->where('billing_id', $billId)->get();
    }

    public function addOrder(array $orders): Order
    {
        return Order::create($orders);
    }

    public function getOrderByOrderId(int $orderId): Order
    {
        return Order::findOrFail($orderId);
    }

    public function deleteOrder(Order $order): bool
    {
        return $order->delete();;
    }
}
