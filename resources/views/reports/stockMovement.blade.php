@extends('layouts.adminApp')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-file-alt"></i> Stock Movement Report</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Stock Movement Logs</h6>
        </div>
        <div class="card-body">

    <!-- Search Form -->
        <form method="GET" action="{{ route('reports.stockMovement') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label for="start_date" class="font-weight-bold">Start Date:</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="font-weight-bold">End Date:</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary mr-2">Search</button>
                    <a href="{{ route('reports.stockMovement') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>

            <div class="table-responsive">
                <table class="table table-sm table-bordered" id="stockChangeLogTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Change Date</th>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Change Type</th>
                            <th>Quantity Before</th>
                            <th>Quantity Changed</th>
                            <th>Quantity After</th>
                            <th>Changed By</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($stockChangeLogs->isEmpty() && (!$startDate && !$endDate))
                            <tr>
                                <td colspan="10" class="text-center">Please enter a Start Date and End Date to view data.</td>
                            </tr>
                        @elseif ($stockChangeLogs->isEmpty())
                            <tr>
                                <td colspan="10" class="text-center">No stock movement logs available for the selected period.</td>
                            </tr>
                        @else
                            @foreach ($stockChangeLogs as $log)
                                <tr>
                                    <td>{{ ($stockChangeLogs->currentPage() - 1) * $stockChangeLogs->perPage() + $loop->iteration }}.</td>
                                    <td>{{ $log->changed_at }}</td>
                                    <td>{{ $log->product->product_id ?? 'N/A' }}</td>
                                    <td>{{ $log->product->product_name ?? 'N/A' }}</td>
                                    <td>{{ $log->stock_change_type }}</td>
                                    <td>{{ $log->qty_before }}</td>
                                    <td>{{ $log->qty_changed }}</td>
                                    <td>{{ $log->qty_after }}</td>
                                    <td>{{ $log->changedBy->name ?? 'System' }}</td>
                                    <td>{{ $log->change_note }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-end mt-3">
                {{ $stockChangeLogs->links('pagination::bootstrap-4') }}
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
                $('#stockChangeLogTable').DataTable({
                    "paging": false, // Nonaktifkan pagination bawaan DataTables
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







        });
    </script>
@endsection

@endsection