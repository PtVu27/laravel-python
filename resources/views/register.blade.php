@extends('layouts.app')
@section('title', 'Đăng ký - Pickleball Pro')

@section('content')
<div class="auth-page">
    <div class="auth-card" data-aos="zoom-in">
        <div style="text-align:center;margin-bottom:24px;">
            <i class="fas fa-table-tennis-paddle-ball" style="font-size:2.5rem;color:var(--primary);"></i>
        </div>
        <h1>Tạo tài khoản</h1>
        <p class="auth-subtitle">Tham gia cộng đồng Pickleball Pro</p>

        <form id="registerForm">
            <div class="form-group">
                <label><i class="fas fa-user"></i> Họ Tên</label>
                <input type="text" name="name" class="form-control" required placeholder="Nguyễn Văn A">
                <div class="form-error" id="nameError"></div>
            </div>
            <div class="form-group">
                <label><i class="fas fa-venus-mars"></i> Giới tính</label>
                <select name="gender" class="form-control" required>
                    <option value="">Chọn giới tính</option>
                    <option value="male">Nam</option>
                    <option value="female">Nữ</option>
                    <option value="other">Khác</option>
                </select>
                <div class="form-error" id="genderError"></div>
            </div>
            <div class="form-group">
                <label><i class="fas fa-calendar-alt"></i> Ngày sinh</label>
                <input type="date" name="birth_date" class="form-control" required>
                <div class="form-error" id="birthDateError"></div>
            </div>
            <div class="form-group">
                <label><i class="fas fa-envelope"></i> Email</label>
                <input type="email" name="email" class="form-control" required placeholder="email@example.com">
                <div class="form-error" id="emailError"></div>
            </div>
            <div class="form-group">
                <label><i class="fas fa-lock"></i> Mật khẩu</label>
                <input type="password" name="password" class="form-control" required placeholder="Tối thiểu 3 ký tự">
                <div class="form-error" id="passwordError"></div>
            </div>
            <div class="form-group">
                <label><i class="fas fa-lock"></i> Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation" class="form-control" required placeholder="Nhập lại mật khẩu">
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-lg" id="registerBtn">
                <i class="fas fa-user-plus"></i> Đăng ký
            </button>
        </form>

        <div class="auth-divider"><span>hoặc</span></div>
        <div class="auth-footer">Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('registerBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
    document.querySelectorAll('.form-error').forEach(el => el.textContent = '');

    $.ajax({
        url: '{{ route("register.submit") }}',
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
            btn.innerHTML = '<i class="fas fa-user-plus"></i> Đăng ký';
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                const errors = xhr.responseJSON.errors;
                if (errors.name) document.getElementById('nameError').textContent = errors.name[0];
                if (errors.gender) document.getElementById('genderError').textContent = errors.gender[0];
                if (errors.birth_date) document.getElementById('birthDateError').textContent = errors.birth_date[0];
                if (errors.email) document.getElementById('emailError').textContent = errors.email[0];
                if (errors.password) document.getElementById('passwordError').textContent = errors.password[0];
            } else {
                toastr.error('Có lỗi xảy ra!');
            }
        }
    });
});
</script>
@endsection
