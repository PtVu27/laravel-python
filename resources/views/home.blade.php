@extends('layouts.app')
@section('title', 'Pickleball Pro - Trang chủ')

@section('content')
<!-- Hero -->
<section class="hero">
    <div id="particles-js"></div>
    <div class="hero-container">
        <div class="hero-content" data-aos="fade-right">
            <div class="hero-badge animate__animated animate__fadeInDown">
                <i class="fas fa-trophy"></i> #1 Pickleball Store in Vietnam
            </div>
            <h1>Nâng Tầm<br>Trận Đấu Của Bạn<br>Với <span class="highlight">Pro Gear</span></h1>
            <p>Trang bị dụng cụ Pickleball chuyên nghiệp. Chất lượng đỉnh cao, hiệu suất vượt trội cho mọi trận đấu.</p>
            <div class="hero-actions">
                <a href="{{ route('categories.index') }}" class="btn btn-primary btn-lg"><i class="fas fa-shopping-bag"></i> Mua sắm ngay</a>
                <a href="#featured" class="btn btn-secondary btn-lg"><i class="fas fa-star"></i> Sản phẩm nổi bật</a>
            </div>
        </div>
        <div class="hero-image" data-aos="fade-left">
            <img src="https://images.unsplash.com/photo-1554068865-24cecd4e34b8?w=500&h=500&fit=crop" alt="Pickleball">
        </div>
    </div>
</section>

<!-- Stats -->
<section class="stats-section">
    <div class="stats-grid">
        <div class="stat-item" data-aos="fade-up" data-aos-delay="0">
            <h3 id="stat1">500+</h3><p>Sản phẩm</p>
        </div>
        <div class="stat-item" data-aos="fade-up" data-aos-delay="100">
            <h3 id="stat2">10,000+</h3><p>Khách hàng</p>
        </div>
        <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
            <h3 id="stat3">50+</h3><p>Thương hiệu</p>
        </div>
        <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
            <h3 id="stat4">99%</h3><p>Hài lòng</p>
        </div>
    </div>
</section>

<!-- Categories -->
<section class="section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <h2>Danh Mục Sản Phẩm</h2>
            <p>Khám phá bộ sưu tập dụng cụ Pickleball đa dạng</p>
            <div class="accent-line"></div>
        </div>
        <div class="categories-grid">
            @forelse($categories as $index => $cat)
            <a href="{{ route('categories.show', $cat->id) }}" class="category-card" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <i class="fas fa-table-tennis-paddle-ball"></i>
                <h3>{{ $cat->name }}</h3>
                <p>{{ $cat->products_count }} sản phẩm</p>
            </a>
            @empty
            <div class="category-card" data-aos="fade-up"><i class="fas fa-table-tennis-paddle-ball"></i><h3>Vợt Pickleball</h3><p>Sắp ra mắt</p></div>
            <div class="category-card" data-aos="fade-up" data-aos-delay="100"><i class="fas fa-baseball-ball"></i><h3>Bóng Pickleball</h3><p>Sắp ra mắt</p></div>
            <div class="category-card" data-aos="fade-up" data-aos-delay="200"><i class="fas fa-shoe-prints"></i><h3>Giày thể thao</h3><p>Sắp ra mắt</p></div>
            <div class="category-card" data-aos="fade-up" data-aos-delay="300"><i class="fas fa-tshirt"></i><h3>Phụ kiện</h3><p>Sắp ra mắt</p></div>
            @endforelse
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="section" id="featured" style="background:var(--surface-dim);">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <h2>Sản Phẩm Nổi Bật</h2>
            <p>Được yêu thích nhất bởi cộng đồng Pickleball</p>
            <div class="accent-line"></div>
        </div>
        <div class="products-grid">
            @forelse($featuredProducts as $index => $product)
            <div class="product-card" data-aos="fade-up" data-aos-delay="{{ $index * 80 }}">
                <div class="card-image">
                    <img src="{{ $product->image ?: 'https://placehold.co/400x400/ecf0dd/446900?text=Pickleball' }}" alt="{{ $product->name }}">
                    <div class="card-overlay">
                        <button onclick="addToCart({{ $product->id }})" class="btn btn-primary btn-sm"><i class="fas fa-cart-plus"></i></button>
                        <a href="{{ route('product.show', $product->id) }}" class="btn btn-dark btn-sm"><i class="fas fa-eye"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-category">{{ $product->category->name ?? 'Pickleball' }}</div>
                    <h3 class="card-title">{{ $product->name }}</h3>
                    <div class="card-price">{{ number_format($product->price, 0, ',', '.') }}đ</div>
                </div>
            </div>
            @empty
            @for($i = 0; $i < 4; $i++)
            <div class="product-card" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                <div class="card-image"><img src="https://placehold.co/400x400/ecf0dd/446900?text=Coming+Soon" alt="Coming Soon"></div>
                <div class="card-body"><div class="card-category">Pickleball</div><h3 class="card-title">Sản phẩm sắp ra mắt</h3><div class="card-price">Liên hệ</div></div>
            </div>
            @endfor
            @endforelse
        </div>
    </div>
</section>

<!-- New Products -->
<section class="section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <h2>Sản Phẩm Mới</h2>
            <p>Hàng mới về, cập nhật liên tục</p>
            <div class="accent-line"></div>
        </div>
        <div class="products-grid">
            @forelse($newProducts as $index => $product)
            <div class="product-card" data-aos="fade-up" data-aos-delay="{{ $index * 80 }}">
                <div class="card-image">
                    <img src="{{ $product->image ?: 'https://placehold.co/400x400/ecf0dd/446900?text=Pickleball' }}" alt="{{ $product->name }}">
                    <div class="card-overlay">
                        <button onclick="addToCart({{ $product->id }})" class="btn btn-primary btn-sm"><i class="fas fa-cart-plus"></i></button>
                        <a href="{{ route('product.show', $product->id) }}" class="btn btn-dark btn-sm"><i class="fas fa-eye"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-category">{{ $product->category->name ?? 'Pickleball' }}</div>
                    <h3 class="card-title">{{ $product->name }}</h3>
                    <div class="card-price">{{ number_format($product->price, 0, ',', '.') }}đ</div>
                </div>
            </div>
            @empty
            @for($i = 0; $i < 4; $i++)
            <div class="product-card" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                <div class="card-image"><img src="https://placehold.co/400x400/ecf0dd/446900?text=New" alt="New"></div>
                <div class="card-body"><div class="card-category">Mới</div><h3 class="card-title">Sản phẩm mới sắp ra mắt</h3><div class="card-price">Liên hệ</div></div>
            </div>
            @endfor
            @endforelse
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
// Particles.js for hero
if (typeof particlesJS !== 'undefined') {
    particlesJS('particles-js', {
        particles: {
            number: { value: 30 },
            color: { value: '#a3e635' },
            shape: { type: 'circle' },
            opacity: { value: 0.3 },
            size: { value: 3, random: true },
            move: { enable: true, speed: 1 }
        }
    });
}

// GSAP animations for hero
gsap.from('.hero-badge', { y: -30, opacity: 0, duration: 0.8, delay: 0.3 });
gsap.from('.hero h1', { y: 40, opacity: 0, duration: 0.8, delay: 0.5 });
gsap.from('.hero p', { y: 30, opacity: 0, duration: 0.8, delay: 0.7 });
gsap.from('.hero-actions', { y: 30, opacity: 0, duration: 0.8, delay: 0.9 });
</script>
@endsection
