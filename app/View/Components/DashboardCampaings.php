<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DashboardCampaings extends Component
{
    public $title;
    public $actionRoute;
    public $campaignOptions;
    public $selectedCampaign;
    /**
     * Create a new component instance.
     */
    public function __construct($title, $actionRoute, $campaignOptions, $selectedCampaign = null)
    {
        $this->title = $title;
        $this->actionRoute = $actionRoute;
        $this->campaignOptions = $campaignOptions;
        $this->selectedCampaign = $selectedCampaign;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard-campaings');
    }
}
