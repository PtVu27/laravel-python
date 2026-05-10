@extends('layouts.app')
@section('title', 'Giỏ hàng - Pickleball Pro')

@section('content')
<div class="cart-page">
    <div class="container">
        <h1 class="page-title" data-aos="fade-right"><i class="fas fa-shopping-cart"></i> Giỏ Hàng</h1>

        @if(count($cartItems) > 0)
        <div class="cart-layout">
            <div class="cart-items">
                @foreach($cartItems as $index => $item)
                <div class="cart-item" data-aos="fade-up" data-aos-delay="{{ $index * 80 }}" id="cart-item-{{ $item['product']->id }}">
                    <div class="cart-item-image">
                        <img src="{{ $item['product']->image ?: 'https://placehold.co/120x120/ecf0dd/446900?text=P' }}" alt="{{ $item['product']->name }}">
                    </div>
                    <div class="cart-item-info">
                        <div>
                            <div class="cart-item-category">{{ $item['product']->category->name ?? 'Pickleball' }}</div>
                            <h3 class="cart-item-name">{{ $item['product']->name }}</h3>
                        </div>
                        <div class="cart-item-actions">
                            <div class="quantity-control">
                                <button class="qty-btn" onclick="updateCartQty({{ $item['product']->id }}, -1)">−</button>
                                <input type="number" class="qty-input" id="qty-{{ $item['product']->id }}" value="{{ $item['quantity'] }}" min="1" readonly>
                                <button class="qty-btn" onclick="updateCartQty({{ $item['product']->id }}, 1)">+</button>
                            </div>
                            <div class="cart-item-price" id="subtotal-{{ $item['product']->id }}">{{ number_format($item['subtotal'], 0, ',', '.') }}đ</div>
                            <button class="remove-btn" onclick="removeFromCart({{ $item['product']->id }})" title="Xóa">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="cart-summary" data-aos="fade-left">
                <h3>Tóm Tắt Đơn Hàng</h3>
                <div class="summary-row"><span>Tạm tính</span><span id="subtotalAll">{{ number_format($total, 0, ',', '.') }}đ</span></div>
                <div class="summary-row"><span>Phí vận chuyển</span><span style="color:var(--primary);font-weight:600;">Miễn phí</span></div>
                <div class="summary-row total"><span>Tổng cộng</span><span id="totalDisplay">{{ number_format($total, 0, ',', '.') }}đ</span></div>
                <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-block btn-lg" style="margin-top:24px;">
                    <i class="fas fa-credit-card"></i> Thanh toán
                </a>
                <a href="{{ route('categories.index') }}" class="btn btn-outline btn-block" style="margin-top:12px;">
                    <i class="fas fa-arrow-left"></i> Tiếp tục mua sắm
                </a>
            </div>
        </div>
        @else
        <div class="empty-cart" data-aos="fade-up">
            <i class="fas fa-shopping-cart"></i>
            <h2>Giỏ hàng trống</h2>
            <p>Hãy khám phá và thêm sản phẩm yêu thích vào giỏ hàng!</p>
            <a href="{{ route('categories.index') }}" class="btn btn-primary btn-lg"><i class="fas fa-shopping-bag"></i> Mua sắm ngay</a>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
function updateCartQty(productId, delta) {
    const input = document.getElementById('qty-' + productId);
    let newQty = parseInt(input.value) + delta;
    if (newQty < 1) { removeFromCart(productId); return; }
    input.value = newQty;

    $.post('{{ route("cart.update") }}', { product_id: productId, quantity: newQty }, function(data) {
        if (data.success) {
            document.getElementById('subtotal-' + productId).textContent = new Intl.NumberFormat('vi-VN').format(data.subtotal) + 'đ';
            document.getElementById('subtotalAll').textContent = new Intl.NumberFormat('vi-VN').format(data.total) + 'đ';
            document.getElementById('totalDisplay').textContent = new Intl.NumberFormat('vi-VN').format(data.total) + 'đ';
            document.getElementById('cartBadge').textContent = data.cartCount;
        }
    });
}

function removeFromCart(productId) {
    Swal.fire({
        title: 'Xóa sản phẩm?',
        text: 'Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ba1a1a',
        cancelButtonText: 'Hủy',
        confirmButtonText: 'Xóa'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('{{ route("cart.remove") }}', { product_id: productId }, function(data) {
                if (data.success) {
                    gsap.to('#cart-item-' + productId, {
                        x: -100, opacity: 0, height: 0, padding: 0, margin: 0,
                        duration: 0.4, ease: 'power2.in',
                        onComplete: function() {
                            document.getElementById('cart-item-' + productId).remove();
                            document.getElementById('subtotalAll').textContent = new Intl.NumberFormat('vi-VN').format(data.total) + 'đ';
                            document.getElementById('totalDisplay').textContent = new Intl.NumberFormat('vi-VN').format(data.total) + 'đ';
                            document.getElementById('cartBadge').textContent = data.cartCount;
                            if (data.cartCount === 0) location.reload();
                        }
                    });
                    toastr.success(data.message);
                }
            });
        }
    });
}
</script>
@endsection
