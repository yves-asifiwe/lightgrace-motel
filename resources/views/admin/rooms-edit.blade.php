@extends('layouts.app')

@section('title', 'Lightgrace Admin - Edit Room')
@section('page-title', 'Edit Room')

@section('content')
<div class="hero-section">
    <div class="hero-content">
        <h1>Edit Room</h1>
        <p>Update room details for {{ $room->name }}</p>
    </div>
</div>

<div class="container">
    @if($errors->any())
        <div class="alert alert-error">
            <ul style="margin: 0; padding-left: 1.25rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-container">
        @include('rooms._form', [
            'action' => auth()->user()->role === 'manager'
                ? route('manager.rooms.update', $room)
                : route('rooms.update', $room),
            'method' => 'PUT',
            'submitLabel' => 'Save Changes',
            'room' => $room,
        ])
    </div>

    <div style="margin-top: 1.5rem;">
        <a href="{{ auth()->user()->role === 'manager' ? route('manager.rooms') : route('admin.rooms') }}" class="btn btn-secondary">Back to Rooms</a>
    </div>
</div>
@endsection
