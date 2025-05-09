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


<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-file-invoice"></i> RECEIVING</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">RECEIVING HEADER TABLE</h6>
        </div>
        <div class="card-body">
            <a href="#" class="btn btn-md btn-success mb-3" data-toggle="modal" data-target="#addReceivingHeaderModal"><i class='fas fa-plus'></i> Add Receiving</a>
           
            <div class="table-responsive">
                <table id="receivingHeaderTable" class="table table-bordered table-sm">
                    <thead class="text-center">
                        <tr>
                            <th scope="col" rowspan="2">No.</th>
                            <th scope="col" rowspan="2">Receiving ID</th>
                            <th scope="col" rowspan="2">Designation</th>
                            <th scope="col" colspan="2">Creation</th>
                           
                            <th scope="col" colspan="2">Confirmation</th>
                            <th scope="col" rowspan="2">Receiving Status</th>
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
                        @forelse ($receiving_headers as $header)
                            <tr>
                                <td>{{ ($receiving_headers->currentPage() - 1) * $receiving_headers->perPage() + $loop->iteration }}.</td>
                                <td>{{ $header->receiving_header_id }}</td>
                                <td>{{ $header->receiving_header_name }}</td>
                                <td>{{ $header->created_at ? \Carbon\Carbon::parse($header->created_at)->timezone('Asia/Jakarta')->format('l, d F Y H:i') : 'N/A' }}</td>
                                <td>{{ $header->created_by ? \App\Models\User::find($header->created_by)->name : 'N/A' }}</td>
                                <td>{{ $header->confirmed_at ? \Carbon\Carbon::parse($header->confirmed_at)->timezone('Asia/Jakarta')->format('l, d F Y H:i') : 'N/A' }}</td>
                                <td>{{ $header->confirmed_by ? \App\Models\User::find($header->confirmed_by)->name : 'N/A' }}</td>
                                <td>                                
                                    <span class="badge 
                                        {{ $header->receiving_header_status === 'Confirmed' ? 'badge-success' : 'badge-warning' }}">
                                        {{ ucfirst($header->receiving_header_status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        @if ($header->receivingDetails->where('receiving_detail_status', 'Confirmed')->isNotEmpty())
                                            <!-- Tombol Show Detail -->
                                            <a href="{{ route('receiving.detail.ShowById', $header->receiving_header_id) }}" 
                                            class="btn btn-sm btn-dark mr-2">
                                                <i class="fas fa-search"></i>
                                            </a>
                                        @else
                                            <!-- Tombol Show -->
                                            <a href="{{ route('receiving.detail.ShowById', $header->receiving_header_id) }}" 
                                            class="btn btn-sm btn-dark mr-2">
                                                <i class="fas fa-search"></i>
                                            </a>

                                            <!-- Tombol Edit -->
                                            <a href="#" 
                                            class="btn btn-sm btn-primary btn-edit mr-2" 
                                            data-receiving_id="{{ $header->receiving_header_id }}" 
                                            data-toggle="modal" 
                                            data-target="#editReceivingHeaderModal">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Tombol Delete -->
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger btn-delete" 
                                                    data-receiving_id="{{ $header->receiving_header_id }}" 
                                                    data-toggle="modal" 
                                                    data-target="#deleteReceivingHeaderModal">
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

                    <!-- Info Jumlah Data dan Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <!-- Info Jumlah Data -->
                        <div class="table">
                            <p class="mb-0">
                                Showing {{ $receiving_headers->firstItem() }} to {{ $receiving_headers->lastItem() }} of {{ $receiving_headers->total() }} entries
                            </p>
                        </div>

                        <!-- Laravel Pagination -->
                        <div>
                            {{ $receiving_headers->links('pagination::simple-bootstrap-4') }}
                        </div>
                    </div>

            </div>
        </div>
    </div>

    <!-- Modal for Add header -->
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
                <form action="{{ route('receiving.header.storeHeader') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="receiving_header_id" class="font-weight-bold">Receiving Header ID :</label>
                            <input type="text" class="form-control @error('receiving_header_id') is-invalid @enderror" id="addReceivingHeaderId" name="receiving_header_id" readonly>
                            @error('receiving_header_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="adjust_qty_before" class="font-weight-bold">Designation :</label>
                            <select name="receiving_header_name" class="custom-select @error('receiving_header_name') is-invalid @enderror" required>
                                <option value="">Select Designation</option>
                                <option value="Restock">Restock</option>
                                <option value="Opening Balance">Opening Balance</option>
                                <option value="Transfer In">Transfer In</option>
                                <option value="Return from Customer">Return from Customer</option>
                            
                            </select>
                            @error('receiving_header_name')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

            

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Description :</label>
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
                        <button type="submit" class="btn btn-success">Submit</button>
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No, keep it</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
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
                            <select name="receiving_header_name" id="editReceivingHeaderName" class="custom-select @error('receiving_header_name') is-invalid @enderror" required>
                                <option value="">Select Designation</option>
                                <option value="Restock">Restock</option>
                                <option value="Opening Balance">Opening Balance</option>
                                <option value="Transfer In">Transfer In</option>
                                <option value="Return from Customer">Return from Customer</option>
                            </select>
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
                    $('#editReceivingHeaderName').val(data.receiving_header_name); // Set nilai pada select
                    $('#editReceivingHeaderDescription').val(data.receiving_header_description);

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

        $('.btn-delete').on('click', function() {
            const receivingId = $(this).data('receiving_id'); // Ambil ID receiving header dari tombol
            const receivingName = $(this).closest('tr').find('td:nth-child(3)').text(); // Ambil nama receiving header dari tabel

            if (!receivingId) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Receiving header ID is undefined. Please try again.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Isi modal dengan data receiving header
            $('#deleteReceivingHeaderId').text(receivingName);

            // Set action URL untuk form delete
            const deleteUrl = `/receiving/header/${receivingId}`;
            $('#deleteReceivingHeaderForm').attr('action', deleteUrl);

            // Tampilkan modal
            $('#deleteReceivingHeaderModal').modal('show');
        });
    });
</script>
@endsection

@endsection