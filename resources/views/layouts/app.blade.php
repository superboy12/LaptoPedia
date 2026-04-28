<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laptopedia — Best Laptops for Your Needs</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-blue: #1e3a8a; /* Deep Blue dari Hero */
            --accent-yellow: #facc15; /* Yellow Button */
            --text-dark: #1e293b;
            --text-gray: #64748b;
            --bg-light: #f8fafc;
            --footer-bg: #1e293b;
        }

        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #ffffff; 
            color: var(--text-dark);
        }

        /* Navbar */
        .navbar {
            padding: 1rem 0;
            background: #ffffff;
            border-bottom: 1px solid #f1f5f9;
        }
        .navbar-brand { font-weight: 800; font-size: 1.5rem; color: var(--primary-blue) !important; }
        .nav-link { font-weight: 500; font-size: 0.95rem; color: var(--text-dark) !important; margin: 0 10px; }
        .nav-link:hover { color: var(--primary-blue) !important; }
        
        /* Search Bar */
        .search-box {
            background: var(--bg-light);
            border-radius: 50px;
            padding: 8px 20px;
            border: none;
            width: 300px;
        }
        .search-box:focus { outline: none; box-shadow: 0 0 0 2px rgba(30, 58, 138, 0.2); }

        /* Icons */
        .icon-circle {
            width: 40px; height: 40px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 50%; background: var(--bg-light);
            color: var(--text-dark); text-decoration: none; position: relative;
        }
        .icon-circle:hover { background: #e2e8f0; }
        .cart-badge {
            position: absolute; top: -5px; right: -5px;
            background: var(--accent-yellow); color: #000;
            font-size: 0.7rem; font-weight: bold; width: 18px; height: 18px;
            display: flex; align-items: center; justify-content: center; border-radius: 50%;
        }

        /* Footer */
        .footer { background: var(--footer-bg); color: #cbd5e1; padding: 4rem 0 2rem; font-size: 0.9rem; }
        .footer h5 { color: #ffffff; font-weight: 600; margin-bottom: 1.5rem; }
        .footer a { color: #cbd5e1; text-decoration: none; transition: 0.3s; line-height: 2; }
        .footer a:hover { color: var(--accent-yellow); }
        .social-icons a { color: #ffffff; font-size: 1.2rem; margin-right: 15px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <i class="fa-solid fa-laptop-code me-2 text-primary"></i>Laptopedia
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#">Laptops</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Brands</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Deals</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Support</a></li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <input type="text" class="search-box d-none d-lg-block" placeholder="Find laptops...">
                    
                    <a href="#" class="icon-circle">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="cart-badge">2</span>
                    </a>

                    @guest
                        <a href="{{ route('login') }}" class="icon-circle"><i class="fa-regular fa-user"></i></a>
                    @else
                        <div class="dropdown">
                            <a href="#" class="icon-circle" data-bs-toggle="dropdown"><i class="fa-solid fa-user-check"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                                <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">{{ Auth::user()->name }}</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                </li>
                            </ul>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer mt-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-4 mb-4">
                    <h4 class="text-white fw-bold mb-3"><span style="color: var(--accent-yellow)">Laptop</span>edia</h4>
                    <p>Your trusted destination for premium laptops and expert advice.</p>
                    <div class="social-icons mt-4">
                        <a href="#"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-6 mb-4">
                    <h5>Shop</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">All Laptops</a></li>
                        <li><a href="#">Gaming</a></li>
                        <li><a href="#">Business</a></li>
                        <li><a href="#">Student</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-6 mb-4">
                    <h5>Support</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">Warranty</a></li>
                        <li><a href="#">Returns</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-6 mb-4">
                    <h5>Company</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="text-center pt-4 border-top border-secondary">
                <p class="mb-0">&copy; 2026 Laptopedia. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>