@extends('layouts.app')

@section('title', 'Dashboard - Excellent Care Services')

@section('content')
<style>
    .dashboard-page { min-height: 100vh; padding-bottom: 50px; }
    .breadcrumb { font-size: 13px; color: var(--text-light); margin-bottom: 12px; font-weight: 500; }
    .page-title { font-size: 32px; font-weight: 800; color: var(--text); letter-spacing: -1px; margin-bottom: 8px; }
    .page-subtitle { font-size: 15px; color: var(--text-light); max-width: 700px; line-height: 1.6; }
    
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 35px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .action-group {
        display: flex;
        gap: 12px;
    }

    .btn-outline {
        border: 1px solid var(--border);
        background: white;
        border-radius: 10px;
        padding: 10px 18px;
        font-size: 14px;
        font-weight: 600;
        color: var(--text);
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-outline:hover {
        border-color: var(--primary);
        color: var(--primary);
    }

    .btn-primary {
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: opacity 0.2s;
    }

    .btn-primary:hover {
        opacity: 0.9;
        color: white;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        margin-bottom: 35px;
    }

    .stat-card {
        padding: 24px;
        position: relative;
        overflow: hidden;
    }

    .stat-card::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 80px;
        height: 80px;
        background: var(--primary);
        opacity: 0.03;
        border-radius: 0 0 0 100%;
    }

    .stat-title {
        font-size: 13px;
        color: var(--text-light);
        margin-bottom: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 800;
        color: var(--text);
        display: block;
    }

    .stat-label {
        font-size: 12px;
        color: var(--primary);
        font-weight: 600;
        margin-top: 5px;
        display: inline-block;
    }

    .dashboard-layout {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 24px;
        margin-bottom: 25px;
    }

    .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .panel-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--text);
        margin: 0;
    }

    .progress-group {
        margin-bottom: 20px;
    }

    .progress-label {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .progress-bar {
        height: 10px;
        background: #f1f5f9;
        border-radius: 20px;
        overflow: hidden;
    }

    .progress-value {
        height: 100%;
        background: var(--primary);
        border-radius: 20px;
    }

    .activity-table {
        width: 100%;
        border-collapse: collapse;
    }

    .activity-table th {
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        color: var(--text-light);
        text-transform: uppercase;
        padding: 15px 10px;
        border-bottom: 1px solid var(--border);
    }

    .activity-table td {
        padding: 18px 10px;
        font-size: 14px;
        color: var(--text);
        border-bottom: 1px solid var(--border);
    }

    .badge {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-success { background: #dcfce7; color: #15803d; }
    .badge-primary { background: #e0e7ff; color: #4338ca; }

    @media (max-width: 1024px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .dashboard-layout { grid-template-columns: 1fr; }
    }

    @media (max-width: 600px) {
        .stats-grid { grid-template-columns: 1fr; }
    }

    /* Chart Toggle Styles */
    .btn-chart-toggle {
        border: none;
        background: transparent;
        padding: 6px 12px;
        font-size: 11px;
        font-weight: 700;
        color: var(--text-light);
        cursor: pointer;
        border-radius: 6px;
        transition: all 0.2s;
    }

    .btn-chart-toggle.active {
        background: white;
        color: var(--primary);
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
</style>

<div class="dashboard-page">
    <div class="breadcrumb">Portal > Dashboard > Overview</div>

    <div class="page-header">
        <div>
            <h1 class="page-title">Welcome back, {{ Auth::user()->name }}</h1>
            <p class="page-subtitle">
                Manage your care services, track participant progress, and monitor compliance reports in one place.
            </p>
        </div>

        <div class="action-group">
            <button class="btn-outline">Download Report</button>
            <a href="{{ route('dashboard.export') }}" class="btn-primary">Export Data</a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="card stat-card">
            <div class="stat-title">Total Clinicians</div>
            <span class="stat-value">{{ $totalClinicians }}</span>
            <span class="stat-label">Verified Specialists</span>
        </div>
        <div class="card stat-card">
            <div class="stat-title">Active Caregivers</div>
            <span class="stat-value">{{ $totalCaregivers }}</span>
            <span class="stat-label">Support Staff</span>
        </div>
        <div class="card stat-card">
            <div class="stat-title">Registered Users</div>
            <span class="stat-value">{{ $totalUsers }}</span>
            <span class="stat-label">Portal Accounts</span>
        </div>
        <div class="card stat-card">
            <div class="stat-title">System Admins</div>
            <span class="stat-value">{{ $totalAdmins }}</span>
            <span class="stat-label">Administrators</span>
        </div>
    </div>

    <!-- Main Dashboard Content -->
    <div class="dashboard-layout">
        <div class="card">
            <div class="panel-header">
                <h3 class="panel-title">Analytical Insights</h3>
                <div class="action-group" style="background: #f1f5f9; padding: 4px; border-radius: 8px;">
                    <button id="toggleActivity" class="btn-chart-toggle active">Activity</button>
                    <button id="toggleGrowth" class="btn-chart-toggle">Growth</button>
                </div>
            </div>
            <div style="height: 220px; position: relative;">
                <canvas id="activityChart"></canvas>
            </div>
        </div>

        <div class="card">
            <h3 class="panel-title mb-4">Role Distribution</h3>
            <div style="height: 250px; position: relative;">
                <canvas id="distributionChart"></canvas>
            </div>
            
            <div class="mt-4 pt-4 border-top">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <span style="font-size: 13px; font-weight: 600; color: var(--text-light);">Clinicians</span>
                    <span style="font-size: 14px; font-weight: 700; color: var(--primary);">{{ $clinicianPercentage }}%</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 13px; font-weight: 600; color: var(--text-light);">Caregivers</span>
                    <span style="font-size: 14px; font-weight: 700; color: var(--secondary);">{{ $caregiverPercentage }}%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="card">
        <div class="panel-header">
            <h3 class="panel-title">Recent Activity Log</h3>
            <a href="#" class="btn-outline" style="padding: 6px 12px; font-size: 12px;">View All</a>
        </div>

        <table class="activity-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Action</th>
                    <th>Role</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentUsers as $user)
                    <tr>
                        <td style="font-weight: 600;">{{ $user->name }}</td>
                        <td>Account Created</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</td>
                        <td><span class="badge badge-success">Active</span></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-4">No recent activity found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('activityChart').getContext('2d');
const labels = @json($activityDates);
const clinicians = @json($clinicianActivity);
const caregivers = @json($caregiverActivity);

const grad1 = ctx.createLinearGradient(0, 0, 0, 400);
grad1.addColorStop(0, 'rgba(111, 45, 189, 0.4)');
grad1.addColorStop(1, 'rgba(111, 45, 189, 0)');

const grad2 = ctx.createLinearGradient(0, 0, 0, 400);
grad2.addColorStop(0, 'rgba(244, 93, 117, 0.4)');
grad2.addColorStop(1, 'rgba(244, 93, 117, 0)');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Clinicians',
                data: clinicians,
                borderColor: '#6f2dbd',
                backgroundColor: grad1,
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointRadius: 0,
                pointHoverRadius: 6
            },
            {
                label: 'Caregivers',
                data: caregivers,
                borderColor: '#f45d75',
                backgroundColor: grad2,
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointRadius: 0,
                pointHoverRadius: 6
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
            mode: 'index',
            intersect: false,
        },
        plugins: {
            legend: { 
                position: 'top',
                align: 'end',
                labels: {
                    usePointStyle: true,
                    padding: 20,
                    font: { size: 12, weight: '600' }
                }
            },
            tooltip: {
                backgroundColor: '#111827',
                padding: 15,
                titleFont: { size: 14 },
                bodyFont: { size: 13 },
                cornerRadius: 10,
                displayColors: true
            }
        },
        scales: {
            y: {
                stacked: true,
                beginAtZero: true,
                grid: { color: '#f1f5f9', drawBorder: false },
                ticks: { color: '#6b7280', padding: 10 }
            },
            x: {
                grid: { display: false },
                ticks: { color: '#6b7280', padding: 10 }
            }
        }
    }
});

