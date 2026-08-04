@extends('layouts.app')

@section('title', 'Lightgrace Admin - Rooms Management')
@section('page-title', 'Rooms Management')

@section('content')
<div class="hero-section">
    <div class="hero-content">
        <h1>Rooms Management</h1>
        <p>Manage all hotel rooms</p>
    </div>
</div>

<div class="container">
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
        <a href="{{ route('rooms.create') }}" class="btn btn-primary">Add New Room</a>
    </div>

    @if($rooms->count() > 0)
    <div class="rooms-grid">
        @foreach($rooms as $room)
        <div class="room-card">
            @php
                // Determine image URL with fallbacks:
                // 1) storage disk public/rooms/<filename>
                // 2) legacy public/uploads/rooms/<filename>
                // 3) placeholder image
                $imageUrl = asset('images/placeholder-room.png');
                if ($room->image) {
                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists('rooms/' . $room->image)) {
                        $imageUrl = asset('storage/rooms/' . $room->image);
                    } elseif (file_exists(public_path('uploads/rooms/' . $room->image))) {
                        $imageUrl = asset('uploads/rooms/' . $room->image);
                    }
                }
            @endphp

            <div class="room-image">
                <img src="{{ $imageUrl }}" alt="{{ $room->name }}">
            </div>

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
                    <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-sm btn-edit">Edit</a>
                    <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" style="display: inline;">
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
            <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.[...]"/>
        </svg>
        <h3>No Rooms Found</h3>
        <p>Get started by adding your first room from the dashboard.</p>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Add First Room</a>
    </div>
    @endif
</div>

<style>
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
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
