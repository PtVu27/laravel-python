@extends('admin.layouts.app')

@section('title', 'Chi tiết đơn hàng ' . $order->code)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <h4 class="m-0 fw-bold">Chi tiết Đơn hàng <span class="text-primary">{{ $order->code }}</span></h4>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-light"><i class="fa-solid fa-arrow-left me-2"></i>Quay lại</a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 mb-4 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h6 class="fw-bold m-0"><i class="fa-solid fa-box-open me-2 text-primary"></i>Sản phẩm đã đặt</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach($order->orderDetails as $detail)
                            @php $total += $detail->price * $detail->quantity; @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $detail->product->image ?? 'https://placehold.co/50x50/ecf0dd/446900?text=P' }}" alt="" class="rounded" width="50" height="50" style="object-fit: cover;">
                                        <div>
                                            <h6 class="m-0">{{ $detail->product->name ?? 'Sản phẩm đã xóa' }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ number_format($detail->price, 0, ',', '.') }} ₫</td>
                                <td>x{{ $detail->quantity }}</td>
                                <td class="text-end fw-medium">{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} ₫</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                                <td class="text-end fw-bold text-primary fs-5">{{ number_format($total, 0, ',', '.') }} ₫</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Trạng thái -->
        <div class="card border-0 mb-4 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="fa-solid fa-spinner fa-spin me-2 text-primary"></i>Cập nhật trạng thái</h6>
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <select name="status" class="form-select">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Đang xử lý</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang chuẩn bị</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Đang giao hàng</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Đã giao</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Cập nhật</button>
                </form>
            </div>
        </div>

        <!-- Thông tin khách hàng -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="fa-solid fa-address-card me-2 text-primary"></i>Thông tin nhận hàng</h6>
                <div class="d-flex flex-column gap-2 text-secondary">
                    <div><i class="fa-solid fa-user me-2 w-20px text-center"></i> <strong>{{ $order->name ?? 'Guest' }}</strong></div>
                    <div><i class="fa-solid fa-phone me-2 w-20px text-center"></i> {{ $order->phone ?? 'Không có' }}</div>
                    <div><i class="fa-solid fa-envelope me-2 w-20px text-center"></i> {{ $order->email ?? 'Không có' }}</div>
                    <div><i class="fa-solid fa-location-dot me-2 w-20px text-center"></i> {{ $order->address ?? 'Không có' }}</div>
                    <div><i class="fa-solid fa-calendar me-2 w-20px text-center"></i> {{ $order->created_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
