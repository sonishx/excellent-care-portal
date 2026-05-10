<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Excellent Care Services')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        :root {
            --primary: #6f2dbd;
            --primary-light: #a29bfe;
            --primary-gradient: linear-gradient(135deg, #6f2dbd 0%, #a29bfe 100%);
            --secondary: #f45d75;
            --accent: #f28c52;
            --bg: #f8fafc;
            --text: #0f172a;
            --text-light: #475569;
            --white: #ffffff;
            --border: #e2e8f0;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.5;
        }

        .top-header {
            height: 80px;
            background: var(--white);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .brand-area {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .brand-logo-circle {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--primary);
            color: white;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            line-height: 1.1;
        }

        .brand-provider {
            font-size: 11px;
            color: var(--text-light);
            line-height: 1.2;
            font-weight: 500;
        }

        .brand-main {
            font-size: 20px;
            font-weight: 800;
            color: var(--secondary);
            letter-spacing: -0.5px;
        }

        .brand-main span {
            font-size: 14px;
            color: var(--accent);
            font-weight: 600;
            margin-left: 3px;
        }

        .nav-links {
            display: flex;
            gap: 25px;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-light);
            font-size: 14px;
            font-weight: 500;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .nav-links a:hover {
            background: rgba(111, 45, 189, 0.05);
            color: var(--primary);
        }

        .nav-links a.active {
            font-weight: 600;
            color: var(--primary);
            background: rgba(111, 45, 189, 0.1);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .search-box {
            height: 40px;
            border-radius: 10px;
            border: 1.5px solid #cbd5e1;
            padding: 0 15px;
            font-size: 14px;
            background: #fff;
            width: 220px;
            transition: all 0.2s;
            color: var(--text);
        }

        .search-box::placeholder {
            color: #94a3b8;
        }

        .search-box:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(111, 45, 189, 0.1);
        }

        .icon-circle {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .icon-circle:hover {
            background: #e5e7eb;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-name-header {
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
        }

        .logout-btn {
            background: #fee2e2;
            border: none;
            color: #ef4444;
            font-size: 12px;
            font-weight: 600;
            padding: 8px 14px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .logout-btn:hover {
            background: #fecaca;
        }

        /* Global Utilities */
        .btn-primary {
            background: linear-gradient(135deg, #6f2dbd 0%, #a29bfe 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(111, 45, 189, 0.3);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
            padding: 8px 18px;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        .primary-gradient {
            background: linear-gradient(135deg, #6f2dbd 0%, #a29bfe 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .main-container {
            max-width: 1280px;
            margin: 40px auto;
            padding: 0 30px;
        }

        /* Standard Card Style */
        .card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow);
            padding: 24px;
            border: 1px solid var(--border);
        }

        @media (max-width: 1024px) {
            .search-box { display: none; }
        }

        @media (max-width: 768px) {
            .top-header {
                flex-direction: column;
                height: auto;
                padding: 20px;
                gap: 20px;
            }
            .nav-links {
                overflow-x: auto;
                width: 100%;
                padding-bottom: 5px;
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
            
            @auth
                {{-- Caregiver and Admin --}}
                @if(in_array(strtolower(auth()->user()->role), ['caregiver', 'admin']))
                    <a href="{{ route('patients') }}" class="@if(request()->routeIs('patients*')) active @endif">Patients</a>
                @endif
                {{-- Caregiver Only --}}
                @if(strtolower(auth()->user()->role) === 'caregiver')
                    <a href="{{ route('careplans.select') }}" class="@if(request()->routeIs('careplans.select')) active @endif">Care Plans</a>
                @endif
            @endauth
            
            <a href="{{ route('documents') }}" class="@if(request()->routeIs('documents*')) active @endif">Documents</a>
            
            @auth
                <a href="{{ route('messages.index') }}" class="@if(request()->routeIs('messages*')) active @endif">Messages</a>
            @endauth
            
            <a href="{{ route('chatsupport') }}" class="@if(request()->routeIs('chatsupport')) active @endif">Chat Support</a>
            
            @auth
                {{-- Admin and Clinician Only --}}
                @php $role = strtolower(auth()->user()->role); @endphp
                @if(in_array($role, ['admin', 'clinician']))
                    <a href="{{ route('settings') }}" class="@if(request()->routeIs('settings*')) active @endif">Settings</a>
                @endif
            @endauth
        </div>

        <!-- Header Right -->
        <div class="header-right">
            <input type="text" class="search-box" placeholder="Search...">
            <div class="icon-circle" style="position: relative;">
                🔔
                @auth
                    @php 
                        $unreadCount = \App\Models\Message::where('receiver_id', auth()->id())->whereNull('read_at')->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span style="position: absolute; top: -5px; right: -5px; background: var(--secondary); color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800; border: 2px solid white;">
                            {{ $unreadCount }}
                        </span>
                    @endif
                @endauth
            </div>
            <div class="user-info">
                <div class="user-name-header">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</div>
                <div class="icon-circle">👩</div>
            </div>

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

    <!-- Floating Chatbot Component (Hidden on Chat Support page) -->
    @if(!request()->routeIs('chatsupport'))
        <x-chatbot />
    @endif
</body>
</html>