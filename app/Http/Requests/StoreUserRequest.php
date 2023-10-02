<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'display_name' => 'required|max:255',
            'username' => [
                'required',
                'email:rfc,dns',
                'max:255',
                Rule::unique('users', 'username')->where(fn($query) => $query->whereNull('deleted_at')),
            ],
            'role_id' => 'required|exists:roles,id',
        ];
    }

    public function messages()
    {
        $maxCharacters = trans('app.validate.input.max');
        return [
            'display_name.required' => __('app.display_name_required'),
            'display_name.max' => $maxCharacters,
            'username.required' => __('app.username_required'),
            'username.max' => $maxCharacters,
            'role.required' => __('app.role_required'),
            'username.email' => trans('app.validate.email'),
        ];
    }
}
