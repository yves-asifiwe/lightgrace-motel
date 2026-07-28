@extends('layouts.app')

@section('title', 'Lightgrace Admin - Customers')
@section('page-title', 'Customers')

@section('content')
<div class="hero-section">
    <div class="hero-content">
        <h1>Customers Management</h1>
        <p>Manage customer information</p>
    </div>
</div>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="section-header">
        <h2>All Customers ({{ $customers->count() }})</h2>
    </div>

    @if($customers->count() > 0)
    <div class="customers-table-wrapper">
        <table class="customers-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Total Bookings</th>
                    <th>Total Spent</th>
                    <th>Last Booking</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $index => $customer)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="customer-name-cell">
                            <div class="customer-avatar">
                                {{ strtoupper(substr($customer->customer_name, 0, 1)) }}
                            </div>
                            <span>{{ $customer->customer_name }}</span>
                        </div>
                    </td>
                    <td>{{ $customer->customer_email }}</td>
                    <td>{{ $customer->customer_phone ?? 'N/A' }}</td>
                    <td>
                        <span class="badge badge-bookings">{{ $customer->total_bookings }}</span>
                    </td>
                    <td class="amount">{{ number_format($customer->total_spent) }} RWF</td>
                    <td>{{ $customer->last_booking_date ? \Carbon\Carbon::parse($customer->last_booking_date)->format('M d, Y') : 'N/A' }}</td>
                    <td>
                        <span class="status-dot active"></span> Active
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="empty-state">
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" viewBox="0 0 16 16">
            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
        </svg>
        <h3>No Customers Found</h3>
        <p>Customer information will appear here once bookings are created.</p>
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

    .customers-table-wrapper {
        overflow-x: auto;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(13, 74, 53, 0.12);
        border: 1px solid #e8f5e9;
    }

    .customers-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.92rem;
    }

    .customers-table thead {
        background: linear-gradient(135deg, #0d4a35 0%, #1a6b4f 100%);
        color: white;
    }

    .customers-table thead th {
        padding: 1rem 1.2rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .customers-table tbody tr {
        border-bottom: 1px solid #e8f5e9;
        transition: all 0.2s;
    }

    .customers-table tbody tr:last-child {
        border-bottom: none;
    }

    .customers-table tbody tr:hover {
        background: #f0faf4;
    }

    .customers-table tbody td {
        padding: 1rem 1.2rem;
        color: #374151;
    }

    .customer-name-cell {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .customer-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0d4a35, #38ef7d);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .badge-bookings {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 28px;
        padding: 0.2rem 0.6rem;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 700;
        background: #e8f5e9;
        color: #0d4a35;
    }

    .amount {
        font-weight: 700;
        color: #0d4a35;
    }

    .status-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-right: 0.4rem;
    }

    .status-dot.active {
        background: #38ef7d;
        box-shadow: 0 0 6px rgba(56, 239, 125, 0.5);
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
