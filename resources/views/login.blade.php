@extends('layouts.app')
@section('title', 'Đăng nhập - Pickleball Pro')

@section('content')
<div class="auth-page">
    <div class="auth-card" data-aos="zoom-in">
        <div style="text-align:center;margin-bottom:24px;">
            <i class="fas fa-table-tennis-paddle-ball" style="font-size:2.5rem;color:var(--primary);"></i>
        </div>
        <h1>Đăng Nhập</h1>
        <p class="auth-subtitle">Chào mừng quay trở lại!</p>

        <form id="loginForm">
            <div class="form-group">
                <label><i class="fas fa-envelope"></i> Email</label>
                <input type="email" name="email" class="form-control" required placeholder="email@example.com">
                <div class="form-error" id="loginEmailError"></div>
            </div>
            <div class="form-group">
                <label><i class="fas fa-lock"></i> Mật khẩu</label>
                <input type="password" name="password" class="form-control" required placeholder="Nhập mật khẩu">
                <div class="form-error" id="loginPasswordError"></div>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-lg" id="loginBtn">
                <i class="fas fa-sign-in-alt"></i> Đăng nhập
            </button>
        </form>

        <div class="auth-divider"><span>hoặc</span></div>
        <div class="auth-footer">Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('loginBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
    document.querySelectorAll('.form-error').forEach(el => el.textContent = '');

    $.ajax({
        url: '{{ route("login.submit") }}',
        method: 'POST',
        data: $(this).serialize(),
        success: function(data) {
            if (data.success) {
                toastr.success(data.message);
                setTimeout(() => window.location.href = data.redirect, 1000);
            }
        },
        error: function(xhr) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Đăng nhập';
            if (xhr.responseJSON) {
                if (xhr.responseJSON.errors && xhr.responseJSON.errors.email) {
                    document.getElementById('loginEmailError').textContent = xhr.responseJSON.errors.email[0];
                } else if (xhr.responseJSON.message) {
                    toastr.error(xhr.responseJSON.message);
                }
            } else {
                toastr.error('Email hoặc mật khẩu không đúng!');
            }
        }
    });
});
</script>
@endsection
