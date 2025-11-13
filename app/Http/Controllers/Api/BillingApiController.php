<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\BillingService;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchBillsRequest;
use App\Http\Requests\UpdateBillingRequest;
use App\Traits\ApiResponseTrait;

class BillingApiController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected BillingService $billingService) {}

    public function index(Request $request)
    {
        $bills = $this->billingService->searchBillsByDate($request->searchDate);
        if ($bills !== null) {
            return $this->successResponse($bills, "Bills displayed successfully");
        }
        return $this->errorResponse();
    }

    public function show(int $id)
    {
        $bill = $this->billingService->getBillingDetails($id);
        if ($bill !== null) {
            return $this->successResponse($bill, "Bill fetched successfully");
        }
        return $this->errorResponse();
    }

    public function update(UpdateBillingRequest $request, int $id)
    {
        $data = $request->validated();
        $result = $this->billingService->updateBillAfterCheckOut($data, $id);
        if ($result) {
            return $this->successResponse($data, "Bill successfully updated to paid");
        }
        return $this->errorResponse("Failed to update");
    }
}
