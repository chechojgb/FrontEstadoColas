<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class stateAgentCard extends Component
{
    /**
     * Create a new component instance.
     */
    public $count;
    public $state;
    public $colors;

    public function __construct($count, $state, $colors = [])
    {
        $this->count = $count;
        $this->state = $state;
        $this->colors = $colors;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.state-agent-card');
    }
}
