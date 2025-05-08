@extends('layouts.adminApp')
  
@section('styles')
    <style>
        .pagination {
            margin: 0; /* Hilangkan margin default */
        }
        .table-responsive .pagination {
            justify-content: flex-end; /* Posisikan pagination di kanan */
        }
        
    </style>


@endsection


@section('content')

@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><i class='fas fa-users'></i> CUSTOMER MASTER</h1>
    <p class="mb-4"></p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">CUSTOMER TABLE</h6>
        </div>
        <div class="card-body">
            <a href="#" class="btn btn-md btn-success mb-3" data-toggle="modal" data-target="#addCustomerModal"><i class='fas fa-plus'></i> Add Customer</a>
           
            <div class="table-responsive">
                <table id="customerTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Customer ID</th>
                            <th scope="col">Customer Name</th>
                            <th scope="col">Customer Email</th>
                            <th scope="col">Customer Phone</th>
                            <th scope="col">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $customer)
                            <tr>
                            <td>{{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}.</td> <!-- Nomor otomatis -->
                                <td>{{ $customer->customer_id }}</td>
                                <td>{{ $customer->customer_name }}</td>
                                <td>{{ $customer->customer_email }}</td>
                                <td>{{ $customer->customer_phone }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center">

                                        <!-- Tombol Show -->
                                        <a href="#" 
                                            class="btn btn-sm btn-dark btn-show mr-2" 
                                            data-customer_id="{{ $customer->customer_id }}" 
                                            data-toggle="modal" 
                                            data-target="#customerDetailModal">
                                            <i class="fas fa-search"></i>
                                        </a>

                                        <!-- Tombol Edit -->
                                        <a href="#" 
                                            class="btn btn-sm btn-primary btn-edit mr-2" 
                                            data-customer_id="{{ $customer->customer_id }}" 
                                            data-toggle="modal" 
                                            data-target="#editCustomerModal">
                                            <i class='fas fa-edit'></i>
                                        </a>

                                        <!-- Tombol Delete -->
                                        <button type="button" 
                                            class="btn btn-sm btn-danger btn-delete" 
                                            data-customer_id="{{ $customer->customer_id }}"
                                            data-toggle="modal" 
                                            data-target="#deleteCustomerModal">
                                            <i class='fas fa-trash-alt'></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <div class="alert alert-danger">
                                No data available in table
                            </div>
                        @endforelse
                    </tbody>
                </table>

                    <!-- Info Jumlah Data dan Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <!-- Info Jumlah Data -->
                        <div class="table">
                            <p class="mb-0">
                                Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of {{ $customers->total() }} entries
                            </p>
                        </div>

                        <!-- Laravel Pagination -->
                        <div>
                            {{ $customers->links('pagination::simple-bootstrap-4') }}
                        </div>
                    </div>

            </div>
        </div>
    </div>

    <!-- Modal for Add Customer -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomerModalLabel">Add Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form action="{{ route('customers.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="customer_id" class="font-weight-bold">Customer ID :</label>
                            <input type="text" class="form-control" id="addCustomerId" name="customer_id" readonly>
                            @error('customer_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="customer_name" class="font-weight-bold">Customer Name :</label>
                            <input type="text" class="form-control @error('customer_name') is-invalid @enderror" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" placeholder="Enter customer name" required>
                            @error('customer_name')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Customer Description :</label>
                            <textarea class="form-control @error('customer_description') is-invalid @enderror" id="customer_description" name="customer_description" rows="3" placeholder="Input customer description">{{ old('customer_description') }}</textarea>
                            @error('customer_description')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="customer_address" class="font-weight-bold">Customer Address :</label>
                            <input type="text" class="form-control @error('customer_address') is-invalid @enderror" id="customer_address" name="customer_address" value="{{ old('customer_address') }}" placeholder="Enter customer address" required>
                            @error('customer_address')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="customer_phone" class="font-weight-bold">Customer Phone :</label>
                                    <input type="text" class="form-control @error('customer_phone') is-invalid @enderror" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" placeholder="Enter customer phone" required>
                                    @error('customer_phone')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="customer_email" class="font-weight-bold">Customer Email :</label>
                                    <input type="email" class="form-control @error('customer_email') is-invalid @enderror" id="customer_email" name="customer_email" value="{{ old('customer_email') }}" placeholder="Enter customer email" required>
                                    @error('customer_email')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="customer_website" class="font-weight-bold">Customer Website :</label>
                            <input type="text" class="form-control @error('customer_website') is-invalid @enderror" id="customer_website" name="customer_website" value="{{ old('customer_website') }}" placeholder="http://example.com">
                            @error('customer_website')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Customer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Delete Confirmation -->
    <div class="modal fade" id="deleteCustomerModal" tabindex="-1" role="dialog" aria-labelledby="deleteCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCustomerModalLabel">Delete Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteCustomerForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p><span class="text-primary"> {{ Auth::user()->name }}</span>, are you sure you want to delete "<strong><span id="deleteCustomerName"></span></strong>" ?</p>
                        <div class="alert alert-danger">
                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> <strong>WARNING</strong></span>
                            <p class="text-danger"><small>This action cannot be undone, the selected customer data will be permanently deleted!</small></p>
                        </div>
                        <div class="form-group form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember" required> I agree to the Terms & Conditions.
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Check this box to continue.</div>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No, keep it</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Show Customer Details -->
    <div class="modal fade" id="customerDetailModal" tabindex="-1" role="dialog" aria-labelledby="customerDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="customerDetailModalLabel">Customer Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="detailCustomerId" class="font-weight-bold">Customer ID :</label>
                            <input type="text" class="form-control" id="detailCustomerId" readonly>
                        </div>
                        <div class="form-group">
                            <label for="detailCustomerName" class="font-weight-bold">Customer Name :</label>
                            <input type="text" class="form-control" id="detailCustomerName" readonly>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Customer Description :</label>
                            <textarea class="form-control" id="detailCustomerDescription" rows="3" readonly></textarea>
                        </div>

                        <div class="form-group">
                            <label for="detailCustomerAddress" class="font-weight-bold">Customer Address :</label>
                            <input type="text" class="form-control" id="detailCustomerAddress" readonly>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="detailCustomerPhone" class="font-weight-bold">Customer Phone :</label>
                                    <input type="text" class="form-control" id="detailCustomerPhone" readonly>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="detailCustomerEmail" class="font-weight-bold">Customer Email :</label>
                                    <input type="email" class="form-control" id="detailCustomerEmail" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="customer_website" class="font-weight-bold">Customer Website :</label>
                            <input type="email" class="form-control" id="detailCustomerWebsite" readonly>
                        </div>

                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Edit Customer -->
    <div class="modal fade" id="editCustomerModal" tabindex="-1" role="dialog" aria-labelledby="editCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="editCustomerModalLabel">Edit Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form id="editCustomerForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editCustomerId" class="font-weight-bold">Customer ID :</label>
                            <input type="text" class="form-control" id="editCustomerId" name="customer_id" readonly>
                        </div>
                        <div class="form-group">
                            <label for="editCustomerName" class="font-weight-bold">Customer Name :</label>
                            <input type="text" class="form-control" id="editCustomerName" name="customer_name" required>
                        </div>

                        <div class="form-group">
                            <label for="editCustomerDescription" class="font-weight-bold">Customer Description :</label>
                            <textarea class="form-control" id="editCustomerDescription" name="customer_description" rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="editCustomerAddress" class="font-weight-bold">Customer Address :</label>
                            <input type="text" class="form-control" id="editCustomerAddress" name="customer_address" required>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="editCustomerPhone" class="font-weight-bold">Customer Phone :</label>
                                    <input type="text" class="form-control" id="editCustomerPhone" name="customer_phone" required>
                                </div> 
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="editCustomerEmail" class="font-weight-bold">Customer Email :</label>
                                    <input type="email" class="form-control" id="editCustomerEmail" name="customer_email" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                                    <label for="editCustomerWebsite" class="font-weight-bold">Customer Website :</label>
                                    <input type="text" class="form-control" id="editCustomerWebsite" name="customer_website" placeholder="https://example.com">
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

<!-- Scripts -->
@section('scripts')

<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Datatable -->
<script>
    $(document).ready(function() {
        $('#customerTable').DataTable({
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

        // Generate random customer_id when the modal is shown
        $('#addCustomerModal').on('show.bs.modal', function() {
            const randomId = 'CUST-' + Math.floor(100000 + Math.random() * 900000); // Generate random ID
            $('#addCustomerId').val(randomId); // Set the value of customer_id input
        });

        // Handle click event on "SHOW" button
        $('.btn-show').on('click', function() {
            const customerId = $(this).data('customer_id'); // Ambil ID customer dari tombol

            // Lakukan permintaan AJAX ke server
            $.ajax({
                url: `/customers/${customerId}`, // URL rute Laravel untuk mendapatkan detail customer
                method: 'GET',
                success: function(data) {
                    // Isi modal dengan data customer
                    $('#detailCustomerId').val(data.customer_id);
                    $('#detailCustomerName').val(data.customer_name);
                    $('#detailCustomerDescription').val(data.customer_description);
                    $('#detailCustomerAddress').val(data.customer_address);
                    $('#detailCustomerPhone').val(data.customer_phone);
                    $('#detailCustomerEmail').val(data.customer_email);
                    $('#detailCustomerWebsite').val(data.customer_website);


                    // Tampilkan modal
                    $('#customerDetailModal').modal('show');
                },
                error: function(xhr) {
                    alert('Failed to fetch customer details. Please try again.');
                }
            });
        });

        // Handle click event on "EDIT" button
        $('.btn-edit').on('click', function() {
            const customerId = $(this).data('customer_id'); // Ambil ID customer dari tombol

            // Lakukan permintaan AJAX ke server
            $.ajax({
                url: `/customers/${customerId}`, // URL rute Laravel untuk mendapatkan detail customer
                method: 'GET',
                success: function(data) {
                    // Isi modal dengan data customer
                    $('#editCustomerId').val(data.customer_id);
                    $('#editCustomerName').val(data.customer_name);
                    $('#editCustomerDescription').val(data.customer_description);
                    $('#editCustomerAddress').val(data.customer_address);
                    $('#editCustomerPhone').val(data.customer_phone);
                    $('#editCustomerEmail').val(data.customer_email);
                    $('#editCustomerWebsite').val(data.customer_website);

                    // Set action URL untuk form edit
                    $('#editCustomerForm').attr('action', `/customers/${customerId}`);

                    // Tampilkan modal
                    $('#editCustomerModal').modal('show');
                },
                error: function(xhr) {
                    alert('Failed to fetch customer details. Please try again.');
                }
            });
        });

        // Handle click event on "DELETE" button
        $('.btn-delete').on('click', function() {
            const customerId = $(this).data('customer_id'); // Ambil ID customer dari tombol
            const customerName = $(this).closest('tr').find('td:nth-child(3)').text(); // Ambil nama customer dari tabel

            // Isi modal dengan data customer
            $('#deleteCustomerId').text(customerId);
            $('#deleteCustomerName').text(customerName);

            // Set action URL untuk form delete
            const deleteUrl = `/customers/${customerId}`;
            $('#deleteCustomerForm').attr('action', deleteUrl);
        });
    });
</script>
@endsection

@endsection