@extends('layouts.app')

@section('title', 'Add New Room')
@section('page-title', 'Add New Room')

@section('content')
<div class="hero-section">
    <div class="hero-content">
        <h1>Add New Room</h1>
        <p>Add a new room to your hotel</p>
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
        <form action="{{ route('rooms.store') }}" method="POST" class="room-form" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Room Name</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}"
                    required
                    placeholder="e.g., Deluxe Suite, Standard Room"
                >
                @error('name')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Price per Night (RWF)</label>
                <input 
                    type="number" 
                    id="price" 
                    name="price" 
                    value="{{ old('price') }}"
                    required
                    min="0"
                    step="1"
                    placeholder="e.g., 150000"
                >
                <p class="help-text">Enter price in Rwandan Francs (RWF)</p>
                @error('price')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="capacity">Capacity (Guests)</label>
                <input 
                    type="number" 
                    id="capacity" 
                    name="capacity" 
                    value="{{ old('capacity') }}"
                    required
                    min="1"
                    placeholder="e.g., 2"
                >
                @error('capacity')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="4"
                    placeholder="Describe the room amenities, view, and features..."
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Room Image</label>
                <input 
                    type="file" 
                    id="image" 
                    name="image" 
                    accept="image/jpeg,image/png,image/jpg,image/gif"
                >
                <p class="help-text">Upload an image of the room (JPEG, PNG, JPG, GIF - Max2MB)</p>
                @error('image')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Add Room</button>
                <a href="{{ route('admin.rooms') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<style>
    .form-container {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(13, 74, 53, 0.15);
    }

    .room-form {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-group label {
        font-weight: 600;
        color: #0d4a35;
        font-size: 0.95rem;
    }

    .form-group input,
    .form-group textarea {
        padding: 0.875rem;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s;
        background-color: #f9fbf9;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #38ef7d;
        background-color: white;
        box-shadow: 0 0 0 3px rgba(56, 239, 125, 0.1);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .error-message {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .help-text {
        color: #666;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }

    .form-actions .btn {
        flex: 1;
        text-align: center;
    }
</style>
@endsection
