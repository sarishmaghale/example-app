<?php

namespace App\Repositories\Interfaces;

use App\Models\Order;

interface OrderInterface
{


    public function getOrdersByBillingId(int $billId);
    public function addOrder(array $orders,);
    public function getOrderByOrderId(int $orderId);
    public function deleteOrder(Order $order);
}
