@extends('layouts.app')
@section('title', $product->name . ' - Pickleball Pro')

@section('content')
<div class="product-page">
    <div class="container">
        <div class="product-detail">
            <div class="product-gallery" data-aos="fade-right">
                <img src="{{ $product->image ?: 'https://placehold.co/600x600/ecf0dd/446900?text=Pickleball' }}" alt="{{ $product->name }}">
            </div>
            <div class="product-info" data-aos="fade-left">
                <span class="product-category-tag">{{ $product->category->name ?? 'Pickleball' }}</span>
                <h1>{{ $product->name }}</h1>
                <div class="product-price-display">{{ number_format($product->price, 0, ',', '.') }}đ</div>
                <div class="product-meta">
                    <div class="meta-item"><i class="fas fa-eye"></i> {{ $product->view }} lượt xem</div>
                    <div class="meta-item"><i class="fas fa-box"></i> Còn {{ $product->quantity }} sản phẩm</div>
                </div>
                <p class="product-description">{{ $product->description }}</p>
                <div class="quantity-selector">
                    <label>Số lượng:</label>
                    <div class="quantity-control">
                        <button class="qty-btn" onclick="changeQty(-1)">−</button>
                        <input type="number" class="qty-input" id="productQty" value="1" min="1" max="{{ $product->quantity }}">
                        <button class="qty-btn" onclick="changeQty(1)">+</button>
                    </div>
                </div>
                <div class="product-actions">
                    <button onclick="addToCart({{ $product->id }}, parseInt(document.getElementById('productQty').value))" class="btn btn-primary btn-lg">
                        <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                    </button>
                    <a href="{{ route('cart.index') }}" class="btn btn-outline btn-lg">
                        <i class="fas fa-shopping-bag"></i> Xem giỏ hàng
                    </a>
                </div>
            </div>
        </div>

        @if($relatedProducts->count() > 0)
        <div class="section-header" data-aos="fade-up">
            <h2>Sản Phẩm Liên Quan</h2>
            <div class="accent-line"></div>
        </div>
        <div class="products-grid">
            @foreach($relatedProducts as $index => $rp)
            <div class="product-card" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="card-image">
                    <img src="{{ $rp->image ?: 'https://placehold.co/400x400/ecf0dd/446900?text=Pickleball' }}" alt="{{ $rp->name }}">
                    <div class="card-overlay">
                        <button onclick="addToCart({{ $rp->id }})" class="btn btn-primary btn-sm"><i class="fas fa-cart-plus"></i></button>
                        <a href="{{ route('product.show', $rp->id) }}" class="btn btn-dark btn-sm"><i class="fas fa-eye"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-category">{{ $rp->category->name ?? '' }}</div>
                    <h3 class="card-title">{{ $rp->name }}</h3>
                    <div class="card-price">{{ number_format($rp->price, 0, ',', '.') }}đ</div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
function changeQty(delta) {
    const input = document.getElementById('productQty');
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    if (val > {{ $product->quantity }}) val = {{ $product->quantity }};
    input.value = val;
}
</script>
@endsection
