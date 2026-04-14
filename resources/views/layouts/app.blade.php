<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Excellent Care Services')</title>

    <!-- Tailwind or app CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Inline CSS for dashboard style -->
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f7fb;
        }

        .dashboard-page {
            min-height: 100vh;
            background: #f5f7fb;
        }
        
        .top-header {
            height: 72px;
            background: #ffffff;
            border-bottom: 1px solid #edf1f5;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 35px;
        }

        .brand-area {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-logo-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #6f2dbd;
            color: white;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            text-align: center;
            line-height: 1.1;
        }

        .brand-provider {
            font-size: 10px;
            color: #6b7280;
            line-height: 1.2;
        }

        .brand-main {
            font-size: 20px;
            font-weight: 700;
            color: #f45d75;
        }

        .brand-main span {
            font-size: 13px;
            color: #f28c52;
            font-weight: 600;
            margin-left: 2px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 25px;
            margin-left: 35px;
        }
        
        .nav-links a {
            text-decoration: none;
            font-size: 13px;
            color: #4b5563;
            font-weight: 500;
        }

        .nav-links a.active {
            color: #111827;
            font-weight: 700;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .search-box {
            width: 220px;
            height: 40px;
            border: 1px solid #dbe2ea;
            border-radius: 10px;
            padding: 0 14px;
            font-size: 13px;
            background: #fff;
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
            text-decoration: none;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .breadcrumb {
            font-size: 13px;
            color: #9ca3af;
            margin-bottom: 8px;
        }

        .page-title-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .page-title {
            font-size: 34px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 4px;
        }

        .page-subtitle {
            font-size: 14px;
            color: #6b7280;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .action-buttons button,
        .action-buttons a.btn-primary {
            border: 1px solid #dbe2ea;
            background: white;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
        }

        .action-buttons .primary-btn {
            background: #1f6ef2;
            color: white;
            border: none;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            border-radius: 14px;
            padding: 18px;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.04);
        }

        .stat-title {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 10px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .stat-value {
            font-size: 30px;
            font-weight: 700;
            color: #111827;
        }

        .stat-change {
            font-size: 12px;
            color: #16a34a;
            margin-left: 8px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .panel {
            background: white;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.04);
        }

        .panel-title {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 6px;
        }

        .panel-subtitle {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 18px;
        }

        .activity-table {
            width: 100%;
            border-collapse: collapse;
        }

        .activity-table th,
        .activity-table td {
            text-align: left;
            padding: 14px 10px;
            font-size: 13px;
            border-bottom: 1px solid #eef2f7;
        }

        .activity-table th {
            color: #6b7280;
            font-size: 12px;
            text-transform: uppercase;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-green {
            background: #dcfce7;
            color: #15803d;
        }

        .status-blue {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .status-yellow {
            background: #fef3c7;
            color: #a16207;
        }
    </style>
</head>
<body class="dashboard-page">

    <!-- Top Navbar -->
    <div class="top-header">
        <div class="d-flex align-items-center">
            <div class="brand-area">
                <div class="brand-logo-circle">We<br>ndis</div>
                <div class="brand-provider">Registered<br>NDIS Provider</div>
                <div class="brand-main">excellent<span>Care Services</span></div>
            </div>

            <div class="nav-links">
                <a href="{{ route('dashboard') }}" class="@if(request()->routeIs('dashboard')) active @endif">Dashboard</a>
                <a href="{{ route('patients') }}" class="@if(request()->routeIs('patients*')) active @endif">Patients</a>
                <a href="{{ route('careplans.select') }}" class="@if(request()->routeIs('careplans.select')) active @endif">Care Plans</a>
                <a href="{{ route('documents') }}" class="@if(request()->routeIs('documents*')) active @endif">Documents</a>
                <a href="#">Reports</a>
                <a href="{{ route('settings') }}" class="@if(request()->routeIs('settings*')) active @endif">Settings</a>
            </div>
        </div>

        <div class="header-right">
            <input type="text" class="search-box" placeholder="Search data...">
            <div class="icon-circle">🔔</div>
            <div class="user-name-header">{{ Auth::user()->name }}</div>
            <div class="icon-circle">👩</div>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="logout-btn">Log out</button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="dashboard-container">
        @yield('content')
    </div>

</body>
</html>