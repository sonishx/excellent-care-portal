<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Excellent Care Services')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f7fb;
        }

        .top-header {
            height: 70px;
            background: #ffffff;
            border-bottom: 1px solid #edf1f5;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            flex-wrap: wrap;
        }

        .brand-area {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .brand-logo-circle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #6f2dbd;
            color: white;
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            line-height: 1.1;
        }

        .brand-provider {
            font-size: 10px;
            color: #6b7280;
            line-height: 1.2;
        }

        .brand-main {
            font-size: 18px;
            font-weight: 700;
            color: #f45d75;
        }

        .brand-main span {
            font-size: 12px;
            color: #f28c52;
            font-weight: 600;
            margin-left: 2px;
        }

        .nav-links {
            display: flex;
            gap: 20px;
            margin-left: 25px;
            flex-wrap: wrap;
        }

        .nav-links a {
            text-decoration: none;
            color: #4b5563;
            font-size: 13px;
        }

        .nav-links a.active {
            font-weight: 700;
            color: #111827;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .search-box {
            height: 36px;
            border-radius: 8px;
            border: 1px solid #dbe2ea;
            padding: 0 12px;
            font-size: 13px;
        }

        .icon-circle {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .user-name-header {
            font-size: 13px;
            font-weight: 600;
            color: #111827;
        }

        .logout-btn {
            background: none;
            border: none;
            color: #ef4444;
            font-size: 12px;
            padding: 0;
            cursor: pointer;
        }

        .main-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        @media (max-width: 768px) {
            .top-header {
                flex-direction: column;
                align-items: flex-start;
                padding: 15px 18px;
                height: auto;
                gap: 10px;
            }

            .nav-links {
                margin-left: 0;
            }

            .header-right {
                justify-content: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="top-header">
        <!-- Brand Logo -->
        <div class="brand-area">
            <div class="brand-logo-circle">We<br>ndis</div>
            <div class="brand-provider">Registered<br>NDIS Provider</div>
            <div class="brand-main">excellent<span>Care Services</span></div>
        </div>

        <!-- Navigation -->
        <div class="nav-links">
            <a href="{{ route('dashboard') }}" class="@if(request()->routeIs('dashboard')) active @endif">Dashboard</a>
            <a href="{{ route('patients') }}" class="@if(request()->routeIs('patients*')) active @endif">Patients</a>
            <a href="{{ route('careplans.select') }}" class="@if(request()->routeIs('careplans.select')) active @endif">Care Plans</a>
            <a href="{{ route('documents') }}" class="@if(request()->routeIs('documents*')) active @endif">Documents</a>
            <a href="{{ route('chatsupport') }}" class="@if(request()->routeIs('chatsupport')) active @endif">Chat Support</a>
            <a href="{{ route('settings') }}" class="@if(request()->routeIs('settings*')) active @endif">Settings</a>
        </div>

        <!-- Header Right -->
        <div class="header-right">
            <input type="text" class="search-box" placeholder="Search...">
            <div class="icon-circle">🔔</div>
            <div class="user-name-header">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</div>
            <div class="icon-circle">👩</div>

            @auth
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Log out</button>
                </form>
            @endauth
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-container">
        @yield('content')
    </div>
</body>
</html>