<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Models\Billing;
use App\Models\Station;

class HomeController extends Controller
{


       public function index()
       {
              $date = getTodayDate();
              $chartData = $this->getMonthlySalesData($date);
              $dailySales = getDailySales($date);
              $totalProducts = getTotalProducts();
              $totalStations = getTotalStations();
              return view('dashboard', compact('chartData', 'dailySales', 'totalProducts', 'totalStations'));
       }
       public function getMonthlySalesData($date)
       {
              $currentYear = date('Y', strtotime($date));
              $currentMonth = date('m', strtotime($date));
              $currentDay = date('d', strtotime($date));
              $days = [];
              $totals = [];
              for ($i = 1; $i <= $currentDay; $i++) {
                     $days[$i] = $i;
                     $totals[$i] = 0;
              }
              $sales = Billing::whereMonth('updated_at', $currentMonth)
                     ->whereYear('updated_at', $currentYear)
                     ->where('status', '1')
                     ->whereDay('updated_at', '<=', $currentDay)
                     ->get();

              $grouped = $sales->groupBy(function ($sale) {
                     return $sale->updated_at->day;
              });
              foreach ($grouped as $day => $billings) {
                     $totals[$day] = $billings->sum('total');
              }
              return [
                     'days' => array_values($days),
                     'totals' => array_values($totals),
              ];
       }
}
