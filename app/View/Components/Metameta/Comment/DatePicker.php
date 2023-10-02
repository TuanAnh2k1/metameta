<?php

namespace App\View\Components\Metameta\Comment;

use App\Core\Helper\DateHelper;
use Illuminate\View\Component;

class DatePicker extends Component
{
    public ?string $date;
    public ?bool $disabled;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($date = null, $disabled = false)
    {
        $this->date = $date ?: DateHelper::now('Y-m-d');
        $this->disabled = $disabled;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.metameta.comment.date-picker');
    }
}
