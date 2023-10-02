<?php

namespace App\View\Components\Metameta;

use Illuminate\View\Component;

class DropdownSelector extends Component
{
    public string $title;
    public ?array $options;
    public array $elements;
    public ?int $optionSelected;
    public ?bool $disabled;
    public ?bool $hasMemo;
    public ?array $memos;
    public ?bool $hasComment;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $options, $elements, $disabled = false, $optionSelected = 0, $hasMemo = false, $memos = [], $hasComment = false)
    {
        $this->title = $title;
        $this->options = $options;
        $this->elements = $elements;
        $this->optionSelected = $optionSelected;
        $this->disabled = $disabled;
        $this->hasMemo = $hasMemo;
        $this->memos = $memos;
        $this->hasComment = $hasComment;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.metameta.dropdown-selector');
    }
}
