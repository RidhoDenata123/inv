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
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-file-invoice-dollar"></i> Dispatching Detail</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Dispatching Detail Information</h6>
        </div>
        <div class="card-body">

            <table class="table table-bordered table-sm">
                <tr>
                    <td><span class="font-weight-bold">Dispatching Header ID : </span> {{ $dispatchingHeader->dispatching_header_id }}</td>
                    <td><span class="font-weight-bold">Designation : </span>{{ $dispatchingHeader->dispatching_header_name }}</td>
                </tr>
                <tr>
                    <td><span class="font-weight-bold">Created Date : </span>{{ $dispatchingHeader->created_at ? \Carbon\Carbon::parse($dispatchingHeader->created_at)->timezone('Asia/Jakarta')->format('l, d F Y H:i') : 'N/A' }}</td>
                    <td><span class="font-weight-bold">Created By : </span>{{ $dispatchingHeader->created_by ? \App\Models\User::find($dispatchingHeader->created_by)->name : 'N/A' }}</td>
                </tr>
                <tr>
                    <td><span class="font-weight-bold">Confirmation Date : </span>{{ $dispatchingHeader->confirmed_at ? \Carbon\Carbon::parse($dispatchingHeader->confirmed_at)->timezone('Asia/Jakarta')->format('l, d F Y H:i') : 'N/A' }}</td>
                    <td><span class="font-weight-bold">Confirmed By : </span>{{ $dispatchingHeader->confirmed_by ? \App\Models\User::find($dispatchingHeader->confirmed_by)->name : 'N/A' }}</td>
                </tr>
                <tr>
                    <td><span class="font-weight-bold">Last Update : </span>{{ $dispatchingHeader->updated_at ? \Carbon\Carbon::parse($dispatchingHeader->updated_at)->timezone('Asia/Jakarta')->format('l, d F Y H:i') : 'N/A' }}</td>
                    <td><span class="font-weight-bold">Customer : </span>{{ $dispatchingHeader->customer_id ? \App\Models\customer::find($dispatchingHeader->customer_id)->customer_name : 'N/A' }}</td>
                </tr>
                <tr>
                    <td><span class="font-weight-bold">Description : </span>{{ $dispatchingHeader->dispatching_header_description }}</td>
                    <td><span class="font-weight-bold">Status : </span>
                        <span class="badge 
                            {{ $dispatchingHeader->dispatching_header_status === 'Confirmed' ? 'badge-success' : 'badge-warning' }}">
                            {{ ucfirst($dispatchingHeader->dispatching_header_status) }}
                        </span>
                    </td>
                </tr>
                
            </table>

            @if ($dispatchingHeader->dispatching_header_status === 'Pending')
                <a href="#" class="btn btn-md btn-success mb-3" data-toggle="modal" data-target="#addDispatchingDetailModal"><i class='fas fa-plus'></i> ADD PRODUCT</a>
            @endif

            <div class="table-responsive">
                <table id="dispatchingDetailTable" class="table table-bordered table-sm">
                    <thead class="text-center">
                        <tr>
                            <th scope="col" rowspan="2">No.</th>
                            <th scope="col" rowspan="2">Detail ID</th>
                            <th scope="col" colspan="2">Product</th>
                            <th scope="col" rowspan="2">Dispatching Qty</th>
                            <th scope="col" rowspan="2">Unit</th>
                            <th scope="col" colspan="2">Creation</th>
                            <th scope="col" colspan="2">Confirmation</th>
                            <th scope="col" rowspan="2">Detail Status</th>
                            <th scope="col" rowspan="2">ACTIONS</th>
                        </tr>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Date</th>
                            <th scope="col">By</th>
                            <th scope="col">Date</th>
                            <th scope="col">By</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($dispatchingDetails as $detail)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $detail->dispatching_detail_id }}</td>
                                <td>
                                    <a href="#" 
                                        class="btn-show text-primary" 
                                        data-product_id="{{ $detail->product_id }}" 
                                        data-toggle="modal" 
                                        data-target="#productDetailModal">
                                        {{ $detail->product_id }}
                                    </a>
                                </td>
                                <td>{{ $detail->product_id ? $detail->product->product_name : 'No product name' }}</td>
                                <td>{{ $detail->dispatching_qty }}</td>
                                <td>{{ $detail->product_id ? $detail->product->unit->unit_name : 'No unit' }}</td>
                                <td>{{ $detail->created_at ? \Carbon\Carbon::parse($detail->created_at)->timezone('Asia/Jakarta')->format('l, d F Y H:i') : 'N/A' }}</td>
                                <td>{{ $detail->created_by ? \App\Models\User::find($detail->created_by)->name : 'N/A' }}</td>
                                <td>{{ $detail->confirmed_at ? \Carbon\Carbon::parse($detail->confirmed_at)->timezone('Asia/Jakarta')->format('l, d F Y H:i') : 'N/A' }}</td>
                                <td>{{ $detail->confirmed_by ? \App\Models\User::find($detail->confirmed_by)->name : 'N/A' }}</td>
                                <td>
                                    <span class="badge 
                                        {{ $detail->dispatching_detail_status === 'Confirmed' ? 'badge-success' : 'badge-warning' }}">
                                        {{ ucfirst($detail->dispatching_detail_status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        @if ($detail->dispatching_detail_status === 'Confirmed')
                                            <!-- Tombol Show Detail -->
                                            <a href="#" 
                                            class="btn btn-sm btn-dark btn-show mr-2" 
                                            data-product_id="{{ $detail->product_id }}" 
                                            data-toggle="modal" 
                                            data-target="#productDetailModal">
                                                <i class="fas fa-search"></i>
                                            </a>
                                        @elseif ($detail->dispatching_detail_status === 'Pending')
                                            <!-- Tombol Confirm -->
                                            <button type="button" 
                                                    class="btn btn-sm btn-success btn-confirm mr-2" 
                                                    data-dispatching_detail_id="{{ $detail->dispatching_detail_id }}" 
                                                    data-toggle="modal" 
                                                    data-target="#confirmDetailModal">
                                                <i class="fas fa-check"></i>
                                            </button>

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
                                            data-dispatching_detail_id="{{ $detail->dispatching_detail_id }}" 
                                            data-toggle="modal" 
                                            data-target="#editDispatchingDetailModal">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Tombol Delete -->
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger btn-delete" 
                                                    data-dispatching_detail_id="{{ $detail->dispatching_detail_id }}" 
                                                    data-toggle="modal" 
                                                    data-target="#deleteDispatchingDetailModal">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center">No data available in table</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <hr>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <a href="{{ route('dispatching.header') }}" class="btn btn-secondary">Back to List</a>

                @if ($dispatchingHeader->dispatching_header_status === 'Pending')
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmDispatchingModal">
                        Confirm All
                    </button>
                @endif
            </div>
        </div>
    </div>

    

    <!-- Modal for Add Dispatching Detail -->
    <div class="modal fade" id="addDispatchingDetailModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Add Product</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <form action="{{ route('dispatching.detail.addDetail') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">

                            <!-- Detail ID -->
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Detail ID :</label>
                                <input type="text" class="form-control" id="dispatching_detail_id" name="dispatching_detail_id" value="" readonly>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">Product:</label>
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
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" id="dispatching_qty" name="dispatching_qty" placeholder="Enter quantity" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="product_unit">unit</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        
                            </div>
                            <input type="hidden" name="dispatching_header_id" value="{{ $dispatchingHeader->dispatching_header_id }}">
                            <input type="hidden" name="dispatching_detail_status" value="Pending">
                            <input type="hidden" name="created_by" value="{{ Auth::user()->id }}">
    
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

    <!-- Modal for Delete Dispatching Detail -->
    <div class="modal fade" id="deleteDispatchingDetailModal" tabindex="-1" role="dialog" aria-labelledby="deleteReceivingDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteDispatchingDetailModalLabel">Delete Dispatching Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form id="deleteDispatchingDetailForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>
                        <span class="text-primary"> {{ Auth::user()->name }}</span>, are you sure you want to delete "<strong><span id="deleteDispatchingDetailName"></span></strong>"?
                        </p>
                        <div class="alert alert-danger">
                            <span class="text-danger">
                                <i class="fas fa-exclamation-triangle"></i> <strong>WARNING</strong>
                            </span>
                            <p class="text-danger">
                                <small>This action cannot be undone. The selected dispatching detail will be permanently deleted!</small>
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No, keep it</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Edit Dispatching Detail -->
    <div class="modal fade" id="editDispatchingDetailModal" tabindex="-1" role="dialog" aria-labelledby="editDispatchingDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="editDispatchingDetailModalLabel">Edit Dispatching Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form id="editDispatchingDetailForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <!-- Detail ID -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Detail ID:</label>
                            <input type="text" class="form-control" id="edit_dispatching_detail_id" name="dispatching_detail_id" readonly>
                        </div>

                        <div class="row">
                            <!-- Product Dropdown -->
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

                            <!-- Quantity Input -->
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">Quantity:</label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" id="edit_dispatching_qty" name="dispatching_qty" placeholder="Enter quantity" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="edit_product_unit">unit</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dispatching Detail Status -->
                        <input type="hidden" class="form-control" id="edit_dispatching_detail_status" name="dispatching_detail_status" readonly>
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

    <!-- Modal for Confirm All Dispatching -->
    <div class="modal fade" id="confirmDispatchingModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmReceivingModalLabel">Confirm All Pending Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><span class="text-primary">{{ Auth::user()->name }}</span>, Are you sure you want to confirm all pending dispatching details?</p>
                    <div class="alert alert-primary">
                        <span class="text-primary">
                            <i class="fas fa-exclamation-circle"></i> <strong>ATTENTION</strong>
                        </span>
                        <p class="text-dark">
                            <small>This action will set the dispatching as confirmed and immediately process the selected products for dispatching.</small>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Cancel</button>
                    <form id="confirmAllForm" method="POST" action="{{ route('dispatching.confirmAll', $dispatchingHeader->dispatching_header_id) }}">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-primary">Yes, Confirm All</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Confirm Dispatching per Detail -->
    <div class="modal fade" id="confirmDetailModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDetailModalLabel">Confirm Dispatching Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <p><span class="text-primary"> {{ Auth::user()->name }}</span>, are you sure you want to confirm "<strong><span id="confirmDispatchingDetailName"></span></strong>"?</p>
                        <div class="alert alert-success">
                            <span class="text-success">
                                <i class="fas fa-exclamation-circle"></i> <strong>ATTENTION</strong>
                            </span>
                            <p class="text-dark">
                                <small>This action will set the selected shipment as confirmed and immediately process the selected products for shipment.</small>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Cancel</button>
                    <form id="confirmDetailForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success">Yes, Confirm</button>
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
            $('#dispatchingDetailTable').DataTable({
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

            // Generate random dispatching_detail_id when the modal is shown
            $('#addDispatchingDetailModal').on('show.bs.modal', function() {
                const randomId = 'DET-' + Math.floor(100000 + Math.random() * 900000); // Generate random ID
                $('#dispatching_detail_id').val(randomId); // Set the value of dispatching_detail_id input
            });

            // Handle click event on "EDIT" button
            $('.btn-edit').on('click', function() {
                const detailId = $(this).data('dispatching_detail_id'); // Ambil ID dispatching detail dari tombol

                if (!detailId) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Dispatching detail ID is undefined. Please try again.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Lakukan permintaan AJAX ke server
                $.ajax({
                    url: `/dispatching/detail-modal/${detailId}`, // URL rute Laravel
                    method: 'GET',
                    success: function(data) {
                        // Isi modal dengan data dispatching detail
                        $('#edit_dispatching_detail_id').val(data.dispatching_detail_id);
                        $('#edit_product_id').val(data.product_id).selectpicker('refresh');
                        $('#edit_dispatching_qty').val(data.dispatching_qty);
                        $('#edit_dispatching_detail_status').val(data.dispatching_detail_status);

                        // Set action URL untuk form edit
                        $('#editDispatchingDetailForm').attr('action', `/dispatching/detail/${detailId}`);


                        // Setelah data produk diisi, panggil AJAX untuk mendapatkan unit
                        const productId = data.product_id;
                        console.log('Product ID:', productId); // Debugging: pastikan productId benar

                        if (productId) {
                            $.ajax({
                                url: `/products/${productId}/unit`, // Endpoint untuk mendapatkan unit
                                method: 'GET',
                                success: function(response) {
                                    // Tampilkan unit di input-group-append
                                    $('#edit_product_unit').text(response.unit_name);
                                },
                                error: function(xhr) {
                                    // Jika terjadi error, tampilkan pesan default
                                    $('#edit_product_unit').text('unit');
                                    console.error('Failed to fetch unit:', xhr.responseText);
                                }
                            });
                        } else {
                            // Reset unit jika tidak ada produk yang dipilih
                            $('#edit_product_unit').text('unit');
                        }
                        


                        // Tampilkan modal
                        $('#editDispatchingDetailModal').modal('show');
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to fetch dispatching detail. Please try again.',
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
                const detailId = $(this).data('dispatching_detail_id'); // Ambil ID dispatching detail dari tombol
                const productName = $(this).closest('tr').find('td:nth-child(3)').text(); // Ambil nama produk dari tabel

                if (!detailId) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Dispatching detail ID is undefined. Please try again.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Isi modal dengan data dispatching detail
                $('#deleteDispatchingDetailName').text(detailId);

                // Set action URL untuk form delete
                const deleteUrl = `/dispatching/detail/${detailId}`;
                $('#deleteDispatchingDetailForm').attr('action', deleteUrl);

                // Tampilkan modal
                $('#deleteDispatchingDetailModal').modal('show');
            });

            // Handle click event on "Confirm" button per detail
            $('.btn-confirm').on('click', function() {
                const detailId = $(this).data('dispatching_detail_id'); // Ambil ID dispatching detail dari tombol
                const productName = $(this).closest('tr').find('td:nth-child(3)').text(); // Ambil nama produk dari tabel

                if (!detailId) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Dispatching detail ID is undefined. Please try again.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                // Isi modal dengan data dispatching detail
                $('#confirmDispatchingDetailName').text(detailId);

                // Set action URL untuk form confirm
                const confirmUrl = `/dispatching/detail/confirm/${detailId}`;
                $('#confirmDetailForm').attr('action', confirmUrl);

                // Tampilkan modal
                $('#confirmDetailModal').modal('show');
            });

            // APPEND UNIT ADD DETAIL
            $('#product_id').on('change', function() {
                const productId = $(this).val(); // Ambil product_id yang dipilih

                if (productId) {
                    // Lakukan permintaan AJAX ke server
                    $.ajax({
                        url: `/products/${productId}/unit`, // Endpoint untuk mendapatkan unit
                        method: 'GET',
                        success: function(response) {
                            // Tampilkan unit di input-group-append
                            $('#product_unit').text(response.unit_name);
                        },
                        error: function(xhr) {
                            $('#product_unit').text('unit'); // Reset unit jika terjadi error
                            console.error('Failed to fetch unit:', xhr.responseText);
                        }
                    });
                } else {
                    $('#product_unit').text('unit'); // Reset unit jika tidak ada produk yang dipilih
                }
            });

            // APPEND UNIT EDIT DETAIL
            $('#edit_product_id').on('change', function() {
                const productId = $(this).val(); // Ambil product_id yang dipilih

                if (productId) {
                    // Lakukan permintaan AJAX ke server
                    $.ajax({
                        url: `/products/${productId}/unit`, // Endpoint untuk mendapatkan unit
                        method: 'GET',
                        success: function(response) {
                            $('#edit_product_unit').text(response.unit_name); // Tampilkan unit
                        },
                        error: function(xhr) {
                            $('#edit_product_unit').text('unit'); // Reset unit jika terjadi error
                            console.error('Failed to fetch unit:', xhr.responseText);
                        }
                    });
                } else {
                    $('#edit_product_unit').text('unit'); // Reset unit jika tidak ada produk yang dipilih
                }
            });

            // Ketika modal Edit Dispatching Detail ditampilkan
            $('#editDispatchingDetailModal').on('show.bs.modal', function() {
                const productId = $('#edit_product_id').val(); // Ambil product_id yang sudah dipilih

                if (productId) {
                    // Lakukan permintaan AJAX ke server untuk mendapatkan unit
                    $.ajax({
                        url: `/products/${productId}/unit`, // Endpoint untuk mendapatkan unit
                        method: 'GET',
                        success: function(response) {
                            $('#edit_product_unit').text(response.unit_name); // Tampilkan unit
                        },
                        error: function(xhr) {
                            $('#edit_product_unit').text('unit'); // Reset unit jika terjadi error
                            console.error('Failed to fetch unit:', xhr.responseText);
                        }
                    });
                } else {
                    $('#edit_product_unit').text('unit'); // Reset unit jika tidak ada produk yang dipilih
                }
            });
            
        });
    </script>
@endsection

@endsection