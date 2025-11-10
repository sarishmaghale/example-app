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

    protected $stationRepo;
    protected $orderRepo;
    protected $productRepo;
    protected $billingRepo;

    public function __construct(OrderInterface $orderRepo, StationInterface $stationRepo, ProductInterface $productRepo, BillingInterface $billingRepo,)
    {
        $this->orderRepo = $orderRepo;
        $this->stationRepo = $stationRepo;
        $this->productRepo = $productRepo;
        $this->billingRepo = $billingRepo;
    }
    public function addOrdersToStation(array $data)
    {
        $station = $this->stationRepo->getStationData($data['station_id']);
        $product = $this->productRepo->getProductById($data['product_id']);

        DB::beginTransaction();
        try {
            //check if station is occupied, 0=available | 1=occupied
            if ($station->status == 0) {
                $billData = [
                    'station_id' => $station->id,
                    'total' => 0,
                    'customer_name' => '',
                ];
                $bill = $this->billingRepo->createNewBill($billData);
                // update station status to occupied
                $this->stationRepo->updateStationInfo($station, ['status' => 1]);
            } else {
                // get existing data for the station
                $bill = $this->billingRepo->getBillByStation($station);
            }
            $orderData = [
                'quantity' => $data['quantity'],
                'billing_id' => $bill->id,
                'product_id' => $data['product_id'],
                'sum' => $data['quantity'] * $product->product_price,
            ];
            $this->orderRepo->addOrder($orderData);
            DB::commit();
            return $station;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public function removeOrderFromStation($data)
    {
        $station = $this->stationRepo->getStationData($data['station_id']);
        $order = $this->orderRepo->getOrderByOrderId(($data['order_id']));
        $this->orderRepo->deleteOrder($order);
        return $station;
    }
}
