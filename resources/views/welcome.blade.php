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
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="#">QuickStart</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a class="nav-link" href="#hero">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
        <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
        <li class="nav-item"><a class="nav-link" href="#footer">Contact</a></li>
        </ul>
    </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero" class="hero">
    <div class="container">
        <h1 class="display-4">Welcome to QuickStart</h1>
        <p class="lead">A simple and clean Bootstrap 4 landing page.</p>
        <a href="{{ Auth::check() ? route('dashboard') : route('login') }}" class="btn btn-light btn-lg mt-3">Get Started</a>
    </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section bg-light">
    <div class="container">
        <div class="text-center">
        <h2>About Us</h2>
        <p>We provide fast and responsive landing page solutions using Bootstrap 4.</p>
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
            <h4>Design</h4>
            <p>Clean and modern UI/UX for your website.</p>
            </div>
            <div class="col-md-4">
            <h4>Development</h4>
            <p>Fast and responsive front-end development.</p>
            </div>
            <div class="col-md-4">
            <h4>Support</h4>
            <p>Ongoing support and updates for your site.</p>
            </div>
        </div>
        </div>
    </div>
    </section>

    <!-- Footer -->
    <footer id="footer" class="footer">
    <div class="container">
        <p>&copy; 2025 QuickStart. All rights reserved.</p>
    </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>
