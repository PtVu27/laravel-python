@extends('admin.layouts.app')

@section('title', 'Tổng quan')

@section('content')
{{-- ===== ROW 1: Stat Cards ===== --}}
<div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="card p-4 border-0 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-secondary mb-1 fw-medium" style="font-size:0.85rem;">Tổng đơn hàng</p>
                    <h3 class="fw-bold m-0">{{ number_format($totalOrders) }}</h3>
                </div>
                <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                    <i class="fa-solid fa-clipboard-list fa-xl"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card p-4 border-0 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-secondary mb-1 fw-medium" style="font-size:0.85rem;">Đang xử lý</p>
                    <h3 class="fw-bold m-0 text-warning">{{ number_format($pendingOrders) }}</h3>
                </div>
                <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning">
                    <i class="fa-solid fa-clock fa-xl"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card p-4 border-0 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-secondary mb-1 fw-medium" style="font-size:0.85rem;">Đang giao</p>
                    <h3 class="fw-bold m-0 text-info">{{ number_format($shippedOrders) }}</h3>
                </div>
                <div class="bg-info bg-opacity-10 p-3 rounded-circle text-info">
                    <i class="fa-solid fa-truck-fast fa-xl"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card p-4 border-0 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-secondary mb-1 fw-medium" style="font-size:0.85rem;">Doanh thu (đã giao)</p>
                    <h3 class="fw-bold m-0 text-success">{{ number_format($totalRevenue, 0, ',', '.') }} ₫</h3>
                </div>
                <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                    <i class="fa-solid fa-wallet fa-xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== ROW 2: Order Status Breakdown ===== --}}
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-2">
                <h6 class="fw-bold m-0"><i class="fa-solid fa-chart-pie me-2 text-primary"></i>Phân bố trạng thái đơn hàng</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6 col-md-4 col-lg">
                        <div class="text-center p-3 rounded-3" style="background: rgba(234,179,8,0.1);">
                            <div class="fw-bold fs-4 text-warning">{{ $pendingOrders }}</div>
                            <small class="text-secondary">Chờ xử lý</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg">
                        <div class="text-center p-3 rounded-3" style="background: rgba(59,130,246,0.1);">
                            <div class="fw-bold fs-4" style="color:#2563eb;">{{ $processingOrders }}</div>
                            <small class="text-secondary">Đang chuẩn bị</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg">
                        <div class="text-center p-3 rounded-3" style="background: rgba(6,182,212,0.1);">
                            <div class="fw-bold fs-4 text-info">{{ $shippedOrders }}</div>
                            <small class="text-secondary">Đang giao</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg">
                        <div class="text-center p-3 rounded-3" style="background: rgba(34,197,94,0.1);">
                            <div class="fw-bold fs-4 text-success">{{ $deliveredOrders }}</div>
                            <small class="text-secondary">Đã giao</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg">
                        <div class="text-center p-3 rounded-3" style="background: rgba(239,68,68,0.1);">
                            <div class="fw-bold fs-4 text-danger">{{ $cancelledOrders }}</div>
                            <small class="text-secondary">Đã hủy</small>
                        </div>
                    </div>
                </div>

                {{-- Progress bar visual --}}
                @if($totalOrders > 0)
                <div class="mt-4">
                    <div class="progress" style="height: 12px; border-radius: 8px;">
                        <div class="progress-bar bg-warning" style="width: {{ ($pendingOrders / $totalOrders) * 100 }}%" title="Chờ xử lý"></div>
                        <div class="progress-bar" style="width: {{ ($processingOrders / $totalOrders) * 100 }}%; background-color:#2563eb;" title="Đang chuẩn bị"></div>
                        <div class="progress-bar bg-info" style="width: {{ ($shippedOrders / $totalOrders) * 100 }}%" title="Đang giao"></div>
                        <div class="progress-bar bg-success" style="width: {{ ($deliveredOrders / $totalOrders) * 100 }}%" title="Đã giao"></div>
                        <div class="progress-bar bg-danger" style="width: {{ ($cancelledOrders / $totalOrders) * 100 }}%" title="Đã hủy"></div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-2">
                <h6 class="fw-bold m-0"><i class="fa-solid fa-coins me-2 text-success"></i>Tổng quan Doanh thu</h6>
            </div>
            <div class="card-body d-flex flex-column justify-content-center">
                <div class="mb-4">
                    <p class="text-secondary mb-1" style="font-size: 0.85rem;">Doanh thu (đơn đã giao)</p>
                    <h4 class="fw-bold text-success">{{ number_format($totalRevenue, 0, ',', '.') }} ₫</h4>
                </div>
                <div class="mb-4">
                    <p class="text-secondary mb-1" style="font-size: 0.85rem;">Doanh thu kỳ vọng (trừ đã hủy)</p>
                    <h4 class="fw-bold" style="color:#2563eb;">{{ number_format($totalRevenueAll, 0, ',', '.') }} ₫</h4>
                </div>
                <div>
                    <p class="text-secondary mb-1" style="font-size: 0.85rem;">Tổng khách hàng</p>
                    <h4 class="fw-bold text-dark">{{ number_format($totalCustomers) }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== ROW 3: Top Products ===== --}}
