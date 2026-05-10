@extends('admin.layouts.app')

@section('title', 'Sản phẩm')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="m-0 fw-bold">Danh sách Sản phẩm</h4>
    <button class="btn btn-primary px-4 py-2 rounded-3" data-bs-toggle="modal" data-bs-target="#productModal">
        <i class="fa-solid fa-plus me-2"></i> Thêm Mới
    </button>
</div>

<div class="card border-0">
    <div class="table-responsive">
        <table class="table table-hover m-0">
            <thead>
                <tr>
                    <th>Mã SP</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá bán</th>
                    <th>Tồn kho</th>
                    <th>Trạng thái</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td class="text-secondary fw-medium">SP{{ str_pad($product->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td class="fw-semibold">
                        <img src="{{ $product->image }}" alt="" width="40" height="40" class="rounded me-2 object-fit-cover">
                        {{ $product->name }}
                    </td>
                    <td>{{ number_format($product->price, 0, ',', '.') }} ₫</td>
                    <td>{{ $product->quantity }}</td>
                    <td>
                        @if($product->quantity > 0)
                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                            Đang bán
                        </span>
                        @else
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                            Hết hàng
                        </span>
                        @endif
                    </td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-light text-primary me-1 btn-edit"
                            data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}"
                            data-price="{{ $product->price }}"
                            data-quantity="{{ $product->quantity }}"
                            data-category="{{ $product->category_id }}"
                            data-description="{{ $product->description }}"
                            data-image="{{ $product->image }}">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-light text-danger"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">Chưa có sản phẩm nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Thêm/Sửa Sản Phẩm -->
<div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 p-4 pb-0">
                <h5 class="modal-title fw-bold fs-4">Thêm Sản Phẩm Mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form id="productForm" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                        <!-- Cột Form Info -->
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label class="form-label fw-medium">Tên sản phẩm</label>
                                <input type="text" name="name" class="form-control form-control-lg fs-6" placeholder="Nhập tên sản phẩm...">
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-medium">Danh mục</label>
                                    <select name="category_id" class="form-select form-select-lg fs-6">
                                        <option value="">Chọn danh mục</option>
                                        @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-medium">Giá bán (VNĐ)</label>
                                    <input type="number" name="price" class="form-control form-control-lg fs-6" placeholder="0">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-medium">Số lượng</label>
                                    <input type="number" name="quantity" class="form-control form-control-lg fs-6" placeholder="0">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium">Mô tả chi tiết</label>
                                <textarea name="description" class="form-control" rows="5" placeholder="Nhập mô tả sản phẩm..."></textarea>
                            </div>
                        </div>
                        <!-- Cột Upload Ảnh -->
                        <div class="col-lg-4">
                            <label class="form-label fw-medium">Hình ảnh sản phẩm</label>
                            <div class="drop-zone" id="dropZone">
                                <div id="dropZoneText" class="text-center">
                                    <div class="bg-white rounded-circle d-inline-flex p-3 mb-3 shadow-sm">
                                        <i class="fa-solid fa-cloud-arrow-up fa-2x text-primary"></i>
                                    </div>
                                    <p class="text-secondary m-0 fw-medium">Kéo thả ảnh vào đây</p>
                                    <p class="text-secondary small mt-1">Hoặc click để chọn file (PNG, JPG, WEBP)</p>
                                </div>
                                <input type="file" id="fileInput" name="image" class="d-none" accept="image/*">
                                <img src="" alt="Preview" class="preview-img shadow-sm" id="imgPreview">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 p-4 pt-0">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" form="productForm" class="btn btn-primary px-4 shadow-sm">Lưu Sản Phẩm</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productModal = new bootstrap.Modal(document.getElementById('productModal'));
        const form = document.getElementById('productForm');
        const modalTitle = document.querySelector('.modal-title');
        
        @if($errors->any())
        productModal.show();
        @endif

        // Add New
        document.querySelector('[data-bs-target="#productModal"]').addEventListener('click', function() {
            form.reset();
            modalTitle.textContent = 'Thêm Sản Phẩm Mới';
            form.action = "{{ route('admin.products.store') }}";
            let methodInput = form.querySelector('input[name="_method"]');
            if(methodInput) { methodInput.remove(); }
            document.getElementById('imgPreview').src = '';
            document.getElementById('imgPreview').style.display = 'none';
            document.getElementById('dropZoneText').style.display = 'block';
        });

        // Edit
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                modalTitle.textContent = 'Cập Nhật Sản Phẩm';
                form.action = `/admin/products/${id}`;
                
                let methodInput = form.querySelector('input[name="_method"]');
                if(!methodInput) {
                    methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PUT';
                    form.appendChild(methodInput);
                }

                form.querySelector('[name="name"]').value = this.dataset.name;
                form.querySelector('[name="price"]').value = this.dataset.price;
                form.querySelector('[name="quantity"]').value = this.dataset.quantity;
                form.querySelector('[name="category_id"]').value = this.dataset.category;
                form.querySelector('[name="description"]').value = this.dataset.description;
                
                if(this.dataset.image) {
                    document.getElementById('imgPreview').src = this.dataset.image;
                    document.getElementById('imgPreview').style.display = 'block';
                    document.getElementById('dropZoneText').style.display = 'none';
                }

                productModal.show();
            });
        });
    });
</script>
@endsection
