@extends('layouts.userApp')
  
@section('content')

   

@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@section('styles')
    <!-- Bootstrap Select CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" />
    
    <style>
        .bootstrap-select .dropdown-toggle {
            height: calc(1.5em + .75rem + 2px); /* Sesuaikan tinggi dengan form Bootstrap */
            padding: .375rem .75rem; /* Padding default form */
            font-size: 1rem; /* Ukuran font default */
            line-height: 1.5; /* Line height default */
            color: #858796; /* Warna teks default */
            background-color: #fff; /* Warna latar belakang */
            border: 1px solid #ced4da; /* Warna border */
            border-radius: .25rem; /* Radius border */
        }

        .bootstrap-select .dropdown-menu {
            font-size: 1rem; /* Ukuran font dropdown */
        }

        .pagination {
            margin: 0; /* Hilangkan margin default */
        }
        .table-responsive .pagination {
            justify-content: flex-end; /* Posisikan pagination di kanan */
        }
        
        .table-responsive {
            overflow-x: auto;
            min-height: .01%;
        }
        #productTable {
            width: 100% !important;
            table-layout: auto;
            word-break: break-word;
        }
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 1rem;
        }

        .table-responsive {
            overflow-x: auto;
            position: relative;
        }
        .table-responsive .dropdown-menu {
            position: absolute !important;
            will-change: transform;
        }
    </style>

@endsection

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800"><i class='fas fa-dolly-flatbed'></i> PRODUCT MASTER</h1>
                    <p class="mb-4"></p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">PRODUCT TABLE</h6>
                        </div>
                        <div class="card-body">

                       
                        <div class="table-responsive">
                                <table id="productTable" class="table table-sm table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">No.</th>
                                            <th scope="col">Product ID</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Purchase Price</th>
                                            <th scope="col">Selling Price</th>
                                            <th scope="col">Supplier</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Unit</th>
                                            <th scope="col">Created At</th> <!-- Tambahkan ini -->
                                            <th scope="col">Status</th>
                                            <th scope="col">ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                        <!-- Modal for Show Product Details -->
                        <div class="modal fade" id="productDetailModal" tabindex="-1" role="dialog" aria-labelledby="productDetailModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="productDetailModalLabel">Product Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <!-- Produk img -->
                                            <div class="col-md-4 text-center mb-3 mb-md-0">
                                                <img id="detailProductImage" src="" alt="Product Image" class="img-fluid rounded" style="max-height: 300px;">
                                            </div>

                                            <!-- Produk Detail -->
                                            <div class="col-md-8">

                                            <div class="card">
                                            
                                                <div class="card-body">          
                                                    <p><strong>Product ID :</strong> <span id="detailProductId"></span></p>
                                                    
                                                        <h1><strong><span id="detailProductName"></span></strong></h1>
                                                    
                                                    <p> <span id="detailProductDescription"></span></p>
                                                    <hr>

                                                    <div class="row">
                                                        <div class="col-sm-5"><p><strong>Category :</strong></p></div>
                                                        <div class="col-sm-5"><p><span id="detailProductCategory"></span></p></div>  
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-5"><p><strong>Purchase Price :</strong></p></div>
                                                        <div class="col-sm-5"><p><span id="detailPurchasePrice"></span></p></div>  
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-5"><p><strong>Selling Price :</strong></p></div>
                                                        <div class="col-sm-5"><p><span id="detailSellingPrice"></span></p></div>  
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-5"><p><strong>Quantity :</strong></p></div>
                                                        <div class="col-sm-5"><p><span id="detailProductQty"></span></p></div>  
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-5"><p><strong>Unit :</strong></p></div>
                                                        <div class="col-sm-5"><p><span id="detailProductUnit"></span></p></div>  
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-5"><p><strong>Supplier :</strong></p></div>
                                                        <div class="col-sm-5"><p><span id="detailSupplierId"></span></p></div>  
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-5"><p><strong>Status :</strong></p></div>
                                                        <div class="col-sm-5"><p><span id="detailProductStatus" class="badge"></span></p></div>  
                                                    </div>
                                                
                                                </div>
                                            </div>
                                                        
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <!-- /.container-fluid -->



