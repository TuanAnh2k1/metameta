<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\InvokableRule;

class ColumnIsFreezeCheck implements DataAwareRule,  InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    protected $data = [];

    // ...

    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData($data): static
    {
        $this->data = $data;

        return $this;
    }
    public function __invoke($attribute, $value, $fail)
    {
        $isCheck = false;
        $notCheck = false;
        $isNull = false;
        $dataIsDisplay = [];
        foreach ($this->data['settings'] as $item) {
            if($item['is_display'] == 1) {
                array_push($dataIsDisplay, $item);
            }
        }
        if(empty($dataIsDisplay)){
            return $this->leastOneField($fail);
        }
        if($dataIsDisplay[0]['is_display'] == 1 && $dataIsDisplay[0]['is_freeze'] == 1){
            $isCheck = true;
        }
        foreach ($dataIsDisplay as $item) {
            if($notCheck && $item['is_freeze'] == 1){
                $isCheck = false;
                $isNull = true;
                break;
            }
            if($item['is_freeze'] != 1) {
                $notCheck = true;
            }
        }
        if(!$isCheck && $isNull){
            return $this->failed($fail);
        }
        return true;
    }
    protected function failed($fail)
    {
        return $fail(trans('validation.rules.is_freeze'));
    }

    protected function leastOneField($fail)
    {
        return $fail(trans('metameta.least_one_field'));
    }
}
