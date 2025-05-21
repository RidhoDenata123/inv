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
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-file-invoice"></i> RECEIVING REPORT</h1>



    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">RECEIVING TABLE</h6>
        </div>
        <div class="card-body">

     

            <!-- Button to Add New Report -->
                <form method="POST" action="{{ route('reports.receiving.generate') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger mb-3">
                        <i class="fas fa-file-pdf"></i> Generate Report
                    </button>
                </form>

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" id="receivingTable" width="100%" cellspacing="0">
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
            $('#receivingTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route("reports.receiving.datatable") }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'changed_at', name: 'changed_at' },
                    { data: 'product_id', name: 'product_id' },
                    { data: 'product_name', name: 'product_name' },
                    { data: 'stock_change_type', name: 'stock_change_type' },
                    { data: 'qty_before', name: 'qty_before' },
                    { data: 'qty_changed', name: 'qty_changed' },
                    { data: 'qty_after', name: 'qty_after' },
                    { data: 'changed_by', name: 'changed_by' },
                    { data: 'change_note', name: 'change_note' }
                ],
                order: [[1, 'desc']]
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

    <script>
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