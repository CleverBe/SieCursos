<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Label extends Component
{
    public $texto;

    /**
     * Create a new component instance.
     *
     * @return void
     */

    public function __construct($texto)
    {
        $this->texto = $texto;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.label');
    }
}
