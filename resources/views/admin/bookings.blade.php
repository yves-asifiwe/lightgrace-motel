@extends('layouts.app')

@section('title', 'Lightgrace Admin - Bookings')
@section('page-title', 'Bookings')

@section('content')
<div class="hero-section">
    <div class="hero-content">
        <h1>Bookings Management</h1>
        <p>Manage all room reservations</p>
    </div>
</div>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Recent Bookings Section -->
    @if($recentBookings->count() > 0)
    <div class="recent-section">
        <div class="section-header">
            <h2>Recent Bookings</h2>
        </div>
        <div class="recent-bookings">
            @foreach($recentBookings as $booking)
            <div class="recent-booking-card">
                <div class="recent-booking-info">
                    <div class="recent-room-name">{{ $booking->room->name ?? 'Unknown Room' }}</div>
                    <div class="recent-customer">{{ $booking->customer_name }}</div>
                    <div class="recent-dates">
                        {{ $booking->check_in ? $booking->check_in->format('M d') : 'N/A' }} - {{ $booking->check_out ? $booking->check_out->format('M d') : 'N/A' }}
                    </div>
                </div>
                <div class="recent-booking-status">
                    <span class="status-badge status-{{ $booking->booking_status }}">{{ ucfirst($booking->booking_status) }}</span>
                    <span class="payment-badge payment-{{ $booking->payment_status }}">{{ ucfirst($booking->payment_status) }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="section-header">
        <h2>All Bookings ({{ $bookings->count() }})</h2>
        <a href="{{ route('bookings.create') }}" class="btn btn-primary">Create New Booking</a>
    </div>

    @if($bookings->count() > 0)
    <div class="bookings-grid">
        @foreach($bookings as $booking)
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
                        <span class="info-label">Email:</span>
                        <span class="info-value">{{ $booking->customer_email }}</span>
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
                        <span class="info-value">{{ number_format($booking->total_price) }} RWF</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Payment:</span>
                        <span class="info-value payment-{{ $booking->payment_status }}">{{ ucfirst($booking->payment_status) }}</span>
                    </div>
                </div>
                <div class="booking-actions">
                    <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-view">View Details</a>
                    <form action="{{ route('bookings.destroy', $booking) }}" method="post" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-delete" onclick="return confirm('Are you sure you want to delete this booking?')">Delete</button>
                    </form>
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
        <a href="{{ route('bookings.create') }}" class="btn btn-primary">Create First Booking</a>
    </div>
    @endif
</div>

<style>
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .recent-section {
        margin-bottom: 3rem;
    }

    .recent-bookings {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1rem;
    }

    .recent-booking-card {
        background: white;
        border-radius: 8px;
        padding: 1rem;
        border: 1px solid #e8f5e9;
        box-shadow: 0 2px 8px rgba(13, 74, 53, 0.1);
        transition: all 0.3s;
    }

    .recent-booking-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(13, 74, 53, 0.2);
        border-color: #38ef7d;
    }

    .recent-booking-info {
        margin-bottom: 0.75rem;
    }

    .recent-room-name {
        font-weight: 600;
        color: #0d4a35;
        font-size: 1rem;
        margin-bottom: 0.25rem;
    }

    .recent-customer {
        color: #666;
        font-size: 0.85rem;
        margin-bottom: 0.25rem;
    }

    .recent-dates {
        color: #888;
        font-size: 0.8rem;
    }

    .recent-booking-status {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .status-badge {
        padding: 0.2rem 0.6rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .payment-badge {
        padding: 0.2rem 0.6rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .bookings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
    }

    .booking-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(13, 74, 53, 0.15);
        transition: all 0.3s;
        border: 1px solid #e8f5e9;
    }

    .booking-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(13, 74, 53, 0.25);
        border-color: #38ef7d;
    }

    .booking-card-header {
        background: linear-gradient(135deg, #0d4a35 0%, #1a6b4f 100%);
        color: white;
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .booking-card-header h3 {
        margin: 0;
        font-size: 1.2rem;
    }

    .booking-status {
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-confirmed {
        background: rgba(56, 239, 125, 0.2);
        color: #38ef7d;
    }

    .status-pending {
        background: rgba(255, 193, 7, 0.2);
        color: #ffc107;
    }

    .status-cancelled {
        background: rgba(220, 53, 69, 0.2);
        color: #dc3545;
    }

    .status-completed {
        background: rgba(13, 74, 53, 0.2);
        color: #0d4a35;
    }

    .booking-card-body {
        padding: 1.5rem;
    }

    .booking-info {
        margin-bottom: 1rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid #e8f5e9;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        color: #666;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .info-value {
        color: #0d4a35;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .payment-pending {
        color: #ffc107;
    }

    .payment-paid {
        color: #38ef7d;
    }

    .payment-cancelled {
        color: #dc3545;
    }

    .booking-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e8f5e9;
    }

    .btn-view {
        background: #0d4a35;
        color: white;
        border: 1px solid #38ef7d;
    }

    .btn-view:hover {
        background: #1a6b4f;
    }
</style>
@endsection
