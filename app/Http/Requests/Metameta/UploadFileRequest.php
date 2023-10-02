<?php

namespace App\Http\Requests\Metameta;

use App\Rules\FileTypeCheck;
use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
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
            'note' => 'nullable|max:255',
            'files' => [
                'required',
                'file',
                new FileTypeCheck(),
                'max:5119',
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => trans('app.upload_failed'),
            'files.file' => trans('app.invalid'),
            'files.mimes' => trans('app.invalid'),
            'files.max' => trans('app.file_size_limit'),
            'note.max' => trans('app.validate.input.max'),
        ];
    }
}
