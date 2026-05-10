@extends('layouts.app')

@section('title', 'Add Care Note for ' . $patient->full_name)

@section('content')
<style>
    .careplan-page { padding-bottom: 50px; }

    .breadcrumb { font-size: 13px; color: var(--text-light); margin-bottom: 12px; font-weight: 500; }
    .breadcrumb a { color: var(--primary); text-decoration: none; font-weight: 600; }
    .breadcrumb a:hover { text-decoration: underline; }

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
        max-width: 800px;
    }

    .form-card-header {
        background: linear-gradient(135deg, #6f2dbd 0%, #a29bfe 60%, #f45d75 100%);
        padding: 24px 28px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .form-card-header-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .form-card-header h2 {
        color: white;
        font-size: 18px;
        font-weight: 700;
        margin: 0;
    }

    .form-card-header p {
        color: rgba(255, 255, 255, 0.8);
        font-size: 13px;
        margin: 3px 0 0;
    }

    .form-body {
        padding: 32px 28px;
    }

    /* ── Patient Badge ── */
    .patient-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: rgba(111, 45, 189, 0.06);
        border: 1px solid rgba(111, 45, 189, 0.12);
        padding: 10px 16px;
        border-radius: 12px;
        margin-bottom: 24px;
    }

    .patient-badge-avatar {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: linear-gradient(135deg, #6f2dbd 0%, #a29bfe 100%);
        color: white;
        font-size: 12px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .patient-badge-name {
        font-size: 14px;
        font-weight: 700;
        color: var(--text);
    }

    .patient-badge-id {
        font-size: 12px;
        color: var(--text-light);
    }

    /* ── Form Fields ── */
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
    }

    .form-textarea {
        width: 100%;
        min-height: 180px;
        border-radius: 12px;
        border: 1.5px solid var(--border);
        padding: 16px;
        font-size: 14px;
        font-family: 'Inter', sans-serif;
        color: var(--text);
        background: #fafbfc;
        transition: all 0.25s ease;
        outline: none;
        resize: vertical;
        line-height: 1.7;
        box-sizing: border-box;
    }

    .form-textarea::placeholder {
        color: #94a3b8;
    }

    .form-textarea:focus {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 3px rgba(111, 45, 189, 0.1);
    }

    .form-hint {
        font-size: 12px;
        color: var(--text-light);
        margin-top: 8px;
    }

    .char-counter {
        font-size: 12px;
        color: var(--text-light);
        text-align: right;
        margin-top: 6px;
    }

    .char-counter.warning { color: #f59e0b; }
    .char-counter.danger { color: #dc2626; }

    /* ── Error Alert ── */
    .alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 14px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: 500;
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

    /* ── Action Buttons ── */
    .btn-row {
        display: flex;
        justify-content: flex-end;
        gap: 14px;
        margin-top: 28px;
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

    @media (max-width: 768px) {
        .form-body { padding: 24px 20px; }
        .form-card-header { padding: 20px; }
        .btn-row { flex-direction: column; }
        .btn-cancel, .btn-submit { width: 100%; justify-content: center; }
    }
</style>

<div class="careplan-page">
    <div class="breadcrumb">
        Portal &gt; <a href="{{ route('careplans.select') }}">Care Plans</a> &gt;
        <a href="{{ route('careplans.index', ['patientId' => $patient->id]) }}">{{ $patient->full_name }}</a> &gt; Add Note
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title">Add Care Note</h1>
            <p class="page-subtitle">
                Document clinical observations, progress updates, or care plan adjustments for this participant.
            </p>
        </div>
    </div>

    <div class="form-card">
        <div class="form-card-header">
            <div class="form-card-header-icon">📝</div>
            <div>
                <h2>New Care Note</h2>
                <p>This note will be added to the participant's clinical record</p>
            </div>
        </div>

        <div class="form-body">
            {{-- Patient Badge --}}
            <div class="patient-badge">
                <div class="patient-badge-avatar">
                    {{ strtoupper(substr($patient->full_name, 0, 2)) }}
                </div>
                <div>
                    <div class="patient-badge-name">{{ $patient->full_name }}</div>
                    <div class="patient-badge-id">ID: #{{ $patient->patient_code }}</div>
                </div>
            </div>

            @if($errors->any())
                <div class="alert-error">
                    ⚠️ Please fix the errors below and try again.
                </div>
            @endif

            <form action="{{ route('careplans.store', ['patientId' => $patient->id]) }}" method="POST">
                @csrf

                <div>
                    <label class="form-label">Care Note <span class="required">*</span></label>
                    <textarea
                        name="note"
                        id="noteInput"
                        class="form-textarea"
                        placeholder="Describe clinical observations, care activities, progress updates, or any relevant notes for this participant..."
                        maxlength="1000"
                        oninput="updateCharCount()"
                    >{{ old('note') }}</textarea>
                    @error('note')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                    <div class="char-counter" id="charCounter">0 / 1000 characters</div>
                </div>

                <div class="btn-row">
                    <a href="{{ route('careplans.index', ['patientId' => $patient->id]) }}" class="btn-cancel">← Cancel</a>
                    <button type="submit" class="btn-submit">Save Care Note →</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateCharCount() {
        const textarea = document.getElementById('noteInput');
        const counter = document.getElementById('charCounter');
        const len = textarea.value.length;
        counter.textContent = len + ' / 1000 characters';
        counter.className = 'char-counter' + (len > 900 ? ' danger' : (len > 700 ? ' warning' : ''));
    }
    // Initialize on page load
    updateCharCount();
</script>
@endsection