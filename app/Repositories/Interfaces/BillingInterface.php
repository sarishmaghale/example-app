<?php

namespace App\Repositories\Interfaces;

use App\Models\Billing;
use App\Models\Station;

interface BillingInterface
{

    public function createNewBill(array $billing);
    public function updateBills(Billing $bill, array $data);
    public function getBillByBillId(int $billId);
    public function deleteBill(Billing $billing);
    public function getLatestBillNum();
    public function getBillsByDate(string $date);
    public function getBillByStation(Station $station);
    public function getSalesOfCurrentMonth(string $date);
}
