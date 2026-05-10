@extends('layouts.app')
@section('title', 'Danh mục - Pickleball Pro')

@section('content')
<div class="search-page">
    <div class="container">
        <h1 class="page-title" data-aos="fade-right"><i class="fas fa-th-large"></i> {{ isset($category) ? $category->name : 'Tất Cả Danh Mục' }}</h1>

        <div class="filter-bar" data-aos="fade-up">
            <div class="filter-group">
                <label>Danh mục:</label>
                <select class="filter-select" onchange="window.location.href=this.value">
                    <option value="{{ route('categories.index') }}" {{ !isset($category) ? 'selected' : '' }}>Tất cả</option>
                    @foreach($categories as $cat)
                    <option value="{{ route('categories.show', $cat->id) }}" {{ (isset($category) && $category->id == $cat->id) ? 'selected' : '' }}>{{ $cat->name }} ({{ $cat->products_count }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="products-grid">
            @forelse($products as $index => $product)
            <div class="product-card" data-aos="fade-up" data-aos-delay="{{ ($index % 4) * 80 }}">
                <div class="card-image">
                    <img src="{{ $product->image ?: 'https://placehold.co/400x400/ecf0dd/446900?text=Pickleball' }}" alt="{{ $product->name }}">
                    <div class="card-overlay">
                        <button onclick="addToCart({{ $product->id }})" class="btn btn-primary btn-sm"><i class="fas fa-cart-plus"></i></button>
                        <a href="{{ route('product.show', $product->id) }}" class="btn btn-dark btn-sm"><i class="fas fa-eye"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-category">{{ $product->category->name ?? '' }}</div>
                    <h3 class="card-title">{{ $product->name }}</h3>
                    <div class="card-price">{{ number_format($product->price, 0, ',', '.') }}đ</div>
                </div>
            </div>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:60px;">
                <i class="fas fa-box-open" style="font-size:3rem;color:var(--outline-variant);margin-bottom:16px;"></i>
                <h3>Chưa có sản phẩm</h3>
                <p style="color:var(--text-secondary);">Vui lòng quay lại sau!</p>
            </div>
            @endforelse
        </div>

        @if($products->hasPages())
        <div class="pagination-wrapper">
            <div class="pagination">
                {{ $products->links('pagination::simple-bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
