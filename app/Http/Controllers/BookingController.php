<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\motelmodel;
use App\Mail\BookingConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $recentBookings = Booking::with('room')->latest()->take(5)->get();
        $bookings = Booking::with('room')->latest()->get();
        return view('admin.bookings', compact('bookings', 'recentBookings'));
    }

    public function create()
    {
        return view('admin.bookings-create');
    }

    public function getAvailableRooms(Request $request)
    {
        $checkIn = $request->check_in;
        $checkOut = $request->check_out;

        if (!$checkIn || !$checkOut) {
            return motelmodel::all();
        }

        // Get rooms that have overlapping active bookings (only confirmed or pending bookings block rooms)
        // Cancelled, completed, or deleted bookings do not block rooms
        $bookedRoomIds = Booking::where(function($query) use ($checkIn, $checkOut) {
            $query->where('check_in', '<=', $checkOut)
                  ->where('check_out', '>=', $checkIn)
                  ->whereIn('booking_status', ['confirmed', 'pending']);
        })->pluck('room_id')->unique()->toArray();

        return motelmodel::whereNotIn('id', $bookedRoomIds)->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
            'payment_status' => 'required|in:pending,paid',
        ]);

        $room = motelmodel::find($request->room_id);
        if (!$room) {
            return redirect()->back()->with('error', 'Selected room not found.')->withInput();
        }

        $checkIn = \Carbon\Carbon::parse($request->check_in);
        $checkOut = \Carbon\Carbon::parse($request->check_out);
        $days = $checkIn->diffInDays($checkOut);
        $totalPrice = $days * (float)$room->price;

        $bookingData = [
            'room_id' => $request->room_id,
            'user_id' => auth()->id() ?? 1, // Default to user ID 1 if not authenticated
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'total_price' => $totalPrice,
            'payment_status' => $request->payment_status,
            'booking_status' => 'pending',
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'notes' => $request->notes,
        ];

        // Set payment_date if payment is marked as paid
        if ($request->payment_status === 'paid') {
            $bookingData['payment_date'] = \Carbon\Carbon::today();
            $bookingData['booking_status'] = 'confirmed';
        }

        DB::beginTransaction();
        try {
            $booking = Booking::create($bookingData);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Booking creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create booking: ' . $e->getMessage())->withInput();
        }

        // Attempt to send confirmation email but do not fail the booking creation if mail fails
        if ($request->payment_status === 'paid') {
            try {
                $booking->load('room');
                Mail::to($booking->customer_email)->send(new BookingConfirmationMail($booking));
            } catch (\Throwable $e) {
                Log::error('Booking confirmation email failed: ' . $e->getMessage());
                // Provide a warning to the user but keep booking successful
                return redirect()->route('admin.bookings')
                    ->with('success', 'Booking created successfully')
                    ->with('warning', 'Booking created but confirmation email failed to send.');
            }
        }

        return redirect()->route('admin.bookings')->with('success', 'Booking created successfully');
    }

    public function show(Booking $booking)
    {
        $booking->load('room', 'user');
        return view('admin.bookings-show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,cancelled',
            'booking_status' => 'required|in:confirmed,pending,cancelled,completed',
        ]);

        $oldPaymentStatus = $booking->payment_status;
        
        $updateData = [
            'payment_status' => $request->payment_status,
            'booking_status' => $request->booking_status,
        ];

        // Set payment_date when payment is marked as paid
        if ($oldPaymentStatus !== 'paid' && $request->payment_status === 'paid') {
            $updateData['payment_date'] = \Carbon\Carbon::today();
        }

        $booking->update($updateData);

        // Send confirmation email when payment is marked as paid
        if ($oldPaymentStatus !== 'paid' && $request->payment_status === 'paid') {
            try {
                $booking->load('room');
                Mail::to($booking->customer_email)->send(new BookingConfirmationMail($booking));
            } catch (\Throwable $e) {
                Log::error('Booking confirmation email failed on status update: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.bookings')->with('success', 'Booking status updated successfully');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings')->with('success', 'Booking deleted successfully');
    }
}
