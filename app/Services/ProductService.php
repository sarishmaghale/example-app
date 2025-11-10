<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductInterface;

class ProductService
{
    protected $productRepo;
    public function __construct(
        ProductInterface $productRepo
    ) {
        $this->productRepo = $productRepo;
    }

    public function fetchAllProducts()
    {
        return $this->productRepo->getAllProducts();
    }
    public function addNewProduct($productData)
    {
        return $this->productRepo->addNewProduct($productData);
    }
    public function updateProductInfo($product, $data)
    {
        return $this->productRepo->updateProduct($product, $data);
    }
}
