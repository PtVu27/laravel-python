<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pickleball Pro Shop')</title>
    <meta name="description" content="@yield('meta_description', 'Pickleball Pro - Cửa hàng dụng cụ Pickleball chuyên nghiệp hàng đầu Việt Nam')">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- 8 Frontend Libraries -->
    <!-- 1. AOS - Animate On Scroll -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!-- 2. Animate.css -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <!-- 3. Swiper CSS -->
    <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet">
    <!-- 4. Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <!-- 5. SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- 6. Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="nav-logo">
                <i class="fas fa-table-tennis-paddle-ball"></i>
                <span>Pickleball<span class="logo-accent">Pro</span></span>
            </a>

            <div class="nav-search">
                <form action="{{ route('search') }}" method="GET" class="search-form" id="searchForm">
                    <input type="text" name="q" placeholder="Tìm kiếm sản phẩm..." value="{{ request('q') }}" class="search-input" id="searchInput">
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <div class="nav-actions">
                <a href="{{ route('categories.index') }}" class="nav-link">
                    <i class="fas fa-th-large"></i>
                    <span>Danh mục</span>
                </a>
                <a href="{{ route('cart.index') }}" class="nav-link cart-link" id="cartNavLink">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Giỏ hàng</span>
                    <span class="cart-badge" id="cartBadge">0</span>
                </a>
                @auth
                    <div class="nav-user-dropdown">
                        <button class="nav-link user-btn" id="userDropdownBtn">
                            <i class="fas fa-user-circle"></i>
                            <span>{{ auth()->user()->email }}</span>
                        </button>
                        <div class="user-dropdown" id="userDropdown">
                            @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="dropdown-item" style="color: var(--primary);">
                                <i class="fas fa-chart-line"></i> Trang quản trị
                            </a>
                            @endif
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                <i class="fas fa-user-edit"></i> Chỉnh sửa tài khoản
                            </a>
                            <a href="{{ route('orders.index') }}" class="dropdown-item">
                                <i class="fas fa-box-open"></i> Đơn hàng của tôi
                            </a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="nav-link">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Đăng nhập</span>
                    </a>
                @endauth
            </div>

            <button class="nav-toggle" id="navToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobileMenu">
            <a href="{{ route('home') }}" class="mobile-link">
                <i class="fas fa-home"></i> Trang chủ
            </a>
            <a href="{{ route('categories.index') }}" class="mobile-link">
                <i class="fas fa-th-large"></i> Danh mục
            </a>
            <a href="{{ route('cart.index') }}" class="mobile-link">
                <i class="fas fa-shopping-cart"></i> Giỏ hàng
            </a>
            @auth
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="mobile-link" style="color: var(--primary);">
                    <i class="fas fa-chart-line"></i> Trang quản trị
                </a>
                @endif
                <a href="{{ route('orders.index') }}" class="mobile-link">
                    <i class="fas fa-box-open"></i> Đơn hàng của tôi
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="mobile-link" style="width:100%;text-align:left;border:none;background:none;cursor:pointer;">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="mobile-link">
                    <i class="fas fa-sign-in-alt"></i> Đăng nhập
                </a>
                <a href="{{ route('register') }}" class="mobile-link">
                    <i class="fas fa-user-plus"></i> Đăng ký
                </a>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div class="footer-logo">
                        <i class="fas fa-table-tennis-paddle-ball"></i>
                        <span>Pickleball<span class="logo-accent">Pro</span></span>
                    </div>
                    <p class="footer-desc">Cửa hàng dụng cụ Pickleball chuyên nghiệp hàng đầu Việt Nam. Chất lượng đỉnh cao, giá cả hợp lý.</p>
                    <div class="footer-social">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Sản phẩm</h4>
                    <ul>
                        <li><a href="{{ route('categories.index') }}">Vợt Pickleball</a></li>
                        <li><a href="{{ route('categories.index') }}">Bóng Pickleball</a></li>
                        <li><a href="{{ route('categories.index') }}">Phụ kiện</a></li>
                        <li><a href="{{ route('categories.index') }}">Giày thể thao</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Hỗ trợ</h4>
                    <ul>
                        <li><a href="#">Hướng dẫn mua hàng</a></li>
                        <li><a href="#">Chính sách đổi trả</a></li>
                        <li><a href="#">Giao hàng</a></li>
                        <li><a href="#">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Liên hệ</h4>
                    <ul class="contact-list">
                        <li><i class="fas fa-map-marker-alt"></i> 123 Nguyễn Huệ, Q.1, TP.HCM</li>
                        <li><i class="fas fa-phone"></i> 0912 345 678</li>
                        <li><i class="fas fa-envelope"></i> info@pickleballpro.vn</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 Pickleball Pro. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- 1. AOS -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <!-- 2. GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <!-- 3. Swiper -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- 4. Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- 5. SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- 6. Lottie -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
    <!-- 7. Particles.js -->
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <!-- 8. CountUp.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.8.0/countUp.umd.min.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 50
        });

        // CSRF Token Setup for AJAX
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        // Toastr config
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 3000,
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut"
        };

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        // Mobile menu toggle
        document.getElementById('navToggle').addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.toggle('active');
            this.querySelector('i').classList.toggle('fa-bars');
            this.querySelector('i').classList.toggle('fa-times');
        });

        // User dropdown
        const userBtn = document.getElementById('userDropdownBtn');
        if (userBtn) {
            userBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                document.getElementById('userDropdown').classList.toggle('active');
            });
            document.addEventListener('click', function() {
                const dd = document.getElementById('userDropdown');
                if (dd) dd.classList.remove('active');
            });
        }

        // Update cart badge
        function updateCartBadge() {
            $.get('{{ route("cart.count") }}', function(data) {
                const badge = document.getElementById('cartBadge');
                badge.textContent = data.count;
                if (data.count > 0) {
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }
            });
        }
        updateCartBadge();

        // Global add to cart function
        function addToCart(productId, quantity = 1) {
            $.post('{{ route("cart.add") }}', {
                product_id: productId,
                quantity: quantity
            }, function(data) {
                if (data.success) {
                    toastr.success(data.message);
                    const badge = document.getElementById('cartBadge');
                    badge.textContent = data.cartCount;
                    badge.style.display = 'flex';

                    // Animate cart icon
                    gsap.fromTo('#cartNavLink', { scale: 1 }, {
                        scale: 1.3,
                        duration: 0.3,
                        yoyo: true,
                        repeat: 1,
                        ease: 'back.out(3)'
                    });
                }
            }).fail(function() {
                toastr.error('Có lỗi xảy ra!');
            });
        }

        // Navbar fade-in animation (CSS-based, no GSAP to avoid hiding)
        document.getElementById('navbar').style.animation = 'fadeInDown 0.6s ease forwards';
        document.head.insertAdjacentHTML('beforeend', '<style>@keyframes fadeInDown{from{opacity:0;transform:translateY(-20px)}to{opacity:1;transform:translateY(0)}}</style>');
    </script>

    <!-- Targeted AI Popups -->
    @auth
        @php
            $user = auth()->user();
            $popupData = null;
            if($user->birth_date && $user->gender) {
                $age = \Carbon\Carbon::parse($user->birth_date)->age;
                if($user->gender == 'male' && $age <= 25) {
                    $popupData = [
                        'title' => 'Sức Mạnh & Tốc Độ!',
                        'text' => 'Chào chàng trai trẻ, có vẻ bạn thích lối chơi tấn công. Khám phá ngay dòng Vợt Pickleball Tấn Công mới nhất của chúng tôi!',
                        'img' => 'https://pickleball.vn/wp-content/uploads/2023/10/vot-pickleball-joola-ben-johns-perseus-cfs-16-1.jpg',
                        'link' => route('categories.index')
                    ];
                } elseif($user->gender == 'female' && $age <= 25) {
                    $popupData = [
                        'title' => 'Phong Cách & Kiểm Soát!',
                        'text' => 'Chào cô gái năng động, thiết kế nổi bật cùng khả năng kiểm soát bóng đỉnh cao là dành cho bạn. Xem ngay Vợt Pickleball Kiểm Soát!',
                        'img' => 'https://pickleball.vn/wp-content/uploads/2024/05/Vot-Pickleball-Joola-Simone-Jardim-Hyperion-C2-CFS-14-1.webp',
                        'link' => route('categories.index')
                    ];
                } elseif($user->gender == 'male' && $age > 25) {
                    $popupData = [
                        'title' => 'Bảo Vệ & Bền Bỉ!',
                        'text' => 'Sự thoải mái và bảo vệ cơ thể là ưu tiên hàng đầu. Nâng cấp trải nghiệm với dòng Giày thể thao Pickleball chuyên dụng.',
                        'img' => 'https://pickleball.vn/wp-content/uploads/2024/06/giay-pickleball-babolat-jet-mach-3-all-court-men-1.jpg',
                        'link' => route('categories.index')
                    ];
                } elseif($user->gender == 'female' && $age > 25) {
                    $popupData = [
                        'title' => 'Thời Trang & Tiện Dụng!',
                        'text' => 'Đừng quên trang bị những phụ kiện thời trang và tiện lợi nhất cho mỗi trận đấu của bạn. Xem ngay Phụ Kiện Pickleball!',
                        'img' => 'https://pickleball.vn/wp-content/uploads/2024/05/Tui-Pickleball-Joola-Tour-Elite-Bag-Trang-1.webp',
                        'link' => route('categories.index')
                    ];
                }
            }
        @endphp
        @if($popupData)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if(!sessionStorage.getItem('ad_popup_shown')) {
                    setTimeout(() => {
                        Swal.fire({
                            title: '{{ $popupData["title"] }}',
                            text: '{{ $popupData["text"] }}',
                            imageUrl: '{{ $popupData["img"] }}',
                            imageWidth: 200,
                            imageAlt: 'Product image',
                            showCancelButton: true,
                            confirmButtonText: '<i class="fas fa-shopping-cart"></i> Khám Phá Ngay',
                            cancelButtonText: 'Đóng',
                            confirmButtonColor: 'var(--primary)',
                            cancelButtonColor: '#6c757d',
                            customClass: {
                                popup: 'animated fadeInDown',
                                title: 'fs-4',
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '{{ $popupData["link"] }}';
                            }
                        });
                        sessionStorage.setItem('ad_popup_shown', 'true');
                    }, 1500); // Show popup after 1.5s
                }
            });
        </script>
        @endif
    @endauth

    @yield('scripts')
</body>
</html>
