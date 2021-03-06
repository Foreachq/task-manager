<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateLabelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        $label = $this->route('label');

        return [
            'name' => [
                'required',
                'max:255',
                Rule::unique('labels')->ignore($label->id),
            ],
            'description' => 'max:512',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('messages.form.required'),
            'name.unique' => __('messages.form.label.name.unique'),
        ];
    }
}
