<?php

namespace App\Rules;

use App\Core\Helper\MetametaElementHelper;
use Illuminate\Contracts\Validation\InvokableRule;

class ColumnNameCheck implements InvokableRule
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
        $showableColumn = MetametaElementHelper::showableColumnNames();
        $notFound = true;
        foreach ($showableColumn as $column) {
            if(trans('metameta.'.$column) == $value) {
                $notFound = false;
            }
        }
        if($notFound) return $this->failed($fail);
    }

    protected function failed($fail)
    {
        return $fail(trans('validation.rules.name_check'));
    }
}
