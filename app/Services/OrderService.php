<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Repositories\Eloquent\OrderRepository;
use App\Repositories\Interfaces\OrderInterface;
use App\Repositories\Interfaces\BillingInterface;
use App\Repositories\Interfaces\ProductInterface;
use App\Repositories\Interfaces\StationInterface;

class OrderService
{
    public function __construct(
        protected OrderInterface $orderRepo,
        protected StationInterface $stationRepo,
        protected ProductInterface $productRepo,
        protected BillingInterface $billingRepo,
    ) {}

    public function addOrdersToStation(array $data)
    {
        $stationDetails = $this->stationRepo->getStationData($data['station_id']);
        $productDetails = $this->productRepo->getProductById($data['product_id']);

        DB::beginTransaction();
        try {
            //check if station is occupied, 0=available | 1=occupied
            if ($stationDetails->status == 0) {
                $billData = [
                    'station_id' => $stationDetails->id,
                    'total' => 0,
                    'customer_name' => '',
                ];
                $generatedBill = $this->billingRepo->createNewBill($billData);
                // update station status to occupied
                $this->stationRepo->updateStationInfo($stationDetails, ['status' => 1]);
            } else {
                // get existing data for the station
                $generatedBill = $this->billingRepo->getBillByStation($stationDetails);
            }
            $orderData = [
                'quantity' => $data['quantity'],
                'billing_id' => $generatedBill->id,
                'product_id' => $data['product_id'],
                'sum' => $data['quantity'] * $productDetails->product_price,
            ];
            $this->orderRepo->addOrder($orderData);
            DB::commit();

            return $stationDetails;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function removeOrderFromStation($data)
    {
        $stationDetails = $this->stationRepo->getStationData($data['station_id']);
        $orderDetails = $this->orderRepo->getOrderByOrderId(($data['order_id']));
        $this->orderRepo->deleteOrder($orderDetails);
        return $stationDetails;
    }

    public function fetchOrderById(int $id)
    {
        return $this->orderRepo->getOrderByOrderId($id);
    }
}
