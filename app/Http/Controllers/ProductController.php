<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function show()
    {

        $products = $this->productService->fetchAllProducts();
        return view('display-products', compact('products'));
    }
    public function store(Request $request)
    {
        $products = $request->validate([
            'product_name' => 'required',
            'product_price' => 'required'
        ]);
        $this->productService->addNewProduct($products);
        return redirect('/display-products');
    }

    public function edit(Product $products)
    {
        return view('edit-product', compact('products'));
    }

    public function update(Request $request, Product $products)
    {
        $validated = $request->validate([
            'product_name' => 'required',
            'product_price' => 'required',
        ]);
        $this->productService->updateProductInfo($products, $validated);
        return redirect()->route('products.show');
    }
}
