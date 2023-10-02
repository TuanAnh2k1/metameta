<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class ColumnWidthCheck implements InvokableRule
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
        if(!ctype_digit($value) && !empty($value)) return $this->failed($fail);
    }

    protected function failed($fail)
    {
        return $fail(trans('validation.rules.width_check'));
    }
}
