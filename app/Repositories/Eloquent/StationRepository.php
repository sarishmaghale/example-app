<?php

namespace App\Repositories\Eloquent;

use App\Models\Station;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\StationInterface;

class StationRepository implements StationInterface
{


    public function createNewStation(array $station): Station
    {
        return Station::create($station);
    }
    public function updateStationInfo(Station $station, array $data): bool
    {
        return $station->update($data);
    }
    public function getStationData(int $stationId): Station
    {
        return Station::findOrFail($stationId);
    }
    public function deleteStation(Station $station): bool
    {
        return $station->delete();
    }
    public function getAllStations(): Collection
    {
        return Station::all();
    }
}
