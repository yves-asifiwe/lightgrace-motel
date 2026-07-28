@extends('layouts.app')

@section('title', 'Lightgrace Admin - Create Booking')
@section('page-title', 'Create Booking')

@section('content')
<div class="hero-section">
    <div class="hero-content">
        <h1>Create New Booking</h1>
        <p>Assign room to customer</p>
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

    <div class="form-container">
        <form action="{{ route('bookings.store') }}" method="post" class="room-form">
            @csrf

            <div class="form-group">
                <label for="check_in">Check-in Date</label>
                <input type="date" id="check_in" name="check_in" required onchange="loadAvailableRooms()"/>
            </div>

            <div class="form-group">
                <label for="check_out">Check-out Date</label>
                <input type="date" id="check_out" name="check_out" required onchange="loadAvailableRooms()"/>
            </div>

            <div class="form-group">
                <label for="room_id">Select Room</label>
                <select id="room_id" name="room_id" required onchange="updatePrice()">
                    <option value="">-- Select dates first --</option>
                </select>
                <p class="help-text">Only available rooms for selected dates will be shown</p>
            </div>

            <div class="form-group">
                <label for="customer_name">Customer Name</label>
                <input type="text" id="customer_name" name="customer_name" placeholder="Enter customer name" required/>
            </div>

            <div class="form-group">
                <label for="customer_email">Customer Email</label>
                <input type="email" id="customer_email" name="customer_email" placeholder="Enter customer email" required/>
            </div>

            <div class="form-group">
                <label for="customer_phone">Customer Phone</label>
                <input type="tel" id="customer_phone" name="customer_phone" placeholder="Enter customer phone (optional)"/>
            </div>

            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea id="notes" name="notes" placeholder="Additional notes (optional)"></textarea>
            </div>

            <div class="form-group">
                <label for="payment_status">Payment Status</label>
                <select id="payment_status" name="payment_status" required>
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                </select>
                <p class="help-text">Select "Paid" if customer has already paid</p>
            </div>

            <div class="price-summary">
                <div class="summary-item">
                    <span>Room Price:</span>
                    <span id="roomPrice">0 RWF</span>
                </div>
                <div class="summary-item">
                    <span>Nights:</span>
                    <span id="nights">0</span>
                </div>
                <div class="summary-item total">
                    <span>Total Price:</span>
                    <span id="totalPrice">0 RWF</span>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.bookings') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Booking</button>
            </div>
        </form>
    </div>
</div>

<style>
    .price-summary {
        background: #f9fbf9;
        border: 2px solid #e8f5e9;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid #e8f5e9;
    }

    .summary-item:last-child {
        border-bottom: none;
    }

    .summary-item.total {
        font-weight: 600;
        font-size: 1.1rem;
        color: #0d4a35;
        border-top: 2px solid #38ef7d;
        margin-top: 0.5rem;
        padding-top: 1rem;
    }

    .form-group input[type="date"] {
        padding: 0.8rem 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 5px;
        font-size: 1rem;
        transition: all 0.3s;
        background-color: #f9fbf9;
    }

    .form-group input[type="date"]:focus {
        outline: none;
        border-color: #38ef7d;
        background-color: white;
        box-shadow: 0 0 0 3px rgba(56, 239, 125, 0.1);
    }
</style>

<script>
    function formatRWF(amount) {
        return new Intl.NumberFormat('rw-RW', {
            style: 'currency',
            currency: 'RWF',
            minimumFractionDigits: 0
        }).format(amount);
    }

    async function loadAvailableRooms() {
        const checkIn = document.getElementById('check_in').value;
        const checkOut = document.getElementById('check_out').value;
        const roomSelect = document.getElementById('room_id');

        if (!checkIn || !checkOut) {
            return;
        }

        try {
            const response = await fetch(`{{ route('bookings.available-rooms') }}?check_in=${checkIn}&check_out=${checkOut}`, {
                headers: {
                    'Accept': 'application/json',
                }
            });

            const rooms = await response.json();

            roomSelect.innerHTML = '<option value="">-- Select a Room --</option>';

            rooms.forEach(room => {
                const option = document.createElement('option');
                option.value = room.id;
                option.setAttribute('data-price', room.price);
                option.textContent = `${room.name} - ${formatRWF(room.price)}/night`;
                roomSelect.appendChild(option);
            });

            updatePrice();
        } catch (error) {
            console.error('Error loading available rooms:', error);
        }
    }

    function updatePrice() {
        const select = document.getElementById('room_id');
        const selectedOption = select.options[select.selectedIndex];
        const price = parseFloat(selectedOption.getAttribute('data-price') || 0);
        document.getElementById('roomPrice').textContent = formatRWF(price);
        calculateTotal();
    }

    function calculateTotal() {
        const select = document.getElementById('room_id');
        const selectedOption = select.options[select.selectedIndex];
        const price = parseFloat(selectedOption.getAttribute('data-price') || 0);

        const checkIn = new Date(document.getElementById('check_in').value);
        const checkOut = new Date(document.getElementById('check_out').value);

        if (checkIn && checkOut && checkOut > checkIn) {
            const diffTime = Math.abs(checkOut - checkIn);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            const total = diffDays * price;

            document.getElementById('nights').textContent = diffDays;
            document.getElementById('totalPrice').textContent = formatRWF(total);
        } else {
            document.getElementById('nights').textContent = '0';
            document.getElementById('totalPrice').textContent = formatRWF(0);
        }
    }

    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('check_in').setAttribute('min', today);
    document.getElementById('check_out').setAttribute('min', today);
</script>
@endsection
