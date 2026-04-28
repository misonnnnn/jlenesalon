<?php

namespace App\Http\Requests;

use App\Models\Booking;
use App\Models\PaymentMethod;
use App\Models\ServiceMenu;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_menu_id' => [
                'required',
                'integer',
                Rule::exists('service_menus', 'id')->where('is_active', true),
            ],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:50'],
            'starts_at' => ['required', 'date', 'after:now'],
            'payment_method' => [
                'required',
                Rule::exists('payment_methods', 'code')->where('is_active', true),
            ],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $id = (int) $this->input('service_menu_id');
            if ($id < 1) {
                return;
            }

            $menu = ServiceMenu::query()->with('service')->find($id);
            if (!$menu || !$menu->service || !$menu->service->is_active) {
                $validator->errors()->add('service_menu_id', __('This service is not available for booking.'));
            }

            $startsAt = $this->input('starts_at');
            if (!$startsAt) {
                return;
            }

            $slot = Carbon::parse($startsAt)->format('Y-m-d H:i:s');
            $taken = Booking::query()
                ->where('starts_at', $slot)
                ->where('status', '!=', 'cancelled')
                ->whereHas('menu', function ($query) use ($menu) {
                    $query->where('service_id', $menu->service_id);
                })
                ->exists();

            if ($taken) {
                $validator->errors()->add('starts_at', __('This date and time is already booked for this service. Please choose another slot.'));
            }

            $paymentMethodCode = (string) $this->input('payment_method', '');
            if ($paymentMethodCode !== '') {
                $method = PaymentMethod::query()
                    ->where('code', $paymentMethodCode)
                    ->where('is_active', true)
                    ->first();

                if (!$method) {
                    $validator->errors()->add('payment_method', __('This payment method is not available.'));
                }
            }
        });
    }
}
