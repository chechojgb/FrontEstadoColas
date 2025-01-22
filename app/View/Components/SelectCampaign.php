<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SelectCampaign extends Component
{
    public $name;
    public $title;
    public $options;
    public $selectedValue;

    /**
     * Crear una nueva instancia del componente.
     */
    public function __construct($name, $title, $options, $selectedValue = null)
    {
        $this->name = $name;
        $this->title = $title;
        $this->options = $options;
        $this->selectedValue = $selectedValue;
    }

    /**
     * Obtener la vista del componente.
     */
    public function render()
    {
        return view('components.select-campaign');
    }
}
