@extends('layouts.app')

@section('title', 'Lightgrace Manager - Dashboard')
@section('page-title', 'Manager Dashboard')

@section('content')
<div class="hero-section">
    <div class="hero-content">
        <h1>Manager Dashboard</h1>
        <p>Manage administrators, rooms, and system settings</p>
    </div>
</div>

<div class="container">
    <!-- Dashboard Menu -->
    <div class="dashboard-menu">
        <a href="{{ route('manager.dashboard') }}" class="menu-item active">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H2z"/>
                <path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5z"/>
            </svg>
            Dashboard
        </a>
        <a href="{{ route('manager.rooms') }}" class="menu-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
            </svg>
            Room Management
        </a>
        <a href="{{ route('manager.admins') }}" class="menu-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
            </svg>
            Manage Admins
        </a>
    </div>

    <div class="section-header">
        <h2>Overview</h2>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
            </div>
            <div class="stat-content">
                <h3>{{ $admins->count() }}</h3>
                <p>Total Admins</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M2.5 3.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-11zm2-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM0 13a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1v-2zm1 0v2h14v-2H1zm8.5-8.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5h-5a.5.5 0 0 1-.5-.5v-3zM11 5h4v2h-4V5zm-5 3.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-.5.5h-5a.5.5 0 0 1-.5-.5v-5zm1 0v4h4v-4H7z"/>
                </svg>
            </div>
            <div class="stat-content">
                <h3>{{ $bookings->count() }}</h3>
                <p>Total Bookings</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
            </div>
            <div class="stat-content">
                <h3>{{ $rooms->count() }}</h3>
                <p>Total Rooms</p>
            </div>
        </div>
    </div>

    <div class="section-header">
        <h2>Administrators</h2>
        <a href="{{ route('manager.admins') }}" class="btn btn-primary">Manage Admins</a>
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
                <div class="admin-role">
                    <span class="role-badge role-{{ $admin->role }}">{{ ucfirst($admin->role) }}</span>
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
    </div>
    @endif
</div>

<style>
    .admin-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
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
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: bold;
    }

    .admin-info h3 {
        margin: 0;
        font-size: 1.1rem;
    }

    .admin-info p {
        margin: 0.25rem 0 0 0;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .admin-card-body {
        padding: 1rem;
    }

    .admin-role {
        display: flex;
        justify-content: center;
    }

    .role-badge {
        padding: 0.4rem 1rem;
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

    .dashboard-menu {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .menu-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: white;
        border-radius: 8px;
        text-decoration: none;
        color: #666;
        font-weight: 500;
        border: 1px solid #e8f5e9;
        transition: all 0.3s;
        box-shadow: 0 2px 8px rgba(13, 74, 53, 0.1);
    }

    .menu-item:hover {
        background: #f0fdf4;
        border-color: #38ef7d;
        color: #0d4a35;
        transform: translateY(-2px);
    }

    .menu-item.active {
        background: linear-gradient(135deg, #0d4a35 0%, #1a6b4f 100%);
        color: white;
        border-color: #38ef7d;
    }

    .menu-item svg {
        flex-shrink: 0;
    }
</style>
@endsection
