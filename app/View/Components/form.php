<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class form extends Component
{
    public $routeName;
    public $obj;
    public $parentId;
    public $name;
    /**
     * Create a new component instance.
     */
    public function __construct(string $routeName, $name, $obj = null, $parentId = null)
    {
        $this->name = $name;
        $this->routeName = $routeName;
        $this->obj = $obj;
        $this->parentId = $parentId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form');
    }
}
