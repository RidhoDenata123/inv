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
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-exclamation-triangle"></i> Minimum Stock Reports</h1>



    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Minimum Stock Reports</h6>
        </div>
        <div class="card-body">

     

            <!-- Button to Add New Report -->
            <form method="POST" action="{{ route('reports.minimumStock.generate') }}">
                @csrf
                <button type="submit" class="btn btn-danger mb-3">
                    <i class="fas fa-file-pdf"></i> Generate Report
                </button>
            </form>

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" id="productTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                <th scope="col">No.</th>
                                                <th scope="col">Product ID</th>
                                                <th scope="col">Product Name</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Purchase Price</th>
                                                <th scope="col">Selling Price</th>
                                                <th scope="col">Supplier</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Unit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($products as $product)
                                                    <tr>
                                                        <td>{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}.</td> <!-- Nomor otomatis -->
                                                        <td>{{ $product->product_id }}</td>
                                                        <td>{{ $product->product_name }}</td>
                                                        <td>{{ $product->category ? $product->category->category_name : 'No Category' }}</td>
                                                        <td>{{ "Rp " . number_format($product->purchase_price,2,',','.') }}</td>
                                                        <td>{{ "Rp " . number_format($product->selling_price,2,',','.') }}</td>
                                                        <td>{{ $product->supplier ? $product->supplier->supplier_name : 'No Supplier' }}</td>
                                                        <td>{{ $product->product_qty }}</td>
                                                        <td>{{ $product->unit ? $product->unit->unit_name : 'No Category' }}</td>
                                                        
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="9" class="text-center">No products with low stock available</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    <!-- Info Jumlah Data dan Pagination -->
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <!-- Info Jumlah Data -->
                                        <div class="table">
                                            <p class="mb-0">
                                                Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} entries
                                            </p>
                                        </div>

                                        <!-- Laravel Pagination -->
                                        <div>
                                            {{ $products->links('pagination::simple-bootstrap-4') }}
                                        </div>
                                    </div>
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