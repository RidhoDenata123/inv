@extends('layouts.adminApp')
  
@section('content')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif


    @section('styles')
    <!-- Bootstrap Select CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" />

    <style>
        .bootstrap-select .dropdown-toggle {
            height: calc(1.5em + .75rem + 2px); /* Sesuaikan tinggi dengan form Bootstrap */
            padding: .375rem .75rem; /* Padding default form */
            font-size: 1rem; /* Ukuran font default */
            line-height: 1.5; /* Line height default */
            color: #858796; /* Warna teks default */
            background-color: #fff; /* Warna latar belakang */
            border: 1px solid #ced4da; /* Warna border */
            border-radius: .25rem; /* Radius border */
        }

        .bootstrap-select .dropdown-menu {
            font-size: 1rem; /* Ukuran font dropdown */
        }

        <style>
        .pagination {
            margin: 0; /* Hilangkan margin default */
        }
        .table-responsive .pagination {
            justify-content: flex-end; /* Posisikan pagination di kanan */
        }

        .chart-area {
            position: relative;
            height: 320px;
            min-width: 0;
            width: 100%;
        }
        .chart-pie {
            position: relative;
            height: 320px;
            min-width: 0;
            width: 100%;
        }
        .chart-pie canvas {
            width: 100% !important;
            height: 100% !important;
            max-width: 100%;
            max-height: 100%;
        }
        
        
    </style>

