<?php

namespace App\View\Components\Metameta\Comment;

use Illuminate\View\Component;

class IconShowModal extends Component
{
    public ?bool $hasComment;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($hasComment = false)
    {
        $this->hasComment = $hasComment;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.metameta.comment.icon-show-modal');
    }
}
