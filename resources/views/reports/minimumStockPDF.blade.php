<!DOCTYPE html>
<html>
<head>
    <title>Minimum Stock Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
        <div class="header">
            <h2>MINIMUM STOCK REPORT</h2>
            <p>Generated at : {{ now()->timezone('Asia/Jakarta')->format('l, d F Y H:i') }}</p>
        </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Unit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->product_id }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                    <td class="text-danger">{{ $product->product_qty }}</td>
                    <td>{{ $product->unit->unit_name ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>