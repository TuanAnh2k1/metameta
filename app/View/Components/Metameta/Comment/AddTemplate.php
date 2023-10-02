<?php

namespace App\View\Components\Metameta\Comment;

use App\Core\Helper\DateHelper;
use App\Core\Helper\MetametaElementHelper;
use Illuminate\View\Component;

class AddTemplate extends Component
{
    public array $options;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->options = MetametaElementHelper::transformMetadataElements();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.metameta.comment.add-template');
    }
}
