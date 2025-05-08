<!DOCTYPE html>
<html>
<head>
    <title>Stock Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Stock Report</h1>
    <p>Generated at: {{ now()->format('Y-m-d H:i:s') }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Unit</th>
                <th>Purchase Price</th>
                <th>Selling Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->product_id }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                    <td>{{ $product->product_qty }}</td>
                    <td>{{ $product->unit->unit_name ?? 'N/A' }}</td>
                    <td>{{ number_format($product->purchase_price, 2) }}</td>
                    <td>{{ number_format($product->selling_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>