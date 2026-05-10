@extends('layouts.app')
@section('title', 'Thanh toán - Pickleball Pro')

@section('content')
<div class="checkout-page">
    <div class="container">
        <h1 class="page-title" data-aos="fade-right"><i class="fas fa-credit-card"></i> Thanh Toán</h1>

        <div class="checkout-layout">
            <div>
                <form id="checkoutForm" data-aos="fade-up">
                    <div class="checkout-form-card">
                        <h2><i class="fas fa-user"></i> Thông tin giao hàng</h2>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Họ tên *</label>
                                <input type="text" name="name" class="form-control" required placeholder="Nguyễn Văn A">
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại *</label>
                                <input type="tel" name="phone" class="form-control" required placeholder="0912 345 678">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" name="email" class="form-control" required placeholder="email@example.com" value="{{ auth()->check() ? auth()->user()->email : '' }}">
                        </div>
                        <div class="form-group">
                            <label>Địa chỉ giao hàng *</label>
                            <input type="text" name="address" class="form-control" required placeholder="Số nhà, đường, quận/huyện, TP">
                        </div>
                        <div class="form-group">
                            <label>Ghi chú</label>
                            <textarea name="note" class="form-control" rows="3" placeholder="Ghi chú cho đơn hàng..."></textarea>
                        </div>
                    </div>

                    <div class="checkout-form-card" style="margin-top:24px;">
                        <h2><i class="fas fa-wallet"></i> Phương thức thanh toán</h2>
                        <div class="form-group">
                            <label style="display:flex;align-items:center;gap:10px;padding:16px;border:2px solid var(--primary-container);border-radius:var(--radius);cursor:pointer;background:rgba(163,230,53,0.05);">
                                <input type="radio" name="payment" value="cod" checked> <i class="fas fa-truck" style="color:var(--primary);"></i> Thanh toán khi nhận hàng (COD)
                            </label>
                        </div>
                        <div class="form-group">
                            <label style="display:flex;align-items:center;gap:10px;padding:16px;border:1px solid var(--outline-variant);border-radius:var(--radius);cursor:pointer;">
                                <input type="radio" name="payment" value="bank"> <i class="fas fa-university" style="color:var(--secondary);"></i> Chuyển khoản ngân hàng
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg" style="margin-top:24px;" id="submitOrderBtn">
                        <i class="fas fa-check-circle"></i> Đặt hàng
                    </button>
                </form>
            </div>

            <div class="order-summary-card" data-aos="fade-left">
                <h2><i class="fas fa-receipt"></i> Đơn hàng của bạn</h2>
                @foreach($cartItems as $item)
                <div class="order-item">
                    <div class="order-item-img">
                        <img src="{{ $item['product']->image ?: 'https://placehold.co/60x60/ecf0dd/446900?text=P' }}" alt="">
                    </div>
                    <div class="order-item-info">
                        <div class="order-item-name">{{ $item['product']->name }}</div>
                        <div class="order-item-qty">x{{ $item['quantity'] }}</div>
                    </div>
                    <div class="order-item-price">{{ number_format($item['subtotal'], 0, ',', '.') }}đ</div>
                </div>
                @endforeach
                <div class="summary-row" style="margin-top:16px;"><span>Tạm tính</span><span>{{ number_format($total, 0, ',', '.') }}đ</span></div>
                <div class="summary-row"><span>Phí vận chuyển</span><span style="color:var(--primary);font-weight:600;">Miễn phí</span></div>
                <div class="summary-row total"><span>Tổng cộng</span><span>{{ number_format($total, 0, ',', '.') }}đ</span></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('submitOrderBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';

    const formData = new FormData(this);

    $.ajax({
        url: '{{ route("checkout.process") }}',
        method: 'POST',
        data: Object.fromEntries(formData),
        success: function(data) {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Đặt hàng thành công!',
                    html: 'Mã đơn hàng: <strong>' + data.orderCode + '</strong>',
                    confirmButtonColor: '#446900',
                    confirmButtonText: 'Về trang chủ'
                }).then(() => {
                    window.location.href = data.redirect;
                });
            }
        },
        error: function(xhr) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-check-circle"></i> Đặt hàng';
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                let msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                toastr.error(msg);
            } else {
                toastr.error('Có lỗi xảy ra, vui lòng thử lại!');
            }
        }
    });
});
</script>
@endsection
