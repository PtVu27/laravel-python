@extends('layouts.app')
@section('title', 'Đăng ký - Pickleball Pro')

@section('styles')
<style>
/* ===== REGISTER PAGE - SPLIT SCREEN LAYOUT ===== */
.register-page {
    min-height: calc(100vh - 72px);
    display: grid;
    grid-template-columns: 1fr 1fr;
}

/* --- Left Panel: Visual / Branding --- */
.register-visual {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a2f 50%, #1a3a1a 100%);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 60px 48px;
    position: relative;
    overflow: hidden;
}

.register-visual::before {
    content: '';
    position: absolute;
    width: 500px;
    height: 500px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(163,230,53,0.12) 0%, transparent 70%);
    top: -100px;
    right: -100px;
    pointer-events: none;
}

.register-visual::after {
    content: '';
    position: absolute;
    width: 400px;
    height: 400px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(68,105,0,0.15) 0%, transparent 70%);
    bottom: -80px;
    left: -80px;
    pointer-events: none;
}

.visual-content {
    position: relative;
    z-index: 2;
    text-align: center;
    max-width: 420px;
}

.visual-icon {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(163,230,53,0.2) 0%, rgba(163,230,53,0.05) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 32px;
    border: 2px solid rgba(163,230,53,0.2);
    animation: floatIcon 4s ease-in-out infinite;
}

.visual-icon i {
    font-size: 2.8rem;
    color: var(--primary-container);
}

@keyframes floatIcon {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-12px); }
}

.visual-content h2 {
    font-family: 'Montserrat', sans-serif;
    font-size: 2rem;
    font-weight: 800;
    color: #fff;
    margin-bottom: 16px;
    line-height: 1.2;
}

.visual-content h2 span {
    color: var(--primary-container);
}

.visual-content p {
    color: rgba(255,255,255,0.6);
    font-size: 1rem;
    line-height: 1.7;
    margin-bottom: 40px;
}

/* Feature list */
.register-features {
    list-style: none;
    padding: 0;
    margin: 0;
    text-align: left;
    width: 100%;
}

.register-features li {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 0;
    border-bottom: 1px solid rgba(255,255,255,0.06);
    color: rgba(255,255,255,0.75);
    font-size: 0.95rem;
}

.register-features li:last-child {
    border-bottom: none;
}

.register-features li .feature-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: rgba(163,230,53,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.register-features li .feature-icon i {
    color: var(--primary-container);
    font-size: 1rem;
}

/* Floating decorative elements */
.floating-shape {
    position: absolute;
    border-radius: 50%;
    opacity: 0.06;
    background: var(--primary-container);
    z-index: 1;
}

.floating-shape:nth-child(1) {
    width: 120px;
    height: 120px;
    top: 15%;
    left: 10%;
    animation: float1 8s ease-in-out infinite;
}

.floating-shape:nth-child(2) {
    width: 80px;
    height: 80px;
    bottom: 20%;
    right: 15%;
    animation: float2 6s ease-in-out infinite;
}

.floating-shape:nth-child(3) {
    width: 60px;
    height: 60px;
    top: 60%;
    left: 5%;
    animation: float3 7s ease-in-out infinite;
}

@keyframes float1 {
    0%, 100% { transform: translate(0, 0); }
    50% { transform: translate(20px, -20px); }
}

@keyframes float2 {
    0%, 100% { transform: translate(0, 0); }
    50% { transform: translate(-15px, 15px); }
}

@keyframes float3 {
    0%, 100% { transform: translate(0, 0); }
    50% { transform: translate(10px, -10px); }
}

/* --- Right Panel: Register Form --- */
.register-form-panel {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 48px;
    background: #fff;
    overflow-y: auto;
}

.register-form-wrapper {
    width: 100%;
    max-width: 460px;
}

.register-form-header {
    margin-bottom: 36px;
}

.register-form-header .form-logo {
    display: flex;
    align-items: center;
    gap: 8px;
    font-family: 'Montserrat', sans-serif;
    font-size: 1.25rem;
    font-weight: 800;
    color: var(--secondary);
    margin-bottom: 28px;
}

.register-form-header .form-logo i {
    color: var(--primary);
    font-size: 1.5rem;
}

.register-form-header h1 {
    font-family: 'Montserrat', sans-serif;
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--secondary);
    margin-bottom: 8px;
    text-align: left;
}

.register-form-header p {
    color: var(--text-secondary);
    font-size: 0.95rem;
    text-align: left;
}

/* Form groups enhanced */
.reg-form .form-group {
    margin-bottom: 20px;
    position: relative;
}

.reg-form .form-group label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-weight: 600;
    font-size: 0.85rem;
    margin-bottom: 8px;
    color: var(--text);
    letter-spacing: 0.01em;
}

