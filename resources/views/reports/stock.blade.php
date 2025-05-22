@extends('layouts.adminApp')


@section('styles')
    <style>
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
        #receivingHeaderTable {
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
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-boxes"></i> STOCK REPORT</h1>



    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">STOCK TABLE</h6>
        </div>
        <div class="card-body">

     

            <!-- Button to Add New Report -->
            <a href="{{ route('reports.stockGenerate') }}" class="btn btn-danger mb-3">
                <i class="fas fa-file-pdf"></i> Generate .pdf
            </a>

                    <div class="table-responsive">
                        <table id="productTable" class="table table-sm table-bordered" width="100%" cellspacing="0">
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
                                    <th scope="col">Created At</th> <!-- Tambahkan ini -->
                                 
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

               
                    </div>

          
        </div>
    </div>
</div>





<!-- Scripts -->
@section('scripts')

    <!-- Page level plugins -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <!-- DataTables core -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- DataTables Responsive (setelah DataTables utama) -->
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>
    <!-- Datatable -->
    <script>
        $(document).ready(function() {
            $('#productTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route("reports.stock.products.datatable") }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'product_id', name: 'product_id' },
                    { data: 'product_name', name: 'product_name' },
                    { data: 'category', name: 'category.category_name' },
                    { data: 'purchase_price', name: 'purchase_price' },
                    { data: 'selling_price', name: 'selling_price' },
                    { data: 'supplier', name: 'supplier.supplier_name' },
                    { data: 'product_qty', name: 'product_qty' },
                    { data: 'unit', name: 'unit.unit_name' },
                    { data: 'created_at', name: 'created_at' } // Tambahkan ini
                ],
                order: [[9, 'desc']]
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