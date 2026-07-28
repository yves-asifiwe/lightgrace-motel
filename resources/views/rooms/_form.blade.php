<form action="{{ $action }}" method="POST" class="room-form" enctype="multipart/form-data">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <div class="form-group">
        <label for="name">Room Name *</label>
        <input type="text" id="name" name="name" value="{{ old('name', $room?->name) }}" placeholder="e.g. Deluxe Suite" required />
        @error('name')<span class="field-error">{{ $message }}</span>@enderror
    </div>

    <div class="form-group">
        <label for="price">Price per Night ($) *</label>
        <input type="number" id="price" name="price" value="{{ old('price', $room?->price) }}" placeholder="e.g. 120.00" min="0" step="0.01" required />
        @error('price')<span class="field-error">{{ $message }}</span>@enderror
    </div>

    <div class="form-group">
        <label for="capacity">Capacity (guests) *</label>
        <input type="number" id="capacity" name="capacity" value="{{ old('capacity', $room?->capacity ?? 1) }}" placeholder="e.g. 2" min="1" max="20" required />
        @error('capacity')<span class="field-error">{{ $message }}</span>@enderror
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" placeholder="Describe the room amenities, view, bed type, etc.">{{ old('description', $room?->description) }}</textarea>
        @error('description')<span class="field-error">{{ $message }}</span>@enderror
    </div>

    <div class="form-group">
        <label for="image">Room Image</label>
        @if($room?->image)
            <div class="current-image">
                <img src="{{ asset('uploads/rooms/' . $room->image) }}" alt="{{ $room->name }}" style="max-width: 200px; border-radius: 8px; margin-bottom: 0.75rem;">
                <p style="font-size: 0.85rem; color: #666; margin-bottom: 0.5rem;">Current image. Upload a new one to replace it.</p>
            </div>
        @endif
        <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" />
        @error('image')<span class="field-error">{{ $message }}</span>@enderror
    </div>

    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
</form>

<style>
    .field-error {
        display: block;
        color: #dc3545;
        font-size: 0.85rem;
        margin-top: 0.35rem;
    }
</style>
