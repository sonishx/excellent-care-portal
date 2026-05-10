@extends('layouts.app')

@section('title', 'Care Plans for ' . $patient->full_name)

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
        margin-bottom: 30px;
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

    /* ── Patient Info Bar ── */
    .patient-info-bar {
        background: linear-gradient(135deg, #6f2dbd 0%, #a29bfe 60%, #f45d75 100%);
        border-radius: 16px;
        padding: 24px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .patient-info-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .patient-info-avatar {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
        color: white;
        font-size: 18px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .patient-info-name {
        font-size: 20px;
        font-weight: 700;
        color: white;
    }

    .patient-info-id {
        font-size: 13px;
        color: rgba(255, 255, 255, 0.75);
        margin-top: 2px;
    }

    .btn-add-note {
        background: white;
        color: var(--primary);
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        font-size: 14px;
        font-weight: 700;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
    }

    .btn-add-note:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        color: var(--primary);
    }

    /* ── Success Alert ── */
    .alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
        padding: 14px 20px;
        border-radius: 12px;
        margin-bottom: 24px;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* ── Notes List ── */
    .notes-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .note-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 24px;
        transition: all 0.2s;
        position: relative;
    }

    .note-card:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    }

    .note-content {
        font-size: 15px;
        color: var(--text);
        line-height: 1.7;
        margin-bottom: 16px;
    }

    .note-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .note-meta {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .note-author-avatar {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: linear-gradient(135deg, #6f2dbd 0%, #a29bfe 100%);
        color: white;
        font-size: 12px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .note-author-name {
        font-size: 13px;
        font-weight: 600;
        color: var(--text);
    }

    .note-date {
        font-size: 12px;
        color: var(--text-light);
    }

    .btn-delete-note {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #dc2626;
        font-size: 12px;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 8px;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        transition: all 0.2s;
    }

    .btn-delete-note:hover {
        background: #fee2e2;
        border-color: #f87171;
    }

    /* ── Empty State ── */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 16px;
        border: 1.5px dashed var(--border);
    }

    .empty-state-icon { font-size: 48px; margin-bottom: 16px; }
    .empty-state-title { font-size: 18px; font-weight: 700; color: var(--text); margin-bottom: 8px; }
    .empty-state-text { font-size: 14px; color: var(--text-light); margin-bottom: 20px; }

    .btn-empty-add {
        background: linear-gradient(135deg, #6f2dbd 0%, #a29bfe 100%);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        font-size: 14px;
        font-weight: 700;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.25s;
        box-shadow: 0 4px 14px rgba(111, 45, 189, 0.25);
    }

    .btn-empty-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(111, 45, 189, 0.35);
        color: white;
    }

    /* ── Notes Count ── */
    .notes-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .notes-count-label {
        font-size: 14px;
        color: var(--text-light);
        font-weight: 500;
    }

    .notes-count-badge {
        background: rgba(111, 45, 189, 0.1);
        color: var(--primary);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
    }
</style>

<div class="careplan-page">
    <div class="breadcrumb">
        Portal &gt; <a href="{{ route('careplans.select') }}">Care Plans</a> &gt; {{ $patient->full_name }}
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title">Care Notes</h1>
            <p class="page-subtitle">
                Clinical notes and care documentation for this participant's ongoing support plan.
            </p>
        </div>
    </div>

    {{-- Patient Info Banner --}}
    <div class="patient-info-bar">
        <div class="patient-info-left">
            <div class="patient-info-avatar">
                {{ strtoupper(substr($patient->full_name, 0, 2)) }}
            </div>
            <div>
                <div class="patient-info-name">{{ $patient->full_name }}</div>
                <div class="patient-info-id">Patient ID: #{{ $patient->patient_code }}</div>
            </div>
        </div>
        <a href="{{ route('careplans.create', ['patientId' => $patient->id]) }}" class="btn-add-note">
            + Add Care Note
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if($careNotes->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">📝</div>
            <div class="empty-state-title">No Care Notes Yet</div>
            <div class="empty-state-text">Start documenting this participant's care journey by adding the first note.</div>
            <a href="{{ route('careplans.create', ['patientId' => $patient->id]) }}" class="btn-empty-add">
                + Add First Care Note
            </a>
        </div>
    @else
        <div class="notes-header">
            <span class="notes-count-label">Showing all care notes</span>
            <span class="notes-count-badge">{{ $careNotes->count() }} {{ Str::plural('note', $careNotes->count()) }}</span>
        </div>

        <div class="notes-list">
            @foreach($careNotes as $note)
                <div class="note-card">
                    <div class="note-content">{{ $note->note }}</div>
                    <div class="note-footer">
                        <div class="note-meta">
                            <div class="note-author-avatar">
                                {{ strtoupper(substr($note->user->name ?? 'U', 0, 2)) }}
                            </div>
                            <div>
                                <div class="note-author-name">{{ $note->user->name ?? 'Unknown' }}</div>
                                <div class="note-date">{{ $note->created_at->format('d M Y, H:i') }}</div>
                            </div>
                        </div>
                        @if($note->user_id === auth()->id())
                            <form action="{{ route('careplans.destroy', ['patientId' => $patient->id, 'id' => $note->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete-note">🗑 Delete</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection