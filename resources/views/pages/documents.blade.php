@extends('layouts.app')

@section('title', 'Documents & Media - Excellent Care Services')

@section('content')
<style>
    .documents-page { padding-bottom: 50px; }
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

    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
    }

    .upload-zone {
        border: 2px dashed var(--border);
        border-radius: 16px;
        padding: 40px 20px;
        text-align: center;
        background: #fcfdff;
        margin-bottom: 25px;
        transition: border-color 0.2s;
    }

    .upload-zone:hover {
        border-color: var(--primary);
    }

    .upload-icon {
        font-size: 32px;
        margin-bottom: 15px;
        display: block;
    }

    .file-table {
        width: 100%;
        border-collapse: collapse;
    }

    .file-table th {
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        color: var(--text-light);
        text-transform: uppercase;
        padding: 15px 10px;
        border-bottom: 1px solid var(--border);
    }

    .file-table td {
        padding: 18px 10px;
        font-size: 14px;
        color: var(--text);
        border-bottom: 1px solid var(--border);
    }

    .file-name {
        font-weight: 700;
        color: var(--text);
        display: block;
    }

    .file-meta {
        font-size: 12px;
        color: var(--text-light);
    }

    .action-btn {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        margin-right: 15px;
        background: none;
        border: none;
        cursor: pointer;
    }

    .delete-btn {
        color: var(--secondary);
    }

    .storage-card {
        padding: 24px;
    }

    .storage-bar {
        height: 10px;
        background: #f1f5f9;
        border-radius: 20px;
        overflow: hidden;
        margin: 15px 0;
    }

    .storage-fill {
        height: 100%;
        background: var(--primary);
        border-radius: 20px;
    }

    @media (max-width: 1024px) {
        .content-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="documents-page">
    <div class="breadcrumb">Portal > Documents > Storage</div>

    <div class="page-header">
        <div>
            <h1 class="page-title">Documents & Media</h1>
            <p class="page-subtitle">Securely manage NDIS plans, medical reports, and clinical evidence.</p>
            <div style="margin-top: 10px; font-size: 13px; color: #16a34a; font-weight: 600;">
                ✓ HIPAA & Privacy Act Compliant Storage Enabled
            </div>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 15px; border-radius: 12px; margin-bottom: 25px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="content-grid">
        <div class="card">
            <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="upload-zone">
                    <span class="upload-icon">📁</span>
                    <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 5px;">Upload a New Document</h3>
                    <p style="font-size: 13px; color: var(--text-light); margin-bottom: 20px;">
                        Drag and drop files here or click to browse.<br>
                        Supports PDF, JPG, PNG (Max 25MB).
                    </p>

                    <input type="file" name="document_file" style="margin-bottom: 15px;">
                    
                    @error('document_file')
                        <div style="color: var(--secondary); font-size: 12px; margin-bottom: 15px;">{{ $message }}</div>
                    @enderror

                    <div>
                        <button type="submit" class="btn-primary">Start Upload</button>
                    </div>
                </div>
            </form>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h4 style="font-size: 16px; font-weight: 700;">Recent Uploads</h4>
                <input type="text" class="search-box" style="width: 200px; height: 36px;" placeholder="Search files...">
            </div>

            <table class="file-table">
                <thead>
                    <tr>
                        <th>File Name</th>
                        <th>Uploaded On</th>
                        <th>Size</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $document)
                        <tr>
                            <td>
                                <span class="file-name">{{ $document->file_name }}</span>
                                <span class="file-meta">By {{ $document->uploaded_by }}</span>
                            </td>
                            <td>{{ $document->created_at ? $document->created_at->format('d M, Y') : 'N/A' }}</td>
                            <td>{{ $document->file_size }}</td>
                            <td style="text-align: right;">
                                <a href="{{ route('documents.download', $document->id) }}" class="action-btn">Download</a>
                                <form method="POST" action="{{ route('documents.delete', $document->id) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="action-btn delete-btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 40px; color: var(--text-light);">No documents found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            <div class="card storage-card mb-4">
                <h3 class="panel-title mb-2">Storage Overview</h3>
                <p style="font-size: 13px; color: var(--text-light);">Used for clinical evidence and plans.</p>
                
                <div class="storage-bar">
                    <div class="storage-fill" style="width: 45%;"></div>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 12px; font-weight: 600;">
                    <span>4.5 GB Used</span>
                    <span>10 GB Total</span>
                </div>
            </div>

            <div class="card">
                <h3 class="panel-title mb-3">Security & Compliance</h3>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <div style="display: flex; gap: 10px; font-size: 13px;">
                        <span style="color: #16a34a;">✔</span>
                        <span>End-to-end encryption</span>
                    </div>
                    <div style="display: flex; gap: 10px; font-size: 13px;">
                        <span style="color: #16a34a;">✔</span>
                        <span>Daily secure backups</span>
                    </div>
                    <div style="display: flex; gap: 10px; font-size: 13px;">
                        <span style="color: #16a34a;">✔</span>
                        <span>Access log auditing</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection