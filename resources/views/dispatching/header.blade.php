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
                <table id="dispatchingHeaderTable" class="table table-bordered table-sm" style="width:100%">
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

                    </tbody>

                </table>

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
                            <label for="adjust_qty_before" class="font-weight-bold">Designation :</label>
                            <select name="dispatching_header_name" id="editDispatchingHeaderName" class="custom-select @error('dispatching_header_name') is-invalid @enderror" required>
                                <option value="">Select Designation</option>
                                <option value="Sales Order">Sales Order</option>
                                
                            </select>
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
    <!-- DataTables core -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- DataTables Responsive (setelah DataTables utama) -->
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>

    <!-- Bootstrap Select JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>

    <!-- Datatable -->
    <script>
        $(document).ready(function() {
            $('#dispatchingHeaderTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route("dispatching.header.datatable") }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'dispatching_header_id', name: 'dispatching_header_id' },
                    { data: 'designation', name: 'dispatching_header_name' },
                    { data: 'customer', name: 'customer.customer_name' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'created_by', name: 'created_by' },
                    { data: 'confirmed_at', name: 'confirmed_at' },
                    { data: 'confirmed_by', name: 'confirmed_by' },
                    { data: 'dispatching_header_status', name: 'dispatching_header_status', orderable: false, searchable: false },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                order: [[1, 'desc']]
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
        $(document).on('click', '.btn-edit', function() {
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
        $(document).on('click', '.btn-delete', function() {
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