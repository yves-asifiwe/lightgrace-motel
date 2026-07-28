<?php

namespace App\Http\Controllers;

use App\Models\motelmodel;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $rooms = motelmodel::all();
        return view('admin.dashboard', compact('rooms'));
    }

    public function rooms()
    {
        $rooms = motelmodel::all();
        return view('admin.rooms', compact('rooms'));
    }

    public function bookings()
    {
        return view('admin.bookings');
    }

    public function customers()
    {
        // Get unique customers from bookings, with their booking statistics
        $customers = Booking::selectRaw('
            customer_email,
            customer_name,
            customer_phone,
            COUNT(*) as total_bookings,
            SUM(total_price) as total_spent,
            MAX(created_at) as last_booking_date
        ')
        ->groupBy('customer_email', 'customer_name', 'customer_phone')
        ->orderByDesc('last_booking_date')
        ->get();

        return view('admin.customers', compact('customers'));
    }

    public function reports()
    {
        // Calculate revenue from paid bookings
        $totalRevenue = Booking::where('payment_status', 'paid')->sum('total_price');
        
        // Calculate today's revenue - use payment_date if available, otherwise updated_at
        try {
            $todayRevenue = Booking::where('payment_status', 'paid')
                ->whereDate('payment_date', \Carbon\Carbon::today())
                ->sum('total_price');
        } catch (\Exception $e) {
            // Fallback to updated_at if payment_date column doesn't exist
            $todayRevenue = Booking::where('payment_status', 'paid')
                ->whereDate('updated_at', \Carbon\Carbon::today())
                ->sum('total_price');
        }
        
        // Total bookings
        $totalBookings = Booking::count();
        
        // Paid bookings
        $paidBookings = Booking::where('payment_status', 'paid')->count();
        
        // New customers (unique email addresses)
        $newCustomers = Booking::distinct('customer_email')->count('customer_email');
        
        // Room occupancy (bookings that are currently active)
        $activeBookings = Booking::where('booking_status', 'confirmed')
            ->where('check_in', '<=', \Carbon\Carbon::today())
            ->where('check_out', '>=', \Carbon\Carbon::today())
            ->count();
        
        $totalRooms = motelmodel::count();
        $occupancyRate = $totalRooms > 0 ? round(($activeBookings / $totalRooms) * 100, 1) : 0;
        
        // Booking percentage (total bookings vs total rooms)
        $bookingPercentage = $totalRooms > 0 ? round(($totalBookings / $totalRooms) * 100, 1) : 0;

        return view('admin.reports', compact(
            'totalRevenue',
            'todayRevenue',
            'totalBookings',
            'paidBookings',
            'newCustomers',
            'occupancyRate',
            'totalRooms',
            'bookingPercentage'
        ));
    }

    public function settings()
    {
        $hotelSettings = [
            'hotel_name' => session('hotel_name', 'Lightgrace'),
            'contact_email' => session('contact_email', 'info@lightgrace.com'),
            'contact_phone' => session('contact_phone', '+1 234 567 890'),
        ];
        
        $appearanceSettings = [
            'theme_color' => session('theme_color', 'green'),
            'dark_mode' => session('dark_mode', false),
        ];
        
        return view('admin.settings', compact('hotelSettings', 'appearanceSettings'));
    }

    public function updateHotelInfo(Request $request)
    {
        $request->validate([
            'hotel_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:20',
        ]);

        session([
            'hotel_name' => $request->hotel_name,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
        ]);

        return redirect()->route('admin.settings')->with('success', 'Hotel information updated successfully');
    }

    public function updateAppearance(Request $request)
    {
        $request->validate([
            'theme_color' => 'required|in:green,blue,purple',
            'dark_mode' => 'nullable|boolean',
        ]);

        session([
            'theme_color' => $request->theme_color,
            'dark_mode' => $request->has('dark_mode'),
        ]);

        return redirect()->route('admin.settings')->with('success', 'Appearance settings updated successfully');
    }

    public function storeAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,manager,recipient'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return back()->with('success', 'New admin added successfully.');
    }

    // Manager-specific methods
    public function managerDashboard()
    {
        $admins = User::all();
        $bookings = Booking::with('room')->latest()->get();
        $rooms = motelmodel::all();
        
        return view('manager.dashboard', compact('admins', 'bookings', 'rooms'));
    }

    public function managerRooms()
    {
        $rooms = motelmodel::all();
        return view('manager.rooms', compact('rooms'));
    }

    public function adminsList()
    {
        $admins = User::all();
        return view('manager.admins', compact('admins'));
    }

    // Recipient-specific methods
    public function recipientDashboard()
    {
        $bookings = Booking::with('room')->latest()->get();
        $rooms = motelmodel::all();
        $paidBookings = Booking::where('payment_status', 'paid')->count();
        
        return view('recipient.dashboard', compact('bookings', 'rooms', 'paidBookings'));
    }

    public function deleteAdmin(User $user)
    {
        // Prevent deleting the current user
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        // Prevent deleting managers (only managers can delete managers)
        if ($user->role === 'manager' && auth()->user()->role !== 'manager') {
            return back()->with('error', 'Only managers can delete other managers.');
        }

        $user->delete();
        return back()->with('success', 'Administrator deleted successfully.');
    }
}