// Distribution Chart
const ctx2 = document.getElementById('distributionChart').getContext('2d');
new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ['Clinicians', 'Caregivers', 'Admins'],
        datasets: [{
            data: [{{ $totalClinicians }}, {{ $totalCaregivers }}, {{ $totalAdmins }}],
            backgroundColor: ['#6f2dbd', '#f45d75', '#f28c52'],
            borderWidth: 0,
            hoverOffset: 10
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '75%',
        plugins: {
            legend: { display: false }
        }
    }
});

// Dynamic Switcher Logic
const mainChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Clinicians',
                data: clinicians,
                borderColor: '#6f2dbd',
                backgroundColor: grad1,
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointRadius: 0,
                pointHoverRadius: 6
            },
            {
                label: 'Caregivers',
                data: caregivers,
                borderColor: '#f45d75',
                backgroundColor: grad2,
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointRadius: 0,
                pointHoverRadius: 6
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: {
            legend: { position: 'top', align: 'end', labels: { usePointStyle: true, padding: 20, font: { size: 12, weight: '600' } } },
            tooltip: { backgroundColor: '#111827', padding: 15, cornerRadius: 10 }
        },
        scales: {
            y: { stacked: true, beginAtZero: true, grid: { color: '#f1f5f9', drawBorder: false }, ticks: { color: '#6b7280' } },
            x: { grid: { display: false }, ticks: { color: '#6b7280' } }
        }
    }
});

document.getElementById('toggleGrowth').addEventListener('click', function() {
    this.classList.add('active');
    document.getElementById('toggleActivity').classList.remove('active');
    
    mainChart.options.scales.y.stacked = false;
    mainChart.data.datasets[0].label = 'Cumulative Users';
    mainChart.data.datasets[0].data = clinicians.map((sum => value => sum += value)(0));
    mainChart.data.datasets[1].label = 'Target Growth';
    mainChart.data.datasets[1].data = clinicians.map((v, i) => v + i * 2);
    mainChart.update();
});

document.getElementById('toggleActivity').addEventListener('click', function() {
    this.classList.add('active');
    document.getElementById('toggleGrowth').classList.remove('active');
    
    mainChart.options.scales.y.stacked = true;
    mainChart.data.datasets[0].label = 'Clinicians';
    mainChart.data.datasets[0].data = clinicians;
    mainChart.data.datasets[1].label = 'Caregivers';
    mainChart.data.datasets[1].data = caregivers;
    mainChart.update();
});
</script>
@endsection