<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Station;
use App\Helpers\Utility;
use App\Services\StationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StationController extends Controller
{
    protected $stationService;
    public function __construct(StationService $stationService)
    {
        $this->stationService = $stationService;
    }

    public function index()
    {

        $stations = $this->stationService->fetchAllStations();
        return view('display-stations', compact('stations'));
    }

    //display the orders of station
    public function show(Station $station)
    {
        $result = $this->stationService->getStationDetails($station);
        return view('station-info', [
            'stationInfo' => $result['station'],
            'products' => $result['products'],
            'billings' => $result['billings'],
            'orders' => $result['orders'],
        ]);
    }

    public function addNewStation()
    {

        $stations = $this->stationService->fetchAllStations();
        return view('add-station', compact('stations'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $stationData = [
            'station_name' => $request->name,
            'status' => 0,
        ];
        $this->stationService->createNewStation($stationData);
        return redirect()->route('stations.index');
    }
}
