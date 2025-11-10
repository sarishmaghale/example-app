<?php

namespace  App\Repositories\Eloquent;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\ProductInterface;

class ProductRepository implements ProductInterface
{

    public function addNewProduct(array $product): Product
    {
        return Product::create($product);
    }
    public function updateProduct(Product $product, array $data): bool
    {
        return $product->update($data);
    }
    public function deleteProduct(Product $product): bool
    {
        return $product->delete();
    }

    public function getProductById(int $productId): Product
    {
        return Product::findOrFail($productId);
    }
    public function getAllProducts(): Collection
    {
        return Product::all();
    }
}
