<?php

namespace App\View\Components\Metameta\Comment;

use Illuminate\View\Component;

class Textarea extends Component
{
    public ?string $comment;
    public ?bool $disabled;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($comment = null, $disabled = false)
    {
        $this->comment = $comment;
        $this->disabled = $disabled;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.metameta.comment.textarea');
    }
}
