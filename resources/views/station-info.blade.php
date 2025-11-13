@extends('layout')

@section('content')

    <div class="container mx-auto p-3">
        <h2 class="text-xl font-bold mb-4">Orders for {{ $stationInfo->station_name }}:</h2>


        <!-- Add New Product Form -->
        <form action="{{ route('orders.store') }}" method="POST" class="row g-2 align-items-center mb-4">
            @csrf
            <input type="hidden" name="station_id" value="{{ $stationInfo->id }}">

            <div class="col-auto">
                <label for="product_id" class="form-label fw-bold">Add Product:</label>
                <select name="product_id" id="product_id" class="form-select" required>
                    <option value="" disabled selected>--Select item--</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">
                            {{ $product->product_name }} - Rs. {{ $product->product_price }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-auto">
                <label for="quantity" class="form-label fw-bold">Qty:</label>
                <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control w-75"
                    required>
            </div>

            <div class="col-auto mt-5">
                <button type="submit" class="btn btn-primary">Add Order</button>
            </div>
        </form>



        <div class="table-responsive">
            <!-- Orders Table -->
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Product</th>
                        <th scope="col" class="text-center">Quantity</th>
                        <th scope="col" class="text-end">Price</th>
                        <th scope="col" class="text-end">Total</th>
                        <th>...</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($orders->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center text-muted">No orders yet.</td>
                        </tr>
                    @else
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->product->product_name }}</td>
                                <td class="text-center">{{ $order->quantity }}</td>
                                <td class="text-end">{{ $order->product->product_price }}</td>
                                <td class="text-end">
                                    {{ $order->quantity * $order->product->product_price }}</td>
                                <td class="text-center">
                                    <form action="{{ route('orders.delete') }}"method="POST"
                                        onsubmit="return confirm('Are you sure you want to remove this item?')">
                                        @csrf
                                        @method('Delete')
                                        <input type="hidden" name="id" value="{{ $order->id }}">
                                        <input type="hidden" name="station_id" value="{{ $stationInfo->id }}">
                                        <button class="btn btn-danger" type="submit">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot class="table-light fw-bold">
                    <tr>
                        <td colspan="3" class="text-end">Total Amount:</td>
                        <td class="text-end">{{ $stationInfo->total_amount }}</td>
                    </tr>
                </tfoot>
            </table>

        </div>

        <!-- Checkout Button -->
        @if ($orders->isNotEmpty())
            <div class="d-flex justify-content-end mt-3">
                <form action="{{ route('billings.initiate', $billings->id) }}" method="GET">
                    @csrf
                    <button type="submit" class="btn btn-success btn-lg">Checkout</button>
                </form>
            </div>
        @endif
    </div>


@endsection
