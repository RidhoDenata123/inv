<!-- filepath: c:\Users\Erika\Downloads\inv\resources\views\landing.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Landing Page</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex flex-col min-h-screen">

    <!-- Hero Section -->
    <header class="bg-gradient-primary text-white py-20">
        <div class="container text-center">
            <h1 class="text-4xl font-bold mb-4">Welcome to Our Platform</h1>
            <p class="text-lg mb-6">Discover the best way to manage your projects and collaborate with your team.</p>
            <a href="{{ route('login') }}" class="btn btn-light btn-lg px-5 py-3">Get Started</a>
        </div>
    </header>

    <!-- Features Section -->
    <section class="py-16 bg-white dark:bg-[#161615]">
        <div class="container">
            <h2 class="text-3xl font-bold text-center mb-12">Our Features</h2>
            <div class="row">
                <div class="col-md-4 text-center mb-4">
                    <i class="fas fa-tachometer-alt fa-3x text-primary mb-3"></i>
                    <h3 class="text-xl font-semibold mb-2">Fast Performance</h3>
                    <p>Experience lightning-fast performance with our optimized platform.</p>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h3 class="text-xl font-semibold mb-2">Team Collaboration</h3>
                    <p>Collaborate with your team seamlessly and efficiently.</p>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <i class="fas fa-lock fa-3x text-primary mb-3"></i>
                    <h3 class="text-xl font-semibold mb-2">Secure Platform</h3>
                    <p>Your data is safe with our industry-standard security measures.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call-to-Action Section -->
    <section class="py-16 bg-gradient-primary text-white">
        <div class="container text-center">
            <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
            <p class="text-lg mb-6">Join thousands of users who trust our platform to manage their projects.</p>
            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 py-3">Sign Up Now</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p>&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
</body>
</html>