@endsection
                <!-- Begin Page Content -->
                <div class="container-fluid">


                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-primary shadow-sm dropdown-toggle" type="button" id="dropdownReportButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownReportButton">
                                <a class="dropdown-item" href="{{ route('reports.stock') }}">Stock Report</a>
                                <a class="dropdown-item" href="{{ route('reports.stockMovement') }}">Stock Movement Report</a>
                                <a class="dropdown-item" href="{{ route('reports.minimumStock') }}">Minimum Stock Report</a>
                                <a class="dropdown-item" href="{{ route('reports.receiving') }}">Receiving Report</a>
                                <a class="dropdown-item" href="{{ route('reports.dispatching') }}">Dispatching Report</a>
                                <a class="dropdown-item" href="{{ route('reports.stockAdjustment') }}">Stock Adjustment Report</a>
                            </div>
                        </div>
                    </div>

                <!-- Content Row -->
                <div class="row">

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                items sold</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $itemSold }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Transactions</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $transaction }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Earning </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalIncome, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Requests Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                            Customers</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $customerCount }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Row -->

                <div class="row align-items-stretch">

                    <!-- Area Chart -->
                    <div class="col-xl-8 col-lg-7 d-flex">
                        <div class="card shadow mb-4 flex-fill">
                            <!-- Card Header - Dropdown -->
                            <div
                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Stock Flow Overview</h6>
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                        aria-labelledby="dropdownMenuLink">
                                        <div class="dropdown-header">Dropdown Header:</div>
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body d-flex flex-column">
                                <div class="chart-area flex-grow-1">
                                    <canvas id="myAreaChart" width="600" height="300" style="max-width:100%;height:300px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pie Chart -->
                    <div class="col-xl-4 col-lg-5 d-flex">
                        <div class="card shadow mb-4 flex-fill">
                            <!-- Card Header - Dropdown -->
                            <div
                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Inventory Change Sources</h6>
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                        aria-labelledby="dropdownMenuLink">
                                        <div class="dropdown-header">Dropdown Header:</div>
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body d-flex flex-column">
                                <div class="chart-pie pt-4 pb-2 flex-grow-1">
                                    <canvas id="myPieChart"></canvas>
                                </div>
                                <div class="mt-4 text-center small">
                                    <!-- Legends 
                                    <span class="mr-2">
                                        <i class="fas fa-circle text-primary"></i> Direct
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle text-success"></i> Social
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle text-info"></i> Referral
                                    </span>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Row -->
                <div class="row">

                    <!-- Content Column -->
                    <div class="col-lg-6 mb-4">

                        <!-- Project Card Example 
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Projects</h6>
                            </div>
                            <div class="card-body">
                                <h4 class="small font-weight-bold">Server Migration <span
                                        class="float-right">20%</span></h4>
                                <div class="progress mb-4">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 20%"
                                        aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <h4 class="small font-weight-bold">Sales Tracking <span
                                        class="float-right">40%</span></h4>
                                <div class="progress mb-4">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 40%"
                                        aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <h4 class="small font-weight-bold">Customer Database <span
                                        class="float-right">60%</span></h4>
                                <div class="progress mb-4">
                                    <div class="progress-bar" role="progressbar" style="width: 60%"
                                        aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <h4 class="small font-weight-bold">Payout Details <span
                                        class="float-right">80%</span></h4>
                                <div class="progress mb-4">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 80%"
                                        aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <h4 class="small font-weight-bold">Account Setup <span
                                        class="float-right">Complete!</span></h4>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%"
                                        aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>-->

                        <!-- Color System 
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <div class="card bg-primary text-white shadow">
                                    <div class="card-body">
                                        Primary
                                        <div class="text-white-50 small">#4e73df</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="card bg-success text-white shadow">
                                    <div class="card-body">
                                        Success
                                        <div class="text-white-50 small">#1cc88a</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="card bg-info text-white shadow">
                                    <div class="card-body">
                                        Info
                                        <div class="text-white-50 small">#36b9cc</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="card bg-warning text-white shadow">
                                    <div class="card-body">
                                        Warning
                                        <div class="text-white-50 small">#f6c23e</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="card bg-danger text-white shadow">
                                    <div class="card-body">
                                        Danger
                                        <div class="text-white-50 small">#e74a3b</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="card bg-secondary text-white shadow">
                                    <div class="card-body">
                                        Secondary
                                        <div class="text-white-50 small">#858796</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="card bg-light text-black shadow">
                                    <div class="card-body">
                                        Light
                                        <div class="text-black-50 small">#f8f9fc</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="card bg-dark text-white shadow">
                                    <div class="card-body">
                                        Dark
                                        <div class="text-white-50 small">#5a5c69</div>
                                    </div>
                                </div>
                            </div>
                        </div>-->

                    </div>

                    <div class="col-lg-6 mb-4">

                        <!-- Illustrations
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                                        src="{{ asset('img/undraw_posting_photo.svg') }}" alt="...">
                                </div>
                                <p>Add some quality, svg illustrations to your project courtesy of <a
                                        target="_blank" rel="nofollow" href="https://undraw.co/">unDraw</a>, a
                                    constantly updated collection of beautiful svg images that you can use
                                    completely free and without attribution!</p>
                                <a target="_blank" rel="nofollow" href="https://undraw.co/">Browse Illustrations on
                                    unDraw &rarr;</a>
                            </div>
                        </div> -->

                        <!-- Approach 
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>
                            </div>
                            <div class="card-body">
                                <p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce
                                    CSS bloat and poor page performance. Custom CSS classes are used to create
                                    custom components and custom utility classes.</p>
                                <p class="mb-0">Before working with this theme, you should become familiar with the
                                    Bootstrap framework, especially the utility classes.</p>
                            </div>
                        </div>-->

                    </div>
                </div>

                </div>
                <!-- /.container-fluid -->

@section('scripts')
    <!-- Page level custom scripts -->
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('myPieChart').getContext('2d');
            var pieLabels = {!! json_encode(array_keys($stockChangeSummary)) !!};
            var pieData = {!! json_encode(array_values($stockChangeSummary)) !!};

            var myPieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: pieLabels,
                    datasets: [{
                        data: pieData,
                        backgroundColor: [
                            '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'
                        ],
                        hoverBackgroundColor: [
                            '#2e59d9', '#17a673', '#2c9faf', '#dda20a', '#be2617', '#6c757d'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Penting agar tinggi mengikuti parent
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('myAreaChart').getContext('2d');
            var myAreaChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Receiving', 'Dispatching'],
                    datasets: [{
                        label: 'Amount of Data ',
                        data: [{{ $receivingCount }}, {{ $dispatchingCount }}],
                        backgroundColor: 'rgba(78, 115, 223, 0.2)',
                        borderColor: 'rgba(78, 115, 223, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Tambahkan ini agar tinggi bisa diatur oleh parent
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        });
    </script>
    
@endsection

@endsection
