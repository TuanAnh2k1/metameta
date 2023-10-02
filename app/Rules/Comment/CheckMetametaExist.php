<?php

namespace App\Rules\Comment;

use App\Models\Metameta;
use Illuminate\Contracts\Validation\InvokableRule;

class CheckMetametaExist implements InvokableRule
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
        if (empty($value)) return $this->failed($fail);
        if(empty(Metameta::where('id','=', $value)->whereNull('deleted_at')->first())) return $this->failed($fail);
    }

    /**
     * @param $fail
     * @return mixed
     */
    protected function failed($fail)
    {
        return $fail(trans('metameta.validate.exists'));
    }
}
