<!DOCTYPE html>
<html lang="vi" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - AdminPro</title>
    
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Admin Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    @yield('styles')
</head>
<body>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="text-center mb-5 mt-2">
            <h4 class="fw-bold m-0 tracking-tight">
                <i class="fa-solid fa-layer-group text-primary me-2"></i>AdminPro
            </h4>
        </div>
        <div class="nav flex-column">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie w-20px"></i> Tổng quan
            </a>
            <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fa-solid fa-box w-20px"></i> Sản phẩm
            </a>
            <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="fa-solid fa-cart-shopping w-20px"></i> Đơn hàng
            </a>
            <a href="{{ route('home') }}" target="_blank" class="nav-link text-secondary mt-5">
                <i class="fa-solid fa-arrow-up-right-from-square w-20px"></i> Xem website
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Topbar -->
        <header class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light d-md-none" id="toggleSidebar">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h5 class="m-0 fw-semibold" id="pageTitle">@yield('title', 'Tổng quan')</h5>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light rounded-circle" id="themeToggle" style="width: 40px; height: 40px;">
                    <i class="fa-solid fa-moon"></i>
                </button>
                <div class="dropdown">
                    <a href="#" class="d-block text-decoration-none" data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=0D8ABC&color=fff" alt="Admin" width="40" height="40" class="rounded-circle shadow-sm">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><a class="dropdown-item" href="#">Hồ sơ</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item text-danger" type="submit">Đăng xuất</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Dynamic Sections -->
        <div id="content-area">
            @yield('content')
        </div>
    </main>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Admin Custom JS -->
    <script src="{{ asset('js/admin.js') }}"></script>
    
    @yield('scripts')
</body>
</html>
