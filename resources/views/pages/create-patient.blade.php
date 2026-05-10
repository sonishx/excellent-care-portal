@extends('layouts.app')

@section('title', 'Add Patient - Excellent Care Services')

@section('content')
<style>
    .create-patient-page {
        padding-bottom: 50px;
    }

    .breadcrumb {
        font-size: 13px;
        color: var(--text-light);
        margin-bottom: 12px;
        font-weight: 500;
    }

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

    /* ── Form Card ── */
    .form-card {
        background: white;
        border-radius: 20px;
        border: 1px solid var(--border);
        box-shadow: 0 4px 24px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .form-card-header {
        background: linear-gradient(135deg, #6f2dbd 0%, #a29bfe 60%, #f45d75 100%);
        padding: 28px 32px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .form-card-header-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .form-card-header h2 {
        color: white;
        font-size: 20px;
        font-weight: 700;
        margin: 0;
    }

    .form-card-header p {
        color: rgba(255, 255, 255, 0.8);
        font-size: 13px;
        margin: 4px 0 0;
    }

    .form-body {
        padding: 36px 32px 32px;
    }

    /* ── Section Dividers ── */
    .form-section {
        margin-bottom: 32px;
    }

    .form-section:last-child {
        margin-bottom: 0;
    }

    .form-section-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--primary);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f1f0fb;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-section-title .section-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--primary);
    }

    /* ── Form Grid ── */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px 28px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-label {
        font-size: 13px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-label .required {
        color: var(--secondary);
        font-size: 14px;
    }

    .form-control,
    .form-select {
        height: 48px;
        border-radius: 12px;
        border: 1.5px solid var(--border);
        padding: 0 16px;
        font-size: 14px;
        font-family: 'Inter', sans-serif;
        color: var(--text);
        background: #fafbfc;
        transition: all 0.25s ease;
        outline: none;
        width: 100%;
        box-sizing: border-box;
    }

    .form-control::placeholder {
        color: #94a3b8;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 3px rgba(111, 45, 189, 0.1);
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%236b7280' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 16px center;
        padding-right: 40px;
        cursor: pointer;
    }

    .field-error {
        color: #dc2626;
        font-size: 12px;
        margin-top: 6px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .field-error::before {
        content: '⚠';
        font-size: 12px;
    }

    .form-hint {
        font-size: 12px;
        color: var(--text-light);
        margin-top: 6px;
    }

    /* ── Action Buttons ── */
    .btn-row {
        display: flex;
        justify-content: flex-end;
        gap: 14px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid var(--border);
    }

    .btn-cancel {
        background: white;
        color: var(--text);
        border: 1.5px solid var(--border);
        border-radius: 12px;
        padding: 12px 24px;
        font-size: 14px;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-cancel:hover {
        border-color: var(--text-light);
        background: #f8fafc;
        color: var(--text);
    }

    .btn-submit {
        background: linear-gradient(135deg, #6f2dbd 0%, #a29bfe 100%);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 12px 28px;
        font-size: 14px;
        font-weight: 700;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.25s;
        box-shadow: 0 4px 14px rgba(111, 45, 189, 0.25);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(111, 45, 189, 0.35);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    /* ── Alert ── */
    .alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 16px 20px;
        border-radius: 14px;
        margin-bottom: 24px;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-body {
            padding: 24px 20px;
        }

        .form-card-header {
            padding: 20px;
        }

        .btn-row {
            flex-direction: column;
        }

        .btn-cancel, .btn-submit {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="create-patient-page">
    <div class="breadcrumb">Portal &gt; Patients &gt; Add New Patient</div>

    <div class="page-header">
        <div>
            <h1 class="page-title">Add New Patient</h1>
            <p class="page-subtitle">
                Register a new participant in the care portal. Complete all required fields to create their record.
            </p>
        </div>
    </div>

    @if($errors->any())
        <div class="alert-error">
            ⚠️ Please fix the errors below and try again.
        </div>
    @endif

    <div class="form-card">
        <div class="form-card-header">
            <div class="form-card-header-icon">👤</div>
            <div>
                <h2>Patient Registration Form</h2>
                <p>Fields marked with * are required</p>
            </div>
        </div>

        <div class="form-body">
            <form method="POST" action="{{ route('patients.store') }}">
                @csrf

                {{-- Section: Identity --}}
                <div class="form-section">
                    <div class="form-section-title">
                        <span class="section-dot"></span>
                        Participant Identity
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Patient Code <span class="required">*</span></label>
                            <input type="text" name="patient_code" class="form-control" value="{{ old('patient_code') }}" placeholder="e.g. P1005">
                            @error('patient_code')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                            <div class="form-hint">Unique identifier for this participant</div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Full Name <span class="required">*</span></label>
                            <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}" placeholder="e.g. Sarah Williams">
                            @error('full_name')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Section: Care Details --}}
                <div class="form-section">
                    <div class="form-section-title">
                        <span class="section-dot"></span>
                        Care Details
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Assigned Staff</label>
                            <input type="text" name="assigned_staff" class="form-control" value="{{ old('assigned_staff') }}" placeholder="e.g. Dr. Sarah Jenkins">
                            <div class="form-hint">Primary clinician or caregiver</div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Care Plan</label>
                            <input type="text" name="care_plan" class="form-control" value="{{ old('care_plan') }}" placeholder="e.g. Mobility Support Plan">
                            <div class="form-hint">Current active care goal</div>
                        </div>
                    </div>
                </div>

                {{-- Section: Status --}}
                <div class="form-section">
                    <div class="form-section-title">
                        <span class="section-dot"></span>
                        Status & Timeline
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Last Update</label>
                            <input type="date" name="last_update" class="form-control" value="{{ old('last_update') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Status <span class="required">*</span></label>
                            <select name="status" class="form-select">
                                <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Pending Review" {{ old('status') == 'Pending Review' ? 'selected' : '' }}>Pending Review</option>
                                <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="btn-row">
                    <a href="{{ route('patients') }}" class="btn-cancel">← Back to Patients</a>
                    <button type="submit" class="btn-submit">Save Patient →</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection