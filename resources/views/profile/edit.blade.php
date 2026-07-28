@extends('layouts.app')

@section('title', 'Profile')
@section('page-title', 'Profile & Password')

@section('content')
<div class="container" style="padding-top: 2rem; padding-bottom: 2rem;">
    <div class="profile-shell">
        <div class="profile-hero">
            <div>
                <h2>Manage your account</h2>
                <p>Update your profile details, change your password, or safely delete your account.</p>
            </div>
            <div class="profile-badge">Secure</div>
        </div>

        <div class="profile-grid">
            <div class="profile-card">
                <div class="profile-card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="profile-card">
                <div class="profile-card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="profile-card">
                <div class="profile-card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-shell {
    max-width: 980px;
    margin: 0 auto;
}

.profile-hero {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem 1.75rem;
    margin-bottom: 1.25rem;
    border-radius: 18px;
    background: linear-gradient(135deg, #0d4a35 0%, #1a6b4f 100%);
    color: white;
    box-shadow: 0 12px 30px rgba(13, 74, 53, 0.18);
}

.profile-hero h2 {
    font-size: 1.35rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.profile-hero p {
    margin: 0;
    color: #dff7e8;
    font-size: 0.95rem;
}

.profile-badge {
    padding: 0.55rem 0.9rem;
    border-radius: 999px;
    background: rgba(255,255,255,0.16);
    border: 1px solid rgba(255,255,255,0.24);
    font-weight: 700;
    white-space: nowrap;
}

.profile-grid {
    display: grid;
    gap: 1rem;
}

.profile-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(13, 74, 53, 0.08);
    border: 1px solid #e8f5e9;
    overflow: hidden;
}

.profile-card-body {
    padding: 1.25rem;
}

@media (max-width: 768px) {
    .profile-hero {
        flex-direction: column;
        align-items: flex-start;
    }

    .profile-card-body {
        padding: 1rem;
    }
}
</style>
@endsection
