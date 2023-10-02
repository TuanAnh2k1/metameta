<?php

namespace App\Rules;

use App\Models\Attachment;
use Illuminate\Contracts\Validation\InvokableRule;

class FileTypeCheck implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $type = $value->getClientOriginalExtension();
        if(!in_array($type,Attachment::MIMETYPE)) return $this->failed($fail);
    }

    protected function failed($fail)
    {
        return $fail(trans('validation.rules.file_type_check'));
    }
}
