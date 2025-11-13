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
        return response()->json($allStations);
    }

    public function store(StoreStationRequest $request)
    {
        $stationData = $request->validatedData();
        $addedStation = $this->stationService->createNewStation($stationData);
        return response()->json($addedStation);
    }

    public function show(int $id)
    {
        $stationData = $this->stationService->getStationDetails($id);
        $filterRequiredData = new StationOrderResource($stationData);
        return response()->json($filterRequiredData);
    }

    public function destroy(int $id)
    {
        $result = $this->stationService->activateSoftDelete($id);
        if ($result) {
            return $this->successResponse('', "Station deleted successfully");
        }
        return $this->errorResponse();
    }
}
