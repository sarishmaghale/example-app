<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductInterface;

class ProductService
{
    public function __construct(protected ProductInterface $productRepo) {}

    public function fetchAllProducts()
    {
        return $this->productRepo->getAllProducts();
    }

    public function addNewProduct($productData)
    {
        return $this->productRepo->addNewProduct($productData);
    }

    public function updateProductInfo($id, $data)
    {
        $product = $this->productRepo->getProductById($id);
        return $this->productRepo->updateProduct($product, $data);
    }
    public function fetchProductById(int $id)
    {
        return $this->productRepo->getProductById($id);
    }
}
