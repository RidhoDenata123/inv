@extends('layouts.adminApp')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-chart-bar"></i> STOCK MOVEMENT REPORT</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">STOCK MOVEMENT TABLE</h6>
        </div>
        <div class="card-body">

    <!-- Search Form -->
    <!-- Form GET untuk pencarian -->
            <form method="GET" action="{{ route('reports.stockMovement') }}" class="mb-4" id="searchForm">
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
            </form>     
                        <a href="{{ route('reports.stockMovement') }}" class="btn btn-secondary mr-2"><i class="fas fa-sync"></i> Reset</a>
                    
                    <!-- Form Generate PDF, letakkan di luar form GET, tetap dalam satu baris dengan CSS -->
                    <form method="POST" action="{{ route('reports.stockMovement.generate') }}" id="generatePdfForm" class="d-inline-block ml-2" style="display:none;">
                        @csrf
                        <input type="hidden" name="start_date" id="pdf_start_date">
                        <input type="hidden" name="end_date" id="pdf_end_date">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-file-pdf"></i> Generate .pdf
                        </button>
                    </form>
                        
                    </div>
                </div>
        
            <hr>
            <div class="table-responsive">
                <table class="table table-sm table-bordered" id="stockChangeLogTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Change Date</th>
                            <th>Changed By</th>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Change Type</th>
                            <th>Quantity Before</th>
                            <th>Quantity Changed</th>
                            <th>Quantity After</th>
                            
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
            // Inisialisasi DataTable tanpa auto-load data
            var table = $('#stockChangeLogTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route("reports.stockMovement.datatable") }}',
                    data: function(d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    },
                    dataSrc: function(json) {
                        // Jika tanggal belum diisi, kosongkan data
                        if (!$('#start_date').val() || !$('#end_date').val()) {
                            json.data = [];
                        }
                        return json.data;
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'changed_at', name: 'changed_at' },
                    { data: 'changed_by', name: 'changed_by' },
                    { data: 'product_id', name: 'product_id' },
                    { data: 'product_name', name: 'product_name' },
                    { data: 'stock_change_type', name: 'stock_change_type' },
                    { data: 'qty_before', name: 'qty_before' },
                    { data: 'qty_changed', name: 'qty_changed' },
                    { data: 'qty_after', name: 'qty_after' }
                    
                ],
                
                rowCallback: function(row, data) {
                    $(row).removeClass('table-success table-primary table-warning table-danger table-secondary');
                    if (data.row_class) {
                        $(row).addClass(data.row_class);
                    }
                },
                // Jangan auto-load data saat halaman pertama kali dibuka
                deferLoading: 0
            });

            // Reload DataTable saat filter tanggal berubah
            $('#start_date, #end_date').on('change', function() {
                if ($('#start_date').val() && $('#end_date').val()) {
                    table.ajax.reload();
                } else {
                    table.clear().draw();
                }
            });

            // Saat submit form pencarian
            $('form[method="GET"]').on('submit', function(e) {
                e.preventDefault();
                if ($('#start_date').val() && $('#end_date').val()) {
                    table.ajax.reload();
                } else {
                    table.clear().draw();
                }
            });

            // Saat halaman pertama kali dibuka, kosongkan tabel
            table.clear().draw();
        });
    </script>

    <script>
$(document).ready(function() {
    function toggleGeneratePdf() {
        var start = $('#start_date').val();
        var end = $('#end_date').val();
        if (start && end) {
            $('#generatePdfForm').show();
            $('#pdf_start_date').val(start);
            $('#pdf_end_date').val(end);
        } else {
            $('#generatePdfForm').hide();
        }
    }

    // Panggil saat halaman dimuat dan saat tanggal berubah
    toggleGeneratePdf();
    $('#start_date, #end_date').on('change', function() {
        toggleGeneratePdf();
    });

    // Pastikan hidden input selalu update sebelum submit
    $('#searchForm').on('submit', function() {
        $('#pdf_start_date').val($('#start_date').val());
        $('#pdf_end_date').val($('#end_date').val());
    });
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