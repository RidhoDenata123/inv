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
    <h1 class="h3 mb-2 text-gray-800"><i class='fas fa-balance-scale'></i> UNIT MASTER</h1>
    <p class="mb-4"></p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">UNIT TABLE</h6>
        </div>
        <div class="card-body">
            <a href="#" class="btn btn-md btn-success mb-3" data-toggle="modal" data-target="#addUnitModal"><i class='fas fa-plus'></i> Add Unit</a>
           
            <div class="table-responsive">
                <table id="unitTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Unit ID</th>
                            <th scope="col">Unit Name</th>
                            <th scope="col">Unit Description</th>
                            <th scope="col">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($units as $unit)
                            <tr>
                                <td>{{ $loop->iteration }}.</td> <!-- Nomor otomatis -->
                                <td>{{ $unit->unit_id }}</td>
                                <td>{{ $unit->unit_name }}</td>
                                <td>{{ $unit->unit_description }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center">

                                        <!-- Tombol Show -->
                                        <a href="#" 
                                            class="btn btn-sm btn-dark btn-show mr-2" 
                                            data-unit_id="{{ $unit->unit_id }}" 
                                            data-toggle="modal" 
                                            data-target="#unitDetailModal">
                                            <i class="fas fa-search"></i>
                                        </a>

                                        <!-- Tombol Edit -->
                                        <a href="#" 
                                            class="btn btn-sm btn-primary btn-edit mr-2" 
                                            data-unit_id="{{ $unit->unit_id }}" 
                                            data-toggle="modal" 
                                            data-target="#unitEditModal">
                                            <i class='fas fa-edit'></i>
                                        </a>

                                        <!-- Tombol Delete -->
                                        <button type="button" 
                                            class="btn btn-sm btn-danger btn-delete" 
                                            data-unit_id="{{ $unit->unit_id }}"
                                            data-toggle="modal" 
                                            data-target="#deleteUnitModal">
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
                {{ $units->links() }}
            </div>
        </div>
    </div>

    <!-- Modal for Add Unit -->
    <div class="modal fade" id="addUnitModal" tabindex="-1" role="dialog" aria-labelledby="addUnitModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="addUnitModalLabel">Add Unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form action="{{ route('units.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="unit_id" class="font-weight-bold">Unit ID :</label>
                            <input type="text" class="form-control" id="addUnitId" name="unit_id" readonly>
                            @error('unit_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="unit_name" class="font-weight-bold">Unit Name :</label>
                            <input type="text" class="form-control @error('unit_name') is-invalid @enderror" id="unit_name" name="unit_name" value="{{ old('unit_name') }}" placeholder="Enter unit name" required>
                            @error('unit_name')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Unit Description :</label>
                            <textarea class="form-control @error('unit_description') is-invalid @enderror" id="unit_description" name="unit_description" rows="5" placeholder="Input unit description">{{ old('unit_description') }}</textarea>
                            @error('unit_description')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Unit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Delete Confirmation -->
    <div class="modal fade" id="deleteUnitModal" tabindex="-1" role="dialog" aria-labelledby="deleteUnitModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUnitModalLabel">Delete Unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteUnitForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p><span class="text-primary"> {{ Auth::user()->name }}</span>, are you sure you want to delete "<strong><span id="deleteUnitName"></span></strong>" ?</p>
                        <div class="alert alert-danger">
                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> <strong>WARNING</strong></span>
                            <p class="text-danger"><small>This action cannot be undone, the selected unit data will be permanently deleted!</small></p>
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

    <!-- Modal for Show Unit Details -->
    <div class="modal fade" id="unitDetailModal" tabindex="-1" role="dialog" aria-labelledby="unitDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="unitDetailModalLabel">Unit Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="detailUnitId" class="font-weight-bold">Unit ID :</label>
                            <input type="text" class="form-control" id="detailUnitId" readonly>
                        </div>
                        <div class="form-group">
                            <label for="detailUnitName" class="font-weight-bold">Unit Name :</label>
                            <input type="text" class="form-control" id="detailUnitName" readonly>
                        </div>
                        <div class="form-group">
                            <label for="detailUnitDescription" class="font-weight-bold">Unit Description :</label>
                            <textarea class="form-control" id="detailUnitDescription" rows="3" readonly></textarea>
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

    <!-- Modal for Edit Unit -->
    <div class="modal fade" id="editUnitModal" tabindex="-1" role="dialog" aria-labelledby="editUnitModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="editUnitModalLabel">Edit Unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form id="editUnitForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editUnitId" class="font-weight-bold">Unit ID :</label>
                            <input type="text" class="form-control" id="editUnitId" name="unit_id" readonly>
                        </div>
                        <div class="form-group">
                            <label for="editUnitName" class="font-weight-bold">Unit Name :</label>
                            <input type="text" class="form-control" id="editUnitName" name="unit_name" required>
                        </div>
                        <div class="form-group">
                            <label for="editUnitDescription" class="font-weight-bold">Unit Description :</label>
                            <textarea class="form-control" id="editUnitDescription" name="unit_description" rows="3" required></textarea>
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
        $('#unitTable').DataTable({
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

        // Generate random unit_id when the modal is shown
        $('#addUnitModal').on('show.bs.modal', function() {
            const randomId = 'UNT-' + Math.floor(100000 + Math.random() * 900000); // Generate random ID
            $('#addUnitId').val(randomId); // Set the value of unit_id input
        });

        // Handle click event on "SHOW" button
        $('.btn-show').on('click', function() {
            const unitId = $(this).data('unit_id'); // Ambil ID unit dari tombol

            // Lakukan permintaan AJAX ke server
            $.ajax({
                url: `/units/${unitId}`, // URL rute Laravel untuk mendapatkan detail unit
                method: 'GET',
                success: function(data) {
                    // Isi modal dengan data unit
                    $('#detailUnitId').val(data.unit_id);
                    $('#detailUnitName').val(data.unit_name);
                    $('#detailUnitDescription').val(data.unit_description);

                    // Tampilkan modal
                    $('#unitDetailModal').modal('show');
                },
                error: function(xhr) {
                    alert('Failed to fetch unit details. Please try again.');
                }
            });
        });

        // Handle click event on "EDIT" button
        $('.btn-edit').on('click', function() {
            const unitId = $(this).data('unit_id'); // Ambil ID unit dari tombol

            // Lakukan permintaan AJAX ke server
            $.ajax({
                url: `/units/${unitId}`, // URL rute Laravel untuk mendapatkan detail unit
                method: 'GET',
                success: function(data) {
                    // Isi modal dengan data unit
                    $('#editUnitId').val(data.unit_id);
                    $('#editUnitName').val(data.unit_name);
                    $('#editUnitDescription').val(data.unit_description);

                    // Set action URL untuk form edit
                    $('#editUnitForm').attr('action', `/units/${unitId}`);

                    // Tampilkan modal
                    $('#editUnitModal').modal('show');
                },
                error: function(xhr) {
                    alert('Failed to fetch unit details. Please try again.');
                }
            });
        });

        // Handle click event on "DELETE" button
        $('.btn-delete').on('click', function() {
            const unitId = $(this).data('unit_id'); // Ambil ID unit dari tombol
            const unitName = $(this).closest('tr').find('td:nth-child(3)').text(); // Ambil nama unit dari tabel

            // Isi modal dengan data unit
            $('#deleteUnitId').text(unitId);
            $('#deleteUnitName').text(unitName);

            // Set action URL untuk form delete
            const deleteUrl = `/units/${unitId}`;
            $('#deleteUnitForm').attr('action', deleteUrl);
        });
    });
</script>
@endsection

@endsection