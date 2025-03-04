@extends('layouts.app')

@section('content')



<div id="indexPartial">

    
    <div class="mb-4 border-b border-gray-200 border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
            <li class="me-2" role="presentation">
                <button class="  inline-block p-4 border-b-2 rounded-t-lg hover:border-[#00acc1] hover:text-[#00acc1]" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Campaings Selected</button>
            </li>
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-[#00acc1] hover:text-[#00acc1]" id="allCampaings-tab" data-tabs-target="#allCampaings" type="button" role="tab" aria-controls="allCampaings" aria-selected="false">Alls campaings</button>
            </li>
    
        </ul>
    </div>
    <div id="default-tab-content">
        <div class="flex p-4 rounded-lg bg-gray-50 " id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <!-- Table Container -->
            <div class="w-full pr-4" >
                <div class="flex justify-between">
                    <x-search.operation-title />
                
                    <div class="max-w-lg w-1/2 mb-4">
                        <div class="flex">
                            <x-search.search-bar />
                        </div>
                    </div>
                </div>
                
                
                {{-- min-w-full table-auto border-collapse rounded-lg overflow-hidden --}}
                <table class="overflow-hidden w-full text-sm text-left rtl:text-right text-gray-500 text-gray-400  rounded-lg border-collapse border-spacing-0">
                    <thead class="text-xs text-white uppercase bg-[#00acc1] text-white bg-soul-1 border-none sm:rounded-lg">
                        <tr>
                            <th scope="col" class="px-6 py-3 border-none">
                                {{__('Extension')}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{__('User name')}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{__('IP User')}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{__('Call State')}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{__('State in asterisk')}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{__('Management times')}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                            </th>
                        </tr>
                    </thead>
                    <tbody id="agent-table">
                        <div id="toast-container" class="fixed top-5 right-5 space-y-2 z-50 flex flex-col"></div>
                        @if (empty($agentDetails))
                            <tr>
                                <td colspan="10" class="px-6 py-4 text-center">{{ __('No data available') }}.</td>
                            </tr>
                        @else
                            @foreach ($agentDetails as $agent)
                                @php
                                    $duration2 = $agent['duration2'] ?? '00:00:00';
                                    $timeInSeconds = strtotime("1970-01-01 " . $duration2 . " UTC") - strtotime("1970-01-01 00:00:00 UTC");
                    
                                    if ($agent['state'] == 'Not in use') {
                                        $buttonstatus = 'bg-gray-200';
                                        $idStatus = 'notUserStatus';
                                    } elseif ($timeInSeconds <= 600) {
                                        $buttonstatus = 'bg-green-500';
                                        $idStatus = 'activeStatus';
                                    } elseif ($timeInSeconds >= 600 && $timeInSeconds <= 900) { 
                                        $buttonstatus = 'bg-yellow-500';
                                        $idStatus = 'activeStatus';
                                    } elseif ($timeInSeconds >= 900 && $timeInSeconds <= 1200) { 
                                        $buttonstatus = 'bg-orange-500';
                                        $idStatus = 'activeStatus';
                                    } elseif ($timeInSeconds > 1200) { 
                                        $buttonstatus = 'bg-red-500';
                                        $idStatus = 'activeStatus';
                                    } else { 
                                        $buttonstatus = 'bg-gray-200';
                                        $idStatus = 'notUserStatus';
                                    }
                                @endphp
                    
                                <tr class="odd:bg-white even:bg-gray-50 border-b">
                                    <td scope="row" class="px-6 py-4 text-gray-900 whitespace-nowrap">
                                        {{ $agent['extension'] }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if (isset($agent['name']))
                                            {{ $agent['name'] }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if (isset($agent['call_state']))
                                            {{ $agent['ipUser'] }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if (isset($agent['call_state']))
                                            @if ($agent['call_state'] == 'Call finished' && 
                                                ($agent['duration1'] != "NA" || $agent['duration2'] != "NA") && $agent['call_state'] != 'Not in use')
                                                {{ 'In transfer' }} 
                                            @else
                                                {{ $agent['call_state'] }} 
                                            @endif
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $agent['state'] }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if (isset($agent['call_state']))
                                            {{ $agent['duration2'] }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 flex">
                                        <button>
                                            <img src="{{ asset('images/editButton.svg') }}" alt="editAgent{{ $agent['name'] ?? '' }}">
                                        </button>
                                        <div class="pt-2">
                                            <span class="flex w-3 h-3 me-3 rounded-full ml-4 pt-2 {{ $buttonstatus }} {{$idStatus}}"></span>
                                        </div>
                                    </td>
                                </tr>
          
                                @if ($timeInSeconds > 990)
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function () {
                                            addToast("{{ $agent['name'] }}", "{{ $agent['duration2'] }}");
                                        });
                                    </script>
                                @endif
                            @endforeach
                        @endif
    
                        <script>
                            function addToast(user, time) {
                                let container = document.getElementById("toast-container");
                        
                                let toast = document.createElement("div");
                                toast.className = "toast flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-700 justify-end";
                                toast.innerHTML = `
                                    <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-orange-500 bg-orange-100 rounded-lg dark:bg-orange-700 dark:text-orange-200">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>
                                        </svg>
                                    </div>
                                    <div class="ms-3 text-sm font-normal">El usuario <strong>${user}</strong> lleva <strong>${time}</strong> en gestión.</div>
                                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-700 dark:hover:bg-gray-700" onclick="closeToast(this)">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                    </button>
                                `;
                        
                                container.appendChild(toast);
                        
                                // Eliminar automáticamente después de 5 segundos
                                setTimeout(() => toast.remove(), 5000);
                            }
                        
                            function closeToast(button) {
                                let toast = button.parentElement;
                                toast.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                                setTimeout(() => toast.remove(), 500);
                            }
                        </script>
                    </tbody>
                </table>
            </div>
        
            {{-- Queue Information Container --}}
            <div class="relative mx-auto">
                <x-queue-details :callsInQueue="$callsInQueue ?? 0" />
    
    
                
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
                    <x-state-agent-card :count="$totalCount" state="Total_agents" :colors="$colors" image="totalAgents"/>
                </div>
            </div>
            
        </div>
        
    
        <div class="hidden p-4 rounded-lg  " id="allCampaings" role="tabpanel" aria-labelledby="allCampaings-tab">
            <div class="bg-gray-50">
                <x-selectorOperationAll />
    
                
                <div class="flex flex-wrap gap-4 mt-4" id="allCampaingsRefresh">
                    @if (empty($membersSummaryAll))
                        <p class="text-gray-500">No campaign selected</p>
                    @else
                        @foreach ($membersSummaryAll as $index => $allCampaign)
                            @php
                                preg_match('/^(\d+)\s.*?(\d+) calls$/', $allCampaign, $matches);
                                $campaignId = $matches[1] ?? null;
                                $calls = isset($matches[2]) ? (int) $matches[2] : 0;
                                if ($calls === 0) {
                                    $bgColor = 'gray-100';
                                } elseif ($calls > 0 && $calls <= 3) {
                                    $bgColor = 'blue-200';
                                } else {
                                    $bgColor = 'red-300';
                                }
                                $modalId = $campaignId+1;
                                $campaignName = $campaignOptions[$campaignId - 1] ?? "Unknown Campaign";
                            @endphp
                            @if ($campaignId)
                                <x-allCampaingsItem :campaignId="$campaignId" :calls="$calls" :bgColor="$bgColor" :modalId="$modalId" :campaignName="$campaignName" />
                            @endif
                        @endforeach
                    @endif
                </div>
    
            </div>
    
            {{-- <div class="flex flex-wrap gap-4 mt-8 mb-8">
                <div id="containerGraphics"> </div>
                <div id="containerGraphicsTMOandASA"></div>
        
                <script>
                    var chartData = @json($data ?? 'Not data available');
                    var chartDataTMO = @json($dataASAandTMO ?? 'Not data available');
                    console.log("Datos enviados al JS:", chartData);
                </script>
            </div> --}}
    
        </div>
    
    </div>
</div>





@endsection