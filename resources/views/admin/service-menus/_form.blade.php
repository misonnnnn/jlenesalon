@csrf
<ul class="nav nav-tabs mb-3" id="menuLanguageTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="menu-en-tab" data-bs-toggle="tab" data-bs-target="#menu-en-pane" type="button" role="tab">English</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="menu-ja-tab" data-bs-toggle="tab" data-bs-target="#menu-ja-pane" type="button" role="tab">Japanese</button>
    </li>
</ul>
<div class="tab-content border border-top-0 rounded-bottom p-3 mb-3">
    <div class="tab-pane fade show active" id="menu-en-pane" role="tabpanel">
        <div class="mb-3">
            <label class="form-label">Service Menu Title (English)</label>
            <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $menu->title_en ?? $menu->title ?? '') }}" required>
        </div>
        <div class="mb-0">
            <label class="form-label">Description (English)</label>
            <textarea name="description_en" rows="4" class="form-control" required>{{ old('description_en', $menu->description_en ?? $menu->description ?? '') }}</textarea>
        </div>
    </div>
    <div class="tab-pane fade" id="menu-ja-pane" role="tabpanel">
        <div class="mb-3">
            <label class="form-label">Service Menu Title (Japanese)</label>
            <input type="text" name="title_ja" class="form-control" value="{{ old('title_ja', $menu->title_ja ?? $menu->title ?? '') }}" required>
        </div>
        <div class="mb-0">
            <label class="form-label">Description (Japanese)</label>
            <textarea name="description_ja" rows="4" class="form-control" required>{{ old('description_ja', $menu->description_ja ?? $menu->description ?? '') }}</textarea>
        </div>
    </div>
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
