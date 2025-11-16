<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\StationService;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStationRequest;
use App\Http\Resources\StationOrderResource;

class StationApiController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected StationService $stationService) {}

    public function index()
    {
        $allStations = $this->stationService->fetchAllStations();
        if ($allStations) {
            return $this->successResponse(data: $allStations, message: "All stations displayed successfully");
        }
        return $this->errorResponse();
    }

    public function store(StoreStationRequest $request)
    {
        $stationData = $request->validatedData();
        $addedStation = $this->stationService->createNewStation($stationData);
        if ($addedStation) {
            return $this->successResponse(data: $addedStation, message: "New station created successfully");
        }
        return $this->errorResponse();
    }

    public function show(int $id)
    {
        $stationData = $this->stationService->getStationDetails($id);
        $filterRequiredData = new StationOrderResource($stationData);
        if ($filterRequiredData) {
            return $this->successResponse(data: $filterRequiredData, message: "Orders of station fetched successfully");
        }
        return $this->errorResponse();
    }

    public function destroy(int $id)
    {
        $result = $this->stationService->activateSoftDelete($id);
        if ($result) {
            return $this->successResponse(message: "Station deleted successfully");
        }
        return $this->errorResponse();
    }
}
