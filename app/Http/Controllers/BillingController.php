<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Models\Billing;
use App\Models\Order;
use App\Models\Product;
use App\Models\Station;
use Illuminate\Http\Request;
use App\Service\OrderService;
use App\Services\BillingService;

class BillingController extends Controller
{

    protected $billingService;
    public function __construct(BillingService $billingService)
    {
        $this->billingService = $billingService;
    }
    public function show(Billing $billings)
    {
        $billings = $this->billingService->getBillingDetails($billings);
        return view(
            'initiate-billing',
            compact('billings')
        );
    }

    public function update(Request $request, Billing $billings)
    {
        $data = $request->only(['customer_name', 'total']);
        $this->billingService->updateBillAfterCheckOut($data, $billings);
        return redirect()->route('stations.index');
    }

    public function showBills(Request $request)
    {
        $date = $request->searchDate;
        $bills = $this->billingService->searchBillsByDate($date);
        return view('show-bills', compact('bills'));
    }
}
