@extends('layouts.app')
@section('title', 'Chi tiết đơn hàng ' . $order->code . ' - Pickleball Pro')

@section('content')
<div class="checkout-page">
    <div class="container">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:32px;" data-aos="fade-down">
            <h1 class="page-title" style="margin-bottom:0;"><i class="fas fa-file-invoice"></i> Chi tiết đơn hàng #{{ $order->code }}</h1>
            <a href="{{ route('orders.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Quay lại</a>
        </div>

        <div class="checkout-layout">
            <div data-aos="fade-right">
                <div class="checkout-form-card" style="margin-bottom:24px;">
                    <h2><i class="fas fa-info-circle"></i> Trạng thái đơn hàng</h2>
                    <div style="padding:16px; background:var(--surface-dim); border-radius:var(--radius); display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <p style="margin-bottom:4px; color:var(--text-secondary); font-size:0.9rem;">Ngày đặt hàng</p>
                            <p style="font-weight:600;">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                        @php
                            $statusColors = [
                                'pending' => ['bg' => 'rgba(234, 179, 8, 0.15)', 'text' => '#ca8a04', 'label' => 'Đang xử lý'],
                                'processing' => ['bg' => 'rgba(59, 130, 246, 0.15)', 'text' => '#2563eb', 'label' => 'Đang chuẩn bị'],
                                'shipped' => ['bg' => 'rgba(59, 130, 246, 0.15)', 'text' => '#2563eb', 'label' => 'Đang giao hàng'],
                                'delivered' => ['bg' => 'rgba(34, 197, 94, 0.15)', 'text' => '#16a34a', 'label' => 'Đã giao'],
                                'cancelled' => ['bg' => 'rgba(239, 68, 68, 0.15)', 'text' => '#dc2626', 'label' => 'Đã hủy'],
                            ];
                            $status = $statusColors[$order->status] ?? $statusColors['pending'];
                        @endphp
                        <span style="display:inline-block; padding:8px 16px; border-radius:50px; background:{{ $status['bg'] }}; color:{{ $status['text'] }}; font-weight:700;">
                            {{ $status['label'] }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="checkout-form-card">
                <h2><i class="fas fa-box-open"></i> Sản phẩm đã đặt</h2>
                <div style="display:flex; flex-direction:column; gap:16px; margin-top:16px;">
                    @foreach($order->orderDetails as $detail)
                    <div style="display:flex; gap:16px; padding-bottom:16px; border-bottom:1px solid var(--outline-variant);">
                        <div style="width:80px; height:80px; border-radius:var(--radius); overflow:hidden; flex-shrink:0;">
                            <img src="{{ $detail->product->image ?: 'https://placehold.co/80x80/ecf0dd/446900?text=P' }}" style="width:100%; height:100%; object-fit:cover;" alt="{{ $detail->product->name }}">
                        </div>
                        <div style="flex:1;">
                            <div style="font-size:0.8rem; color:var(--text-secondary); text-transform:uppercase;">{{ $detail->product->category->name ?? 'Sản phẩm' }}</div>
                            <h3 style="font-size:1rem; font-weight:600; margin-bottom:4px;">
                                <a href="{{ route('product.show', $detail->product_id) }}" style="color:inherit; text-decoration:none;">{{ $detail->product->name }}</a>
                            </h3>
                            <div style="color:var(--text-secondary); font-size:0.9rem;">Số lượng: {{ $detail->quantity }}</div>
                        </div>
                        <div style="text-align:right;">
                            <div style="font-weight:700; color:var(--primary);">{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}đ</div>
                            <div style="font-size:0.8rem; color:var(--text-secondary); text-decoration:line-through;">{{ number_format($detail->price, 0, ',', '.') }}đ/sp</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="order-summary-card" data-aos="fade-left">
            <h2><i class="fas fa-receipt"></i> Tổng kết thanh toán</h2>
            
            <div style="margin-top:24px;">
                @php
                    $subtotal = $order->orderDetails->sum(function($detail) { return $detail->price * $detail->quantity; });
                @endphp
                <div class="summary-row"><span>Tạm tính</span><span>{{ number_format($subtotal, 0, ',', '.') }}đ</span></div>
                <div class="summary-row"><span>Phí vận chuyển</span><span style="color:var(--primary);font-weight:600;">Miễn phí</span></div>
                <div class="summary-row total"><span>Tổng cộng</span><span>{{ number_format($subtotal, 0, ',', '.') }}đ</span></div>
            </div>

            <div style="margin-top:32px; padding-top:24px; border-top:1px dashed var(--outline-variant);">
                <h3 style="font-size:1.1rem; margin-bottom:16px;"><i class="fas fa-map-marker-alt" style="color:var(--secondary); margin-right:8px;"></i> Thông tin nhận hàng</h3>
                <p style="margin-bottom:8px;"><strong>Họ tên:</strong> {{ $order->name ?? 'Guest' }}</p>
                <p style="margin-bottom:8px;"><strong>Điện thoại:</strong> {{ $order->phone ?? 'Không có' }}</p>
                <p style="margin-bottom:8px;"><strong>Email:</strong> {{ $order->email ?? 'Không có' }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order->address ?? 'Không có' }}</p>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
