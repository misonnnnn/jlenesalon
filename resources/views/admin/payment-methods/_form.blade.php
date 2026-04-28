@csrf
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Display Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $payment->name ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Code</label>
        <input type="text" name="code" class="form-control" value="{{ old('code', $payment->code ?? '') }}" placeholder="card" required>
        <div class="form-text">Lowercase letters, numbers, underscore only.</div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Stripe Method (optional)</label>
        <input type="text" name="stripe_method" class="form-control" value="{{ old('stripe_method', $payment->stripe_method ?? '') }}" placeholder="card / gcash / paypay">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Sort Order</label>
        <input type="number" min="0" name="sort_order" class="form-control" value="{{ old('sort_order', $payment->sort_order ?? 0) }}">
    </div>
    <div class="col-md-3 mb-3 d-flex align-items-center">
        <div class="form-check mt-4">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ old('is_active', $payment->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
        </div>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Notes (optional)</label>
    <textarea name="notes" rows="3" class="form-control">{{ old('notes', $payment->notes ?? '') }}</textarea>
</div>

<button class="btn btn-admin-primary" type="submit">{{ $submitLabel }}</button>
