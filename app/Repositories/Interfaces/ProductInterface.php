<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;

interface ProductInterface
{

    public function addNewProduct(array $product);
    public function updateProduct(Product $product, array $data);
    public function deleteProduct(Product $product);
    public function getAllProducts();
    public function getProductById(int $productId);
}
