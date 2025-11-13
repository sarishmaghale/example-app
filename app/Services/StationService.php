<?php

namespace App\Services;

use App\Repositories\Interfaces\BillingInterface;
use App\Repositories\Interfaces\OrderInterface;
use App\Repositories\Interfaces\ProductInterface;
use App\Repositories\Interfaces\StationInterface;

class StationService
{
    public function __construct(
        protected StationInterface $stationRepo,
        protected BillingInterface $billingRepo,
        protected OrderInterface $orderRepo,
        protected ProductInterface $productRepo
    ) {}

    public function fetchAllStations()
    {
        return $this->stationRepo->getAllStations();
    }

    public function getStationDetails($id)
    {
        $products = $this->productRepo->getAllProducts();
        $stationInfo = $this->stationRepo->getStationData($id);
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
    public function activateSoftDelete($id)
    {
        $station = $this->stationRepo->getStationData($id);
        return $this->stationRepo->deleteStation($station);
    }
}
