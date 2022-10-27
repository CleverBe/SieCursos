<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $texto, $color;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($texto = '', $color = 'secondary')
    {
        $this->texto = $texto;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button');
    }
}
