<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Traits\ApiResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductApiController extends Controller
{
    use ApiResponseTrait;
    public function __construct(protected ProductService $productService) {}

    public function index()
    {
        $products = $this->productService->fetchAllProducts();
        if ($products !== null) {
            return $this->successResponse(data: $products, message: "All products displayed successfully");
        }
        return $this->errorResponse();
    }

    public function store(StoreProductRequest $request)
    {
        $products = $request->validated();
        $result = $this->productService->addNewProduct($products);
        if ($result !== null) {
            return $this->successResponse(data: $result, message: "Product added successfully", code: 201);
        }
        return $this->errorResponse();
    }

    public function show(int $id)
    {
        try {
            $product = $this->productService->fetchProductById($id);
            if ($product !== null) {
                return $this->successResponse(data: $product, message: "Product displayed successfully");
            }
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(message: 'Product not found', code: 404);
        }
        return $this->errorResponse();
    }

    public function update(UpdateProductRequest $request, int $id)
    {
        $product = $request->validated();
        $result = $this->productService->updateProductInfo($id, $product);
        if ($result) {
            return $this->successResponse(data: $result, message: "Product upated successfully");
        }
        return $this->errorResponse();
    }

    public function delete(int $id)
    {
        $result = $this->productService->activateSoftDelete($id);
        if ($result) {
            return $this->successResponse(message: "Product removed successfully");
        }
        return $this->errorResponse();
    }
}
