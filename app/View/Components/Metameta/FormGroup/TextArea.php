<?php

namespace App\View\Components\Metameta\FormGroup;

use Illuminate\View\Component;

class TextArea extends Component
{
    public array $elements;
    public string $title;
    public ?string $value;
    public ?bool $disabled;
    public ?bool $hasComment;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($elements, $title, $value = "", $disabled = false,$hasComment = false)
    {
        $this->elements = $elements;
        $this->title = $title;
        $this->value = $value;
        $this->disabled = $disabled;
        $this->hasComment = $hasComment;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.metameta.form-group.text-area');
    }
}
