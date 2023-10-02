<?php

namespace App\Http\Requests\Metameta;

use Illuminate\Foundation\Http\FormRequest;

class StoreMetametaRequest extends FormRequest
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
            'metameta' => 'nullable|array',
            'metameta.dataset_number' => 'nullable|integer',
            'metameta.dataset_name_ja' => 'nullable|max:255',
            'metameta.dataset_name_en' => 'nullable|max:255',
            'metameta.dataset_id' => 'nullable|max:255',
            'metameta.severity' => 'nullable',
            'metameta.remarks' => 'nullable',
            'metameta.manager' => 'nullable|max:255',
            'metameta.reception_id' => 'nullable|max:255',
            'metameta.application_progress' => 'nullable',
            'metameta.data_meeting_progress' => 'nullable',
            'metameta.leader_meeting_progress' => 'nullable',
            'metameta.data_transfer_progress' => 'nullable',
            'metameta.metadata_progress' => 'nullable',
            'metameta.download_progress' => 'nullable',
            'metameta.search_progress' => 'nullable',
            'metameta.pr_progress' => 'nullable',
            'metameta.permission' => 'nullable',
            'metameta.doi' => 'nullable|max:255',
            'metameta.category' => 'nullable',
            'metameta.release_method' => 'nullable',
            'metameta.access_permission' => 'nullable',
            'metameta.data_directory' => 'nullable|max:255',
            'metameta.metadata_ja_url' => 'nullable|url|max:255',
            'metameta.metadata_en_url' => 'nullable|url|max:255',
            'metameta.search_url' => 'nullable|url|max:255',
        ];
    }

    public function messages()
    {
        $invalidURL = trans('metameta.validate.url');
        $maxCharacters = trans('app.validate.input.max');
        return [
            'metameta.dataset_number.integer' => __('app.dataset_number_integer'),
            'metameta.metadata_ja_url.url' => $invalidURL,
            'metameta.metadata_en_url.url' => $invalidURL,
            'metameta.search_url.url' => $invalidURL,
            'metameta.dataset_name_ja.max' => $maxCharacters,
            'metameta.dataset_name_en.max' => $maxCharacters,
            'metameta.dataset_id.max' => $maxCharacters,
            'metameta.manager.max' => $maxCharacters,
            'metameta.reception_id.max' => $maxCharacters,
            'metameta.doi.max' => $maxCharacters,
            'metameta.data_directory.max' => $maxCharacters,
            'metameta.metadata_ja_url.max' => $maxCharacters,
            'metameta.search_url.max' => $maxCharacters,
        ];
    }
}
