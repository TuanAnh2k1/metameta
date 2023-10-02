<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('user');
        return [
            'display_name' => 'sometimes|required',
            'username' => [
                'sometimes',
                'required',
                Rule::unique('users', 'username')->ignore($userId)->where(fn ($query) => $query->whereNull('deleted_at'))
            ],
            'role_id' => 'sometimes|required|exists:roles,id',
        ];
    }
}
