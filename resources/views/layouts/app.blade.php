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
        <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="sidebar">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
            </svg>
        </button>

        <!-- Sidebar Navigation -->
        <aside class="sidebar" id="sidebar" role="navigation" aria-label="Main navigation">
            <div class="sidebar-header">
                <h1>Lightgrace</h1>
                <p>Admin Dashboard</p>
            </div>
            
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin') ? 'active' : '' }}" role="menuitem">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.rooms') }}" class="{{ request()->is('admin/rooms') ? 'active' : '' }}" role="menuitem">
                        Rooms Management
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.bookings') }}" class="{{ request()->is('admin/bookings') ? 'active' : '' }}" role="menuitem">
                        Bookings
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.customers') }}" class="{{ request()->is('admin/customers') ? 'active' : '' }}" role="menuitem">
                        Customers
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reports') }}" class="{{ request()->is('admin/reports') ? 'active' : '' }}" role="menuitem">
                        Reports
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.settings') }}" class="{{ request()->is('admin/settings') ? 'active' : '' }}" role="menuitem">
                        Settings
                    </a>
                </li>
                <li>
                    <a href="{{ route('profile.edit') }}" class="{{ request()->is('profile') ? 'active' : '' }}" role="menuitem">
                        Profile & Password
                    </a>
                </li>
            </ul>

            <!-- Logout Section -->
            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                    @csrf
                    <button type="submit" class="logout-btn" role="menuitem">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 0h-8A1.5 1.5 0 0 0 0 1.5v9A1.5 1.5 0 0 0 1.5 12h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                            <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                        </svg>
                        <span>Logout</span>
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
            <nav class="top-navbar" role="navigation" aria-label="Top navigation">
                <div class="page-title">
                    <h2>@yield('page-title', 'Dashboard')</h2>
                </div>
                <div class="user-info">
                    <span>{{ $currentAdminName }}</span>
                    <div class="user-avatar" title="{{ $currentAdminName }}">
                        {{ $currentAdminInitial }}
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="main-content" role="main">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer style="margin-top: 24px; padding: 18px 20px; text-align: center; font-size: 0.92rem; color: #6b7280; border-top: 1px solid #e5e7eb; background: linear-gradient(90deg, rgba(255,255,255,0.5) 0%, rgba(248,249,250,0.5) 100%);">
                <div style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; font-weight: 700; color: #111827; padding: 8px 12px; border-radius: 999px; background: rgb(255, 243, 224); flex-wrap: wrap;">
                    <span style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 50%; background: #fff2ec; color: #f53003; flex-shrink: 0;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="4" y="4" width="16" height="16" rx="3"></rect>
                            <path d="M8 9h8"></path>
                            <path d="M8 13h5"></path>
                        </svg>
                    </span>
                    <span>Developed by Yves Dev</span>
                </div>
                <a href="https://wa.me/250787821533" target="_blank" rel="noopener noreferrer" style="margin-top: 10px; display: inline-flex; align-items: center; justify-content: center; gap: 8px; color: #10b981; text-decoration: none; font-weight: 600; transition: color 0.3s;">
                    <span style="display: inline-flex; align-items: center; justify-content: center; width: 22px; height: 22px; border-radius: 50%; background: rgba(255,255,255,0.2); flex-shrink: 0;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.149-.67.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.67-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421-7.403h-.004a9.87 9.87 0 00-4.869 1.176c-1.493.823-2.712 1.982-3.556 3.355-1.671 2.789-.923 6.385 1.849 8.514 1.423 1.031 3.054 1.626 4.78 1.626h.004c2.925 0 5.657-1.193 7.72-3.368 1.732-1.849 2.747-4.269 2.747-6.741 0-5.368-4.37-9.735-9.75-9.736"/>
                        </svg>
                    </span>
                    <span>Chat on WhatsApp</span>
                </a>
            </footer>
        </div>
    </div>

    <script>
        // Mobile menu toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const sidebar = document.getElementById('sidebar');
            const mainWrapper = document.querySelector('.main-wrapper');
            const menuLinks = document.querySelectorAll('.sidebar-menu a');

            // Toggle menu on button click
            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isOpen = sidebar.classList.contains('active');
                    
                    sidebar.classList.toggle('active');
                    mainWrapper.classList.toggle('shifted');
                    mobileMenuToggle.setAttribute('aria-expanded', !isOpen);
                });
            }

            // Close menu when clicking on a navigation link (on mobile only)
            menuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        sidebar.classList.remove('active');
                        mainWrapper.classList.remove('shifted');
                        mobileMenuToggle.setAttribute('aria-expanded', 'false');
                    }
                });
            });

            // Close menu when clicking outside (on mobile only)
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 768) {
                    const isClickInsideSidebar = sidebar.contains(event.target);
                    const isClickOnToggle = mobileMenuToggle.contains(event.target);
                    
                    if (!isClickInsideSidebar && !isClickOnToggle && sidebar.classList.contains('active')) {
                        sidebar.classList.remove('active');
                        mainWrapper.classList.remove('shifted');
                        mobileMenuToggle.setAttribute('aria-expanded', 'false');
                    }
                }
            });

            // Handle window resize - close menu when resizing to desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('active');
                    mainWrapper.classList.remove('shifted');
                    mobileMenuToggle.setAttribute('aria-expanded', 'false');
                }
            });

            // Prevent menu from closing when clicking the logout form inside sidebar
            const logoutForm = sidebar.querySelector('form[action*="logout"]');
            if (logoutForm) {
                logoutForm.addEventListener('click', function(e) {
                    // Allow the logout to proceed naturally
                });
            }
        });

        // Handle touch events for better mobile experience
        document.addEventListener('touchstart', function(event) {
            const sidebar = document.getElementById('sidebar');
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !mobileMenuToggle.contains(event.target) &&
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
                document.querySelector('.main-wrapper').classList.remove('shifted');
                mobileMenuToggle.setAttribute('aria-expanded', 'false');
            }
        });
    </script>
</body>
</html>