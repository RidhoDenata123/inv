
@extends('layouts.adminApp')


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
    </style>


    @endsection

@section('content')

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-receipt"></i> Receiving Detail</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Receiving Detail Information</h6>
        </div>
        <div class="card-body">

            <table class="table table-bordered table-sm">
                <tr>
                    <th>Receiving Header ID</th>
                    <td>{{ $receivingHeader->receiving_header_id }}</td>
                </tr>
                <tr>
                    <th>Designation</th>
                    <td>{{ $receivingHeader->receiving_header_name }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $receivingHeader->receiving_header_description }}</td>
                </tr>
                <tr>
                    <th>Created By</th>
                    <td>{{ $receivingHeader->created_by }}</td>
                </tr>
                <tr>
                    <th>Created Date</th>
                    <td>{{ $receivingHeader->created_at }}</td>
                </tr>
                <tr>
                    <th>Confirmation Date</th>
                    <td>{{ $receivingHeader->confirmed_at }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $receivingHeader->receiving_header_status }}</td>
                </tr>
            </table>

        @if ($receivingHeader->receiving_header_status === 'Pending')
            <a href="#" class="btn btn-md btn-success mb-3" data-toggle="modal" data-target="#addReceivingDetailModal"><i class='fas fa-plus'></i> ADD PRODUCT</a>
        @endif
           

            <div class="table-responsive">
                <table id="detailTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Detail ID</th>
                            <th scope="col">Product ID</th>
                            <th scope="col">Receiving Qty</th>
                            
                            <th scope="col">Created Date</th>
                            <th scope="col">Confirmation Date</th>
                            <th scope="col">Detail Status</th>
                            <th scope="col">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($receivingDetails as $detail)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $detail->receiving_detail_id }}</td>
                                <td>
                                    <a href="#" 
                                        class="btn-show text-primary" 
                                        data-product_id="{{ $detail->product_id }}" 
                                        data-toggle="modal" 
                                        data-target="#productDetailModal">
                                        {{ $detail->product_id }}
                                    </a>
                                    
                                </td>
                                <td>{{ $detail->receiving_qty }}</td>
                                
                                <td>{{ $detail->created_at }}</td>
                                <td>{{ $detail->confirmed_at }}</td>
                                <td>{{ $detail->receiving_detail_status }}</td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        @if ($detail->receiving_detail_status === 'Confirmed')
                                            <!-- Tombol Show Detail -->
                                            <a href="#" 
                                            class="btn btn-sm btn-dark btn-show mr-2" 
                                            data-product_id="{{ $detail->product_id }}" 
                                            data-toggle="modal" 
                                            data-target="#productDetailModal">
                                                <i class="fas fa-search"></i>
                                            </a>
                                        @elseif ($detail->receiving_detail_status === 'Pending')

                                            <!-- Tombol Show Detail -->
                                            <a href="#" 
                                            class="btn btn-sm btn-dark btn-show mr-2" 
                                            data-product_id="{{ $detail->product_id }}" 
                                            data-toggle="modal" 
                                            data-target="#productDetailModal">
                                                <i class="fas fa-search"></i>
                                            </a>
                                            <!-- Tombol Edit -->
                                            <a href="#" 
                                            class="btn btn-sm btn-primary btn-edit mr-2" 
                                            data-receiving_detail_id="{{ $detail->receiving_detail_id }}" 
                                            data-toggle="modal" 
                                            data-target="#editReceivingDetailModal">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Tombol Delete -->
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger btn-delete" 
                                                    data-receiving_detail_id="{{ $detail->receiving_detail_id }}" 
                                                    data-toggle="modal" 
                                                    data-target="#deleteReceivingDetailModal">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>


                            </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">No data available in table</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <hr>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <a href="{{ route('receiving.header') }}" class="btn btn-secondary">Back to List</a>

                @if ($receivingHeader->receiving_header_status === 'Pending')
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmReceivingModal">
                        Confirm
                    </button>
                @endif
            </div>
            
        </div>
        
    </div>

    <!-- Modal for restock Product -->
    <div class="modal fade" id="addReceivingDetailModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Restock Product</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <form action="{{ route('receiving.detail.addDetail') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">

                            <!-- Detail ID -->
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Detail ID :</label>
                                <input type="text" class="form-control" id="receiving_detail_id" name="receiving_detail_id" value="" readonly>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">Product :</label>
                                        <select class="form-control selectpicker" id="product_id" name="product_id" data-live-search="true" required>
                                            <option value="" disabled selected>Select a product</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">Quantity:</label>
                                        <input type="number" class="form-control" id="receiving_qty" name="receiving_qty" placeholder="Enter quantity" required>
                                    </div>
                                </div>
                            </div>

                            <!-- receiving_header_id -->
                            <input type="hidden" class="form-control" id="header_id" name="receiving_header_id" value="{{ $receivingHeader->receiving_header_id }}" readonly>
                            <!-- receiving_detail_status -->
                            <input type="hidden" class="form-control" id="receiving_detail_status" name="receiving_detail_status" value="Pending" readonly>
                            <!-- confirmed_at -->
                            <input type="hidden" class="form-control" id="confirmed_at" name="confirmed_at" value="" readonly>
                            <!-- receiving_detail_type -->
                            <input type="hidden" class="form-control" id="receiving_detail_type" name="receiving_detail_type" value="Restock" readonly>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Product</button>
                        </div>
                        
                    </form>
            </div>
        </div>
    </div>

    <!-- Modal for Delete Receiving Detail -->
    <div class="modal fade" id="deleteReceivingDetailModal" tabindex="-1" role="dialog" aria-labelledby="deleteReceivingDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteReceivingDetailModalLabel">Delete Receiving Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form id="deleteReceivingDetailForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>
                            Are you sure you want to delete "<strong><span id="deleteReceivingDetailName"></span></strong>"?
                        </p>
                        <div class="alert alert-danger">
                            <span class="text-danger">
                                <i class="fas fa-exclamation-triangle"></i> <strong>WARNING</strong>
                            </span>
                            <p class="text-danger">
                                <small>This action cannot be undone. The selected receiving detail will be permanently deleted!</small>
                            </p>
                        </div>
                        <div class="form-group form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="confirm_delete" required>
                                I agree to the Terms & Conditions.
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Check this box to continue.</div>
                            </label>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No, keep it.</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete!</button>
                    </div>
                </form>
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
    
    <!-- Modal for Edit Receiving Detail -->
    <div class="modal fade" id="editReceivingDetailModal" tabindex="-1" role="dialog" aria-labelledby="editReceivingDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="editReceivingDetailModalLabel">Edit Receiving Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form id="editReceivingDetailForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <!-- Detail ID -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Detail ID:</label>
                            <input type="text" class="form-control" id="edit_receiving_detail_id" name="receiving_detail_id" readonly>
                        </div>

                        <div class="row">
                                <div class="col">
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">Product:</label>
                                        <select class="form-control selectpicker" id="edit_product_id" name="product_id" data-live-search="true" required>
                                            <option value="" disabled>Select a product</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">Quantity:</label>
                                        <input type="number" class="form-control" id="edit_receiving_qty" name="receiving_qty" placeholder="Enter quantity" required>
                                    </div>
                                </div>
                            </div>

                            <!-- receiving_detail_status -->
                            <input type="hidden" class="form-control" id="edit_receiving_detail_status" name="receiving_detail_status" readonly>
                       
                           

                        </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Confirm Receiving -->
    <div class="modal fade" id="confirmReceivingModal" tabindex="-1" role="dialog" aria-labelledby="confirmReceivingModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmReceivingModalLabel">Confirm Receiving</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p>Are you sure you want to confirm this receiving? This action will update the status and product quantities.</p>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form id="confirmReceivingForm" method="POST" action="{{ route('receiving.confirm', $receivingHeader->receiving_header_id) }}">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



</div>


@section('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Bootstrap Select JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#receivingHeaderTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });

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

            // Inisialisasi Bootstrap Select
            $('.selectpicker').selectpicker({
                liveSearch: true,
                style: 'btn-light',
                size: 5
            });

          // Generate random receiving_detail_id when the modal is shown
            $('#addReceivingDetailModal').on('show.bs.modal', function() {
                const randomId = 'DET-' + Math.floor(100000 + Math.random() * 900000); // Generate random ID
                $('#receiving_detail_id').val(randomId); // Set the value of receiving_detail_id input
            });

            // Handle click event on "EDIT" button
            $('.btn-edit').on('click', function() {
                const detailId = $(this).data('receiving_detail_id'); // Ambil ID receiving detail dari tombol

                if (!detailId) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Receiving detail ID is undefined. Please try again.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Lakukan permintaan AJAX ke server
                $.ajax({
                    url: `/receiving/detail-modal/${detailId}`, // URL rute Laravel
                    method: 'GET',
                    success: function(data) {
                        // Isi modal dengan data receiving detail
                        $('#edit_receiving_detail_id').val(data.receiving_detail_id);
                        $('#edit_product_id').val(data.product_id).selectpicker('refresh');
                        $('#edit_receiving_qty').val(data.receiving_qty);
                        $('#edit_receiving_detail_status').val(data.receiving_detail_status);

                        // Set action URL untuk form edit
                        $('#editReceivingDetailForm').attr('action', `/receiving/detail/${detailId}`);

                        // Tampilkan modal
                        $('#editReceivingDetailModal').modal('show');
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to fetch receiving detail. Please try again.',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // Handle click event on "SHOW" button
            $('.btn-show').on('click', function() {
                const productId = $(this).data('product_id'); // Ambil ID produk

                // Lakukan permintaan AJAX ke server
                $.ajax({
                    url: `/products/${productId}/detail`, // URL rute Laravel
                    method: 'GET',
                    success: function(data) {
                        // Isi modal dengan data produk
                        $('#detailProductId').text(data.product_id);
                        $('#detailProductName').text(data.product_name);
                        $('#detailProductCategory').text(data.category_name);
                        $('#detailProductDescription').text(data.product_description);
                        $('#detailPurchasePrice').text("Rp " + parseFloat(data.purchase_price).toLocaleString('id-ID', { minimumFractionDigits: 2 }));
                        $('#detailSellingPrice').text("Rp " + parseFloat(data.selling_price).toLocaleString('id-ID', { minimumFractionDigits: 2 }));
                        $('#detailProductQty').text(data.product_qty);
                        $('#detailProductUnit').text(data.unit_name);
                        $('#detailSupplierId').text(data.supplier_name);

                        // Atur warna badge berdasarkan status produk
                        const statusElement = $('#detailProductStatus');
                        statusElement.text(data.product_status);
                        if (data.product_status === 'active') {
                            statusElement.removeClass('badge-danger').addClass('badge-success');
                        } else if (data.product_status === 'inactive') {
                            statusElement.removeClass('badge-success').addClass('badge-danger');
                        }

                        // Tampilkan gambar produk
                        if (data.product_img) {
                            $('#detailProductImage').attr('src', data.product_img);
                        } else {
                            $('#detailProductImage').attr('src', '/img/default-product.png'); // Gambar default
                        }

                        // Tampilkan modal
                        $('#productDetailModal').modal('show');
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to fetch product details. Please try again.',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // Handle click event on "DELETE" button
            $('.btn-delete').on('click', function() {
                const detailId = $(this).data('receiving_detail_id'); // Ambil ID receiving detail dari tombol
                const productName = $(this).closest('tr').find('td:nth-child(3)').text(); // Ambil nama produk dari tabel

                if (!detailId) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Receiving detail ID is undefined. Please try again.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Isi modal dengan data receiving detail
                $('#deleteReceivingDetailName').text(productName);

                // Set action URL untuk form delete
                const deleteUrl = `/receiving/detail/${detailId}`;
                $('#deleteReceivingDetailForm').attr('action', deleteUrl);

                // Tampilkan modal
                $('#deleteReceivingDetailModal').modal('show');
            });
        });
    </script>
@endsection

@endsection