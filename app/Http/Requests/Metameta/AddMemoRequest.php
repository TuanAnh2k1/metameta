<?php

namespace App\Http\Requests\Metameta;

use Illuminate\Foundation\Http\FormRequest;

class AddMemoRequest extends FormRequest
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
            "memo_date" => 'required|date|date_format:Y-m-d|bail',
            'metameta_element_id' => 'nullable',
            'memo' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'memo_date.required' => __('app.memo_date_required'),
            'memo_date.date' => __('app.memo_date'),
            'memo_date.date_format' => trans('app.validate.date.format'),
        ];
    }
}
