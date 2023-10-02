<?php

namespace App\Http\Requests\Metameta;

use Illuminate\Foundation\Http\FormRequest;

class AddMetametaCommentRequest extends FormRequest
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
            "comment_date" => 'required|date|date_format:Y-m-d|bail',
            'metameta_element_id' => 'nullable',
            'comment' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'comment_date.required' => __('app.comment_date_required'),
            'comment_date.date' => __('app.comment_date'),
            'comment_date.date_format' => __('app.validate.date.format'),
        ];
    }
}
