@extends('layouts.app')

@section('title', 'Patients - Excellent Care Services')

@section('content')
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f5f7fb;
    }

    .patients-page {
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
        padding: 0 32px;
    }

    .brand-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .brand-logo {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #6f2dbd;
        color: white;
        font-size: 11px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        line-height: 1.05;
    }

    .brand-provider {
        font-size: 9px;
        color: #7c8796;
        line-height: 1.2;
    }

    .brand-name {
        font-size: 14px;
        font-weight: 700;
        color: #f45d75;
    }

    .brand-name span {
        color: #f28c52;
        font-size: 11px;
        font-weight: 600;
        margin-left: 2px;
    }

    .top-nav {
        display: flex;
        align-items: center;
        gap: 28px;
        margin-left: 28px;
    }

    .top-nav a {
        text-decoration: none;
        color: #4b5563;
        font-size: 14px;
    }

    .top-nav a.active {
        color: #2563eb;
        font-weight: 700;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 12px;
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
        font-size: 13px;
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

    .patients-content {
        max-width: 1480px;
        margin: 0 auto;
        padding: 28px 40px 40px;
    }

    .breadcrumb {
        font-size: 13px;
        color: #9ca3af;
        margin-bottom: 8px;
    }

    .page-title-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .page-title {
        font-size: 34px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 6px;
    }

    .page-subtitle {
        font-size: 14px;
        color: #6b7280;
    }

    .page-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-light {
        background: white;
        color: #374151;
        border: 1px solid #dbe2ea;
        border-radius: 10px;
        padding: 10px 16px;
        font-size: 13px;
        font-weight: 600;
    }

    .btn-primary {
        background: #1f6ef2;
        color: white;
        border: none;
        border-radius: 10px;
        padding: 10px 16px;
        font-size: 13px;
        font-weight: 600;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }

    .summary-card {
        background: white;
        border-radius: 18px;
        padding: 20px;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05);
    }

    .summary-title {
        font-size: 12px;
        color: #6b7280;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .summary-value {
        font-size: 30px;
        font-weight: 700;
        color: #111827;
    }

    .summary-sub {
        font-size: 12px;
        color: #16a34a;
        margin-top: 6px;
    }

    .panel {
        background: white;
        border-radius: 18px;
        padding: 22px;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05);
    }

    .toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }

    .toolbar-left {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .filter-select, .search-filter {
        height: 42px;
        border: 1px solid #dbe2ea;
        border-radius: 10px;
        padding: 0 12px;
        font-size: 13px;
        background: white;
    }

    .search-filter {
        width: 240px;
    }

    .patient-table {
        width: 100%;
        border-collapse: collapse;
    }

    .patient-table th,
    .patient-table td {
        text-align: left;
        padding: 14px 10px;
        font-size: 13px;
        border-bottom: 1px solid #eef2f7;
        vertical-align: middle;
    }

    .patient-table th {
        color: #6b7280;
        font-size: 12px;
        text-transform: uppercase;
    }

    .patient-name {
        font-weight: 700;
        color: #111827;
    }

    .patient-sub {
        font-size: 11px;
        color: #9ca3af;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
    }

    .status-active {
        background: #dcfce7;
        color: #15803d;
    }

    .status-review {
        background: #fef3c7;
        color: #a16207;
    }

    .status-inactive {
        background: #fee2e2;
        color: #dc2626;
    }

    .action-link {
        text-decoration: none;
        font-size: 12px;
        color: #2563eb;
        margin-right: 8px;
    }

    .flash-success {
        background: #ecfdf3;
        border: 1px solid #bbf7d0;
        color: #15803d;
        border-radius: 10px;
        padding: 14px 16px;
        font-size: 13px;
        margin-bottom: 20px;
    }

    @media (max-width: 1100px) {
        .summary-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .top-header {
            flex-direction: column;
            height: auto;
            padding: 16px;
            gap: 12px;
        }

        .patients-content {
            padding: 20px 16px 28px;
        }

        .summary-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="patients-page">
    <div class="top-header">
        <div class="d-flex align-items-center">
            <div class="brand-wrap">
                <div class="brand-logo">We<br>ndis</div>
                <div>
                    <div class="brand-provider">Registered<br>NDIS Provider</div>
                </div>
                <div class="brand-name">excellent<span>Care Services</span></div>
            </div>

            <div class="top-nav">
                <a href="/dashboard">Dashboard</a>
                <a href="/patients" class="active">Patients</a>
                <a href="/careplans">Care Plans</a>
                <a href="#">Reports</a>
                <a href="/settings">Settings</a>
            </div>
        </div>

        <div class="header-right">
            <input type="text" class="search-box" placeholder="Search patients...">
            <div class="icon-circle">🔔</div>
            <div class="user-name-header">{{ Auth::user()->name }}</div>
            <div class="icon-circle">👩</div>

            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="logout-btn">Log out</button>
            </form>
        </div>
    </div>

    <div class="patients-content">
        <div class="breadcrumb">Home &nbsp; &gt; &nbsp; Patients</div>

        <div class="page-title-row">
            <div>
                <div class="page-title">Patients</div>
                <div class="page-subtitle">
                    Manage participant records, assigned staff, and care status across the portal.
                </div>
            </div>

            <div class="page-actions">
                <button class="btn-light" type="button">Export List</button>
                <a href="{{ route('patients.create') }}" class="btn-primary text-decoration-none">Add Patient</a>
            </div>
        </div>

        @if(session('success'))
            <div class="flash-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-title">Total Patients</div>
                <div class="summary-value">{{ $totalPatients }}</div>
                <div class="summary-sub">Currently registered</div>
            </div>

            <div class="summary-card">
                <div class="summary-title">Active Care</div>
                <div class="summary-value">{{ $activePatients }}</div>
                <div class="summary-sub">Receiving support</div>
            </div>

            <div class="summary-card">
                <div class="summary-title">Pending Review</div>
                <div class="summary-value">{{ $pendingPatients }}</div>
                <div class="summary-sub">Needs follow-up</div>
            </div>

            <div class="summary-card">
                <div class="summary-title">Inactive Patients</div>
                <div class="summary-value">{{ $inactivePatients }}</div>
                <div class="summary-sub">Archived/inactive care</div>
            </div>
        </div>

        <div class="panel">
            <div class="toolbar">
                <div class="toolbar-left">
                    <select class="filter-select">
                        <option>All Statuses</option>
                        <option>Active</option>
                        <option>Pending Review</option>
                        <option>Inactive</option>
                    </select>

                    <select class="filter-select">
                        <option>All Providers</option>
                        <option>Clinician</option>
                        <option>Caregiver</option>
                    </select>
                </div>

                <input type="text" class="search-filter" placeholder="Search by patient name...">
            </div>

            <table class="patient-table">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Assigned Staff</th>
                        <th>Care Plan</th>
                        <th>Last Update</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                        <tr>
                            <td>
                                <div class="patient-name">{{ $patient->full_name }}</div>
                                <div class="patient-sub">NDIS Participant ID #{{ $patient->patient_code }}</div>
                            </td>
                            <td>{{ $patient->assigned_staff }}</td>
                            <td>{{ $patient->care_plan }}</td>
                            <td>{{ $patient->last_update ? \Carbon\Carbon::parse($patient->last_update)->format('d M Y') : 'N/A' }}</td>
                            <td>
                                @if($patient->status == 'Active')
                                    <span class="status-badge status-active">Active</span>
                                @elseif($patient->status == 'Pending Review')
                                    <span class="status-badge status-review">Pending Review</span>
                                @else
                                    <span class="status-badge status-inactive">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="#" class="action-link">View</a>
                                <a href="#" class="action-link">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No patient records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection