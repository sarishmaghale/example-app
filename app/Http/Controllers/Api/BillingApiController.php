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
    public function __construct(protected BillingService $billingService) {}

    public function show(SearchBillsRequest $request)
    {
        $date = $request->validated();
        $bills = $this->billingService->searchBillsByDate($date);
        if ($bills !== null) {
            return $this->successResponse($bills, "Bills displayed successfully");
        }
        return $this->errorResponse();
    }

    public function update(UpdateBillingRequest $request, int $id)
    {
        $data = $request->validated();
        $result = $this->billingService->updateBillAfterCheckOut($data, $id);
        if ($result) {
            return $this->successResponse("Successfully updated", $data);
        }
        return $this->errorResponse("Failed to update");
    }
}
