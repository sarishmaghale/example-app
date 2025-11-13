<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Traits\ApiResponseTrait;

class ProductApiController extends Controller
{
    use ApiResponseTrait;
    public function __construct(protected ProductService $productService) {}

    public function index()
    {
        $products = $this->productService->fetchAllProducts();
        if ($products !== null) {
            return $this->successResponse($products, "All products displayed successfully");
        }
        return $this->errorResponse();
    }

    public function store(StoreProductRequest $request)
    {
        $products = $request->validated();
        $result = $this->productService->addNewProduct($products);
        if ($result !== null) {
            return $this->successResponse($result, "Product added successfully");
        }
        return $this->errorResponse();
    }

    public function show(int $id)
    {
        $product = $this->productService->fetchProductById($id);
        if ($product !== null) {
            return $this->successResponse($product, "Product displayed successfully");
        }
        return $this->errorResponse();
    }

    public function update(UpdateProductRequest $request, int $id)
    {
        $product = $request->validated();
        $result = $this->productService->updateProductInfo($id, $product);
        if ($result) {
            return $this->successResponse($product, "Product upated successfully");
        }
        return $this->errorResponse();
    }

    public function delete(int $id)
    {
        $result = $this->productService->activateSoftDelete($id);
        if ($result) {
            return $this->successResponse("", "Product removed successfully");
        }
        return $this->errorResponse();
    }
}
