<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminPaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('admin.payment-methods.index', compact('paymentMethods'));
    }

    public function create()
    {
        return view('admin.payment-methods.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatePayload($request);
        PaymentMethod::create($data);

        return redirect()
            ->route('admin.payments.index')
            ->with('status', 'Payment method created.');
    }

    public function edit(PaymentMethod $payment)
    {
        return view('admin.payment-methods.edit', compact('payment'));
    }

    public function update(Request $request, PaymentMethod $payment)
    {
        $data = $this->validatePayload($request, $payment);
        $payment->update($data);

        return redirect()
            ->route('admin.payments.index')
            ->with('status', 'Payment method updated.');
    }

    public function destroy(PaymentMethod $payment)
    {
        $payment->delete();

        return redirect()
            ->route('admin.payments.index')
            ->with('status', 'Payment method deleted.');
    }

    private function validatePayload(Request $request, ?PaymentMethod $payment = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-z0-9_]+$/',
                Rule::unique('payment_methods', 'code')->ignore($payment?->id),
            ],
            'stripe_method' => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'code.regex' => 'Code may only contain lowercase letters, numbers, and underscores.',
        ]) + [
            'sort_order' => (int) $request->input('sort_order', 0),
            'is_active' => $request->boolean('is_active'),
        ];
    }
}
