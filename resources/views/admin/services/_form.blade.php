@csrf
<ul class="nav nav-tabs mb-3" id="serviceLanguageTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="service-en-tab" data-bs-toggle="tab" data-bs-target="#service-en-pane" type="button" role="tab">English</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="service-ja-tab" data-bs-toggle="tab" data-bs-target="#service-ja-pane" type="button" role="tab">Japanese</button>
    </li>
</ul>
<div class="tab-content border border-top-0 rounded-bottom p-3 mb-3">
    <div class="tab-pane fade show active" id="service-en-pane" role="tabpanel">
        <div class="mb-3">
            <label class="form-label">Service Name (English)</label>
            <input type="text" name="name_en" class="form-control" value="{{ old('name_en', $service->name_en ?? '') }}" required>
        </div>
        <div class="mb-0">
            <label class="form-label">Short Description / Excerpt (English)</label>
            <textarea name="excerpt_en" rows="4" class="form-control" required>{{ old('excerpt_en', $service->excerpt_en ?? $service->excerpt ?? '') }}</textarea>
        </div>
    </div>
    <div class="tab-pane fade" id="service-ja-pane" role="tabpanel">
        <div class="mb-3">
            <label class="form-label">Service Name (Japanese)</label>
            <input type="text" name="name_ja" class="form-control" value="{{ old('name_ja', $service->name_ja ?? '') }}" required>
        </div>
        <div class="mb-0">
            <label class="form-label">Short Description / Excerpt (Japanese)</label>
            <textarea name="excerpt_ja" rows="4" class="form-control" required>{{ old('excerpt_ja', $service->excerpt_ja ?? $service->excerpt ?? '') }}</textarea>
        </div>
    </div>
</div>
<div class="mb-3">
    <label class="form-label">Slug (optional)</label>
    <input type="text" name="slug" class="form-control" value="{{ old('slug', $service->slug ?? '') }}">
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
