<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <style>
        html {
        scroll-behavior: smooth;
        }
        .hero {
        background: #4e73df;
        color: white;
        padding: 100px 0;
        text-align: center;
        }
        .section {
        padding: 60px 0;
        }
        .footer {
        background: #f8f9fa;
        padding: 20px 0;
        text-align: center;
        }
    </style>
</head>
    <body>

    <!-- Navbar -->


    <!-- Hero Section -->
    <section id="hero" class="hero">
    <div class="container">
        <h1 class="display-4">Welcome to E-Inventory 2</h1>
        <p class="lead">Simple web based Inventory management system.</p>
        <a href="{{ Auth::check() ? route('dashboard') : route('login') }}" class="btn btn-light btn-lg mt-3">Get Started</a>
    </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section bg-light">
    <div class="container">
        <div class="text-center">
        <h2>About E-Inventory 2</h2>
        <p>E-Inventory 2 is a modern solution for easy, fast, and efficient inventory management. This system is designed to help your business manage stock, incoming/outgoing transactions, and real-time reporting.</p>
        </div>
    </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="section">
    <div class="container">
        <div class="text-center">
        <h2>Our Services</h2>
        <div class="row mt-4">
            <div class="col-md-4">
            <h4>Stock Management</h4>
            <p>Automatic and accurate recording of stock, including history of stock changes.</p>
            </div>
            <div class="col-md-4">
            <h4>Easy Transaction</h4>
            <p>Integrated and easy-to-use product receiving and dispatching process.</p>
            </div>
            <div class="col-md-4">
            <h4>Real-Time Report</h4>
            <p>Monitor stock reports, transactions, and inventory activities directly and in detail.</p>
            </div>
        </div>
        </div>
    </div>
    </section>

    <!-- Footer -->


    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>