.reg-form .form-group label i {
    font-size: 0.8rem;
    color: var(--primary);
    opacity: 0.8;
}

.reg-form .form-control {
    width: 100%;
    padding: 13px 16px;
    border: 2px solid #e8ecf0;
    border-radius: 12px;
    font-size: 0.95rem;
    font-family: 'Inter', sans-serif;
    transition: all 0.3s ease;
    background: #f8fafc;
    color: var(--text);
}

.reg-form .form-control:focus {
    outline: none;
    border-color: var(--primary);
    background: #fff;
    box-shadow: 0 0 0 4px rgba(68,105,0,0.08);
}

.reg-form .form-control::placeholder {
    color: #94a3b8;
}

/* Row layout for gender and birth */
.form-row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

/* Password strength indicator */
.password-strength {
    display: flex;
    gap: 4px;
    margin-top: 8px;
}

.strength-bar {
    flex: 1;
    height: 3px;
    border-radius: 2px;
    background: #e8ecf0;
    transition: all 0.3s ease;
}

.strength-bar.active { background: var(--error); }
.strength-bar.medium { background: #f59e0b; }
.strength-bar.strong { background: var(--primary); }

.strength-text {
    font-size: 0.75rem;
    margin-top: 4px;
    color: var(--text-secondary);
}

/* Submit button */
.register-submit-btn {
    width: 100%;
    padding: 15px 28px;
    background: linear-gradient(135deg, var(--primary) 0%, #365200 100%);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-family: 'Inter', sans-serif;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-top: 8px;
    position: relative;
    overflow: hidden;
}

.register-submit-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
    transition: left 0.5s ease;
}

.register-submit-btn:hover::before {
    left: 100%;
}

.register-submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(68,105,0,0.3);
}

.register-submit-btn:active {
    transform: translateY(0);
}

.register-submit-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

/* Divider */
.register-divider {
    display: flex;
    align-items: center;
    gap: 16px;
    margin: 28px 0;
}

.register-divider::before,
.register-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #e8ecf0;
}

.register-divider span {
    color: var(--text-secondary);
    font-size: 0.85rem;
    font-weight: 500;
}

/* Social buttons */
.social-register-btns {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-bottom: 24px;
}

.social-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 12px 16px;
    border: 2px solid #e8ecf0;
    border-radius: 12px;
    background: #fff;
    font-family: 'Inter', sans-serif;
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--text);
    cursor: pointer;
    transition: all 0.3s ease;
}

.social-btn:hover {
    border-color: var(--primary);
    background: rgba(68,105,0,0.03);
    transform: translateY(-1px);
}

.social-btn i {
    font-size: 1.15rem;
}

