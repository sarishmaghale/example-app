<?php

use Carbon\Carbon;

function getTodayDate()
{
    return Carbon::today()->toDateString();
}
function calculateTotalAmount($data)
{
    $total = $data->sum(function ($item) {
        return $item->quantity * $item->product->product_price;
    });
    return $total;
}
