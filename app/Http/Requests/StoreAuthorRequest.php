<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuthorRequest extends FormRequest
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
            "name" => 'nullable|max:255',
            "email" => [
                "required", 'email:rfc,dns','max:255',
            ],
            "metameta_no" => 'required',
        ];
    }

    public function messages()
    {
        $maxCharacters = trans('app.validate.input.max');
        return [
            'email.required' => __('app.email_required'),
            'name.max' => $maxCharacters,
            'email.max' => $maxCharacters,
            'email.email' => trans('app.validate.email'),
        ];
    }
}