.social-btn.google i { color: #ea4335; }
.social-btn.facebook i { color: #1877f2; }

/* Footer link */
.register-footer {
    text-align: center;
    font-size: 0.9rem;
    color: var(--text-secondary);
    margin-top: 4px;
}

.register-footer a {
    color: var(--primary);
    font-weight: 600;
    transition: color 0.3s ease;
}

.register-footer a:hover {
    color: var(--secondary);
    text-decoration: underline;
}

/* Error messages */
.reg-form .form-error {
    color: var(--error);
    font-size: 0.78rem;
    margin-top: 5px;
    display: flex;
    align-items: center;
    gap: 4px;
}

/* Terms checkbox */
.terms-check {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin: 16px 0 4px;
}

.terms-check input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: var(--primary);
    margin-top: 2px;
    flex-shrink: 0;
    cursor: pointer;
}

.terms-check label {
    font-size: 0.85rem;
    color: var(--text-secondary);
    line-height: 1.5;
    cursor: pointer;
}

.terms-check label a {
    color: var(--primary);
    font-weight: 600;
}

/* Stagger animation */
.stagger-item {
    opacity: 0;
    transform: translateY(15px);
    animation: staggerIn 0.5s ease forwards;
}

@keyframes staggerIn {
    to { opacity: 1; transform: translateY(0); }
}

.stagger-item:nth-child(1) { animation-delay: 0.05s; }
.stagger-item:nth-child(2) { animation-delay: 0.1s; }
.stagger-item:nth-child(3) { animation-delay: 0.15s; }
.stagger-item:nth-child(4) { animation-delay: 0.2s; }
.stagger-item:nth-child(5) { animation-delay: 0.25s; }
.stagger-item:nth-child(6) { animation-delay: 0.3s; }
.stagger-item:nth-child(7) { animation-delay: 0.35s; }
.stagger-item:nth-child(8) { animation-delay: 0.4s; }
.stagger-item:nth-child(9) { animation-delay: 0.45s; }
.stagger-item:nth-child(10) { animation-delay: 0.5s; }

/* Toggle password visibility */
.password-wrapper {
    position: relative;
}

.password-wrapper .form-control {
    padding-right: 44px;
}

.toggle-password {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: #94a3b8;
    font-size: 0.95rem;
    padding: 4px;
    transition: color 0.3s ease;
}

.toggle-password:hover {
    color: var(--primary);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 1024px) {
    .register-page {
        grid-template-columns: 1fr;
    }
    .register-visual {
        display: none;
    }
    .register-form-panel {
        min-height: calc(100vh - 72px);
        padding: 40px 24px;
    }
}

@media (max-width: 480px) {
    .form-row-2 {
        grid-template-columns: 1fr;
    }
    .social-register-btns {
        grid-template-columns: 1fr;
    }
    .register-form-panel {
        padding: 32px 16px;
    }
    .register-form-header h1 {
        font-size: 1.5rem;
    }
}
</style>
@endsection

@section('content')
<div class="register-page">
    {{-- Left Panel: Visual --}}
    <div class="register-visual">
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>

        <div class="visual-content" data-aos="fade-right" data-aos-duration="800">
            <div class="visual-icon">
                <i class="fas fa-table-tennis-paddle-ball"></i>
            </div>
            <h2>Chào mừng đến với <span>Pickleball Pro</span></h2>
            <p>Tạo tài khoản để trải nghiệm mua sắm dụng cụ Pickleball chuyên nghiệp với hàng ngàn ưu đãi hấp dẫn.</p>

            <ul class="register-features">
                <li>
                    <div class="feature-icon"><i class="fas fa-bolt"></i></div>
                    <span>Mua sắm nhanh chóng, thanh toán tiện lợi</span>
                </li>
                <li>
                    <div class="feature-icon"><i class="fas fa-tags"></i></div>
                    <span>Ưu đãi độc quyền cho thành viên mới</span>
                </li>
                <li>
                    <div class="feature-icon"><i class="fas fa-truck-fast"></i></div>
                    <span>Miễn phí vận chuyển đơn hàng đầu tiên</span>
                </li>
                <li>
                    <div class="feature-icon"><i class="fas fa-shield-halved"></i></div>
                    <span>Bảo hành chính hãng, đổi trả dễ dàng</span>
                </li>
            </ul>
        </div>
    </div>

    {{-- Right Panel: Form --}}
    <div class="register-form-panel">
        <div class="register-form-wrapper">
            <div class="register-form-header stagger-item">
                <div class="form-logo">
                    <i class="fas fa-table-tennis-paddle-ball"></i>
                    Pickleball<span style="color:var(--primary)">Pro</span>
                </div>
                <h1>Tạo tài khoản mới</h1>
                <p>Điền thông tin bên dưới để bắt đầu hành trình cùng chúng tôi</p>
            </div>

            <form id="registerForm" class="reg-form" autocomplete="off">
                <div class="form-group stagger-item">
                    <label><i class="fas fa-user"></i> Họ và tên</label>
                    <input type="text" name="name" class="form-control" required placeholder="Nhập họ và tên đầy đủ" id="regName">
                    <div class="form-error" id="nameError"></div>
                </div>

                <div class="form-row-2 stagger-item">
                    <div class="form-group">
                        <label><i class="fas fa-venus-mars"></i> Giới tính</label>
                        <select name="gender" class="form-control" required id="regGender">
                            <option value="">Chọn giới tính</option>
                            <option value="male">Nam</option>
                            <option value="female">Nữ</option>
                            <option value="other">Khác</option>
                        </select>
                        <div class="form-error" id="genderError"></div>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-calendar-alt"></i> Ngày sinh</label>
                        <input type="date" name="birth_date" class="form-control" required id="regBirthDate">
                        <div class="form-error" id="birthDateError"></div>
                    </div>
                </div>

                <div class="form-group stagger-item">
                    <label><i class="fas fa-envelope"></i> Địa chỉ email</label>
                    <input type="email" name="email" class="form-control" required placeholder="yourname@email.com" id="regEmail">
                    <div class="form-error" id="emailError"></div>
                </div>

                <div class="form-group stagger-item">
                    <label><i class="fas fa-lock"></i> Mật khẩu</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" class="form-control" required placeholder="Tối thiểu 3 ký tự" id="regPassword">
                        <button type="button" class="toggle-password" data-target="regPassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="password-strength" id="passwordStrength">
                        <div class="strength-bar" id="str1"></div>
                        <div class="strength-bar" id="str2"></div>
                        <div class="strength-bar" id="str3"></div>
                        <div class="strength-bar" id="str4"></div>
                    </div>
                    <div class="strength-text" id="strengthText"></div>
                    <div class="form-error" id="passwordError"></div>
                </div>

                <div class="form-group stagger-item">
                    <label><i class="fas fa-lock"></i> Xác nhận mật khẩu</label>
                    <div class="password-wrapper">
                        <input type="password" name="password_confirmation" class="form-control" required placeholder="Nhập lại mật khẩu" id="regPasswordConfirm">
                        <button type="button" class="toggle-password" data-target="regPasswordConfirm">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="terms-check stagger-item">
                    <input type="checkbox" id="termsCheck" required>
                    <label for="termsCheck">Tôi đồng ý với <a href="#">Điều khoản sử dụng</a> và <a href="#">Chính sách bảo mật</a> của Pickleball Pro</label>
                </div>

                <button type="submit" class="register-submit-btn stagger-item" id="registerBtn">
                    <i class="fas fa-user-plus"></i> Tạo tài khoản
                </button>
            </form>

            <div class="register-divider stagger-item"><span>hoặc đăng ký bằng</span></div>

            <div class="social-register-btns stagger-item">
                <button type="button" class="social-btn google">
                    <i class="fab fa-google"></i> Google
                </button>
                <button type="button" class="social-btn facebook">
                    <i class="fab fa-facebook-f"></i> Facebook
                </button>
            </div>

            <div class="register-footer stagger-item">
                Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Toggle password visibility
document.querySelectorAll('.toggle-password').forEach(function(btn) {
    btn.addEventListener('click', function() {
        const target = document.getElementById(this.dataset.target);
        const icon = this.querySelector('i');
        if (target.type === 'password') {
            target.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            target.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
});

// Password strength indicator
document.getElementById('regPassword').addEventListener('input', function() {
    const val = this.value;
    const bars = [
        document.getElementById('str1'),
        document.getElementById('str2'),
        document.getElementById('str3'),
        document.getElementById('str4')
    ];
    const strengthText = document.getElementById('strengthText');
    let score = 0;

    // Reset
    bars.forEach(b => { b.className = 'strength-bar'; });
    strengthText.textContent = '';

    if (val.length === 0) return;
    if (val.length >= 3) score++;
    if (val.length >= 6) score++;
    if (/[A-Z]/.test(val) && /[a-z]/.test(val)) score++;
    if (/[0-9]/.test(val) && /[^A-Za-z0-9]/.test(val)) score++;

    const labels = ['', 'Yếu', 'Trung bình', 'Mạnh', 'Rất mạnh'];
    const classes = ['', 'active', 'medium', 'strong', 'strong'];

    for (let i = 0; i < score; i++) {
        bars[i].classList.add(classes[score]);
    }
    strengthText.textContent = labels[score] || '';
    strengthText.style.color = score <= 1 ? 'var(--error)' : score === 2 ? '#f59e0b' : 'var(--primary)';
});

// Form submission
document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('registerBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang tạo tài khoản...';
    document.querySelectorAll('.form-error').forEach(el => el.textContent = '');

    $.ajax({
        url: '{{ route("register.submit") }}',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(data) {
            if (data.success) {
                // Success animation
                btn.innerHTML = '<i class="fas fa-check"></i> Thành công!';
                btn.style.background = 'linear-gradient(135deg, #16a34a, #15803d)';
                toastr.success(data.message);
                setTimeout(() => window.location.href = data.redirect, 1200);
            }
        },
        error: function(xhr) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-user-plus"></i> Tạo tài khoản';
            btn.style.background = '';
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                const errors = xhr.responseJSON.errors;
                if (errors.name) document.getElementById('nameError').textContent = errors.name[0];
                if (errors.gender) document.getElementById('genderError').textContent = errors.gender[0];
                if (errors.birth_date) document.getElementById('birthDateError').textContent = errors.birth_date[0];
                if (errors.email) document.getElementById('emailError').textContent = errors.email[0];
                if (errors.password) document.getElementById('passwordError').textContent = errors.password[0];

                // Shake animation on error fields
                document.querySelectorAll('.form-error').forEach(el => {
                    if (el.textContent) {
                        const ctrl = el.closest('.form-group') ? el.closest('.form-group').querySelector('.form-control') : null;
                        if (ctrl) {
                            ctrl.style.borderColor = 'var(--error)';
                            ctrl.style.animation = 'shake 0.4s ease';
                            setTimeout(() => { ctrl.style.animation = ''; }, 400);
                        }
                    }
                });
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                toastr.error(xhr.responseJSON.message);
            } else {
                toastr.error('Có lỗi xảy ra! Vui lòng thử lại.');
            }
        }
    });
});

// Shake animation
if (!document.getElementById('shakeKeyframe')) {
    const style = document.createElement('style');
    style.id = 'shakeKeyframe';
    style.textContent = '@keyframes shake{0%,100%{transform:translateX(0)}25%{transform:translateX(-6px)}50%{transform:translateX(6px)}75%{transform:translateX(-6px)}}';
    document.head.appendChild(style);
}

// Reset border color on focus
document.querySelectorAll('.reg-form .form-control').forEach(function(input) {
    input.addEventListener('focus', function() {
        this.style.borderColor = '';
    });
});
</script>
@endsection
