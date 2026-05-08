@extends('layouts.app')

@section('title', 'Patients - Excellent Care Services')

@section('content')
<style>
    .patients-page { padding-bottom: 50px; }
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
        text-decoration: none;
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

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        margin-bottom: 35px;
    }

    .summary-card {
        padding: 24px;
        position: relative;
    }

    .summary-title {
        font-size: 13px;
        color: var(--text-light);
        margin-bottom: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .summary-value {
        font-size: 32px;
        font-weight: 800;
        color: var(--text);
        display: block;
    }

    .summary-label {
        font-size: 12px;
        color: var(--primary);
        font-weight: 600;
        margin-top: 5px;
        display: inline-block;
    }

    .toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }

    .toolbar-left {
        display: flex;
        gap: 12px;
    }

    .filter-select {
        height: 42px;
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 0 15px;
        font-size: 14px;
        background: white;
        color: var(--text);
        outline: none;
    }

    .search-input {
        height: 42px;
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 0 15px;
        font-size: 14px;
        width: 300px;
        outline: none;
    }

    .search-input:focus {
        border-color: var(--primary);
    }

    .patient-table {
        width: 100%;
        border-collapse: collapse;
    }

    .patient-table th {
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        color: var(--text-light);
        text-transform: uppercase;
        padding: 15px 10px;
        border-bottom: 1px solid var(--border);
    }

    .patient-table td {
        padding: 20px 10px;
        font-size: 14px;
        color: var(--text);
        border-bottom: 1px solid var(--border);
    }

    .patient-name {
        font-weight: 700;
        color: var(--text);
        display: block;
    }

    .patient-id {
        font-size: 12px;
        color: var(--text-light);
    }

    .badge {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-active { background: #dcfce7; color: #15803d; }
    .badge-pending { background: #fef3c7; color: #a16207; }
    .badge-inactive { background: #fee2e2; color: #dc2626; }

    .action-link {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        margin-right: 15px;
    }

    .action-link:hover {
        text-decoration: underline;
    }

    @media (max-width: 1024px) {
        .summary-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 640px) {
        .summary-grid { grid-template-columns: 1fr; }
        .toolbar { flex-direction: column; align-items: stretch; }
        .search-input { width: 100%; }
    }
</style>

<div class="patients-page">
    <div class="breadcrumb">Portal > Patients > Management</div>

    <div class="page-header">
        <div>
            <h1 class="page-title">Patient Management</h1>
            <p class="page-subtitle">
                Centralized dashboard for tracking participant IDs, care status, and clinical assignments.
            </p>
        </div>

        <div class="action-group">
            <button class="btn-outline">Export List</button>
            <a href="{{ route('patients.create') }}" class="btn-primary">Add New Patient</a>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 15px; border-radius: 12px; margin-bottom: 25px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="summary-grid">
        <div class="card summary-card">
            <div class="summary-title">Total Patients</div>
            <span class="summary-value">{{ $totalPatients }}</span>
            <span class="summary-label">Registered Participants</span>
        </div>

        <div class="card summary-card">
            <div class="summary-title">Active Care</div>
            <span class="summary-value">{{ $activePatients }}</span>
            <span class="summary-label">Receiving Support</span>
        </div>

        <div class="card summary-card">
            <div class="summary-title">Pending Review</div>
            <span class="summary-value">{{ $pendingPatients }}</span>
            <span class="summary-label">Awaiting Updates</span>
        </div>

        <div class="card summary-card">
            <div class="summary-title">Inactive</div>
            <span class="summary-value">{{ $inactivePatients }}</span>
            <span class="summary-label">Archived Records</span>
        </div>
    </div>

    <div class="card">
        <div class="toolbar">
            <div class="toolbar-left">
                <select class="filter-select">
                    <option>All Statuses</option>
                    <option>Active</option>
                    <option>Pending Review</option>
                    <option>Inactive</option>
                </select>

                <select class="filter-select">
                    <option>All Staff</option>
                    <option>Clinicians</option>
                    <option>Caregivers</option>
                </select>
            </div>

            <input type="text" class="search-input" placeholder="Search by name or ID...">
        </div>

        <table class="patient-table">
            <thead>
                <tr>
                    <th>Participant</th>
                    <th>Assigned Staff</th>
                    <th>Care Goal</th>
                    <th>Last Update</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $patient)
                    <tr>
                        <td>
                            <span class="patient-name">{{ $patient->full_name }}</span>
                            <span class="patient-id">ID: #{{ $patient->patient_code }}</span>
                        </td>
                        <td style="font-weight: 500;">
                            @if($patient->assignedStaff->count() > 0)
                                <div style="display: flex; flex-direction: column; gap: 4px;">
                                    @foreach($patient->assignedStaff as $staff)
                                        <div style="font-size: 13px; display: flex; align-items: center; gap: 6px;">
                                            <span style="width: 8px; height: 8px; border-radius: 50%; background: {{ $staff->role === 'clinician' ? '#2563eb' : '#059669' }};"></span>
                                            {{ $staff->name }}
                                            @if(strtolower(Auth::user()->role) === 'admin')
                                                <form action="{{ route('patient-assignments.destroy', $staff->pivot->id) }}" method="POST" style="display: inline;">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" style="background: none; border: none; color: #dc2626; cursor: pointer; font-size: 14px; padding: 0;">×</button>
                                                </form>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <span style="color: var(--text-light); font-size: 13px;">Unassigned</span>
                            @endif
                        </td>
                        <td>{{ $patient->care_plan ?? 'N/A' }}</td>
                        <td style="color: var(--text-light); font-size: 13px;">
                            {{ $patient->last_update ? \Carbon\Carbon::parse($patient->last_update)->format('d M, Y') : 'N/A' }}
                        </td>
                        <td>
                            @if($patient->status == 'Active')
                                <span class="badge badge-active">Active</span>
                            @elseif($patient->status == 'Pending Review')
                                <span class="badge badge-pending">Review</span>
                            @else
                                <span class="badge badge-inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('careplans.index', ['patientId' => $patient->id]) }}" class="action-link">Care Plans</a>
                            @if(strtolower(Auth::user()->role) === 'admin')
                                <a href="javascript:void(0)" class="action-link" onclick="openAssignModal({{ $patient->id }}, '{{ $patient->full_name }}')">Assign Staff</a>
                            @endif
                            <a href="#" class="action-link" style="color: var(--text-light);">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-light);">No participant records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@if(strtolower(Auth::user()->role) === 'admin')
<!-- Assignment Modal -->
<div id="assignModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center; padding: 20px;">
    <div style="background: white; width: 100%; max-width: 450px; border-radius: 16px; padding: 30px; box-shadow: 0 20px 50px rgba(0,0,0,0.1);">
        <h3 style="margin-top: 0; margin-bottom: 8px; font-size: 20px; font-weight: 800;">Assign Staff Member</h3>
        <p style="color: var(--text-light); font-size: 14px; margin-bottom: 24px;">Assign a primary clinician or caregiver to <span id="modalPatientName" style="color: var(--text); font-weight: 700;"></span>.</p>
        
        <form action="{{ route('patient-assignments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="patient_id" id="modalPatientId">
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 8px;">Select Staff Member</label>
                <select name="staff_id" required style="width: 100%; height: 46px; border: 1px solid var(--border); border-radius: 10px; padding: 0 12px; font-size: 14px;">
                    <option value="">Choose from active staff...</option>
                    @foreach($staffMembers as $staff)
                        <option value="{{ $staff->id }}">{{ $staff->name }} ({{ ucfirst($staff->role) }})</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 8px;">Assignment Type</label>
                <select name="assignment_type" required style="width: 100%; height: 46px; border: 1px solid var(--border); border-radius: 10px; padding: 0 12px; font-size: 14px;">
                    <option value="primary">Primary Care Provider</option>
                    <option value="backup">Backup Staff</option>
                    <option value="specialist">Visiting Specialist</option>
                </select>
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="button" onclick="closeAssignModal()" style="flex: 1; height: 46px; border-radius: 10px; border: 1px solid var(--border); background: white; font-weight: 600; cursor: pointer;">Cancel</button>
                <button type="submit" style="flex: 1; height: 46px; border-radius: 10px; border: none; background: var(--primary); color: white; font-weight: 600; cursor: pointer;">Save Assignment</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAssignModal(id, name) {
        document.getElementById('modalPatientId').value = id;
        document.getElementById('modalPatientName').innerText = name;
        document.getElementById('assignModal').style.display = 'flex';
    }
    function closeAssignModal() {
        document.getElementById('assignModal').style.display = 'none';
    }
</script>
@endif
@endsection