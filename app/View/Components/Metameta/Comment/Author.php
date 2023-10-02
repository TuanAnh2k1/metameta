<?php

namespace App\View\Components\Metameta\Comment;

use Illuminate\View\Component;

class Author extends Component
{
    public ?string $author;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($author = '')
    {
        $this->author = $author;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.metameta.comment.author');
    }
}
