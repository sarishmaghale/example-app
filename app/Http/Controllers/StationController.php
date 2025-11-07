<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Station;
use App\Helpers\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StationController extends Controller
{
    //

    public function index()
    {

        $stations = Station::all();
        return view('display-stations', compact('stations'));
    }

    //display the orders of station
    public function show(Station $station)
    {
        $products = Product::all();
        $stationInfo = Station::findOrFail($station->id);
        $billings = null;
        $orders = collect();
        if ($stationInfo->status == 1) { //if station occupied
            $billings = $stationInfo->bills()->latest()->first();
            if ($billings) {
                $orders = $billings->orders()->get();
                $stationInfo->total_amount = calculateTotalAmount($orders);
            }
        }
        //if station empty, returning empty values
        return view('station-info', compact('stationInfo', 'products', 'billings', 'orders'));
    }

    public function addNewStation()
    {

        $stations = Station::all();
        return view('add-station', compact('stations'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        Station::create([
            'station_name' => $request->name,
            'status' => 0,
        ]);
        return redirect()->route('stations.index');
    }
}
