@extends('layouts.adminApp')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-chart-bar"></i> Stock Movement Report</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Stock Movement Report</h6>
        </div>
        <div class="card-body">

    <!-- Search Form -->
<!-- Form GET untuk pencarian -->
<form method="GET" action="{{ route('reports.stockMovement') }}" class="mb-4">
    <div class="row">
        <div class="col-md-4">
            <label for="start_date" class="font-weight-bold">Start Date :</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
        </div>
        <div class="col-md-4">
            <label for="end_date" class="font-weight-bold">End Date :</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary mr-2"><i class='fas fa-search'></i> Search</button>	
            <a href="{{ route('reports.stockMovement') }}" class="btn btn-secondary"><i class="fas fa-sync"></i> Reset</a>
        </div>
    </div>
</form>

<!-- Form POST untuk Generate Report -->
@if (request('start_date') && request('end_date'))
    <form method="POST" action="{{ route('reports.stockMovement.generate') }}">
        @csrf
        <input type="hidden" name="start_date" value="{{ request('start_date') }}">
        <input type="hidden" name="end_date" value="{{ request('end_date') }}">
        <button type="submit" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Generate
        </button>
    </form>
@endif
<hr>
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
                        @if (!$startDate || !$endDate)
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
    
                    <!-- Info Jumlah Data dan Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <!-- Info Jumlah Data -->
                        <div class="table">
                            <p class="mb-0">
                                Showing {{ $stockChangeLogs->firstItem() }} to {{ $stockChangeLogs->lastItem() }} of {{ $stockChangeLogs->total() }} entries
                            </p>
                        </div>

                        <!-- Laravel Pagination -->
                        <div>
                             {{ $stockChangeLogs->appends(request()->query())->links('pagination::simple-bootstrap-4') }}
                        </div>
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