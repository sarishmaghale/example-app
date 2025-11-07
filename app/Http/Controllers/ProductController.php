<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function show()
    {

        if (Auth::check()) {
            $products = Product::all();
            return view('display-products', compact('products'));
        }
        return view('login');
    }
    public function store(Request $request)
    {
        $products = $request->validate([
            'product_name' => 'required',
            'product_price' => 'required'
        ]);
        Product::create($products);
        return redirect('/display-products');
    }

    public function edit(Product $products)
    {
        return view('edit-product', compact('products'));
    }

    public function update(Request $request, Product $products)
    {
        $request->validate([
            'product_name' => 'required',
            'product_price' => 'required',
        ]);
        $products->update($request->all());
        return redirect()->route('products.show');
    }
}
