<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Report</title>

    
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

            #CompanyLogo {
            margin-right: 0px; /* Tambahkan jarak antara logo dan teks */
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

                            <h4 class="float-right font-size-15">INVOICE #</h4>
                            
                            
                            <div class="mb-4">
                                <h2 class="mb-1 text-muted">{{ $userCompany->company_name }}</h2>
                            <!--  Logo and name 
                                <div class="row align-items-center">
                                    
                                    <div class="col-auto">
                                        <img id="CompanyLogo" src="{{ $userCompany->company_img ? asset('storage/' . $userCompany->company_img) : asset('img/logo_primary.png') }}" alt="Company Logo" class="img-fluid rounded" style="max-height: 45px;">
                                    </div>

                                  
                                    <div class="col">
                                        <h2 class="mb-1 text-muted">{{ $userCompany->company_name }}</h2>
                                    </div>
                                </div>-->
                                
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
                                    <h5 class="font-size-15 mb-2"></h5>
                                    <p class="mb-1"></p>
                                    <p class="mb-1"></p>
                                    <p></p>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-sm-6 text-right">
                                <div class="text-muted">
                                    <div>
                                        <h5 class="font-size-15 mb-1">Invoice No :</h5>
                                        <p>#</p>
                                    </div>
                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">Invoice Date :</h5>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="py-2">
                            <h5 class="font-size-15">Order Summary</h5>

                      
                            <div class="table-responsive">
                <table class="table table-sm table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Purchase Price</th>
                            <th>Selling Price</th>
                            <th>Supplier</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $product->product_id }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->category->category_name ?? 'N/A' }}</td>
      
                                <td>Rp.{{ number_format($product->purchase_price, 2) }}</td>
                                <td>Rp.{{ number_format($product->selling_price, 2) }}</td>
     
                                <td>{{ $product->supplier->supplier_name ?? 'N/A' }}</td>
                                <td>{{ $product->product_qty }}</td>
                                <td>{{ $product->unit->unit_name ?? 'N/A' }}</td>
                                
                            </tr>
                        @endforeach
                    </tbody>
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