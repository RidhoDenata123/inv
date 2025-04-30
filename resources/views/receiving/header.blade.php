@extends('layouts.adminApp')

@section('content')


<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-receipt"></i> Receiving</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Receiving Header Table</h6>
        </div>
        <div class="card-body">
            <a href="#" class="btn btn-md btn-success mb-3" data-toggle="modal" data-target="#addReceivingHeaderModal"><i class='fas fa-plus'></i> ADD RECEIVING</a>
           
            <div class="table-responsive">
                <table id="receivingHeaderTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Receiving ID</th>
                            <th scope="col">Designation</th>
                            <th scope="col">Created By</th>
                            <th scope="col">Created Date</th>
                            <th scope="col">Confirmation Date</th>
                            <th scope="col">Receiving Status</th>
                            <th scope="col">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($receiving_headers as $header)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $header->receiving_header_id }}</td>
                                <td>{{ $header->receiving_header_name }}</td>
                                <td>{{ $header->created_by }}</td>
                                <td>{{ $header->created_at }}</td>
                                <td>{{ $header->confirmed_at }}</td>
                                <td>{{ $header->receiving_header_status }}</td>
  
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <!-- Tombol Show -->
                                        <a href="#" 
                                            class="btn btn-sm btn-dark btn-show mr-2" 
                                            data-receiving_id="{{ $header->receiving_header_id }}" 
                                            data-toggle="modal" 
                                            data-target="#receivingHeaderDetailModal">
                                            <i class='fas fa-eye'></i>
                                        </a>

                                        <!-- Tombol Edit -->
                                        <a href="#" 
                                            class="btn btn-sm btn-primary btn-edit mr-2" 
                                            data-receiving_id="{{ $header->receiving_header_id }}" 
                                            data-toggle="modal" 
                                            data-target="#editReceivingHeaderModal">
                                            <i class='fas fa-edit'></i>
                                        </a>

                                        <!-- Tombol Delete -->
                                        <button type="button" 
                                            class="btn btn-sm btn-danger btn-delete" 
                                            data-receiving_id="{{ $header->receiving_header_id }}"
                                            data-toggle="modal" 
                                            data-target="#deleteReceivingHeaderModal">
                                            <i class='fas fa-trash-alt'></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No data available in table</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $receiving_headers->links() }}
            </div>
        </div>
    </div>

    <!-- Modal for Add Unit -->
    <div class="modal fade" id="addReceivingHeaderModal" tabindex="-1" role="dialog" aria-labelledby="addUnitModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="addUnitModalLabel">Add Receiving Header</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal Body -->
                <form action="{{ route('receiving.header.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="receiving_header_id" class="font-weight-bold">Receiving Header ID :</label>
                            <input type="text" class="form-control" id="addReceivingHeaderId" name="receiving_header_id" readonly>
                            @error('receiving_header_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="receiving_header_name" class="font-weight-bold">Designation :</label>
                            <input type="text" class="form-control @error('receiving_header_name') is-invalid @enderror" id="receiving_header_name" name="receiving_header_name" value="{{ old('receiving_header_name') }}" placeholder="Enter Designation for this receiving" required>
                            @error('receiving_header_name')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Receiving Header Description :</label>
                            <textarea class="form-control @error('receiving_header_description') is-invalid @enderror" id="receiving_header_description" name="receiving_header_description" rows="3" placeholder="Enter description">{{ old('receiving_header_description') }}</textarea>
                            @error('receiving_header_description')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- created_by -->
                        <input type="hidden" class="form-control" name="created_by" value="{{ Auth::user()->id }}" readonly>
                        <!-- receiving_header_status -->
                        <input type="hidden" class="form-control" name="receiving_header_status" value="Pending" readonly>
                        <!-- confirmed_at -->
                        <input type="hidden" class="form-control" name="confirmed_at" value="" readonly>

                        


                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Delete Confirmation -->
    <div class="modal fade" id="deleteReceivingHeaderModal" tabindex="-1" role="dialog" aria-labelledby="deleteReceivingHeaderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteReceivingHeaderModalLabel">Delete Receiving Header</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form id="deleteReceivingHeaderForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>
                            <span class="text-primary">{{ Auth::user()->name }}</span>, are you sure you want to delete 
                            "<strong><span id="deleteReceivingHeaderId"></span></strong>"?
                        </p>
                        <div class="alert alert-danger">
                            <span class="text-danger">
                                <i class="fas fa-exclamation-triangle"></i> <strong>WARNING</strong>
                            </span>
                            <p class="text-danger">
                                <small>This action cannot be undone. The selected receiving header data will be permanently deleted!</small>
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

    <!-- Modal for Edit Receiving Header -->
<div class="modal fade" id="editReceivingHeaderModal" tabindex="-1" role="dialog" aria-labelledby="editReceivingHeaderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="editReceivingHeaderModalLabel">Edit Receiving Header</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <form id="editReceivingHeaderForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editReceivingHeaderId" class="font-weight-bold">Receiving Header ID:</label>
                        <input type="text" class="form-control" id="editReceivingHeaderId" name="receiving_header_id" readonly>
                    </div>

                    <div class="form-group">
                        <label for="editReceivingHeaderName" class="font-weight-bold">Designation:</label>
                        <input type="text" class="form-control @error('receiving_header_name') is-invalid @enderror" id="editReceivingHeaderName" name="receiving_header_name" required>
                        @error('receiving_header_name')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="editReceivingHeaderDescription" class="font-weight-bold">Receiving Header Description:</label>
                        <textarea class="form-control @error('receiving_header_description') is-invalid @enderror" id="editReceivingHeaderDescription" name="receiving_header_description" rows="3" required></textarea>
                        @error('receiving_header_description')
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

<!-- Datatable -->
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

        // Generate random receiving_header_id when the modal is shown
        $('#addReceivingHeaderModal').on('show.bs.modal', function() {
            const randomId = 'REC-' + Math.floor(100000 + Math.random() * 900000); // Generate random ID
            $('#addReceivingHeaderId').val(randomId); // Set the value of receiving_header_id input
        });

        // Handle click event on "EDIT" button
        $('.btn-edit').on('click', function() {
            const receivingId = $(this).data('receiving_id'); // Ambil ID receiving header dari tombol

            // Lakukan permintaan AJAX ke server
            $.ajax({
                url: `/receiving/header/${receivingId}`, // URL rute Laravel untuk mendapatkan detail receiving header
                method: 'GET',
                success: function(data) {
                    // Isi modal dengan data receiving header
                    $('#editReceivingHeaderId').val(data.receiving_header_id);
                    $('#editReceivingHeaderName').val(data.receiving_header_name);
                    $('#editReceivingHeaderDescription').val(data.receiving_header_description);
                    $('#editReceivingHeaderStatus').val(data.receiving_header_status);

                    // Set action URL untuk form edit
                    $('#editReceivingHeaderForm').attr('action', `/receiving/header/${receivingId}`);

                    // Tampilkan modal
                    $('#editReceivingHeaderModal').modal('show');
                },
                error: function(xhr) {
                    // Tampilkan pesan error jika gagal
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch receiving header details. Please try again.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // Handle click event on "DELETE" button
        $('.btn-delete').on('click', function() {
            const receivingId = $(this).data('receiving_id'); // Ambil ID receiving header dari tombol
            const receivingName = $(this).closest('tr').find('td:nth-child(3)').text(); // Ambil nama receiving header dari tabel

            // Isi modal dengan data receiving header
            $('#deleteReceivingHeaderId').text(receivingId);

            // Set action URL untuk form delete
            const deleteUrl = `/receiving/header/${receivingId}`;
            $('#deleteReceivingHeaderForm').attr('action', deleteUrl);
        });
    });
</script>
@endsection

@endsection