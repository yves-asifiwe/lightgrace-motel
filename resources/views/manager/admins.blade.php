@extends('layouts.app')

@section('title', 'Lightgrace Manager - Administrators')
@section('page-title', 'Manage Administrators')

@section('content')
<div class="hero-section">
    <div class="hero-content">
        <h1>Administrators</h1>
        <p>Manage system administrators and their roles</p>
    </div>
</div>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="section-header">
        <h2>All Administrators ({{ $admins->count() }})</h2>
        <a href="{{ route('admin.settings') }}" class="btn btn-primary">Add New Admin</a>
    </div>

    @if($admins->count() > 0)
    <div class="admin-grid">
        @foreach($admins as $admin)
        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-avatar">
                    {{ strtoupper(substr($admin->name, 0, 1)) }}
                </div>
                <div class="admin-info">
                    <h3>{{ $admin->name }}</h3>
                    <p>{{ $admin->email }}</p>
                </div>
            </div>
            <div class="admin-card-body">
                <div class="admin-details">
                    <div class="detail-item">
                        <span class="detail-label">Role:</span>
                        <span class="detail-value">
                            <span class="role-badge role-{{ $admin->role }}">{{ ucfirst($admin->role) }}</span>
                        </span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Created:</span>
                        <span class="detail-value">{{ $admin->created_at ? $admin->created_at->format('M d, Y') : 'N/A' }}</span>
                    </div>
                </div>
                <div class="admin-actions">
                    @if($admin->role !== 'manager' || auth()->user()->role === 'manager')
                    <form action="{{ route('admin.delete', $admin) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-delete" onclick="return confirm('Are you sure you want to delete this administrator?')">Delete</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state">
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
        </svg>
        <h3>No Administrators Found</h3>
        <p>Add administrators to manage the system.</p>
        <a href="{{ route('admin.settings') }}" class="btn btn-primary">Add First Admin</a>
    </div>
    @endif
</div>

<style>
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .admin-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
    }

    .admin-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(13, 74, 53, 0.15);
        transition: all 0.3s;
        border: 1px solid #e8f5e9;
    }

    .admin-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(13, 74, 53, 0.25);
        border-color: #38ef7d;
    }

    .admin-card-header {
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        background: linear-gradient(135deg, #0d4a35 0%, #1a6b4f 100%);
        color: white;
    }

    .admin-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        font-weight: bold;
    }

    .admin-info h3 {
        margin: 0;
        font-size: 1.2rem;
    }

    .admin-info p {
        margin: 0.25rem 0 0 0;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .admin-card-body {
        padding: 1.5rem;
    }

    .admin-details {
        margin-bottom: 1rem;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid #e8f5e9;
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .detail-label {
        color: #666;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .detail-value {
        color: #0d4a35;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .role-badge {
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .role-admin {
        background: rgba(56, 239, 125, 0.2);
        color: #38ef7d;
    }

    .role-manager {
        background: rgba(255, 193, 7, 0.2);
        color: #ffc107;
    }

    .role-recipient {
        background: rgba(13, 74, 53, 0.2);
        color: #0d4a35;
    }

    .admin-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e8f5e9;
    }
</style>
@endsection
