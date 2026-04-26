<?php

namespace App\Http\Requests;

use App\Models\ServiceMenu;
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
        });
    }
}
