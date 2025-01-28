<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectOperation extends Component
{
    public $name;
    public $title;
    public $options;
    public $selectedValue;
    public function __construct($name, $title, $options, $selectedValue = null)
    {
        $this->name = $name;
        $this->title = $title;
        $this->options = $options;
        $this->selectedValue = $selectedValue;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-operation');
    }
}
