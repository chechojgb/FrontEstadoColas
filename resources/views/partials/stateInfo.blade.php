<div id="stateInfo">
    @php
        $countInCall = !empty($agentDetails) ? collect($agentDetails)->filter(fn($agent) => $agent['state'] === 'in call')->count() : 0;
        $countOnHold = !empty($agentDetails) ? collect($agentDetails)->filter(fn($agent) => $agent['state'] === 'On Hold')->count() : 0;
        $countBusy = !empty($agentDetails) ? collect($agentDetails)->filter(fn($agent) => $agent['state'] === 'Busy')->count() : 0;
        $countNotInUse = !empty($agentDetails) ? collect($agentDetails)->filter(fn($agent) => $agent['state'] === 'Not in use')->count() : 0;
        $countRinging = !empty($agentDetails) ? collect($agentDetails)->filter(fn($agent) => $agent['state'] === 'Ringing')->count() : 0;

        $totalCount = $countInCall + $countOnHold + $countBusy + $countNotInUse + $countRinging;

        $colors = [
            'in call' => '#4A90E2',
            'On Hold' => '#E74C3C',
            'Busy' => '#F1C40F',
            'Not in use' => '#2ECC71',
            'Ringing' => '#c2c2c2',
        ];
    @endphp

    <x-state-agent-card :count="$countInCall" state="in call" :colors="$colors" image="in-call"/>
    <x-state-agent-card :count="$countOnHold" state="On Hold" :colors="$colors" image="on-hold"/>
    <x-state-agent-card :count="$countBusy" state="Busy" :colors="$colors" image="busy"/>
    <x-state-agent-card :count="$countNotInUse" state="Not in use" :colors="$colors" image="not-in-use"/>
    <x-state-agent-card :count="$countRinging" state="Ringing" :colors="$colors" image="rining"/>
    <x-state-agent-card :count="$totalCount" state="Total Agents conected" :colors="$colors" image="totalAgents"/>
</div>
