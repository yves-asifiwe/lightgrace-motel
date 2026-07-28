@extends('layouts.app')

@section('title', 'Lightgrace Admin - Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="hero-section">
    <div class="hero-content">
        <h1>Room Management</h1>
        <p>Add and manage hotel rooms</p>
    </div>
</div>

<div class="container" id="rooms">
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
        <h2>Add New Room</h2>
    </div>

    <div class="form-container">
        <form action="{{ route('motel.store') }}" method="post" class="room-form">
            @csrf
            <div class="form-group">
                <label for="name">Room Name</label>
                <input type="text" id="name" name="name" placeholder="Enter room name" required/>
            </div>
            
            <div class="form-group">
                <label for="price">Price ($)</label>
                <input type="number" id="price" name="price" placeholder="Enter price" required/>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Enter room description"></textarea>
            </div>
            
            <div class="form-group">
                <label for="capacity">Capacity</label>
                <input type="number" id="capacity" name="capacity" placeholder="Enter capacity"/>
            </div>
            
            <button type="submit" class="btn btn-primary">Add Room</button>
        </form>
    </div>

    @if($rooms && $rooms->count() > 0)
    <div class="rooms-list">
        <div class="section-header">
            <h2>Available Rooms ({{ $rooms->count() }})</h2>
        </div>
        <div class="rooms-grid">
            @foreach($rooms as $room)
            <div class="room-card">
                <div class="room-card-header">
                    <h3>{{ $room->name }}</h3>
                    <span class="room-price">${{ number_format($room->price, 2) }}</span>
                </div>
                <div class="room-card-body">
                    <p class="room-description">{{ $room->description ?: 'No description available' }}</p>
                    <div class="room-details">
                        <span class="room-capacity">Capacity: {{ $room->capacity ?? 'N/A' }} guests</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection