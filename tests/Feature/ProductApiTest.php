<?php

use App\Models\Product;

use function Pest\Laravel\patchJson;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

it('fetches all products', function () {
    $products = Product::factory()->count(2)->create();
    getJson('/api/products')
        ->assertOk()
        ->assertJsonCount(2, 'data')
        ->assertJsonFragment(['id' => $products[0]->id]);
});

it('adds new product if valid inputs', function () {
    $product = Product::factory()->make()->toArray();
    postJson('/api/products', $product)
        ->assertCreated()
        ->assertJsonPath('data.product_name', $product['product_name']);
    assertDatabaseHas('products', ['product_name' => $product['product_name']]);
});

it('fails to add product without required fields', function () {
    $product = [
        'product_name' => 'Lemon Tea',
    ];
    $response = postJson('/api/products', $product);
    $response->assertStatus(422);
    assertDatabaseMissing('products', ['product_name' => $product['product_name']]);
});

it('failes to add new product with invalid data', function () {
    $product = [
        'product_name' => 'coffee',
        'product_price' => 'hello', //invalid data:should be decimal to be valid
    ];
    $response = postJson('/api/products', $product);
    $response->assertStatus(422);
    assertDatabaseMissing('products', ['product_name' => $product['product_name']]);
});

it('fails to add new product with invalid route', function () {
    $product = [
        'product_name' => 'coffee',
        'product_price' => '60.0',
    ];
    $response = postJson('/api/Product', $product);
    $response->assertStatus(404);
    assertDatabaseMissing('products', ['product_name' => $product['product_name']]);
});

it('fetches product with valid given id', function () {
    $product = Product::factory()->create();
    getJson('/api/products/' . $product->id)
        ->assertOk()
        ->assertJsonFragment([
            'message' => 'Product displayed successfully'
        ])
        ->assertJsonFragment([
            'id' => $product->id,
            'product_name' => $product->product_name,
            'product_price' => $product->product_price,
        ]);
});

it('returns 404 when fetching product with invalid id', function () {
    $id = '9999ss';
    $response = getJson('/api/products/' . $id);
    $response->assertStatus(404);
});

it('updates product with valid data', function () {
    $product = Product::factory()->create();
    $updatedProduct = [
        'product_name' => 'Tea',
        'product_price' => '80.00'
    ];
    putJson('/api/products/' . $product->id, $updatedProduct)
        ->assertStatus(200)
        ->assertJsonFragment([
            'id' => $product->id,
            'product_name' => 'Tea',
            'product_price' => 80.00
        ]);
    assertDatabaseHas('products', ['product_name' => 'Tea']);
});

it('returns 404 when updating non-existent product', function () {
    $id = '99999';
    $updatedProduct = [
        'product_name' => 'Tea',
        'product_price' => '100.00'
    ];
    putJson('/api/products/' . $id, $updatedProduct)
        ->assertStatus(404);
});

it('deletes product with valid id', function () {
    $product = Product::factory()->create();
    patchJson('/api/products/' . $product->id, ['isDeleted' => 1])
        ->assertOk();
    assertDatabaseHas('products', ['isDeleted' => 1]);
});

it('returns 404 when deleting non-existent product', function () {
    $id = 9999;
    patchJson('/api/products/' . $id, ['isDeleted' => 1])
        ->assertStatus(404);
});
