<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class form extends Component
{
    public $routeName;
    public $obj;
    /**
     * Create a new component instance.
     */
    public function __construct(string $routeName, $obj = null)
    {
        $this->routeName = $routeName;
        $this->obj = $obj;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form');
    }
}
