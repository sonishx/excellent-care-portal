@extends('layouts.app')

@section('title', 'User Invitations - Excellent Care Services')

@section('content')
<div class="dashboard-page">
    <div class="breadcrumb">Settings > User Management > Invitations</div>

    <div class="page-header">
        <div>
            <h1 class="page-title">User Invitations</h1>
            <p class="page-subtitle">Invite new staff or participants to the portal securely.</p>
        </div>
    </div>

    <div class="dashboard-layout">
        <div class="card">
            <h3 class="panel-title mb-4">Send New Invitation</h3>
            
            <form action="{{ route('invitations.store') }}" method="POST">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Email Address</label>
                    <input type="email" name="email" class="search-box" style="width: 100%;" placeholder="user@example.com" required>
                </div>

                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Assigned Role</label>
                    <select name="role" class="search-box" style="width: 100%;" required>
                        <option value="caregiver">Caregiver</option>
                        <option value="clinician">Clinician</option>
                        <option value="patient">Patient</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%;">Generate Invitation Link</button>
            </form>

            @if(session('success'))
                <div style="margin-top: 20px; padding: 15px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; font-size: 13px; color: #166534;">
                    <strong>Success!</strong> {{ session('success') }}
                </div>
            @endif
        </div>

        <div class="card">
            <h3 class="panel-title mb-4">Invitation History</h3>
            
            <div style="display: flex; flex-direction: column; gap: 15px;">
                @forelse($invitations as $invite)
                    <div style="padding: 15px; border: 1px solid var(--border); border-radius: 12px; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <div style="font-weight: 600; font-size: 14px;">{{ $invite->email }}</div>
                            <div style="font-size: 12px; color: var(--text-light);">
                                Role: {{ ucfirst($invite->role) }} | Expires: {{ $invite->expires_at->format('M d') }}
                            </div>
                            <div style="margin-top: 5px;">
                                @if($invite->isUsed())
                                    <span class="badge badge-success">Registered</span>
                                @elseif($invite->isExpired())
                                    <span class="badge" style="background: #fee2e2; color: #ef4444;">Expired</span>
                                @else
                                    <span class="badge badge-primary">Pending</span>
                                @endif
                            </div>
                        </div>
                        
                        @if(!$invite->isUsed())
                            <form action="{{ route('invitations.destroy', $invite->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #ef4444; font-size: 12px; cursor: pointer; font-weight: 600;">Revoke</button>
                            </form>
                        @endif
                    </div>
                @empty
                    <p style="text-align: center; color: var(--text-light); font-size: 14px;">No invitations sent yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
