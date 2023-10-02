<?php

namespace App\View\Components\Metameta\FormGroup;

use Illuminate\View\Component;

class Text extends Component
{
    public array $elements;
    public string $title;
    public ?string $value;
    public ?bool $disabled;
    public ?bool $inputDisabled;
    public ?bool $hasBlank;
    public ?bool $hasComment;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($elements, $title, $value = "", $disabled = false, $inputDisabled = false, $hasBlank = false,$hasComment = false)
    {
        $this->elements = $elements;
        $this->title = $title;
        $this->value = $value;
        $this->disabled = $disabled;
        $this->inputDisabled = $inputDisabled;
        $this->hasBlank = $hasBlank;
        $this->hasComment = $hasComment;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.metameta.form-group.text');
    }
}
