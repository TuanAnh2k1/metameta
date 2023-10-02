<?php

namespace App\View\Components\Metameta\Comment;

use Illuminate\View\Component;

class Element extends Component
{
    public array $comment;
    public array $options;
    public ?bool $disabled;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $comment, $options, $disabled = false)
    {
        $this->comment = $comment;
        $this->options = $options;
        $this->disabled = $disabled;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.metameta.comment.element');
    }
}
