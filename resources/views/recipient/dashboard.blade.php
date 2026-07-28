@extends('layouts.app')

@section('title', 'Lightgrace Recipient - Dashboard')
@section('page-title', 'Recipient Dashboard')

@section('content')
<div class="hero-section">
    <div class="hero-content">
        <h1>Recipient Dashboard</h1>
        <p>View bookings and manage reservations</p>
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
        <h2>Overview</h2>
    </div>

    <div class="stats-grid">
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
                <p>Available Rooms</p>
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
                <h3>{{ $paidBookings }}</h3>
                <p>Paid Bookings</p>
            </div>
        </div>
    </div>

    <div class="section-header">
        <h2>Recent Bookings</h2>
        <a href="{{ route('admin.bookings') }}" class="btn btn-primary">View All Bookings</a>
    </div>

    @if($bookings->count() > 0)
    <div class="bookings-grid">
        @foreach($bookings->take(6) as $booking)
        <div class="booking-card">
            <div class="booking-card-header">
                <h3>{{ $booking->room->name ?? 'Unknown Room' }}</h3>
                <span class="booking-status status-{{ $booking->booking_status }}">{{ ucfirst($booking->booking_status) }}</span>
            </div>
            <div class="booking-card-body">
                <div class="booking-info">
                    <div class="info-item">
                        <span class="info-label">Customer:</span>
                        <span class="info-value">{{ $booking->customer_name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Check-in:</span>
                        <span class="info-value">{{ $booking->check_in ? $booking->check_in->format('M d, Y') : 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Check-out:</span>
                        <span class="info-value">{{ $booking->check_out ? $booking->check_out->format('M d, Y') : 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Total Price:</span>
                        <span class="info-value">${{ number_format($booking->total_price, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state">
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" viewBox="0 0 16 16">
            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
        </svg>
        <h3>No Bookings Found</h3>
        <p>Bookings will appear here once customers start making reservations.</p>
    </div>
    @endif

    <!-- Password Change Section -->
    <div class="section-header">
        <h2>Account Settings</h2>
    </div>

    <div class="form-container">
        <div class="section-header">
            <h3>Change Password</h3>
        </div>
        <form action="{{ route('profile.update') }}" method="post" class="room-form">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password" placeholder="Enter current password" required/>
            </div>
            
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" placeholder="Enter new password" required/>
            </div>
            
            <div class="form-group">
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password" required/>
            </div>
            
            <button type="submit" class="btn btn-primary">Update Password</button>
        </form>
    </div>
</div>

<style>
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
@endsection
