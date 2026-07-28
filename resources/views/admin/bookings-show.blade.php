@extends('layouts.app')

@section('title', 'Lightgrace Admin - Booking Details')
@section('page-title', 'Booking Details')

@section('content')
<div class="hero-section">
    <div class="hero-content">
        <h1>Booking Details</h1>
        <p>View booking information</p>
    </div>
</div>

<div class="container">
    <div class="section-header">
        <h2>Booking #{{ $booking->id }}</h2>
        <a href="{{ route('admin.bookings') }}" class="btn btn-secondary">Back to Bookings</a>
    </div>

    <div class="booking-details-container">
        <div class="detail-section">
            <h3>Room Information</h3>
            <div class="detail-content">
                <div class="detail-item">
                    <span class="detail-label">Room Name:</span>
                    <span class="detail-value">{{ $booking->room->name ?? 'N/A' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Room Price:</span>
                    <span class="detail-value">${{ $booking->room->price ?? '0.00' }}/night</span>
                </div>
                @if($booking->room->image)
                <div class="room-image-large">
                    <img src="{{ asset('uploads/rooms/' . $booking->room->image) }}" alt="{{ $booking->room->name }}">
                </div>
                @endif
            </div>
        </div>

        <div class="detail-section">
            <h3>Customer Information</h3>
            <div class="detail-content">
                <div class="detail-item">
                    <span class="detail-label">Name:</span>
                    <span class="detail-value">{{ $booking->customer_name }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ $booking->customer_email }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Phone:</span>
                    <span class="detail-value">{{ $booking->customer_phone ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <div class="detail-section">
            <h3>Booking Information</h3>
            <div class="detail-content">
                <div class="detail-item">
                    <span class="detail-label">Check-in Date:</span>
                    <span class="detail-value">{{ $booking->check_in ? $booking->check_in->format('F d, Y') : 'N/A' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Check-out Date:</span>
                    <span class="detail-value">{{ $booking->check_out ? $booking->check_out->format('F d, Y') : 'N/A' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Total Price:</span>
                    <span class="detail-value">${{ number_format($booking->total_price, 2) }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Booking Status:</span>
                    <span class="detail-value status-badge status-{{ $booking->booking_status }}">{{ ucfirst($booking->booking_status) }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Payment Status:</span>
                    <span class="detail-value status-badge payment-{{ $booking->payment_status }}">{{ ucfirst($booking->payment_status) }}</span>
                </div>
            </div>
        </div>

        @if($booking->notes)
        <div class="detail-section">
            <h3>Notes</h3>
            <div class="detail-content">
                <p>{{ $booking->notes }}</p>
            </div>
        </div>
        @endif

        <div class="detail-section">
            <h3>Update Status</h3>
            <form action="{{ route('bookings.update-status', $booking) }}" method="post" class="status-form">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="payment_status">Payment Status</label>
                    <select id="payment_status" name="payment_status">
                        <option value="pending" {{ $booking->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ $booking->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="cancelled" {{ $booking->payment_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="booking_status">Booking Status</label>
                    <select id="booking_status" name="booking_status">
                        <option value="pending" {{ $booking->booking_status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $booking->booking_status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ $booking->booking_status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $booking->booking_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Status</button>
            </form>
        </div>
    </div>
</div>

<style>
    .booking-details-container {
        display: grid;
        gap: 2rem;
        max-width: 800px;
    }

    .detail-section {
        background: white;
        border-radius: 8px;
        padding: 2rem;
        box-shadow: 0 4px 15px rgba(13, 74, 53, 0.15);
        border: 1px solid #e8f5e9;
    }

    .detail-section h3 {
        color: #0d4a35;
        margin-bottom: 1.5rem;
        font-size: 1.3rem;
        border-bottom: 2px solid #38ef7d;
        padding-bottom: 0.5rem;
    }

    .detail-content {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e8f5e9;
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .detail-label {
        color: #666;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .detail-value {
        color: #0d4a35;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .room-image-large {
        width: 100%;
        height: 250px;
        overflow: hidden;
        border-radius: 8px;
        margin-top: 1rem;
    }

    .room-image-large img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .status-badge {
        padding: 0.4rem 1rem;
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

    .payment-pending {
        color: #ffc107;
        background: rgba(255, 193, 7, 0.2);
    }

    .payment-paid {
        color: #38ef7d;
        background: rgba(56, 239, 125, 0.2);
    }

    .payment-cancelled {
        color: #dc3545;
        background: rgba(220, 53, 69, 0.2);
    }

    .status-form {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .status-form .form-group {
        margin-bottom: 0;
    }
</style>
@endsection
