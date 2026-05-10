@extends('layouts.app')
@section('title', 'Chỉnh sửa tài khoản - Pickleball Pro')

@section('content')
<div class="checkout-page" style="padding-top: 40px; padding-bottom: 80px;">
    <div class="container">
        <div style="max-width: 600px; margin: 0 auto;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:32px;" data-aos="fade-down">
                <h1 class="page-title" style="margin-bottom:0;"><i class="fas fa-user-edit"></i> Tài khoản của tôi</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success" style="padding: 16px; background: rgba(34, 197, 94, 0.15); color: #16a34a; border-radius: var(--radius); margin-bottom: 24px;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="checkout-form-card" data-aos="fade-up">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-4">
                        <label>Họ tên *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', auth()->user()->name) }}" required>
                        @error('name')
                            <div style="color: var(--danger); font-size: 0.85rem; margin-top: 4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label>Email *</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email) }}" required>
                        @error('email')
                            <div style="color: var(--danger); font-size: 0.85rem; margin-top: 4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <h3 style="font-size: 1.1rem; margin-top: 32px; margin-bottom: 16px; border-bottom: 1px solid var(--outline-variant); padding-bottom: 8px;">Đổi mật khẩu (Tùy chọn)</h3>
                    
                    <div class="form-group mb-4">
                        <label>Mật khẩu mới</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Để trống nếu không muốn đổi">
                        @error('password')
                            <div style="color: var(--danger); font-size: 0.85rem; margin-top: 4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label>Xác nhận mật khẩu mới</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu mới">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg" style="margin-top: 16px;">
                        <i class="fas fa-save"></i> Cập nhật thông tin
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
