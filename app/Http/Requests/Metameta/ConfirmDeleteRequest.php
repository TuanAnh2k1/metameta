<?php

namespace App\Http\Requests\Metameta;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmDeleteRequest extends FormRequest
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
            'delete-confirm' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => trans('app.upload_failed'),
            'files.file' => trans('app.invalid'),
            'files.mimes' => trans('app.invalid'),
        ];
    }
}
