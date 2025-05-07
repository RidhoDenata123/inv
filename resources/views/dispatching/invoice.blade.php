<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>

    
    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">

    <!-- Custom styles for this template-->
        <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">


    <style>
        body {
            margin-top: 20px;
            background-color: #eee;
        }

        .card {
            box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-title">
                            <h4 class="float-right font-size-15">INVOICE #{{ $dispatchingHeader->dispatching_header_id }} </h4>
                            <div class="mb-4">
                                <h2 class="mb-1 text-muted">{{ $userCompany->company_name }}</h2>
                            </div>
                            <div class="text-muted">
                                <p class="mb-1">{{ $userCompany->company_address }}</p>
                                <p class="mb-1"><i class="fas fa-envelope"></i> {{ $userCompany->company_email }}</p>
                                <p><i class="fas fa-phone"></i> {{ $userCompany->company_phone }}</p>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="text-muted">
                                    <h5 class="font-size-16 mb-3">Billed To :</h5>
                                    <h5 class="font-size-15 mb-2">{{ $dispatchingHeader->customer_id ? \App\Models\Customer::find($dispatchingHeader->customer_id)->customer_name : 'N/A' }}</h5>
                                    <p class="mb-1">{{ $dispatchingHeader->customer_id ? \App\Models\Customer::find($dispatchingHeader->customer_id)->customer_address : 'N/A' }}</p>
                                    <p class="mb-1">{{ $dispatchingHeader->customer_id ? \App\Models\Customer::find($dispatchingHeader->customer_id)->customer_email : 'N/A' }}</p>
                                    <p>{{ $dispatchingHeader->customer_id ? \App\Models\Customer::find($dispatchingHeader->customer_id)->customer_phone : 'N/A' }}</p>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-sm-6 text-right">
                                <div class="text-muted">
                                    <div>
                                        <h5 class="font-size-15 mb-1">Invoice No :</h5>
                                        <p>#{{ $dispatchingHeader->dispatching_header_id }}</p>
                                    </div>
                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">Invoice Date :</h5>
                                        <p>{{ $dispatchingHeader->confirmed_at ? \Carbon\Carbon::parse($dispatchingHeader->confirmed_at)->format('d F Y') : 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="py-2">
                            <h5 class="font-size-15">Order Summary</h5>

                            <div class="table-responsive">
                                <table class="table table-centered mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 70px;">No.</th>
                                            <th>Product Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                           
                                            
                                            <th class="text-right" style="width: 120px;">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $grandTotal = 0; // Variabel untuk menyimpan total keseluruhan
                                        @endphp
                                        @foreach ($dispatchingDetails as $detail)
                                            @php
                                                $rowTotal = $detail->dispatching_qty * $detail->product->selling_price; // Hitung total per baris
                                                $grandTotal += $rowTotal; // Tambahkan ke total keseluruhan
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $detail->product->product_name }}</td>
                                                <td>Rp.{{ number_format($detail->product->selling_price, 2) }}</td>
                                                <td>{{ $detail->dispatching_qty }}</td>
                                                <td>{{ $detail->product->unit->unit_name }}</td>
                                                <td class="text-right">Rp.{{ number_format($rowTotal, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-right"><strong>Total :</strong></td>
                                            <td class="text-right"><strong>Rp.{{ number_format($grandTotal, 2) }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <hr>
                            <p class="text-center">Thank you for your business!</p>

                            <div class="d-print-none mt-4">
                                <div class="float-left">
                                    
                                </div>

                                <div class="float-right">

                                    <div class="d-flex justify-content-center align-items-center">
                                        <a href="javascript:window.print()" class="btn btn-success mr-1"><i class="fa fa-print"></i> Print</a>
                                
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
    </div>
</body>
</html>