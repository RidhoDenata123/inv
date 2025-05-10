
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

        .pagination {
            margin: 0; /* Hilangkan margin default */
        }
        .table-responsive .pagination {
            justify-content: flex-end; /* Posisikan pagination di kanan */
        }
    </style>


    @endsection

@section('content')

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-file-invoice"></i> RECEIVING DETAIL</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">RECEIVING DETAIL INFORMATION</h6>
        </div>
        <div class="card-body">

            <table class="table table-bordered table-sm">
                <tr>
                    <td><span class="font-weight-bold">Receiving Header ID : </span> {{ $receivingHeader->receiving_header_id }}</td>
                    <td><span class="font-weight-bold">Designation : </span>{{ $receivingHeader->receiving_header_name }}</td>
                </tr>
                <tr>
                    <td><span class="font-weight-bold">Created By : </span>{{ $receivingHeader->created_by ? \App\Models\User::find($receivingHeader->created_by)->name : 'N/A' }}</td>
                    <td><span class="font-weight-bold">Created Date : </span>{{ $receivingHeader->created_at }}</td>
                </tr>
                <tr>
                    <td><span class="font-weight-bold">Confirmation Date : </span>{{ $receivingHeader->confirmed_at }}</td>
                    <td><span class="font-weight-bold">Confirmed By : </span>{{ $receivingHeader->confirmed_by ? \App\Models\User::find($receivingHeader->confirmed_by)->name : 'N/A' }}</td>
                </tr>
                <tr>
                    <td><span class="font-weight-bold">Description : </span>{{ $receivingHeader->receiving_header_description }}</td>
                    <td><span class="font-weight-bold">Status : </span>
                        <span class="badge 
                            {{ $receivingHeader->receiving_header_status === 'Confirmed' ? 'badge-success' : 'badge-warning' }}">
                            {{ ucfirst($receivingHeader->receiving_header_status) }}
                        </span>
                    </td>
                </tr>

            </table>

        @if ($receivingHeader->receiving_header_status === 'Pending')
            <a href="#" class="btn btn-md btn-success mb-3" data-toggle="modal" data-target="#addReceivingDetailModal"><i class='fas fa-plus'></i> Receive Product</a>
        @endif
           

            <div class="table-responsive">
                <table id="receivingDetailTable" class="table table-bordered table-sm">
                    <thead class="text-center">

                    <tr>
                            <th scope="col" rowspan="2">No.</th>
                            <th scope="col" rowspan="2">Detail ID</th>
                            <th scope="col" colspan="2">Product</th>
                            <th scope="col" rowspan="2">Receiving Qty</th>
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
                        @forelse ($receivingDetails as $detail)
                            <tr>
                                <td>{{ ($receivingDetails->currentPage() - 1) * $receivingDetails->perPage() + $loop->iteration }}.</td>
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
                                <td>{{ $detail->product_id ? $detail->product->product_name : 'No product name' }}</td>
                                <td>{{ $detail->receiving_qty }}</td>
                                <td>{{ $detail->product_id ? ($detail->product->unit->unit_name ?? 'No unit') : 'No unit' }}</td>
                                <td>{{ $detail->created_at ? \Carbon\Carbon::parse($detail->created_at)->timezone('Asia/Jakarta')->format('l, d F Y H:i') : 'N/A' }}</td>
                                <td>{{ $detail->created_by ? \App\Models\User::find($detail->created_by)->name : 'N/A' }}</td>
                                <td>{{ $detail->confirmed_at ? \Carbon\Carbon::parse($detail->confirmed_at)->timezone('Asia/Jakarta')->format('l, d F Y H:i') : 'N/A' }}</td>
                                <td>{{ $detail->confirmed_by ? \App\Models\User::find($detail->confirmed_by)->name : 'N/A' }}</td>
                                <td>
                                    <span class="badge 
                                        {{ $detail->receiving_detail_status === 'Confirmed' ? 'badge-success' : 'badge-warning' }}">
                                        {{ ucfirst($detail->receiving_detail_status) }}
                                    </span>
                                </td>




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

                                            <!-- Tombol Confirm -->
                                            <button type="button" 
                                                class="btn btn-sm btn-success btn-confirm mr-2" 
                                                data-receiving_detail_id="{{ $detail->receiving_detail_id }}" 
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
                            <td colspan="12" class="text-center">No data available in table</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                    <!-- Info Jumlah Data dan Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <!-- Info Jumlah Data -->
                        <div class="table">
                            <p class="mb-0">
                                Showing {{ $receivingDetails->firstItem() }} to {{ $receivingDetails->lastItem() }} of {{ $receivingDetails->total() }} entries
                            </p>
                        </div>

                        <!-- Laravel Pagination -->
                        <div>
                            {{ $receivingDetails->links('pagination::simple-bootstrap-4') }}
                        </div>
                    </div>

            </div>

            <hr>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <a href="{{ route('receiving.header') }}" class="btn btn-secondary">Back to List</a>

                @if ($receivingHeader->receiving_header_status === 'Pending')
                    
                @endif


                @if ($receivingHeader->receiving_header_status === 'Pending')
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmReceivingModal">
                    <i class="fas fa-check-square"></i> Confirm All
                    </button>

                @elseif ($receivingHeader->receiving_header_status === 'Confirmed')
                    <!-- Tombol View Document -->
                    <a href="{{ asset('storage/' . $receivingHeader->receiving_document) }}" 
                        class="btn btn-primary mr-2" 
                        target="_blank">
                        <i class="fas fa-file-alt"></i> View Document
                    </a>
                @endif

            </div>
            
        </div>
        
    </div>

    <!-- Modal for add Product -->
    <div class="modal fade" id="addReceivingDetailModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Add Product</h4>
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
                                        <label class="font-weight-bold">Quantity :</label>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" id="receiving_qty" name="receiving_qty" placeholder="Enter quantity" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="product_unit">unit</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        
                            </div>

                            <!-- receiving_header_id -->
                            <input type="hidden" class="form-control" id="header_id" name="receiving_header_id" value="{{ $receivingHeader->receiving_header_id }}" readonly>
                            <!-- receiving_detail_status -->
                            <input type="hidden" class="form-control" id="receiving_detail_status" name="receiving_detail_status" value="Pending" readonly>
                            <!-- confirmed_at -->
                            <input type="hidden" class="form-control" id="confirmed_at" name="confirmed_at" value="" readonly>
                            <!-- create_by -->
                            <input type="hidden" class="form-control" name="created_by" value="{{ Auth::user()->id }}" readonly>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Receive Product</button>
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
                        <span class="text-primary"> {{ Auth::user()->name }}</span>, are you sure you want to delete "<strong><span id="deleteReceivingDetailName"></span></strong>"?
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No, keep it</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
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
                            <label class="font-weight-bold">Detail ID :</label>
                            <input type="text" class="form-control" id="edit_receiving_detail_id" name="receiving_detail_id" readonly>
                        </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">Product :</label>
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
                                        <label class="font-weight-bold">Quantity :</label>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" id="edit_receiving_qty" name="receiving_qty" placeholder="Enter quantity" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="edit_product_unit"></span>
                                            </div>
                                        </div>
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

