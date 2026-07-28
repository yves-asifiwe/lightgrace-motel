<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Lightgrace Admin')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="admin-layout">
        <!-- Mobile Menu Toggle -->
        <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
            </svg>
        </button>

        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h1>Lightgrace</h1>
                <p>Admin Dashboard</p>
            </div>
            <ul class="sidebar-menu">
                <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin') ? 'active' : '' }}">Dashboard</a></li>
                <li><a href="{{ route('admin.rooms') }}" class="{{ request()->is('admin/rooms') ? 'active' : '' }}">Rooms Management</a></li>
                <li><a href="{{ route('admin.bookings') }}" class="{{ request()->is('admin/bookings') ? 'active' : '' }}">Bookings</a></li>
                <li><a href="{{ route('admin.customers') }}" class="{{ request()->is('admin/customers') ? 'active' : '' }}">Customers</a></li>
                <li><a href="{{ route('admin.reports') }}" class="{{ request()->is('admin/reports') ? 'active' : '' }}">Reports</a></li>
                <li><a href="{{ route('admin.settings') }}" class="{{ request()->is('admin/settings') ? 'active' : '' }}">Settings</a></li>
                <li><a href="{{ route('profile.edit') }}" class="{{ request()->is('profile') ? 'active' : '' }}">Profile & Password</a></li>
            </ul>
            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 0h-8A1.5 1.5 0 0 0 0 1.5v9A1.5 1.5 0 0 0 1.5 12h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                            <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="main-wrapper">
            @php
                $currentAdmin = auth()->user();
                $currentAdminName = $currentAdmin?->name ?: $currentAdmin?->email ?: 'Admin';
                $currentAdminInitial = strtoupper(substr($currentAdminName, 0, 1));
            @endphp

            <!-- Top Navigation Bar -->
            <nav class="top-navbar">
                <div class="page-title">
                    <h2>@yield('page-title', 'Dashboard')</h2>
                </div>
                <div class="user-info">
                    <span>{{ $currentAdminName }}</span>
                    <div class="user-avatar">
                        {{ $currentAdminInitial }}
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="main-content">
                @yield('content')
            </main>

            <footer style="margin-top: 24px; padding: 18px 20px; text-align: center; font-size: 0.92rem; color: #6b7280; border-top: 1px solid #e5e7eb; background: linear-gradient(90deg, rgba(255,248,244,0.9), rgba(255,255,255,0.98)); border-radius: 16px 16px 0 0; box-shadow: 0 -4px 16px rgba(245, 48, 3, 0.06);">
                <div style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; font-weight: 700; color: #111827; padding: 8px 12px; border-radius: 999px; background: rgba(255,255,255,0.9); box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <span style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 50%; background: #fff2ec; color: #f53003;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="4" width="16" height="16" rx="3"></rect>
                            <path d="M8 9h8"></path>
                            <path d="M8 13h5"></path>
                        </svg>
                    </span>
                    <span>Developed by Yves Dev</span>
                </div>
                <a href="https://wa.me/250787821533" target="_blank" rel="noopener noreferrer" style="margin-top: 10px; display: inline-flex; align-items: center; justify-content: center; gap: 8px; color: white; text-decoration: none; font-weight: 700; padding: 8px 12px; border-radius: 999px; background: linear-gradient(90deg, #25d366, #128c7e); box-shadow: 0 6px 18px rgba(37, 211, 102, 0.24);">
                    <span style="display: inline-flex; align-items: center; justify-content: center; width: 22px; height: 22px; border-radius: 50%; background: rgba(255,255,255,0.2);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.149-.67.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.478-1.761-1.651-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.149-.174.199-.297.299-.495.099-.198.049-.372-.025-.521-.074-.149-.669-1.612-.916-2.207-.241-.58-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.521.074-.793.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.099 3.2 5.076 4.487.708.242 1.261.389 1.694.5.712.226 1.36.194 1.873.118.572-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.174-1.413-.074-.124-.273-.198-.57-.347z"></path>
                        </svg>
                    </span>
                    <span>Chat on WhatsApp</span>
                </a>
            </footer>
        </div>
    </div>

    <script>
        function toggleMobileMenu() {
            const sidebar = document.getElementById('sidebar');
            const mainWrapper = document.querySelector('.main-wrapper');
            
            sidebar.classList.toggle('active');
            mainWrapper.classList.toggle('shifted');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.mobile-menu-toggle');
            
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                    sidebar.classList.remove('active');
                    document.querySelector('.main-wrapper').classList.remove('shifted');
                }
            }
        });

        // Close mobile menu on window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const mainWrapper = document.querySelector('.main-wrapper');
            
            if (window.innerWidth > 768) {
                sidebar.classList.remove('active');
                mainWrapper.classList.remove('shifted');
            }
        });
    </script>
</body>
</html>
