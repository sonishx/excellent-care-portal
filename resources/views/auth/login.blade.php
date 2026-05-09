<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Excellent Care Services</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; min-height: 100vh; background: #f8fafc; }

        .login-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }

        /* ── Left: Brand Panel ── */
        .brand-panel {
            background: linear-gradient(160deg, #4a1a8a 0%, #6f2dbd 40%, #a663cc 80%, #f45d75 100%);
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }
        .brand-panel::before {
            content: '';
            position: absolute;
            top: -120px;
            right: -80px;
            width: 400px;
            height: 400px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }
        .brand-panel::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -40px;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.03);
            border-radius: 50%;
        }

        .brand-top { position: relative; z-index: 1; }
        .brand-logo {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 80px;
        }
        .brand-logo-box {
            width: 48px;
            height: 48px;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            font-weight: 800;
            line-height: 1.1;
            text-align: center;
        }
        .brand-logo-text {
            color: white;
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .brand-logo-text span { color: rgba(255,255,255,0.7); font-weight: 500; }

        .brand-headline {
            color: white;
            position: relative;
            z-index: 1;
        }
        .brand-headline h1 {
            font-size: 44px;
            font-weight: 900;
            line-height: 1.15;
            letter-spacing: -1.5px;
            margin-bottom: 20px;
        }
        .brand-headline p {
            font-size: 16px;
            color: rgba(255,255,255,0.75);
            line-height: 1.7;
            max-width: 380px;
        }

        .brand-features {
            display: flex;
            flex-direction: column;
            gap: 16px;
            position: relative;
            z-index: 1;
        }
        .brand-feature {
            display: flex;
            align-items: center;
            gap: 14px;
            color: rgba(255,255,255,0.85);
            font-size: 14px;
            font-weight: 500;
        }
        .brand-feature-dot {
            width: 8px;
            height: 8px;
            background: rgba(255,255,255,0.5);
            border-radius: 50%;
            flex-shrink: 0;
        }

        .brand-footer {
            position: relative;
            z-index: 1;
            color: rgba(255,255,255,0.4);
            font-size: 12px;
        }

        /* ── Right: Form Panel ── */
        .form-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px;
            background: white;
        }
        .form-container {
            width: 100%;
            max-width: 400px;
        }
        .form-header {
            margin-bottom: 40px;
        }
        .form-header h2 {
            font-size: 30px;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -1px;
            margin-bottom: 8px;
        }
        .form-header p {
            font-size: 15px;
            color: #64748b;
            line-height: 1.5;
        }

        /* Error */
        .login-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 13px;
            color: #dc2626;
            font-weight: 500;
            margin-bottom: 24px;
        }

        /* Form fields */
        .field-group {
            margin-bottom: 22px;
        }
        .field-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .field-input {
            width: 100%;
            height: 52px;
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            padding: 0 18px;
            font-size: 15px;
            font-family: inherit;
            font-weight: 500;
            color: #0f172a;
            background: #fafbfc;
            outline: none;
            transition: all 0.25s cubic-bezier(.4,0,.2,1);
        }
        .field-input:focus {
            border-color: #6f2dbd;
            background: white;
            box-shadow: 0 0 0 4px rgba(111,45,189,0.08);
        }
        .field-input::placeholder { color: #94a3b8; font-weight: 400; }

        /* Options row */
        .options-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }
        .remember-check {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        .remember-check input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #6f2dbd;
            border-radius: 4px;
            cursor: pointer;
        }
        .remember-check label {
            font-size: 13px;
            font-weight: 500;
            color: #475569;
            cursor: pointer;
        }
        .forgot-link {
            font-size: 13px;
            font-weight: 600;
            color: #6f2dbd;
            text-decoration: none;
            transition: color 0.2s;
        }
        .forgot-link:hover { color: #4a1a8a; }

        /* Submit */
        .login-btn {
            width: 100%;
            height: 54px;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, #6f2dbd 0%, #a663cc 100%);
            color: white;
            font-size: 16px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(.4,0,.2,1);
            letter-spacing: 0.3px;
        }
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(111,45,189,0.35);
        }
        .login-btn:active {
            transform: translateY(0);
        }

        /* Divider */
        .form-divider {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 28px 0;
            color: #cbd5e1;
            font-size: 12px;
            font-weight: 500;
        }
        .form-divider::before,
        .form-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        .register-link {
            text-align: center;
            font-size: 14px;
            color: #64748b;
        }
        .register-link a {
            color: #6f2dbd;
            font-weight: 700;
            text-decoration: none;
        }
        .register-link a:hover { text-decoration: underline; }

        /* Responsive */
        @media (max-width: 1024px) {
            .login-wrapper { grid-template-columns: 1fr; }
            .brand-panel { display: none; }
            .form-panel { min-height: 100vh; }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Left: Brand -->
        <div class="brand-panel">
            <div class="brand-top">
                <div class="brand-logo">
                    <div class="brand-logo-box">We<br>ndis</div>
                    <div class="brand-logo-text">excellentCare <span>Services</span></div>
                </div>
                <div class="brand-headline">
                    <h1>Quality care,<br>delivered with<br>excellence.</h1>
                    <p>A secure, modern portal for managing NDIS & aged care services. Trusted by clinicians and caregivers across Australia.</p>
                </div>
            </div>

            <div class="brand-features">
                <div class="brand-feature">
                    <div class="brand-feature-dot"></div>
                    Secure role-based access for all stakeholders
                </div>
                <div class="brand-feature">
                    <div class="brand-feature-dot"></div>
                    Real-time care plan tracking and updates
                </div>
                <div class="brand-feature">
                    <div class="brand-feature-dot"></div>
                    Encrypted messaging between care teams
                </div>
            </div>

            <div class="brand-footer">
                &copy; {{ date('Y') }} Excellent Care Services. Registered NDIS Provider.
            </div>
        </div>

        <!-- Right: Form -->
        <div class="form-panel">
            <div class="form-container">
                <div class="form-header">
                    <h2>Welcome back</h2>
                    <p>Sign in to your care management portal.</p>
                </div>

                @if($errors->any())
                    <div class="login-error">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <div class="field-group">
                        <label class="field-label">Email</label>
                        <input type="email" name="email" class="field-input" placeholder="you@example.com" value="{{ old('email') }}" required>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Password</label>
                        <input type="password" name="password" class="field-input" placeholder="Enter your password" required>
                    </div>

                    <div class="options-row">
                        <div class="remember-check">
                            <input type="checkbox" name="remember" id="rememberMe">
                            <label for="rememberMe">Remember me</label>
                        </div>
                        <a href="#" class="forgot-link">Forgot password?</a>
                    </div>

                    <button type="submit" class="login-btn">Sign In</button>
                </form>

                <div class="form-divider">or</div>

                <div class="register-link">
                    Access is by invitation only. <a href="#">Contact your administrator</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Chatbot Component -->
    <x-chatbot />
</body>
</html>