<!-- Modal for Confirm All Receiving -->
<div class="modal fade" id="confirmReceivingModal" tabindex="-1" role="dialog" aria-labelledby="confirmReceivingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="confirmReceivingModalLabel">Confirm All Pending Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <form id="confirmAllForm" method="POST" action="{{ route('receiving.confirmAll', $receivingHeader->receiving_header_id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <p><span class="text-primary">{{ Auth::user()->name }}</span>, Are you sure you want to confirm all pending receiving details?</p>
                    <div class="alert alert-primary">
                        <span class="text-primary">
                            <i class="fas fa-exclamation-circle"></i> <strong>ATTENTION</strong>
                        </span>
                        <p class="text-dark">
                            <small>This action will set the receiving as confirmed and immediately process the selected products to be added to inventory.</small>
                        </p>
                    </div>

                    <!-- Upload Document -->
                <div class="form-group mb-3">
                    <label class="font-weight-bold">Upload proof of receipt :</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('receiving_document') is-invalid @enderror" name="receiving_document" id="receiving_document" accept=".pdf,.jpg,.jpeg,.png" required>
                        <label class="custom-file-label" for="customFile">Choose file</label>
                        <!-- error message for receiving_document -->
                        @error('receiving_document')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Confirm All</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Modal for Confirm Receiving Detail by id -->
    <div class="modal fade" id="confirmDetailModal" tabindex="-1" role="dialog" aria-labelledby="confirmDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDetailModalLabel">Confirm Receiving Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                        <p> </p>
                        <p><span class="text-primary"> {{ Auth::user()->name }}</span>, are you sure you want to confirm "<strong><span id="confirmReceivingDetailName"></span></strong>"?</p>
                        <div class="alert alert-success">
                            <span class="text-success">
                                <i class="fas fa-exclamation-circle"></i> <strong>ATTENTION</strong>
                            </span>
                            <p class="text-dark">
                                <small>This action will set the selected receiving as confirmed and immediately process the selected products to be added to inventory.</small>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form id="confirmDetailForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success">Confirm</button>
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
        $('#receivingDetailTable').DataTable({
            "paging": false,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": false,
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
                $('#deleteReceivingDetailName').text(detailId);

                // Set action URL untuk form delete
                const deleteUrl = `/receiving/detail/${detailId}`;
                $('#deleteReceivingDetailForm').attr('action', deleteUrl);

                // Tampilkan modal
                $('#deleteReceivingDetailModal').modal('show');
            });

            // Handle click event on "Confirm" button per detail
            $('.btn-confirm').on('click', function() {
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

                // Isi modal dengan data receiving detail
                $('#confirmReceivingDetailName').text(detailId);

                // Set action URL untuk form confirm
                const confirmUrl = `/receiving/detail/confirm/${detailId}`;
                $('#confirmDetailForm').attr('action', confirmUrl);

                // Tampilkan modal
                $('#confirmDetailModal').modal('show');
            });

            // APPEND UNIT ADD DETAIL
            // Ketika produk dipilih pada modal Add Receiving Detail
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
                            // Jika terjadi error, tampilkan pesan default
                            $('#product_unit').text('unit');
                            console.error('Failed to fetch unit:', xhr.responseText);
                        }
                    });
                } else {
                    // Reset unit jika tidak ada produk yang dipilih
                    $('#product_unit').text('unit');
                }
            });
            
            // APPEND UNIT EDIT DETAIL
            // Ketika modal Edit Receiving Detail ditampilkan
            $('#editReceivingDetailModal').on('show.bs.modal', function() {
                    $('#edit_product_id').selectpicker('refresh'); // Refresh dropdown produk
                    const productId = $('#edit_product_id').val(); // Ambil product_id yang sudah dipilih

                    console.log('Product ID:', productId); // Debugging: pastikan productId benar

                    if (productId) {
                        // Lakukan permintaan AJAX ke server untuk mendapatkan unit
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
                });

                // Ketika produk dipilih pada modal Edit Receiving Detail
                $('#edit_product_id').on('change', function() {
                    const productId = $(this).val(); // Ambil product_id yang dipilih

                    if (productId) {
                        // Lakukan permintaan AJAX ke server
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
                });


                // Add the following code if you want the name of the file appear on select
                $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                });



        });
    </script>
@endsection

@endsection