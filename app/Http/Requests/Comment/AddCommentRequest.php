<?php

namespace App\Http\Requests\Comment;

use App\Rules\Comment\CheckMetametaExist;
use Illuminate\Foundation\Http\FormRequest;

class AddCommentRequest extends FormRequest
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
            "comment" => [
                "required",
            ],
            "metameta_element_id" => 'required|integer',
            "metadata_no" => [
                'required',
                'integer',
                new CheckMetametaExist(),
            ],
        ];
    }

    public function messages()
    {
        return [
            'comment.required' => __('app.comment_required'),
            'metameta_element_id.required' => __('metameta.metameta_element_id_required'),
            'metadata_no.required' => __('metameta.metadata_no_required'),
            'metameta_element_id.integer' => __('metameta.metameta_element_id_integer'),
            'metadata_no.integer' => __('metameta.metadata_no_integer'),
            'metadata_no.exists' => trans('metameta.validate.exists'),
        ];
    }
}
