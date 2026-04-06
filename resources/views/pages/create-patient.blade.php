@extends('layouts.app')

@section('title', 'Add Patient - Excellent Care Services')

@section('content')
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f5f7fb;
    }

    .patient-create-page {
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

    .form-wrapper {
        max-width: 900px;
        margin: 30px auto;
        padding: 0 20px;
    }

    .breadcrumb {
        font-size: 13px;
        color: #9ca3af;
        margin-bottom: 8px;
    }

    .page-title {
        font-size: 34px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 8px;
    }

    .page-subtitle {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 24px;
    }

    .form-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05);
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        height: 46px;
        border-radius: 10px;
        border: 1px solid #dbe2ea;
        font-size: 14px;
        box-shadow: none !important;
    }

    .field-error {
        color: #dc2626;
        font-size: 12px;
        margin-top: 4px;
    }

    .btn-row {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 20px;
    }

    .btn-light {
        background: white;
        color: #374151;
        border: 1px solid #dbe2ea;
        border-radius: 10px;
        padding: 10px 16px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
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
</style>

<div class="patient-create-page">
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
            <div class="icon-circle">🔔</div>
            <div class="icon-circle">👩</div>
        </div>
    </div>

    <div class="form-wrapper">
        <div class="breadcrumb">Home &nbsp; &gt; &nbsp; Patients &nbsp; &gt; &nbsp; Add Patient</div>
        <div class="page-title">Add Patient</div>
        <div class="page-subtitle">Create a new patient record for the care portal.</div>

        <div class="form-card">
            <form method="POST" action="{{ route('patients.store') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Patient Code</label>
                        <input type="text" name="patient_code" class="form-control" value="{{ old('patient_code') }}" placeholder="P1005">
                        @error('patient_code')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}" placeholder="Patient full name">
                        @error('full_name')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Assigned Staff</label>
                        <input type="text" name="assigned_staff" class="form-control" value="{{ old('assigned_staff') }}" placeholder="Dr. Sarah Jenkins">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Care Plan</label>
                        <input type="text" name="care_plan" class="form-control" value="{{ old('care_plan') }}" placeholder="Mobility Support Plan">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Last Update</label>
                        <input type="date" name="last_update" class="form-control" value="{{ old('last_update') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="Active">Active</option>
                            <option value="Pending Review">Pending Review</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        @error('status')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="btn-row">
                    <a href="{{ route('patients') }}" class="btn-light">Cancel</a>
                    <button type="submit" class="btn-primary">Save Patient</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection