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
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-file-invoice-dollar"></i> DISPATCHING</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DISPATCHING HEADER TABLE</h6>
        </div>
        <div class="card-body">
            <a href="#" class="btn btn-md btn-success mb-3" data-toggle="modal" data-target="#addDispatchingHeaderModal"><i class='fas fa-plus'></i> Add Dispatching</a>
           
            <div class="table-responsive">
                <table id="dispatchingHeaderTable" class="table table-bordered table-sm">
                    <thead class="text-center">
                        <tr>
                            <th scope="col" rowspan="2">No.</th>
                            <th scope="col" rowspan="2">Dispatching ID</th>
                            <th scope="col" rowspan="2">Designation</th>
                            <th scope="col" rowspan="2">Customer</th>
                            <th scope="col" colspan="2">Creation</th>
                            <th scope="col" colspan="2">Confirmation</th>
                            <th scope="col" rowspan="2">Dispatching Status</th>
                            <th scope="col" rowspan="2">ACTIONS</th>
                        </tr>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">By</th>
                            <th scope="col">Date</th>
                            <th scope="col">By</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($dispatching_headers as $header)
                            <tr>
                                <td>{{ ($dispatching_headers->currentPage() - 1) * $dispatching_headers->perPage() + $loop->iteration }}.</td>
                                <td>{{ $header->dispatching_header_id }}</td>
                                <td>{{ $header->dispatching_header_name }}</td>
                                <td>{{ $header->customer_id ? \App\Models\Customer::find($header->customer_id)->customer_name : 'N/A' }}</td>
                                <td>{{ $header->created_at ? \Carbon\Carbon::parse($header->created_at)->timezone('Asia/Jakarta')->format('l, d F Y H:i') : 'N/A' }}</td>
                                <td>{{ $header->created_by ? \App\Models\User::find($header->created_by)->name : 'N/A' }}</td>
                                <td>{{ $header->confirmed_at ? \Carbon\Carbon::parse($header->confirmed_at)->timezone('Asia/Jakarta')->format('l, d F Y H:i') : 'N/A' }}</td>
                                <td>{{ $header->confirmed_by ? \App\Models\User::find($header->confirmed_by)->name : 'N/A' }}</td>
                                <td>                                
                                    <span class="badge 
                                        {{ $header->dispatching_header_status === 'Confirmed' ? 'badge-success' : 'badge-warning' }}">
                                        {{ ucfirst($header->dispatching_header_status) }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        @if ($header->dispatchingDetails->where('dispatching_detail_status', 'Confirmed')->isNotEmpty())
                                            <!-- Tombol Show Detail -->
                                            <a href="{{ route('dispatching.detail.ShowById', $header->dispatching_header_id) }}" 
                                            class="btn btn-sm btn-dark mr-2">
                                                <i class="fas fa-search"></i>
                                            </a>
                                        @else
                                            <!-- Tombol Show -->
                                            <a href="{{ route('dispatching.detail.ShowById', $header->dispatching_header_id) }}" 
                                            class="btn btn-sm btn-dark mr-2">
                                                <i class="fas fa-search"></i>
                                            </a>

                                            <!-- Tombol Edit -->
                                            <a href="#" 
                                            class="btn btn-sm btn-primary btn-edit mr-2" 
                                            data-dispatching_id="{{ $header->dispatching_header_id }}" 
                                            data-toggle="modal" 
                                            data-target="#editDispatchingHeaderModal">
                                                <i class="fas fa-edit"></i> 
                                            </a>

                                            <!-- Tombol Delete -->
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger btn-delete" 
                                                    data-dispatching_id="{{ $header->dispatching_header_id }}" 
                                                    data-toggle="modal" 
                                                    data-target="#deleteDispatchingHeaderModal">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">No data available in table</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                    <!-- Info Jumlah Data dan Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <!-- Info Jumlah Data -->
                        <div class="table">
                            <p class="mb-0">
                                Showing {{ $dispatching_headers->firstItem() }} to {{ $dispatching_headers->lastItem() }} of {{ $dispatching_headers->total() }} entries
                            </p>
                        </div>

                        <!-- Laravel Pagination -->
                        <div>
                            {{ $dispatching_headers->links('pagination::simple-bootstrap-4') }}
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <!-- Modal for Add Dispatching Header -->
    <div class="modal fade" id="addDispatchingHeaderModal" tabindex="-1" role="dialog" aria-labelledby="addDispatchingHeaderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="addDispatchingHeaderModalLabel">Add Dispatching Header</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal Body -->
                <form action="{{ route('dispatching.header.storeHeader') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="dispatching_header_id" class="font-weight-bold">Dispatching Header ID :</label>
                            <input type="text" class="form-control" id="addDispatchingHeaderId" name="dispatching_header_id" readonly>
                            @error('dispatching_header_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                       <div class="form-group">
                            <label for="adjust_qty_before" class="font-weight-bold">Designation :</label>
                            <select name="dispatching_header_name" class="custom-select @error('dispatching_header_name') is-invalid @enderror" required>
                                <option value="">Select Designation</option>
                                <option value="Sales Order">Sales Order</option>
                                <option value="Transfer Out">Transfer Out</option>
                                <option value="Return from Customer">Return to Supplier</option>
                            
                            </select>
                            @error('dispatching_header_name')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>




                        <div class="form-group">
                            <label for="customer_id" class="font-weight-bold">Customer :</label>
                            <select class="form-control selectpicker" id="customer_id" name="customer_id" data-live-search="true" required>
                                <option value="" disabled selected>Select a customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Description :</label>
                            <textarea class="form-control @error('dispatching_header_description') is-invalid @enderror" id="dispatching_header_description" name="dispatching_header_description" rows="3" placeholder="Enter description">{{ old('dispatching_header_description') }}</textarea>
                            @error('dispatching_header_description')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- created_by -->
                        <input type="hidden" class="form-control" name="created_by" value="{{ Auth::user()->id }}" readonly>
                        <!-- dispatching_header_status -->
                        <input type="hidden" class="form-control" name="dispatching_header_status" value="Pending" readonly>
                        <!-- confirmed_at -->
                        <input type="hidden" class="form-control" name="confirmed_at" value="" readonly>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    
    </div>

    <!-- Modal for Delete Dispatching Header -->
    <div class="modal fade" id="deleteDispatchingHeaderModal" tabindex="-1" role="dialog" aria-labelledby="deleteDispatchingHeaderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteDispatchingHeaderModalLabel">Delete Dispatching Header</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form id="deleteDispatchingHeaderForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>
                            <span class="text-primary">{{ Auth::user()->name }}</span>, are you sure you want to delete 
                            "<strong><span id="deleteDispatchingHeaderId"></span></strong>"?
                        </p>
                        <div class="alert alert-danger">
                            <span class="text-danger">
                                <i class="fas fa-exclamation-triangle"></i> <strong>WARNING</strong>
                            </span>
                            <p class="text-danger">
                                <small>This action cannot be undone. The selected dispatching header data will be permanently deleted!</small>
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

    <!-- Modal for Edit Dispatching Header -->
    <div class="modal fade" id="editDispatchingHeaderModal" tabindex="-1" role="dialog" aria-labelledby="editDispatchingHeaderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="editDispatchingHeaderModalLabel">Edit Dispatching Header</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form id="editDispatchingHeaderForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editDispatchingHeaderId" class="font-weight-bold">Dispatching Header ID:</label>
                            <input type="text" class="form-control" id="editDispatchingHeaderId" name="dispatching_header_id" readonly>
                        </div>

                        <div class="form-group">
                            <label for="editDispatchingHeaderName" class="font-weight-bold">Designation:</label>
                            <input type="text" class="form-control @error('dispatching_header_name') is-invalid @enderror" id="editDispatchingHeaderName" name="dispatching_header_name" required>
                            @error('dispatching_header_name')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="edit_customer_id" class="font-weight-bold">Customer :</label>
                            <select class="form-control selectpicker" id="edit_customer_id" name="customer_id" data-live-search="true" required>
                                <option value="" disabled>Select a customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="editDispatchingHeaderDescription" class="font-weight-bold">Dispatching Header Description:</label>
                            <textarea class="form-control @error('dispatching_header_description') is-invalid @enderror" id="editDispatchingHeaderDescription" name="dispatching_header_description" rows="3" required></textarea>
                            @error('dispatching_header_description')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

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
</div>

@section('scripts')

<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Bootstrap Select JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>

<!-- Datatable -->
<script>
    $(document).ready(function() {
        $('#dispatchingHeaderTable').DataTable({
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

        // Generate random dispatching_header_id when the modal is shown
        $('#addDispatchingHeaderModal').on('show.bs.modal', function() {
            const randomId = 'DISP-' + Math.floor(100000 + Math.random() * 900000); // Generate random ID
            $('#addDispatchingHeaderId').val(randomId); // Set the value of dispatching_header_id input
        });

        // Handle click event on "EDIT" button
        $('.btn-edit').on('click', function() {
            const dispatchingId = $(this).data('dispatching_id'); // Ambil ID dispatching header dari tombol

            // Lakukan permintaan AJAX ke server
            $.ajax({
                url: `/dispatching/header/${dispatchingId}`, // URL rute Laravel untuk mendapatkan detail dispatching header
                method: 'GET',
                success: function(data) {
                    // Isi modal dengan data dispatching header
                    $('#editDispatchingHeaderId').val(data.dispatching_header_id);
                    $('#editDispatchingHeaderName').val(data.dispatching_header_name);
                    $('#editDispatchingHeaderDescription').val(data.dispatching_header_description);
                    $('#edit_customer_id').val(data.customer_id).selectpicker('refresh'); // Pilih customer yang sesuai

                    // Set action URL untuk form edit
                    $('#editDispatchingHeaderForm').attr('action', `/dispatching/header/${dispatchingId}`);

                    // Tampilkan modal
                    $('#editDispatchingHeaderModal').modal('show');
                },
                error: function(xhr) {
                    // Tampilkan pesan error jika gagal
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch dispatching header details. Please try again.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // Handle click event on "DELETE" button
        $('.btn-delete').on('click', function() {
            const dispatchingId = $(this).data('dispatching_id'); // Ambil ID dispatching header dari tombol
            const dispatchingName = $(this).closest('tr').find('td:nth-child(3)').text(); // Ambil nama dispatching header dari tabel

            if (!dispatchingId) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Dispatching header ID is undefined. Please try again.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Isi modal dengan data dispatching header
            $('#deleteDispatchingHeaderId').text(dispatchingName);

            // Set action URL untuk form delete
            const deleteUrl = `/dispatching/header/${dispatchingId}`;
            $('#deleteDispatchingHeaderForm').attr('action', deleteUrl);

            // Tampilkan modal
            $('#deleteDispatchingHeaderModal').modal('show');
        });
    });
</script>
@endsection

@endsection