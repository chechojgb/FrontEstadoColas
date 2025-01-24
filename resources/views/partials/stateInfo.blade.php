<div id="stateInfo">
    <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
        @php
            $countInCall = !empty($agentDetails) ? collect($agentDetails)->filter(function ($agent) {
                return isset($agent['state']) && $agent['state'] === 'in call';
            })->count() : 0;
        @endphp 
        {{$countInCall}} Users in state: <span class="font-medium">In call!</span> 
    </div>
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        @php
            $countOnHold = !empty($agentDetails) ? collect($agentDetails)->filter(function ($agent) {
                return isset($agent['state']) && $agent['state'] === 'On Hold';
            })->count() : 0;
        @endphp 
        {{$countOnHold}} Users in state: <span class="font-medium">On hold.</span>
    </div>
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        @php
            $countBusy = !empty($agentDetails) ? collect($agentDetails)->filter(function ($agent) {
                return isset($agent['state']) && $agent['state'] === 'Busy';
            })->count() : 0;
        @endphp 
        {{$countBusy}} Users in state: <span class="font-medium">Busy.</span>
    </div>
    <div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
        @php
            $countNotInUse = !empty($agentDetails) ? collect($agentDetails)->filter(function ($agent) {
                return isset($agent['state']) && $agent['state'] === 'Not in use';
            })->count() : 0;
        @endphp 
        {{ $countNotInUse }} Users in state: <span class="font-medium">Not in use!</span>
    </div>
    <div class="p-4 text-sm text-gray-800 rounded-lg bg-gray-50 dark:bg-gray-800 dark:text-gray-300" role="alert">
        @php
            $countInRinging = !empty($agentDetails) ? collect($agentDetails)->filter(function ($agent) {
                return isset($agent['state']) && $agent['state'] === 'Ringing';
            })->count() : 0;
        @endphp 
        {{$countInRinging}} Users in state: <span class="font-medium">Ringing!</span>
    </div>
</div>