@extends('layouts.adminApp')
  
@section('content')

@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><i class='fas fa-truck'></i> SUPPLIER MASTER</h1>
    <p class="mb-4"></p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">SUPPLIER TABLE</h6>
        </div>
        <div class="card-body">
            <a href="#" class="btn btn-md btn-success mb-3" data-toggle="modal" data-target="#addSupplierModal"><i class='fas fa-plus'></i> ADD SUPPLIER</a>
           
            <div class="table-responsive">
                <table id="supplierTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Supplier ID</th>
                            <th scope="col">Supplier Name</th>
                            <th scope="col">Supplier Email</th>
                            <th scope="col">Supplier Phone</th>
                            <th scope="col">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($suppliers as $supplier)
                            <tr>
                                <td>{{ $loop->iteration }}.</td> <!-- Nomor otomatis -->
                                <td>{{ $supplier->supplier_id }}</td>
                                <td>{{ $supplier->supplier_name }}</td>
                                <td>{{ $supplier->supplier_email }}</td>
                                <td>{{ $supplier->supplier_phone }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center">

                                        <!-- Tombol Show -->
                                        <a href="#" 
                                            class="btn btn-sm btn-dark btn-show mr-2" 
                                            data-supplier_id="{{ $supplier->supplier_id }}" 
                                            data-toggle="modal" 
                                            data-target="#supplierDetailModal">
                                            <i class="fas fa-search"></i>
                                        </a>

                                        <!-- Tombol Edit -->
                                        <a href="#" 
                                            class="btn btn-sm btn-primary btn-edit mr-2" 
                                            data-supplier_id="{{ $supplier->supplier_id }}" 
                                            data-toggle="modal" 
                                            data-target="#editSupplierModal">
                                            <i class='fas fa-edit'></i>
                                        </a>

                                        <!-- Tombol Delete -->
                                        <button type="button" 
                                            class="btn btn-sm btn-danger btn-delete" 
                                            data-supplier_id="{{ $supplier->supplier_id }}"
                                            data-toggle="modal" 
                                            data-target="#deleteSupplierModal">
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
                {{ $suppliers->links() }}
            </div>
        </div>
    </div>

    <!-- Modal for Add Supplier -->
    <div class="modal fade" id="addSupplierModal" tabindex="-1" role="dialog" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="addSupplierModalLabel">Add Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form action="{{ route('suppliers.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="supplier_id" class="font-weight-bold">Supplier ID :</label>
                            <input type="text" class="form-control" id="addSupplierId" name="supplier_id" readonly>
                            @error('supplier_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="supplier_name" class="font-weight-bold">Supplier Name :</label>
                            <input type="text" class="form-control @error('supplier_name') is-invalid @enderror" id="supplier_name" name="supplier_name" value="{{ old('supplier_name') }}" placeholder="Enter supplier name" required>
                            @error('supplier_name')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Supplier Description :</label>
                            <textarea class="form-control @error('supplier_description') is-invalid @enderror" id="supplier_description" name="supplier_description" rows="3" placeholder="Input supplier description">{{ old('supplier_description') }}</textarea>
                            @error('supplier_description')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="supplier_address" class="font-weight-bold">Supplier Address :</label>
                            <input type="text" class="form-control @error('supplier_address') is-invalid @enderror" id="supplier_address" name="supplier_address" value="{{ old('supplier_address') }}" placeholder="Enter supplier address" required>
                            @error('supplier_address')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                        <label for="supplier_phone" class="font-weight-bold">Supplier Phone :</label>
                                        <input type="text" class="form-control @error('supplier_phone') is-invalid @enderror" id="supplier_phone" name="supplier_phone" value="{{ old('supplier_phone') }}" placeholder="Enter supplier phone" required>
                                        @error('supplier_phone')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="supplier_email" class="font-weight-bold">Supplier Email :</label>
                                    <input type="email" class="form-control @error('supplier_email') is-invalid @enderror" id="supplier_email" name="supplier_email" value="{{ old('supplier_email') }}" placeholder="Enter supplier email" required>
                                    @error('supplier_email')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="supplier_website" class="font-weight-bold">Supplier Website :</label>
                            <input type="text" class="form-control @error('supplier_website') is-invalid @enderror" id="supplier_website" name="supplier_website" value="{{ old('supplier_website') }}" placeholder="https://example.com">
                            @error('supplier_website')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Supplier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Delete Confirmation -->
    <div class="modal fade" id="deleteSupplierModal" tabindex="-1" role="dialog" aria-labelledby="deleteSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteSupplierModalLabel">Delete Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteSupplierForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p><span class="text-primary"> {{ Auth::user()->name }}</span>, are you sure you want to delete "<strong><span id="deleteSupplierName"></span></strong>" ?</p>
                        <div class="alert alert-danger">
                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> <strong>WARNING</strong></span>
                            <p class="text-danger"><small>This action cannot be undone, the selected supplier data will be permanently deleted!</small></p>
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No, keep it.</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Show Supplier Details -->
    <div class="modal fade" id="supplierDetailModal" tabindex="-1" role="dialog" aria-labelledby="supplierDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="supplierDetailModalLabel">Supplier Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="detailSupplierId" class="font-weight-bold">Supplier ID :</label>
                            <input type="text" class="form-control" id="detailSupplierId" readonly>
                        </div>
                        <div class="form-group">
                            <label for="detailSupplierName" class="font-weight-bold">Supplier Name :</label>
                            <input type="text" class="form-control" id="detailSupplierName" readonly>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Supplier Description :</label>
                            <textarea class="form-control" id="detailSupplierDescription" rows="3" readonly></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="supplier_address" class="font-weight-bold">Supplier Address :</label>
                            <input type="text" class="form-control" id="detailSupplierAddress" readonly>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                        <label for="supplier_phone" class="font-weight-bold">Supplier Phone :</label>
                                        <input type="text" class="form-control" id="detailSupplierPhone" readonly>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="supplier_email" class="font-weight-bold">Supplier Email :</label>
                                    <input type="email" class="form-control" id="detailSupplierEmail" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="supplier_website" class="font-weight-bold">Supplier Website :</label>
                            <input type="email" class="form-control" id="detailSupplierWebsite" readonly>
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

    <!-- Modal for Edit Supplier -->
    <div class="modal fade" id="editSupplierModal" tabindex="-1" role="dialog" aria-labelledby="editSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="editSupplierModalLabel">Edit Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form id="editSupplierForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editSupplierId" class="font-weight-bold">Supplier ID :</label>
                            <input type="text" class="form-control" id="editSupplierId" name="supplier_id" readonly>
                        </div>
                        <div class="form-group">
                            <label for="editSupplierName" class="font-weight-bold">Supplier Name :</label>
                            <input type="text" class="form-control" id="editSupplierName" name="supplier_name" required>
                        </div>

                        <div class="form-group">
                            <label for="editSupplierDescription" class="font-weight-bold">Supplier Description :</label>
                            <textarea class="form-control" id="editSupplierDescription" name="supplier_description" rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="editSupplierAddress" class="font-weight-bold">Supplier Address :</label>
                            <input type="text" class="form-control" id="editSupplierAddress" name="supplier_address" required>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="editSupplierPhone" class="font-weight-bold">Supplier Phone :</label>
                                    <input type="text" class="form-control" id="editSupplierPhone" name="supplier_phone" required>
                                </div> 
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="editSupplierEmail" class="font-weight-bold">Supplier Email :</label>
                                    <input type="email" class="form-control" id="editSupplierEmail" name="supplier_email" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="editSupplierWebsite" class="font-weight-bold">Supplier Website :</label>
                            <input type="text" class="form-control" id="editSupplierWebsite" name="supplier_website" placeholder="https://example.com">
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
        $('#supplierTable').DataTable({
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

        // Generate random supplier_id when the modal is shown
        $('#addSupplierModal').on('show.bs.modal', function() {
            const randomId = 'SUP-' + Math.floor(100000 + Math.random() * 900000); // Generate random ID
            $('#addSupplierId').val(randomId); // Set the value of supplier_id input
        });

        // Handle click event on "SHOW" button
        $('.btn-show').on('click', function() {
            const supplierId = $(this).data('supplier_id'); // Ambil ID supplier dari tombol

            // Lakukan permintaan AJAX ke server
            $.ajax({
                url: `/suppliers/${supplierId}`, // URL rute Laravel untuk mendapatkan detail supplier
                method: 'GET',
                success: function(data) {
                    // Isi modal dengan data supplier
                    $('#detailSupplierId').val(data.supplier_id);
                    $('#detailSupplierName').val(data.supplier_name);
                    $('#detailSupplierDescription').val(data.supplier_description);
                    $('#detailSupplierEmail').val(data.supplier_email);
                    $('#detailSupplierPhone').val(data.supplier_phone);
                    $('#detailSupplierWebsite').val(data.supplier_website);
                    $('#detailSupplierAddress').val(data.supplier_address);

                    // Tampilkan modal
                    $('#supplierDetailModal').modal('show');
                },
                error: function(xhr) {
                    alert('Failed to fetch supplier details. Please try again.');
                }
            });
        });

        // Handle click event on "EDIT" button
        $('.btn-edit').on('click', function() {
            const supplierId = $(this).data('supplier_id'); // Ambil ID supplier dari tombol

            // Lakukan permintaan AJAX ke server
            $.ajax({
                url: `/suppliers/${supplierId}`, // URL rute Laravel untuk mendapatkan detail supplier
                method: 'GET',
                success: function(data) {
                    // Isi modal dengan data supplier
                    $('#editSupplierId').val(data.supplier_id);
                    $('#editSupplierName').val(data.supplier_name);
                    $('#editSupplierDescription').val(data.supplier_description);
                    $('#editSupplierAddress').val(data.supplier_address);
                    $('#editSupplierPhone').val(data.supplier_phone);
                    $('#editSupplierEmail').val(data.supplier_email);
                    $('#editSupplierWebsite').val(data.supplier_website);

                    // Set action URL untuk form edit
                    $('#editSupplierForm').attr('action', `/suppliers/${supplierId}`);

                    // Tampilkan modal
                    $('#editSupplierModal').modal('show');
                },
                error: function(xhr) {
                    alert('Failed to fetch supplier details. Please try again.');
                }
            });
        });

        // Handle click event on "DELETE" button
        $('.btn-delete').on('click', function() {
            const supplierId = $(this).data('supplier_id'); // Ambil ID supplier dari tombol
            const supplierName = $(this).closest('tr').find('td:nth-child(3)').text(); // Ambil nama supplier dari tabel

            // Isi modal dengan data supplier
            $('#deleteSupplierId').text(supplierId);
            $('#deleteSupplierName').text(supplierName);

            // Set action URL untuk form delete
            const deleteUrl = `/suppliers/${supplierId}`;
            $('#deleteSupplierForm').attr('action', deleteUrl);
        });
    });
</script>
@endsection

@endsection