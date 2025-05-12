<!DOCTYPE html>
<html>
<head>
    <title>Stock Adjustment Report</title>
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
            <h2>Stock Adjustment Report</h2>
            <p>Generated at : {{ now()->timezone('Asia/Jakarta')->format('l, d F Y H:i') }}</p>
        </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Change Date</th>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Change Type</th>
                <th>Quantity Before</th>
                <th>Quantity Changed</th>
                <th>Quantity After</th>
                <th>Changed By</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($adjustmentLogs as $index => $log)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $log->changed_at ? \Carbon\Carbon::parse($log->changed_at)->timezone('Asia/Jakarta')->format('l, d F Y H:i') : 'N/A' }}</td>
                    <td>{{ $log->product->product_id ?? 'N/A' }}</td>
                    <td>{{ $log->product->product_name ?? 'N/A' }}</td>
                    <td>{{ $log->stock_change_type }}</td>
                    <td>{{ $log->qty_before }}</td>
                    <td>{{ $log->qty_changed }}</td>
                    <td>{{ $log->qty_after }}</td>
                    <td>{{ $log->changedBy->name ?? 'System' }}</td>
                    <td>{{ $log->change_note }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>