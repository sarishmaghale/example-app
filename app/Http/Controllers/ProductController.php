<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService) {}

    public function show()
    {
        $products = $this->productService->fetchAllProducts();
        return view('display-products', compact('products'));
    }

    public function store(StoreProductRequest $request)
    {
        $products = $request->validated();
        $this->productService->addNewProduct($products);
        return redirect()->route('products.show');
    }

    public function edit(int $id)
    {
        $products = $this->productService->fetchProductById($id);
        return view('edit-product', compact('products'));
    }

    public function update(UpdateProductRequest $request, int $id)
    {
        $validated = $request->validated();
        $this->productService->updateProductInfo($id, $validated);
        return redirect()->route('products.show');
    }
}
