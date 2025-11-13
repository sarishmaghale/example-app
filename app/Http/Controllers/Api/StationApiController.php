<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStationRequest;
use App\Services\StationService;
use Illuminate\Http\Request;

class StationApiController extends Controller
{
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
        return response()->json($stationData);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
