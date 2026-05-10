@extends('layouts.app')
@section('title', 'Đơn hàng của tôi - Pickleball Pro')

@section('content')
<div class="cart-page">
    <div class="container">
        <h1 class="page-title" data-aos="fade-right"><i class="fas fa-box-open"></i> Đơn hàng của tôi</h1>

        @if($orders->count() > 0)
        <div class="cart-items" data-aos="fade-up">
            @foreach($orders as $order)
            <div class="cart-item" style="display:block; padding: 24px;">
                <div style="display:flex; justify-content:space-between; border-bottom:1px solid var(--outline-variant); padding-bottom:16px; margin-bottom:16px;">
                    <div>
                        <h3 style="font-size:1.1rem; margin-bottom:8px;">Mã đơn: <span style="color:var(--primary);">{{ $order->code }}</span></h3>
                        <div style="color:var(--text-secondary); font-size:0.9rem;">
                            Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                    <div style="text-align:right;">
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
                        <span style="display:inline-block; padding:6px 12px; border-radius:50px; background:{{ $status['bg'] }}; color:{{ $status['text'] }}; font-weight:600; font-size:0.85rem; margin-bottom:8px;">
                            {{ $status['label'] }}
                        </span>
                        <div style="font-family:'Montserrat',sans-serif; font-weight:700; font-size:1.2rem;">
                            {{ number_format($order->orderDetails->sum(function($detail) { return $detail->price * $detail->quantity; }), 0, ',', '.') }}đ
                        </div>
                    </div>
                </div>

                <div style="display:flex; gap:16px; align-items:center;">
                    <div style="flex:1;">
                        <p style="font-size:0.9rem; color:var(--text-secondary);">
                            <strong>{{ $order->orderDetails->count() }}</strong> sản phẩm:
                            {{ $order->orderDetails->take(2)->map(function($d) { return $d->product->name; })->implode(', ') }}
                            @if($order->orderDetails->count() > 2)
                                ... và {{ $order->orderDetails->count() - 2 }} sản phẩm khác.
                            @endif
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline btn-sm">
                            Chi tiết <i class="fas fa-chevron-right" style="margin-left:4px; font-size:0.7rem;"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-cart" data-aos="fade-up">
            <i class="fas fa-box"></i>
            <h2>Bạn chưa có đơn hàng nào</h2>
            <p>Hãy tiếp tục khám phá và mua sắm những sản phẩm tuyệt vời của chúng tôi!</p>
            <a href="{{ route('categories.index') }}" class="btn btn-primary btn-lg"><i class="fas fa-shopping-bag"></i> Mua sắm ngay</a>
        </div>
        @endif
    </div>
</div>
@endsection
