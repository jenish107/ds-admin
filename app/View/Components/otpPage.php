<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class otpPage extends Component
{
    public $routeName;
    /**
     * Create a new component instance.
     */
    public function __construct($routeName)
    {
        $this->routeName = $routeName;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.otp-page');
    }
}
