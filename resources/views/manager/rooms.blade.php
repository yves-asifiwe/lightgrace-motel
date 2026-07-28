@extends('layouts.app')

@section('title', 'Lightgrace Manager - Rooms Management')
@section('page-title', 'Rooms Management')

@section('content')
<div class="hero-section">
    <div class="hero-content">
        <h1>Rooms Management</h1>
        <p>Manage all hotel rooms</p>
    </div>
</div>

<div class="container">
    <!-- Dashboard Menu -->
    <div class="dashboard-menu">
        <a href="{{ route('manager.dashboard') }}" class="menu-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H2z"/>
                <path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5z"/>
            </svg>
            Dashboard
        </a>
        <a href="{{ route('manager.rooms') }}" class="menu-item active">
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

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="section-header">
        <h2>All Rooms ({{ $rooms->count() }})</h2>
        <a href="{{ route('manager.rooms.create') }}" class="btn btn-primary">Add New Room</a>
    </div>

    @if($rooms->count() > 0)
    <div class="rooms-grid">
        @foreach($rooms as $room)
        <div class="room-card">
            @if($room->image)
            <div class="room-image">
                <img src="{{ asset('uploads/rooms/' . $room->image) }}" alt="{{ $room->name }}">
            </div>
            @endif
            <div class="room-card-header">
                <h3>{{ $room->name }}</h3>
                <span class="room-price">{{ number_format($room->price) }} RWF</span>
            </div>
            <div class="room-card-body">
                <p class="room-description">{{ $room->description ?: 'No description available' }}</p>
                <div class="room-details">
                    <span class="room-capacity">Capacity: {{ $room->capacity ?? '1' }} guest(s)</span>
                </div>
                <div class="room-actions">
                    <a href="{{ route('manager.rooms.edit', $room->id) }}" class="btn btn-sm btn-edit">Edit</a>
                    <form action="{{ route('manager.rooms.destroy', $room->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-delete" onclick="return confirm('Are you sure you want to delete this room?')">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state">
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.125 1.125 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
        </svg>
        <h3>No Rooms Found</h3>
        <p>Contact an admin to add rooms to the system.</p>
    </div>
    @endif
</div>

<style>
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
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

    .room-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e8f5e9;
    }

    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
    }

    .btn-edit {
        background: #0d4a35;
        color: white;
        border: 1px solid #38ef7d;
    }

    .btn-edit:hover {
        background: #1a6b4f;
    }

    .btn-delete {
        background: #dc3545;
        color: white;
        border: 1px solid #dc3545;
    }

    .btn-delete:hover {
        background: #c82333;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #666;
    }

    .empty-state svg {
        color: #38ef7d;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-state h3 {
        color: #0d4a35;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        margin-bottom: 1.5rem;
    }
</style>
@endsection
