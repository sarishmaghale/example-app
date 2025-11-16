<?php

use App\Models\Product;

use App\Services\ProductService;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

it('fetches all products', function () {
    $product1 = Product::factory()->create([
        'product_name' => 'Milk Tea',
        'product_price' => 100,
    ]);
    $id1 = $product1->id;
    $product2 = Product::factory()->create([
        'product_name' => 'Coffee',
        'product_price' => 150,
    ]);
    $id2 = $product2->id;
    $response = getJson('/api/products');
    $response->assertStatus(200)
        ->assertJsonCount(2, 'data')
        ->assertJsonFragment([
            'id' => $id1,
        ])
        ->assertJsonFragment([
            'id' => $id2,
        ]);
});

it('can add new product if valid inputs', function () {
    $product = [
        'product_name' => 'Pastries',
        'product_price' => '80.00',
    ];
    $response = postJson('/api/products', $product);
    $response->assertStatus(200)->assertJsonFragment([
        'message' => 'Product added successfully',
    ])
        ->assertJsonFragment($product);
    assertDatabaseHas('products', $product);
});

it('will return 422 if required inputs not given', function () {
    $product = [
        'product_name' => 'Lemon Tea',
    ];
    $response = postJson('/api/products', $product);
    $response->assertStatus(422);
});

it('will return 422 if invalid data', function () {
    $product = [
        'product_name' => 'coffee',
        'product_price' => 'hello', //invalid data:should be decimal to be valid
    ];
    $response = postJson('/api/products', $product);
    $response->assertStatus(422);
});

it('will not add new product if invalid route', function () {
    $product = [
        'product_name' => 'coffee',
        'product_price' => '60.0',
    ];
    $response = postJson('/api/Product', $product);
    $response->assertStatus(404);
});

it('fetches product by valid given id', function () {
    $product = Product::factory()->create([
        'product_name' => 'Milk Tea',
        'product_price' => '100.00',
    ]);
    $response = getJson('/api/products/' . $product->id);
    $response->assertStatus(200)
        ->assertJsonFragment([
            'message' => 'Product displayed successfully'
        ])
        ->assertJsonFragment([
            'id' => $product->id,
            'product_name' => 'Milk Tea',
            'product_price' => 100.00,
        ]);
});

it('return 404 if invalid id to search for product', function () {
    $id = '9999ss';
    $response = getJson('/api/products/' . $id);
    $response->assertStatus(404);
});

it('will update product if valid data given', function () {
    $product = Product::factory()->create([
        'product_name' => 'Tea',
        'product_price' => '50.00',
    ]);
    $updatedProduct = [
        'product_name' => 'Tea',
        'product_price' => '80.00'
    ];
    $response = putJson('/api/products/' . $product->id, $updatedProduct);
    $response->assertStatus(200)
        ->assertJsonFragment([
            'id' => $product->id,
            'product_name' => 'Tea',
            'product_price' => 80.00
        ]);
});

it('will fail if trying to update product with invalid id', function () {
    $product = Product::factory()->create([
        'product_name' => 'Tea',
        'product_price' => '50.00'
    ]);
    $updatedProduct = [
        'product_name' => 'Tea',
        'product_price' => '100.00'
    ];
    $response = putJson('/api/products/9s9', $updatedProduct);
    expect($response->json('success'))->toBeFalse();
});
