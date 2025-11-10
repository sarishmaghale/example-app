<?php

namespace App\Services;

use App\Repositories\Interfaces;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\BillingInterface;
use App\Repositories\Interfaces\OrderInterface;
use App\Repositories\Interfaces\StationInterface;

class BillingService
{
    protected $billingRepo;
    protected $stationRepo;
    protected $orderRepo;
    public function __construct(
        BillingInterface $billingRepo,
        StationInterface $stationRepo,
        OrderInterface $orderRepo,
    ) {
        $this->billingRepo = $billingRepo;
        $this->stationRepo = $stationRepo;
        $this->orderRepo = $orderRepo;
    }
    public function updateBillAfterCheckOut($data, $bill)
    {
        $billNum = $this->billingRepo->getLatestBillNum();
        DB::beginTransaction();
        try {
            $updateData = array_merge($data, [
                'status' => 1,
                'bill_num' => $billNum + 1,
            ]);
            $this->billingRepo->updateBills($bill, $updateData);
            $this->stationRepo->updateStationInfo(
                $bill->station,
                ['status' => 0]
            );
            DB::commit();
            return $bill->bill_num;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function searchBillsByDate($date)
    {
        if (is_null($date)) {
            $date = getTodayDate();
        }
        return $this->billingRepo->getBillsByDate($date);
    }
    public function getBillingDetails($billing)
    {
        $billing->orders = $this->orderRepo->getOrdersByBillingId($billing->id);
        $billing->total = calculateTotalAmount($billing->orders);
        return $billing;
    }
}
