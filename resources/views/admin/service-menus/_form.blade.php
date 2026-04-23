@csrf
<div class="mb-3">
    <label class="form-label">Service Menu Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $menu->title ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" rows="4" class="form-control" required>{{ old('description', $menu->description ?? '') }}</textarea>
</div>
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Duration</label>
        <input type="text" name="duration" class="form-control" value="{{ old('duration', $menu->duration ?? '') }}" placeholder="e.g. 60 min">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Price</label>
        <input type="text" name="price" class="form-control" value="{{ old('price', $menu->price ?? '') }}" placeholder="e.g. 5,000 JPY">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Sort Order</label>
        <input type="number" min="0" name="sort_order" class="form-control" value="{{ old('sort_order', $menu->sort_order ?? 0) }}">
    </div>
</div>
<div class="mb-3">
    <label class="form-label">Pricing Poster Image</label>
    <input type="file" name="poster_image" class="form-control" accept="image/*">
    @if (!empty($menu?->poster_image))
        <img src="{{ asset($menu->poster_image) }}" class="mt-2" style="max-height: 80px;" alt="Poster">
    @endif
</div>
<div class="mb-3 form-check">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="menu_active" {{ old('is_active', $menu->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="menu_active">Active</label>
</div>
<button class="btn btn-dark" type="submit">{{ $submitLabel }}</button>
