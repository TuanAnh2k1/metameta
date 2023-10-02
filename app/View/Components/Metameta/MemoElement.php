<?php

namespace App\View\Components\Metameta;

use Illuminate\View\Component;

class MemoElement extends Component
{
    public array $memo;
    public bool $disabled;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($memo, $disabled)
    {
        $this->memo = $memo;
        $this->disabled = $disabled;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.metameta.memo-element');
    }
}
