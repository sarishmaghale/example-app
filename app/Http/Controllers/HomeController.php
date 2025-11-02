<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;

class HomeController extends Controller
{
       //

       public function show()
       {
              if (Auth::check()) {
                     $products = Product::all();

                     return view('display-products', compact('products'));
              }
              return redirect()->route('LogInForm');
       }
}
