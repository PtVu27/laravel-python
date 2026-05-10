@extends('layouts.app')
@section('title', 'Tìm kiếm: ' . $query . ' - Pickleball Pro')

@section('content')
<div class="search-page">
    <div class="container">
        <h1 class="page-title" data-aos="fade-right"><i class="fas fa-search"></i> Kết quả tìm kiếm</h1>

        <div class="filter-bar" data-aos="fade-up">
            <form action="{{ route('search') }}" method="GET" style="display:flex;gap:16px;flex-wrap:wrap;align-items:center;width:100%;">
                <div class="filter-group" style="flex:1;min-width:200px;">
                    <input type="text" name="q" value="{{ $query }}" class="form-control" placeholder="Tìm kiếm...">
                </div>
                <div class="filter-group">
                    <label>Danh mục:</label>
                    <select name="category" class="filter-select">
                        <option value="">Tất cả</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label>Giá từ:</label>
                    <input type="number" name="min_price" value="{{ $minPrice }}" class="filter-input" placeholder="0">
                </div>
                <div class="filter-group">
                    <label>đến:</label>
                    <input type="number" name="max_price" value="{{ $maxPrice }}" class="filter-input" placeholder="Max">
                </div>
                <div class="filter-group">
                    <label>Sắp xếp:</label>
                    <select name="sort" class="filter-select">
                        <option value="relevance" {{ $sort=='relevance'?'selected':'' }}>Phù hợp nhất</option>
                        <option value="price_asc" {{ $sort=='price_asc'?'selected':'' }}>Giá tăng dần</option>
                        <option value="price_desc" {{ $sort=='price_desc'?'selected':'' }}>Giá giảm dần</option>
                        <option value="newest" {{ $sort=='newest'?'selected':'' }}>Mới nhất</option>
                        <option value="popular" {{ $sort=='popular'?'selected':'' }}>Phổ biến</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-filter"></i> Lọc</button>
            </form>
        </div>

        <p class="results-info" data-aos="fade-up">Tìm thấy <strong>{{ $products->total() }}</strong> sản phẩm {{ $query ? 'cho "' . $query . '"' : '' }}</p>

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
                <i class="fas fa-search" style="font-size:3rem;color:var(--outline-variant);margin-bottom:16px;"></i>
                <h3>Không tìm thấy sản phẩm</h3>
                <p style="color:var(--text-secondary);">Thử tìm kiếm với từ khóa khác</p>
            </div>
            @endforelse
        </div>

        @if($products->hasPages())
        <div class="pagination-wrapper">{{ $products->links() }}</div>
        @endif
    </div>
</div>
@endsection
