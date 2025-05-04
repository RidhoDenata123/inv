<!-- filepath: resources/views/dispatching/delivery-note.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Note</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Delivery Note</h1>
        <hr>
        <p><strong>Dispatching Header ID:</strong> {{ $dispatchingHeader->dispatching_header_id }}</p>
        <p><strong>Customer:</strong> {{ $dispatchingHeader->customer_id ? \App\Models\Customer::find($dispatchingHeader->customer_id)->customer_name : 'N/A' }}</p>
        <p><strong>Date:</strong> {{ $dispatchingHeader->confirmed_at ? \Carbon\Carbon::parse($dispatchingHeader->confirmed_at)->format('d F Y') : 'N/A' }}</p>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dispatchingDetails as $detail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $detail->product->product_name }}</td>
                        <td>{{ $detail->dispatching_qty }}</td>
                        <td>{{ $detail->product->unit->unit_name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr>
        <p class="text-center">Thank you for your business!</p>
    </div>
</body>
</html>