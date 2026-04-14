@extends('layouts.app')

@section('title', 'Patients - Excellent Care Services')

@section('content')
<style>
/* Patients page specific CSS */
.patients-page {
    min-height: 100vh;
    background: #f5f7fb;
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
    .summary-grid {
        grid-template-columns: 1fr;
    }

    .patients-content {
        padding: 20px 16px 28px;
    }
}
</style>

<div class="patients-page">
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
            <div class="flash-success">{{ session('success') }}</div>
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
                                <a href="{{ route('careplans.index', ['patientId' => $patient->id]) }}" class="action-link">View Care Plans</a>
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