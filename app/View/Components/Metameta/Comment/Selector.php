<?php

namespace App\View\Components\Metameta\Comment;

use Illuminate\View\Component;

class Selector extends Component
{
    public string $name;
    public array $options;
    public ?int $selected;
    public ?bool $disabled;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $options, $selected = 0, $disabled = false)
    {
        $this->name = $name;
        $this->options = $options;
        $this->selected = $selected;
        $this->disabled = $disabled;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.metameta.comment.selector');
    }
}
