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
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-file-invoice"></i> Dispatching Reports</h1>



    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Dispatching Reports</h6>
        </div>
        <div class="card-body">

     

            <!-- Button to Add New Report -->
            <form method="POST" action="{{ route('reports.dispatching.generate') }}">
                @csrf
                <button type="submit" class="btn btn-danger mb-3">
                    <i class="fas fa-file-pdf"></i> Generate Report
                </button>
            </form>

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" width="100%" cellspacing="0">
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
                                @forelse ($dispatchingLogs as $log)
                                    <tr>
                                        <td>{{ ($dispatchingLogs->currentPage() - 1) * $dispatchingLogs->perPage() + $loop->iteration }}.</td>
                                        <td>{{ $log->changed_at ? \Carbon\Carbon::parse($log->changed_at)->timezone('Asia/Jakarta')->format('l, d F Y H:i') : 'N/A' }}</td>
                                        <td>{{ $log->product->product_id ?? 'N/A' }}</td>
                                        <td>{{ $log->product->product_name ?? 'N/A' }}</td>
                                        <td>{{ $log->stock_change_type }}</td>
                                        <td>{{ $log->qty_before }}</td>
                                        <td>{{ $log->qty_changed }}</td>
                                        <td>{{ $log->qty_after }}</td>
                                        <td>{{ $log->changedBy->name ?? 'System' }}</td>
                                        <td>{{ $log->change_note }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">No dispatching transactions available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                                    <!-- Info Jumlah Data dan Pagination -->
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <!-- Info Jumlah Data -->
                                        <div class="table">
                                            <p class="mb-0">
                                                Showing {{ $dispatchingLogs->firstItem() }} to {{ $dispatchingLogs->lastItem() }} of {{ $dispatchingLogs->total() }} entries
                                            </p>
                                        </div>

                                        <!-- Laravel Pagination -->
                                        <div>
                                            {{ $dispatchingLogs->links('pagination::simple-bootstrap-4') }}
                                        </div>
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
            $('#productTable').DataTable({
                "paging": false, // Nonaktifkan pagination bawaan DataTables
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });

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