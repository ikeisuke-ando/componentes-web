<?php

namespace App\View\Components;

use Illuminate\View\Component;

class UserComponent extends Component
{
    public $user;
    /**
     * Create a new component instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.user-component');
    }
}
