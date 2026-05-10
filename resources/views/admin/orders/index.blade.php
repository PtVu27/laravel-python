@extends('admin.layouts.app')

@section('title', 'Đơn hàng')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <h4 class="m-0 fw-bold">Lịch sử Đơn hàng</h4>
    <select class="form-select w-auto rounded-3" id="orderStatusFilter">
        <option value="all">Tất cả trạng thái</option>
        <option value="pending">Đang xử lý</option>
        <option value="shipped">Đã giao</option>
        <option value="cancelled">Đã hủy</option>
    </select>
</div>

<div class="card border-0">
    <div class="table-responsive">
        <table class="table table-hover m-0">
            <thead>
                <tr>
                    <th>Mã ĐH</th>
                    <th>Khách hàng</th>
                    <th>Tổng tiền</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td class="fw-semibold text-primary"><a href="{{ route('admin.orders.show', $order->id) }}">{{ $order->code }}</a></td>
                    <td>{{ $order->name ?? 'Guest' }}</td>
                    <td class="fw-medium">
                        {{ number_format($order->orderDetails->sum(function($detail) { return $detail->price * $detail->quantity; }), 0, ',', '.') }} ₫
                    </td>
                    <td class="text-secondary">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($order->status == 'pending')
                            <span class="badge bg-warning-subtle text-warning">
                                <i class="fa-solid fa-circle fs-6 me-1" style="font-size: 8px; vertical-align: middle;"></i> Đang xử lý
                            </span>
                        @elseif($order->status == 'processing')
                            <span class="badge bg-info-subtle text-info">
                                <i class="fa-solid fa-circle fs-6 me-1" style="font-size: 8px; vertical-align: middle;"></i> Đang chuẩn bị
                            </span>
                        @elseif($order->status == 'shipped' || $order->status == 'delivered')
                            <span class="badge bg-success-subtle text-success">
                                <i class="fa-solid fa-circle fs-6 me-1" style="font-size: 8px; vertical-align: middle;"></i> Đã giao
                            </span>
                        @elseif($order->status == 'cancelled')
                            <span class="badge bg-danger-subtle text-danger">
                                <i class="fa-solid fa-circle fs-6 me-1" style="font-size: 8px; vertical-align: middle;"></i> Đã hủy
                            </span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary">
                                <i class="fa-solid fa-circle fs-6 me-1" style="font-size: 8px; vertical-align: middle;"></i> {{ $order->status }}
                            </span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-light text-secondary" title="Xem chi tiết"><i class="fa-solid fa-eye"></i></a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-secondary">Chưa có đơn hàng nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
