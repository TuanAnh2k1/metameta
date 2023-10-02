<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDataApplicationRequest extends FormRequest
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
            "name_ja" => "nullable|max:255",
            "name_en" => "nullable|max:255",
            "url" => "required|url|max:255",
            "metadata_no" => "required",
        ];
    }

    public function messages()
    {
        $maxCharacters = trans('app.validate.input.max');
        return [
            'url.required' => __('metameta.url_required'),
            'url.url' => trans('metameta.validate.url'),
            'name_ja.max' => $maxCharacters,
            'name_en.max' => $maxCharacters,
            'url.max' => $maxCharacters,
        ];
    }
}