@endsection


@section('scripts')


                <!-- DataTables core -->
                <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
                <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

                <!-- DataTables Responsive (setelah DataTables utama) -->
                <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
                <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>

                <!-- Bootstrap Select JS -->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
                
                
                <!-- Datatable  -->       
                <script>
                    $(document).ready(function() {
                        $('#productTable').DataTable({
                            processing: true,
                            serverSide: true,
                            responsive: true, // Aktifkan responsive
                            ajax: '{{ route("products.UserDatatable") }}',
                            columns: [
                                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                                { data: 'product_id', name: 'product_id' },
                                { data: 'product_name', name: 'product_name' },
                                { data: 'category', name: 'category.category_name' },
                                { data: 'purchase_price', name: 'purchase_price' },
                                { data: 'selling_price', name: 'selling_price' },
                                { data: 'supplier', name: 'supplier.supplier_name' },
                                { data: 'product_qty', name: 'product_qty' },
                                { data: 'unit', name: 'unit.unit_name' },
                                { data: 'created_at', name: 'created_at' }, // Tambahkan ini
                                { data: 'status', name: 'product_status', orderable: false, searchable: false },
                                { data: 'actions', name: 'actions', orderable: false, searchable: false }
                               
                            ],
                            order: [[9, 'desc']]
                        });
                    });
                </script>

                <script>
                    $(document).ready(function() {

                        // Tampilkan SweetAlert jika ada session flash message
                        @if (session('success'))
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: '{{ session('success') }}',
                                confirmButtonText: 'OK'
                            });
                        @endif

                        @if (session('error'))
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: '{{ session('error') }}',
                                confirmButtonText: 'OK'
                            });
                        @endif

                        // Handle click event on "SHOW" button
                        $(document).on('click', '.btn-show', function() {
                            const productId = $(this).data('product_id'); // Ambil ID produk dari tombol
                        // Lakukan permintaan AJAX ke server
                        $.ajax({
                            url: `/user/products/show/${productId}`, // URL rute Laravel
                            method: 'GET',
                            success: function(data) {
                                        // Isi modal dengan data produk
                                        $('#detailProductId').text(data.product_id);
                                        $('#detailProductName').text(data.product_name);
                                        $('#detailProductCategory').text(data.category_name); // Tampilkan category_name
                                        $('#detailProductDescription').text(data.product_description);
                                        $('#detailPurchasePrice').text("Rp " + parseFloat(data.purchase_price).toLocaleString('id-ID', { minimumFractionDigits: 2 }));
                                        $('#detailSellingPrice').text("Rp " + parseFloat(data.selling_price).toLocaleString('id-ID', { minimumFractionDigits: 2 }));
                                        $('#detailProductQty').text(data.product_qty);
                                        $('#detailProductUnit').text(data.unit_name);
                                        $('#detailSupplierId').text(data.supplier_name);
                                        $('#detailProductStatus').text(data.product_status);

                                        
                                        // Atur warna badge berdasarkan status produk
                                            const statusElement = $('#detailProductStatus');
                                            statusElement.text(data.product_status); // Set teks status
                                            if (data.product_status === 'active') {
                                                statusElement.removeClass('badge-danger').addClass('badge-success'); // Warna hijau
                                            } else if (data.product_status === 'inactive') {
                                                statusElement.removeClass('badge-success').addClass('badge-danger'); // Warna merah
                                            }

                                        // Tampilkan gambar produk
                                        if (data.product_img) {
                                            $('#detailProductImage').attr('src', data.product_img);
                                        } else {
                                            $('#detailProductImage').attr('src', '/img/default-product.png'); // Gambar default
                                        }
                                    },
                                    error: function(xhr) {
                                        alert('Failed to fetch product details. Please try again.');
                                    }
                                });
                            });
                        });


                        // Add the following code if you want the name of the file appear on select
                        $(".custom-file-input").on("change", function() {
                        var fileName = $(this).val().split("\\").pop();
                        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                        });
                </script>
@endsection