<div class="row g-4 mb-4">
    {{-- Sản phẩm mua nhiều nhất --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-2">
                <h6 class="fw-bold m-0"><i class="fa-solid fa-fire me-2 text-danger"></i>Mua nhiều nhất</h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($topProducts as $i => $product)
                    <div class="list-group-item d-flex align-items-center gap-3 border-0 px-4 py-3">
                        <span class="badge rounded-pill {{ $i === 0 ? 'bg-danger' : ($i === 1 ? 'bg-warning text-dark' : 'bg-secondary') }}" style="width:28px; height:28px; display:flex; align-items:center; justify-content:center;">{{ $i + 1 }}</span>
                        <img src="{{ $product->image ?: 'https://placehold.co/40x40/ecf0dd/446900?text=P' }}" alt="" class="rounded" width="40" height="40" style="object-fit:cover;">
                        <div class="flex-grow-1 text-truncate">
                            <div class="fw-medium text-truncate">{{ $product->name }}</div>
                            <small class="text-secondary">{{ number_format($product->price, 0, ',', '.') }} ₫</small>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success fw-bold">{{ $product->total_sold }} đã bán</span>
                    </div>
                    @empty
                    <div class="p-4 text-center text-secondary">Chưa có dữ liệu</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Sản phẩm ít mua nhất --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-2">
                <h6 class="fw-bold m-0"><i class="fa-solid fa-arrow-trend-down me-2 text-warning"></i>Ít mua nhất</h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($leastProducts as $i => $product)
                    <div class="list-group-item d-flex align-items-center gap-3 border-0 px-4 py-3">
                        <span class="badge rounded-pill bg-light text-dark" style="width:28px; height:28px; display:flex; align-items:center; justify-content:center;">{{ $i + 1 }}</span>
                        <img src="{{ $product->image ?: 'https://placehold.co/40x40/ecf0dd/446900?text=P' }}" alt="" class="rounded" width="40" height="40" style="object-fit:cover;">
                        <div class="flex-grow-1 text-truncate">
                            <div class="fw-medium text-truncate">{{ $product->name }}</div>
                            <small class="text-secondary">{{ number_format($product->price, 0, ',', '.') }} ₫</small>
                        </div>
                        <span class="badge bg-warning bg-opacity-10 text-warning fw-bold">{{ $product->total_sold }} đã bán</span>
                    </div>
                    @empty
                    <div class="p-4 text-center text-secondary">Chưa có dữ liệu</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Lượt xem cao nhất --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-2">
                <h6 class="fw-bold m-0"><i class="fa-solid fa-eye me-2 text-info"></i>Lượt xem cao nhất</h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($mostViewedProducts as $i => $product)
                    <div class="list-group-item d-flex align-items-center gap-3 border-0 px-4 py-3">
                        <span class="badge rounded-pill {{ $i === 0 ? 'bg-info' : 'bg-light text-dark' }}" style="width:28px; height:28px; display:flex; align-items:center; justify-content:center;">{{ $i + 1 }}</span>
                        <img src="{{ $product->image ?: 'https://placehold.co/40x40/ecf0dd/446900?text=P' }}" alt="" class="rounded" width="40" height="40" style="object-fit:cover;">
                        <div class="flex-grow-1 text-truncate">
                            <div class="fw-medium text-truncate">{{ $product->name }}</div>
                            <small class="text-secondary">{{ number_format($product->price, 0, ',', '.') }} ₫</small>
                        </div>
                        <span class="badge bg-info bg-opacity-10 text-info fw-bold"><i class="fa-solid fa-eye me-1"></i>{{ number_format($product->view ?? 0) }}</span>
                    </div>
                    @empty
                    <div class="p-4 text-center text-secondary">Chưa có dữ liệu</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== ROW 4: AI Analysis ===== --}}
@if(isset($analysis) && !isset($analysis['error']))
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="fw-bold m-0"><i class="fa-solid fa-brain me-2 text-primary"></i>Phân tích Dữ liệu AI (Python Engine)</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info border-0 shadow-sm" style="background-color: #f0f8ff;">
                    <i class="fa-solid fa-lightbulb me-2 text-warning"></i> <strong>Insight:</strong> {{ $analysis['insights'] ?? 'Đang thu thập thêm dữ liệu...' }}
                </div>

                <h6 class="fw-bold mt-4 mb-3">Phân loại & Gợi ý Khách hàng</h6>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nhóm Đối tượng</th>
                                <th>Sản phẩm ưa thích nhất</th>
                                <th>Chiến lược Popup Gợi ý</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="badge bg-primary">Nam (18-25)</span></td>
                                <td>{{ $analysis['demographics']['male_18_25']['top_category'] }}</td>
                                <td>{{ $analysis['demographics']['male_18_25']['suggestion'] }}</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-danger">Nữ (18-25)</span></td>
                                <td>{{ $analysis['demographics']['female_18_25']['top_category'] }}</td>
                                <td>{{ $analysis['demographics']['female_18_25']['suggestion'] }}</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-primary opacity-75">Nam (26-40)</span></td>
                                <td>{{ $analysis['demographics']['male_26_40']['top_category'] }}</td>
                                <td>{{ $analysis['demographics']['male_26_40']['suggestion'] }}</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-danger opacity-75">Nữ (26-40)</span></td>
                                <td>{{ $analysis['demographics']['female_26_40']['top_category'] }}</td>
                                <td>{{ $analysis['demographics']['female_26_40']['suggestion'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
