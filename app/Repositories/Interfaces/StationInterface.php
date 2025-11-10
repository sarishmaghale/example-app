<?php

namespace App\Repositories\Interfaces;

use App\Models\Station;

interface StationInterface
{

    public function getAllStations();
    public function createNewStation(array $station);
    public function updateStationInfo(Station $station, array $data);
    public function getStationData(int $stationId);
    public function deleteStation(Station $station);
}
