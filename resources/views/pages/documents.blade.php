@extends('layouts.app')

@section('title', 'Documents & Media - Excellent Care Services')

@section('content')
<style>
/* Page-specific CSS for Documents page */
.documents-page {
    min-height: 100vh;
    background: #f5f7fb;
}

.documents-container {
    max-width: 1200px;
    margin: 30px auto;
    padding: 0 20px;
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
    flex-wrap: wrap;
    gap: 14px;
    margin-bottom: 22px;
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

.secure-note {
    font-size: 13px;
    color: #16a34a;
    margin-top: 8px;
}

.content-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 20px;
    align-items: start;
}

.panel {
    background: white;
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 6px 18px rgba(15, 23, 42, 0.04);
}

.drop-zone {
    border: 2px dashed #d7dee8;
    border-radius: 14px;
    padding: 30px 20px;
    text-align: center;
    margin-bottom: 18px;
    background: #fcfdff;
}

.drop-icon {
    width: 54px;
    height: 54px;
    border-radius: 50%;
    background: #eaf2ff;
    color: #2563eb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin: 0 auto 14px;
}

.browse-btn {
    margin-top: 14px;
    background: #eef4ff;
    color: #2563eb;
    border: none;
    border-radius: 8px;
    padding: 10px 16px;
    font-size: 13px;
    font-weight: 600;
}

.tab-filter-row {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 16px;
}

.tabs {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.tab-btn {
    border: 1px solid #dbe2ea;
    background: white;
    border-radius: 999px;
    padding: 8px 14px;
    font-size: 12px;
    color: #4b5563;
}

.tab-btn.active {
    background: #1f6ef2;
    color: white;
    border-color: #1f6ef2;
}

.filter-box {
    width: 220px;
    height: 38px;
    border: 1px solid #dbe2ea;
    border-radius: 10px;
    padding: 0 12px;
    font-size: 13px;
}

.file-table {
    width: 100%;
    border-collapse: collapse;
}

.file-table th,
.file-table td {
    padding: 14px 10px;
    font-size: 13px;
    border-bottom: 1px solid #eef2f7;
    text-align: left;
    vertical-align: middle;
}

.file-table th {
    color: #6b7280;
    font-size: 12px;
    text-transform: uppercase;
}

.file-name {
    font-weight: 600;
    color: #111827;
}

.file-sub {
    font-size: 11px;
    color: #9ca3af;
}

.side-card {
    background: white;
    border-radius: 14px;
    padding: 18px;
    box-shadow: 0 6px 18px rgba(15, 23, 42, 0.04);
    margin-bottom: 18px;
}

.side-title {
    font-size: 15px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 12px;
}

.status-item {
    font-size: 13px;
    margin-bottom: 12px;
}

.status-item:last-child {
    margin-bottom: 0;
}

.status-green {
    color: #16a34a;
    font-weight: 600;
}

.status-blue {
    color: #2563eb;
    font-weight: 600;
}

.storage-bar {
    height: 10px;
    border-radius: 999px;
    background: #e5e7eb;
    overflow: hidden;
    margin: 10px 0 14px;
}

.storage-fill {
    width: 48%;
    height: 100%;
    background: #2563eb;
}

.storage-item {
    font-size: 13px;
    color: #6b7280;
    margin-bottom: 6px;
}

.upgrade-btn {
    width: 100%;
    border: 1px solid #dbe2ea;
    background: white;
    border-radius: 10px;
    padding: 10px;
    font-size: 13px;
    font-weight: 600;
    color: #2563eb;
    margin-top: 10px;
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

.error-text {
    color: #dc2626;
    font-size: 12px;
    margin-top: 8px;
}

.action-btn {
    display: inline-block;
    margin-right: 6px;
    text-decoration: none;
    font-size: 12px;
    color: #2563eb;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
}

.delete-btn {
    color: #ef4444;
}

@media (max-width: 992px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="documents-page">
    <div class="documents-container">
        <div class="breadcrumb">Home &nbsp; / &nbsp; My Portal &nbsp; / &nbsp; Documents & Media</div>

        <div class="page-title-row">
            <div>
                <div class="page-title">Documents & Media</div>
                <div class="page-subtitle">Manage uploaded NDIS plans, medical reports, and secure documentation.</div>
                <div class="secure-note">● HIPAA & Privacy Act Compliant Storage</div>
            </div>
        </div>

        @if(session('success'))
            <div class="flash-success">{{ session('success') }}</div>
        @endif

        <div class="content-grid">
            <div class="panel">
                <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="drop-zone">
                        <div class="drop-icon">📄</div>
                        <div class="fw-semibold mb-1">Upload a document</div>
                        <div class="text-muted" style="font-size: 13px;">
                            Upload NDIS plans, medical reports, or incident photos.<br>
                            Supported formats: PDF, JPG, JPEG, PNG. Max size 25MB.
                        </div>

                        <input type="file" name="document_file" class="form-control mt-3">

                        @error('document_file')
                            <div class="error-text">{{ $message }}</div>
                        @enderror

                        <button type="submit" class="browse-btn">Upload File</button>
                    </div>
                </form>

                <div class="tab-filter-row">
                    <div class="tabs">
                        <button class="tab-btn active" type="button">All Files</button>
                        <button class="tab-btn" type="button">Documents</button>
                        <button class="tab-btn" type="button">Images</button>
                    </div>

                    <input type="text" class="filter-box" placeholder="Filter files...">
                </div>

                <table class="file-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date Added</th>
                            <th>Size</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $document)
                            <tr>
                                <td>
                                    <div class="file-name">{{ $document->file_name }}</div>
                                    <div class="file-sub">Uploaded by {{ $document->uploaded_by }}</div>
                                </td>
                                <td>{{ $document->created_at ? $document->created_at->format('d M Y') : 'N/A' }}</td>
                                <td>{{ $document->file_size }}</td>
                                <td>
                                    <a href="{{ route('documents.download', $document->id) }}" class="action-btn">Download</a>
                                    <form method="POST" action="{{ route('documents.delete', $document->id) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="action-btn delete-btn">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">No uploaded documents found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>
                <div class="side-card">
                    <div class="side-title">Upload Status</div>
                    <div class="status-item">
                        <strong>Current session upload</strong><br>
                        <span class="text-muted">Uploaded files will appear in the table instantly after saving.</span><br>
                        <span class="status-green">READY</span>
                    </div>

                    <div class="status-item">
                        <strong>Allowed formats</strong><br>
                        <span class="text-muted">PDF, JPG, JPEG, PNG</span><br>
                        <span class="status-blue">SUPPORTED</span>
                    </div>

                    <div class="status-item">
                        <strong>Security check</strong><br>
                        <span class="text-muted">Files are stored in protected application storage.</span><br>
                        <span class="status-green">ENABLED</span>
                    </div>
                </div>

                <div class="side-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="side-title mb-0">Storage Usage</div>
                        <div class="text-muted" style="font-size: 12px;">Demo Value</div>
                    </div>

                    <div class="storage-bar">
                        <div class="storage-fill"></div>
                    </div>

                    <div class="storage-item">Documents &nbsp;&nbsp; Active</div>
                    <div class="storage-item">Images &nbsp;&nbsp; Active</div>
                    <div class="storage-item">Videos &nbsp;&nbsp; Not enabled</div>

                    <button class="upgrade-btn" type="button">Storage Plan Placeholder</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection