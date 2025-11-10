<?php

namespace App\Services;

use App\Repositories\Interfaces\BillingInterface;
use App\Repositories\Interfaces\OrderInterface;
use App\Repositories\Interfaces\ProductInterface;
use App\Repositories\Interfaces\StationInterface;


class StationService
{
    protected $stationRepo;
    protected $billingRepo;
    protected $orderRepo;
    protected $productRepo;

    public function __construct(
        StationInterface $stationRepo,
        BillingInterface $billingRepo,
        OrderInterface $orderRepo,
        ProductInterface $productRepo,
    ) {
        $this->stationRepo = $stationRepo;
        $this->billingRepo = $billingRepo;
        $this->orderRepo = $orderRepo;
        $this->productRepo = $productRepo;
    }
    public function fetchAllStations()
    {
        return $this->stationRepo->getAllStations();
    }
    public function getStationDetails($station)
    {
        $products = $this->productRepo->getAllProducts();
        $stationInfo = $this->stationRepo->getStationData($station->id);
        $bills = null;
        $orders = collect();
        if ($stationInfo->status == 1) {
            $bills = $this->billingRepo->getBillByStation($stationInfo);
            if ($bills) {
                $orders = $this->orderRepo->getOrdersByBillingId($bills->id);
                $stationInfo->total_amount = calculateTotalAmount($orders);
            }
        }
        return [
            'station' => $stationInfo,
            'products' => $products,
            'billings' => $bills,
            'orders' => $orders,
        ];
    }
    public function createNewStation($data)
    {
        return $this->stationRepo->createNewStation($data);
    }
}
