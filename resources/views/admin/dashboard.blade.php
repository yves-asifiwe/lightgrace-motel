@extends('layouts.app')

@section('title', 'Lightgrace Admin - Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')
<div class="hero-section">
    <div class="hero-content">
        <h1>Admin Dashboard</h1>
        <p>Welcome back, {{ auth()->user()->name }}</p>
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

    <!-- Dashboard Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon rooms">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                </svg>
            </div>
            <div class="stat-info">
                <h3>{{ \App\Models\motelmodel::count() }}</h3>
                <p>Total Rooms</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon bookings">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                </svg>
            </div>
            <div class="stat-info">
                <h3>{{ \App\Models\Booking::count() }}</h3>
                <p>Total Bookings</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon users">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                </svg>
            </div>
            <div class="stat-info">
                <h3>{{ \App\Models\User::count() }}</h3>
                <p>Total Users</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon revenue">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M5.5 10.5A.5.5 0 0 1 6 10h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"/>
                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                </svg>
            </div>
            <div class="stat-info">
                <h3>{{ number_format(\App\Models\Booking::where('payment_status', 'paid')->sum('total_price')) }} RWF</h3>
                <p>Total Revenue</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="section-header">
        <h2>Quick Actions</h2>
    </div>

    <div class="quick-actions">
        <a href="{{ route('bookings.create') }}" class="action-card">
            <div class="action-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
            </div>
            <h3>New Booking</h3>
            <p>Create a new room booking</p>
        </a>

        <a href="{{ route('rooms.create') }}" class="action-card">
            <div class="action-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                </svg>
            </div>
            <h3>Add Room</h3>
            <p>Add a new room to the hotel</p>
        </a>

        <a href="{{ route('admin.bookings') }}" class="action-card">
            <div class="action-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                </svg>
            </div>
            <h3>View Bookings</h3>
            <p>Manage all reservations</p>
        </a>

        <a href="{{ route('admin.settings') }}" class="action-card">
            <div class="action-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                </svg>
            </div>
            <h3>Settings</h3>
            <p>Configure system settings</p>
        </a>
    </div>

    <!-- Recent Activity -->
    <div class="section-header">
        <h2>Recent Activity</h2>
    </div>

    <div class="recent-activity">
        @php
            $recentBookings = \App\Models\Booking::with('room')->latest()->take(5)->get();
        @endphp
        @if($recentBookings->count() > 0)
            @foreach($recentBookings as $booking)
            <div class="activity-item">
                <div class="activity-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                    </svg>
                </div>
                <div class="activity-content">
                    <p><strong>{{ $booking->customer_name }}</strong> booked {{ $booking->room->name ?? 'Unknown Room' }}</p>
                    <span class="activity-time">{{ $booking->created_at ? $booking->created_at->diffForHumans() : 'Recently' }}</span>
                </div>
            </div>
            @endforeach
        @else
            <div class="empty-activity">
                <p>No recent activity</p>
            </div>
        @endif
    </div>
</div>

<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .stat-card {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 4px 15px rgba(13, 74, 53, 0.15);
        border: 1px solid #e8f5e9;
        transition: all 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(13, 74, 53, 0.25);
        border-color: #38ef7d;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .stat-icon.rooms {
        background: linear-gradient(135deg, #0d4a35 0%, #1a6b4f 100%);
    }

    .stat-icon.bookings {
        background: linear-gradient(135deg, #38ef7d 0%, #2dd4a0 100%);
    }

    .stat-icon.users {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .stat-icon.revenue {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .stat-info h3 {
        margin: 0;
        font-size: 1.8rem;
        color: #0d4a35;
        font-weight: 700;
    }

    .stat-info p {
        margin: 0;
        color: #666;
        font-size: 0.9rem;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 3rem;
    }

    .action-card {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
        text-align: center;
        text-decoration: none;
        color: inherit;
        box-shadow: 0 4px 15px rgba(13, 74, 53, 0.15);
        border: 1px solid #e8f5e9;
        transition: all 0.3s;
    }

    .action-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(13, 74, 53, 0.25);
        border-color: #38ef7d;
    }

    .action-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #0d4a35 0%, #1a6b4f 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #38ef7d;
        margin: 0 auto 1rem;
    }

    .action-card h3 {
        color: #0d4a35;
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }

    .action-card p {
        color: #666;
        font-size: 0.85rem;
        margin: 0;
    }

    .recent-activity {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(13, 74, 53, 0.15);
        border: 1px solid #e8f5e9;
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid #e8f5e9;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #0d4a35 0%, #1a6b4f 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #38ef7d;
        flex-shrink: 0;
    }

    .activity-content p {
        margin: 0;
        color: #0d4a35;
        font-size: 0.95rem;
    }

    .activity-time {
        display: block;
        color: #888;
        font-size: 0.8rem;
        margin-top: 0.25rem;
    }

    .empty-activity {
        text-align: center;
        padding: 2rem;
        color: #888;
    }
</style>
@endsection
