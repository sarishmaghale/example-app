<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Http\Requests\UpdateBillingRequest;
use App\Models\Billing;
use App\Models\Order;
use App\Models\Product;
use App\Models\Station;
use Illuminate\Http\Request;
use App\Service\OrderService;
use App\Services\BillingService;

class BillingController extends Controller
{

    public function __construct(protected BillingService $billingService) {}

    public function show(int $id)
    {
        $billings = $this->billingService->getBillingDetails($id);
        return view(
            'initiate-billing',
            compact('billings')
        );
    }

    public function update(UpdateBillingRequest $request, int $id)
    {
        $data = $request->validated();
        $this->billingService->updateBillAfterCheckOut($data, $id);
        return redirect()->route('stations.index');
    }

    public function showBills(Request $request)
    {
        $date = $request->searchDate;
        $bills = $this->billingService->searchBillsByDate($date);
        return view('show-bills', compact('bills'));
    }
}
