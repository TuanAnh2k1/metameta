<?php

namespace App\Http\Requests\Metameta;

use App\Rules\ColumnIsFreezeCheck;
use App\Rules\ColumnNameCheck;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
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
            'settings.*.is_display' => [
                'required',
                'boolean',
            ],
            'settings.*.column_name' => [
                'required',
                new ColumnNameCheck(),
            ],
            'settings.*.width' => 'nullable|integer|gt:0|bail',
            'settings' => [
                'nullable',
                new ColumnIsFreezeCheck(),
            ],
        ];
    }

    public function messages()
    {
        return [
            'settings.*.width.gt' => trans('app.dataset_number_integer'),
            'settings.*.width.integer' => trans('validation.rules.width_check'),
        ];
    }
}
