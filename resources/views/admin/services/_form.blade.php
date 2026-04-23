@csrf
<div class="mb-3">
    <label class="form-label">Service Name (English)</label>
    <input type="text" name="name_en" class="form-control" value="{{ old('name_en', $service->name_en ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Service Name (Japanese)</label>
    <input type="text" name="name_ja" class="form-control" value="{{ old('name_ja', $service->name_ja ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Slug (optional)</label>
    <input type="text" name="slug" class="form-control" value="{{ old('slug', $service->slug ?? '') }}">
</div>
<div class="mb-3">
    <label class="form-label">Short Description / Excerpt</label>
    <textarea name="excerpt" rows="4" class="form-control" required>{{ old('excerpt', $service->excerpt ?? '') }}</textarea>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Icon Image</label>
        <input type="file" name="icon_image" class="form-control" accept="image/*">
        @if (!empty($service?->icon_image))
            <img src="{{ asset($service->icon_image) }}" class="mt-2" style="max-height: 70px;" alt="Icon">
        @endif
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Excerpt Image</label>
        <input type="file" name="excerpt_image" class="form-control" accept="image/*">
        @if (!empty($service?->excerpt_image))
            <img src="{{ asset($service->excerpt_image) }}" class="mt-2" style="max-height: 70px;" alt="Excerpt">
        @endif
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Sort Order</label>
        <input type="number" min="0" name="sort_order" class="form-control" value="{{ old('sort_order', $service->sort_order ?? 0) }}">
    </div>
    <div class="col-md-6 mb-3 d-flex align-items-center">
        <div class="form-check mt-4">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
        </div>
    </div>
</div>
<button class="btn btn-dark" type="submit">{{ $submitLabel }}</button>
