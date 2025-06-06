<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery-Note</title>

    
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
                            
                            <h4 class="float-right font-size-15">DELIVERY #{{ $dispatchingHeader->dispatching_header_id }} </h4>
                            <div class="mb-4">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <img id="CompanyLogo" src="{{ $userCompany->company_img ? asset('storage/' . $userCompany->company_img) : asset('img/logo_primary.png') }}" alt="Company Logo" class="img-fluid rounded" style="max-height: 45px;">
                                    </div>
                                    <div class="col">
                                        <h2 class="mb-1 text-muted">{{ $userCompany->company_name }}</h2>
                                    </div>
                                </div>
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
                                    <h5 class="font-size-16 mb-3">Delivery To :</h5>
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
                                        <h5 class="font-size-15 mb-1">Delivery :</h5>
                                        <p>#{{ $dispatchingHeader->dispatching_header_id }}</p>
                                    </div>
                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">Delivery Date :</h5>
                                        <p>{{ now()->timezone('Asia/Jakarta')->format('l, d F Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="py-2">
                            <h5 class="font-size-15">Delivery Summary</h5>

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

                            <div class="row">
                                <div class="col-sm-5 text-left">
                                    <!-- begin invoice-note -->
                                    <div class="invoice-note">
                                  <span>* Make all cheques payable to {{ $userCompany->company_name }}<br>
                                        * Payment is due within 3 days<br></span>
                                      
                                    </div>
                                </div>

                                <div class="col-sm-2 text-center">
                                    <!-- begin invoice-note -->
                                    <div class="invoice-note">
                                        <table class="table table-sm table-borderless">
                                            <tbody>
                                            <tr>
                                                <td>sincerely</td>
                                            </tr>
                                            <tr>
                                                <td><br></td>
                                            </tr>
                                            <tr>
                                                <td><br></td>
                                            </tr>
                                            <tr>
                                                <td><strong><u>{{ Auth::user()->name }}</u></strong></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                 <div class="col-sm-5 text-right">
                                    <div class="invoice-note">
                                        <span><strong>PAYMENT INFORMATION</strong><br>
                                        {{ $bankAccount ? $bankAccount->bank_name : '-' }} - {{ $userCompany->company_currency }}<br>
                                        {{ $userCompany->company_bank_account }}<br>
                                        {{ $bankAccount ? $bankAccount->account_name : '-' }}<br></span>
             
                                    </div>
                                </div>                                
                            </div>
                        <hr>
                                    <!-- begin invoice-footer -->
                                    <div class="invoice-footer">
                                        <p class="text-center m-b-5 f-w-600">
                                        THANK YOU FOR YOUR BUSINESS
                                        </p>
                                        <p class="text-center mb-1">
                                        <span class="m-r-10"><i class="fa fa-fw fa-lg fa-globe"></i> {{ $userCompany->company_website }}</span>
                                        <span class="m-r-10"><i class="fa fa-fw fa-lg fa-phone-volume"></i> {{ $userCompany->company_phone }} </span>
                                        <span class="m-r-10"><i class="fa fa-fw fa-lg fa-envelope"></i> {{ $userCompany->company_email }}</span>
                                        </p>
                                    </div>
                                    <!-- end invoice-footer -->

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