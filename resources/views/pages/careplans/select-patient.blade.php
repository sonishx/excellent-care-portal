@extends('layouts.app')

@section('title', 'Select Patient - Care Plans')

@section('content')
<style>
    .careplan-page { padding-bottom: 50px; }

    .breadcrumb { font-size: 13px; color: var(--text-light); margin-bottom: 12px; font-weight: 500; }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 35px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .page-title {
        font-size: 32px;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -1px;
        margin-bottom: 8px;
    }

    .page-subtitle {
        font-size: 15px;
        color: var(--text-light);
        max-width: 700px;
        line-height: 1.6;
    }

    /* ── Patient Cards Grid ── */
    .patient-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 20px;
    }

    .patient-select-card {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: 16px;
        padding: 24px;
        transition: all 0.25s ease;
        cursor: pointer;
        text-decoration: none;
        display: block;
        position: relative;
        overflow: hidden;
    }

    .patient-select-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, #6f2dbd 0%, #a29bfe 100%);
        opacity: 0;
        transition: opacity 0.25s;
    }

    .patient-select-card:hover {
        border-color: var(--primary-light);
        box-shadow: 0 8px 30px rgba(111, 45, 189, 0.1);
        transform: translateY(-2px);
    }

    .patient-select-card:hover::before {
        opacity: 1;
    }

    .patient-card-top {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 16px;
    }

    .patient-avatar {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        background: linear-gradient(135deg, #6f2dbd 0%, #a29bfe 100%);
        color: white;
        font-size: 16px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .patient-card-name {
        font-size: 16px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 2px;
    }

    .patient-card-id {
        font-size: 13px;
        color: var(--text-light);
        font-weight: 500;
    }

    .patient-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .patient-card-status {
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-active { background: #dcfce7; color: #15803d; }
    .status-pending { background: #fef3c7; color: #a16207; }
    .status-inactive { background: #fee2e2; color: #dc2626; }

    .view-plans-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--primary);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .view-plans-label::after {
        content: '→';
        transition: transform 0.2s;
    }

    .patient-select-card:hover .view-plans-label::after {
        transform: translateX(4px);
    }

    /* ── Empty State ── */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 16px;
        border: 1.5px dashed var(--border);
    }

    .empty-state-icon {
        font-size: 48px;
        margin-bottom: 16px;
    }

    .empty-state-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 8px;
    }

    .empty-state-text {
        font-size: 14px;
        color: var(--text-light);
    }

    /* ── Search ── */
    .search-bar {
        margin-bottom: 28px;
    }

    .search-input {
        height: 48px;
        border: 1.5px solid var(--border);
        border-radius: 12px;
        padding: 0 18px;
        font-size: 14px;
        font-family: 'Inter', sans-serif;
        width: 100%;
        max-width: 400px;
        outline: none;
        background: white;
        transition: all 0.25s;
    }

    .search-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(111, 45, 189, 0.1);
    }

    @media (max-width: 640px) {
        .patient-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="careplan-page">
    <div class="breadcrumb">Portal &gt; Care Plans &gt; Select Patient</div>

    <div class="page-header">
        <div>
            <h1 class="page-title">Care Plans</h1>
            <p class="page-subtitle">
                Select a participant to view, manage, or add care notes to their clinical record.
            </p>
        </div>
    </div>

    <div class="search-bar">
        <input type="text" class="search-input" id="patientSearch" placeholder="Search patients by name or ID..." oninput="filterPatients()">
    </div>

    @if($patients->count() > 0)
        <div class="patient-grid" id="patientGrid">
            @foreach($patients as $patient)
                <a href="{{ route('careplans.index', ['patientId' => $patient->id]) }}" class="patient-select-card" data-name="{{ strtolower($patient->full_name) }}" data-code="{{ strtolower($patient->patient_code) }}">
                    <div class="patient-card-top">
                        <div class="patient-avatar">
                            {{ strtoupper(substr($patient->full_name, 0, 2)) }}
                        </div>
                        <div>
                            <div class="patient-card-name">{{ $patient->full_name }}</div>
                            <div class="patient-card-id">ID: #{{ $patient->patient_code }}</div>
                        </div>
                    </div>
                    <div class="patient-card-footer">
                        <span class="patient-card-status {{ $patient->status == 'Active' ? 'status-active' : ($patient->status == 'Pending Review' ? 'status-pending' : 'status-inactive') }}">
                            {{ $patient->status }}
                        </span>
                        <span class="view-plans-label">View Care Plans</span>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">📋</div>
            <div class="empty-state-title">No Patients Found</div>
            <div class="empty-state-text">No participant records are available yet. Add patients first to manage their care plans.</div>
        </div>
    @endif
</div>

<script>
    function filterPatients() {
        const query = document.getElementById('patientSearch').value.toLowerCase();
        document.querySelectorAll('.patient-select-card').forEach(card => {
            const name = card.dataset.name;
            const code = card.dataset.code;
            card.style.display = (name.includes(query) || code.includes(query)) ? '' : 'none';
        });
    }
</script>
@endsection