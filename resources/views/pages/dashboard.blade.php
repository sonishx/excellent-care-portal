@extends('layouts.app')

@section('title', 'Dashboard - Excellent Care Services')

@section('content')
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
        gap: 28px;
        margin-left: 35px;
    }

    .nav-links a {
        text-decoration: none;
        font-size: 14px;
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

    .action-buttons button {
        border: 1px solid #dbe2ea;
        background: white;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 13px;
        font-weight: 500;
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

    .chart-placeholder {
        height: 280px;
        background: linear-gradient(to top, #dbeafe, #f8fbff);
        border-radius: 10px;
        display: flex;
        align-items: end;
        justify-content: space-around;
        padding: 20px;
    }

    .bar {
        width: 40px;
        background: #3b82f6;
        border-radius: 8px 8px 0 0;
    }

    .mini-widget {
        background: #f9fafb;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 15px;
    }

    .mini-widget:last-child {
        margin-bottom: 0;
    }

    .progress-line {
        height: 8px;
        border-radius: 30px;
        background: #e5e7eb;
        overflow: hidden;
        margin: 8px 0 6px;
    }

    .progress-fill {
        height: 100%;
        background: #2563eb;
    }

    .legend-item {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 6px;
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

    @media (max-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .dashboard-grid {
            grid-template-columns: 1fr;
        }

        .top-header {
            flex-direction: column;
            height: auto;
            padding: 15px;
            gap: 12px;
        }

        .nav-links {
            margin-left: 0;
            flex-wrap: wrap;
            justify-content: center;
        }

        .header-right {
            flex-wrap: wrap;
            justify-content: center;
        }
    }

    @media (max-width: 600px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .page-title {
            font-size: 28px;
        }
    }
</style>

<div class="dashboard-page">

    <div class="top-header">
        <div class="d-flex align-items-center">
            <div class="brand-area">
                <div class="brand-logo-circle">We<br>ndis</div>

                <div class="brand-provider">
                    Registered<br>NDIS Provider
                </div>

                <div class="brand-main">
                    excellent<span>Care Services</span>
                </div>
            </div>

            <div class="nav-links">
                <a href="/dashboard" class="active">Dashboard</a>
                <a href="/patients">Patients</a>
                <a href="/messages">Messages</a>
                <a href="#">Care Plans</a>
                 <a href="/documents">Documents</a>
                <a href="#">Reports</a>
                <a href="/settings">Settings</a>
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

    <!-- Content -->
    <div class="dashboard-container">
        <div class="breadcrumb">Home &nbsp; &gt; &nbsp; Reports &amp; Analytics</div>

        <div class="page-title-row">
            <div>
                <div class="page-title">System Overview</div>
                <div class="page-subtitle">
                    Welcome, {{ Auth::user()->name }} ({{ Auth::user()->role }}). Track NDIS & My Aged Care engagement metrics, clinician activity, and document compliance.
                </div>
            </div>

            <div class="action-buttons">
                <button>Last 30 Days</button>
                <button>PDF</button>
                <button>CSV</button>
                <button class="primary-btn">Export Data</button>
            </div>
        </div>

        @if(session('success'))
            <div style="
                background: #ecfdf3;
                border: 1px solid #bbf7d0;
                color: #15803d;
                border-radius: 10px;
                padding: 14px 16px;
                font-size: 13px;
                margin-bottom: 20px;
            ">
                {{ session('success') }}
            </div>
        @endif

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-title">Active Clinicians</div>
                <div>
                    <span class="stat-value">{{ $totalClinicians }}</span>
                    <span class="stat-change">Registered users</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-title">Total Users</div>
                <div>
                    <span class="stat-value">{{ $totalUsers }}</span>
                    <span class="stat-change">Portal accounts</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-title">Caregivers</div>
                <div>
                    <span class="stat-value">{{ $totalCaregivers }}</span>
                    <span class="stat-change">Support staff</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-title">Admins</div>
                <div>
                    <span class="stat-value">{{ $totalAdmins }}</span>
                    <span class="stat-change">System managers</span>
                </div>
            </div>
        </div>

        <!-- Middle Panels -->
        <div class="dashboard-grid">
            <div class="panel">
                <div class="panel-title">User Activity</div>
                <div class="panel-subtitle">Daily active users (Clinicians & Caregivers)</div>

                <div class="chart-placeholder">
                    <div class="bar" style="height: 90px;"></div>
                    <div class="bar" style="height: 130px;"></div>
                    <div class="bar" style="height: 120px;"></div>
                    <div class="bar" style="height: 160px;"></div>
                    <div class="bar" style="height: 190px;"></div>
                    <div class="bar" style="height: 150px;"></div>
                    <div class="bar" style="height: 210px;"></div>
                    <div class="bar" style="height: 230px;"></div>
                    <div class="bar" style="height: 180px;"></div>
                    <div class="bar" style="height: 250px;"></div>
                    <div class="bar" style="height: 265px;"></div>
                    <div class="bar" style="height: 290px;"></div>
                </div>
            </div>

            <div>
<div class="panel mini-widget">
    <div class="panel-title">User Distribution</div>

    <div class="legend-item">Clinicians ({{ $clinicianPercentage }}%)</div>
    <div class="progress-line">
        <div class="progress-fill" style="width: {{ $clinicianPercentage }}%;"></div>
    </div>

    <div class="legend-item">Caregivers ({{ $caregiverPercentage }}%)</div>
    <div class="progress-line">
        <div class="progress-fill" style="width: {{ $caregiverPercentage }}%;"></div>
    </div>

    <div class="mt-3 text-success fw-semibold" style="font-size: 13px;">
        {{ $totalUsers }} total registered users
    </div>
    <div class="text-muted" style="font-size: 12px;">
        Based on current portal accounts
    </div>
</div>

                <div class="panel mini-widget">
                    <div class="panel-title">Document Types</div>
                    <div class="legend-item">● Care Plans (45%)</div>
                    <div class="legend-item">● Invoices (30%)</div>
                    <div class="legend-item">● Medical Records (25%)</div>
                </div>
            </div>
        </div>

        <!-- Activity Table -->
        <div class="panel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="panel-title mb-0">Recent System Activity</div>
                <a href="#" class="text-decoration-none" style="font-size: 13px;">View All</a>
            </div>

            <table class="activity-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Action</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
    @forelse($recentUsers as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>Registered account</td>
            <td>{{ $user->role }}</td>
            <td>{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</td>
            <td><span class="status-badge status-green">Active</span></td>
        </tr>
    @empty
        <tr>
            <td colspan="5">No recent activity found.</td>
        </tr>
    @endforelse
</tbody>
            </table>
        </div>
    </div>
</div>
@endsection