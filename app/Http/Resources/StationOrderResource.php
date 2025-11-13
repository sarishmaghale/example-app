<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StationOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $bill = collect($this['billings']);
        $orders = collect($this['orders']);
        return [
            'Station' => $this['station'],
            'Bill' => [
                'id' => $bill->get('id'),
                'created_at' => $bill->get('created_at'),
                'status' => $bill->get('status') == 0 ? 'Unpaid' : 'Pending',
            ],
            'Orders' => $orders->map(function ($order) {
                $order = collect($order);
                $product = collect($order->get('product', []));
                return [
                    'id' => $order->get('id'),
                    'product_id' => $order->get('product_id'),
                    'quantity' => $order->get('quantity'),
                    'sum' => $order->get('sum'),
                    'created_at' => $order->get('created_at'),
                    'product' => [
                        'id' => $product->get('id'),
                        'name' => $product->get('product_name'),
                        'price' => $product->get('product_price'),
                    ],
                ];
            })->toArray(),
        ];
    }
}
