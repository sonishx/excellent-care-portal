@extends('layouts.app')

@section('title', 'Dashboard - Excellent Care Services')

@section('content')
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f5f7fb;
    }
    .dashboard-page { min-height: 100vh; background: #f5f7fb; }
    .dashboard-container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
    .breadcrumb { font-size: 13px; color: #9ca3af; margin-bottom: 8px; }
    .page-title-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; flex-wrap: wrap; gap: 12px; }
    .page-title { font-size: 34px; font-weight: 700; color: #111827; margin-bottom: 4px; }
    .page-subtitle { font-size: 14px; color: #6b7280; }
    .action-buttons { display: flex; gap: 10px; flex-wrap: wrap; }
    .action-buttons button { border: 1px solid #dbe2ea; background: white; border-radius: 8px; padding: 10px 14px; font-size: 13px; font-weight: 500; }
    .action-buttons .primary-btn { background: #1f6ef2; color: white; border: none; }
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; margin-bottom: 20px; }
    .stat-card { background: white; border-radius: 14px; padding: 18px; box-shadow: 0 6px 18px rgba(15, 23, 42, 0.04); }
    .stat-title { font-size: 12px; color: #6b7280; margin-bottom: 10px; text-transform: uppercase; font-weight: 600; }
    .stat-value { font-size: 30px; font-weight: 700; color: #111827; }
    .stat-change { font-size: 12px; color: #16a34a; margin-left: 8px; }
    .dashboard-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px; }
    .panel { background: white; border-radius: 14px; padding: 20px; box-shadow: 0 6px 18px rgba(15, 23, 42, 0.04); }
    .panel-title { font-size: 16px; font-weight: 700; color: #111827; margin-bottom: 6px; }
    .panel-subtitle { font-size: 13px; color: #6b7280; margin-bottom: 18px; }
    .mini-widget { background: #f9fafb; border-radius: 12px; padding: 16px; margin-bottom: 15px; }
    .progress-line { height: 8px; border-radius: 30px; background: #e5e7eb; overflow: hidden; margin: 8px 0 6px; }
    .progress-fill { height: 100%; background: #2563eb; }
    .legend-item { font-size: 13px; color: #6b7280; margin-bottom: 6px; }
    .activity-table { width: 100%; border-collapse: collapse; }
    .activity-table th, .activity-table td { text-align: left; padding: 14px 10px; font-size: 13px; border-bottom: 1px solid #eef2f7; }
    .activity-table th { color: #6b7280; font-size: 12px; text-transform: uppercase; }
    .status-badge { display: inline-block; padding: 5px 10px; border-radius: 999px; font-size: 11px; font-weight: 600; }
    .status-green { background: #dcfce7; color: #15803d; }
    .status-blue { background: #dbeafe; color: #1d4ed8; }
    .status-yellow { background: #fef3c7; color: #a16207; }

    @media (max-width: 992px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } .dashboard-grid { grid-template-columns: 1fr; } }
    @media (max-width: 600px) { .stats-grid { grid-template-columns: 1fr; } .page-title { font-size: 28px; } }
</style>

<div class="dashboard-page">
    <div class="dashboard-container">
        <div class="breadcrumb">Home &gt; Reports & Analytics</div>

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
                <a href="{{ route('dashboard.export') }}" class="primary-btn">Export Data</a>
            </div>
        </div>

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

                <canvas id="activityChart" height="280"></canvas>
            </div>

            <div>
                <div class="panel mini-widget">
                    <div class="panel-title">User Distribution</div>
                    <div class="legend-item">Clinicians ({{ $clinicianPercentage }}%)</div>
                    <div class="progress-line"><div class="progress-fill" style="width: {{ $clinicianPercentage }}%;"></div></div>
                    <div class="legend-item">Caregivers ({{ $caregiverPercentage }}%)</div>
                    <div class="progress-line"><div class="progress-fill" style="width: {{ $caregiverPercentage }}%;"></div></div>
                    <div class="mt-3 text-success fw-semibold" style="font-size: 13px;">
                        {{ $totalUsers }} total registered users
                    </div>
                    <div class="text-muted" style="font-size: 12px;">Based on current portal accounts</div>
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
                        <tr><td colspan="5">No recent activity found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('activityChart').getContext('2d');

const labels = @json($activityDates);  // ['Apr 01', 'Apr 02', ...]
const data = @json($activityCounts);   // [12, 18, ...]

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Daily Active Users',
            data: data,
            backgroundColor: '#1f6ef2',
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: { mode: 'index' }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: { display: true, text: 'Users' }
            },
            x: {
                title: { display: true, text: 'Date' }
            }
        }
    }
});
</script>
@endsection