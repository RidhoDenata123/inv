<!-- filepath: c:\Users\Erika\Downloads\inv\resources\views\products\show.blade.php -->
@extends('layouts.adminApp')

@section('content')
<div class="container">
    <h1>Product Details</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Product ID:</strong> {{ $product->product_id }}</p>
            <p><strong>Product Name:</strong> {{ $product->product_name }}</p>
            <p><strong>Category:</strong> {{ $product->product_category }}</p>
            <p><strong>Description:</strong> {{ $product->product_description }}</p>
            <p><strong>Purchase Price:</strong> Rp {{ number_format($product->purchase_price, 2, ',', '.') }}</p>
            <p><strong>Selling Price:</strong> Rp {{ number_format($product->selling_price, 2, ',', '.') }}</p>
            <p><strong>Quantity:</strong> {{ $product->product_qty }}</p>
            <p><strong>Status:</strong> {{ $product->product_status }}</p>
        </div>
    </div>
    <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Back to Products</a>
</div>
@endsection