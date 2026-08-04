@extends('layouts.app')

@section('title', 'Lightgrace Admin - Settings')
@section('page-title', 'Settings')

@section('content')
<div class="hero-section">
    <div class="hero-content">
        <h1>Settings</h1>
        <p>Configure your admin dashboard</p>
    </div>
</div>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
    @endif

    <div class="section-header">
        <h2>General Settings</h2>
    </div>

    <div class="settings-grid">
        <div class="settings-card">
            <div class="card-header">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z"/>
                    </svg>
                </div>
                <h3>Hotel Information</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.updateHotelInfo') }}" method="POST" class="room-form">
                    @csrf
                    <div class="form-group">
                        <label for="hotel_name">Hotel Name</label>
                        <input type="text" id="hotel_name" name="hotel_name" value="{{ $hotelSettings['hotel_name'] }}" required />
                    </div>
                    <div class="form-group">
                        <label for="contact_email">Contact Email</label>
                        <input type="email" id="contact_email" name="contact_email" value="{{ $hotelSettings['contact_email'] }}" required />
                    </div>
                    <div class="form-group">
                        <label for="contact_phone">Contact Phone</label>
                        <input type="tel" id="contact_phone" name="contact_phone" value="{{ $hotelSettings['contact_phone'] }}" required />
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>

        <div class="settings-card">
            <div class="card-header">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                </div>
                <h3>Appearance</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.updateAppearance') }}" method="POST" class="room-form">
                    @csrf
                    <div class="form-group">
                        <label for="theme_color">Theme Color</label>
                        <select id="theme_color" name="theme_color">
                            <option value="green" {{ $appearanceSettings['theme_color'] === 'green' ? 'selected' : '' }}>Green (Default)</option>
                            <option value="blue" {{ $appearanceSettings['theme_color'] === 'blue' ? 'selected' : '' }}>Blue</option>
                            <option value="purple" {{ $appearanceSettings['theme_color'] === 'purple' ? 'selected' : '' }}>Purple</option>
                        </select>
                    </div>
                    <div class="form-group checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="dark_mode" {{ $appearanceSettings['dark_mode'] ? 'checked' : '' }} />
                            <span>Enable Dark Mode</span>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Appearance</button>
                </form>
            </div>
        </div>

        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'manager')
        <div class="settings-card">
            <div class="card-header">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68[...]"/>
                    </svg>
                </div>
                <h3>Administrators</h3>
            </div>
            <div class="card-body">
                <div class="admin-actions">
                    <a href="#add-admin" class="action-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 [...]"></path>
                        </svg>
                        Add Admin
                    </a>
                    <a href="{{ route('manager.admins') }}" class="action-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                        </svg>
                        View Admins
                    </a>
                </div>

                @if(auth()->user()->role === 'admin')
                <div id="add-admin" class="add-admin-form">
                    <h4>Add New Admin</h4>
                    <form action="{{ route('admin.storeAdmin') }}" method="POST" class="room-form">
                        @csrf
                        <div class="form-group">
                            <label for="name">Admin Name</label>
                            <input type="text" id="name" name="name" placeholder="Enter admin name" required />
                        </div>
                        <div class="form-group">
                            <label for="email">Admin Email</label>
                            <input type="email" id="email" name="email" placeholder="Enter admin email" required />
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select id="role" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="manager">Manager</option>
                                <option value="recipient">Recipient</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Enter password" required />
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm password" required />
                        </div>
                        <button type="submit" class="btn btn-primary">Add Admin</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
        @endif

        <div class="settings-card">
            <div class="card-header">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.6[...]"/>
                    </svg>
                </div>
                <h3>Account Settings</h3>
            </div>
            <div class="card-body">
                <p style="margin-bottom: 1rem; color: #4b5563;">Manage your profile information, email, and password from the profile page.</p>
                <a href="{{ route('profile.edit') }}" class="btn btn-secondary">Go to Profile</a>
            </div>
        </div>

        <div class="settings-card">
            <div class="card-header">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                    </svg>
                </div>
                <h3>Two-Factor Authentication</h3>
            </div>
            <div class="card-body">
                <p style="margin-bottom: 1rem; color: #4b5563;">Add an extra layer of security to your account with two-factor authentication.</p>
                @if (Route::has('2fa.manage'))
                    @if(auth()->user()->hasTwoFactorEnabled())
                        <span class="badge enabled">Enabled</span>
                    @else
                        <span class="badge disabled">Disabled</span>
                    @endif
                    <a href="{{ route('2fa.manage') }}" class="btn btn-secondary">Manage 2FA</a>
                @else
                    <span class="badge disabled">Disabled</span>
                    <p style="margin-top: .5rem; color: #6b7280;">Two-factor authentication is not available in this deployment.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .settings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 1.5rem;
    }

    .settings-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(13, 74, 53, 0.15);
        border: 1px solid #e8f5e9;
        overflow: hidden;
        transition: all 0.3s;
    }

    .settings-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(13, 74, 53, 0.25);
        border-color: #38ef7d;
    }

    .card-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, #0d4a35 0%, #1a6b4f 100%);
        border-bottom: 1px solid #e8f5e9;
    }

    .card-icon {
        width: 45px;
        height: 45px;
        background: rgba(56, 239, 125, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #38ef7d;
        flex-shrink: 0;
    }

    .card-header h3 {
        margin: 0;
        color: white;
        font-size: 1.2rem;
        font-weight: 600;
    }

    .card-body {
        padding: 1.5rem;
    }

    .admin-actions {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .action-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        background: #f9fbf9;
        border: 2px solid #e8f5e9;
        border-radius: 8px;
        text-decoration: none;
        color: #0d4a35;
        font-weight: 500;
        transition: all 0.3s;
    }

    .action-btn:hover {
        background: #f0fdf4;
        border-color: #38ef7d;
        color: #0d4a35;
    }

    .add-admin-form {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e8f5e9;
    }

    .add-admin-form h4 {
        margin: 0 0 1rem 0;
        color: #0d4a35;
        font-size: 1rem;
    }

    .badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        margin-right: 0.5rem;
    }

    .badge.enabled {
        background-color: #10b981;
        color: white;
    }

    .badge.disabled {
        background-color: #6b7280;
        color: white;
    }

    .form-group select {
        padding: 0.8rem;
        border: 2px solid #e0e0e0;
        border-radius: 5px;
        font-size: 1rem;
        transition: all 0.3s;
        background-color: #f9fbf9;
    }

    .form-group select:focus {
        outline: none;
        border-color: #38ef7d;
        background-color: white;
        box-shadow: 0 0 0 3px rgba(56, 239, 125, 0.1);
    }
</style>
@endsection
