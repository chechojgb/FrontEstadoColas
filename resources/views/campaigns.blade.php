@extends('layouts.app')

@section('content')

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
            <p>
                @php
                    $operation = null;
                    
                    if (session('operationIndex')) {
                        $operationIndex = session('operationIndex') -1 ;
                        $operation = \App\Http\Controllers\VicidialController::OPERATION_OPTIONS[$operationIndex] ?? $operationIndex;
                    } elseif (session('campaignIndex')) {
                        $campaignIndex = session('campaignIndex') - 1;
                        $operation = \App\Http\Controllers\VicidialController::CAMPAIGN_OPTIONS[$campaignIndex] ?? $campaignIndex;
                    }
                @endphp
                {{ $operation }}
            </p>
            <div class="max-w-lg ml-auto mb-4">
                <div class="flex">
                    {{-- Searchh --}}
                    <div class="relative w-full flex items-center bg-gray-100 rounded-t-lg shadow-sm" style="border-bottom: 1px solid black">
                        <button type="button" class="p-3 text-gray-800">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                            <span class="sr-only">Search</span>
                        </button>
                        <input type="search" id="search-dropdown" class="block w-full bg-transparent text-gray-800 border-0 focus:ring focus:ring-blue-300 focus:outline-none focus:border-blue-500 transition appearance-none p-3" placeholder="Search" required  />
                       <x-info-popover/>
                    </div>
                    
                </div>
            </div>
            

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 text-gray-400 sm:rounded-lg rounded-lg border-collapse border-spacing-0">
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
                    </tr>
                </thead>
                <tbody id="agent-table">
                    @if (empty($agentDetails))
                        <tr>
                            <td colspan="10" class="px-6 py-4 text-center">{{__('No data available')}}.</td>
                        </tr>
                    @else
                        @foreach ($agentDetails as $agent)
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
                                            ($agent['duration1'] != "NA" || $agent['duration2'] != "NA"))
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
                                        {{ $agent['duration1'] }} / {{ $agent['duration2'] }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    
        {{-- Queue Information Container --}}
        <div class="relative mx-auto">
            <div role="tooltip" class="relative z-10  bg-white border border-gray-200 rounded-lg shadow-sm   z-950 inline-block max-w-xs p-4 border border-gray-300 rounded-lg shadow-md bg-white">
                <!-- Icono posicionado fuera del contenedor -->
                <div class="absolute -top-6 bottom-1/2 transform -translate-x-1/2 flex justify-center items-center w-12 h-12 rounded-full bg-[#00acc1] border border-gray-300" style="top: -15px; left: 20%">
                    <img src="{{ asset('images/vector.png') }}" alt="">
                </div>
                <!-- Título -->
                <h2 class="text-center text-lg font-semibold text-gray-800 mb-1 mt-6">Queue details</h2>
                <p class="text-center text-sm text-gray-600 font-medium mb-4">
                    Here you can view all details about the current campaign. If you need to make changes or get more information, please follow the links below.
                </p>
                <p class="text-center text-sm text-blue-500 mb-4">Learn more about the skill <i class="fas fa-info-circle"></i></p>
                <!-- Información -->
                <div class="text-sm text-gray-700 space-y-2">
                    <div class="mt-6" id="queueDetail">
                        
                        @if (empty($callsInQueue))
                            <p  class="px-6 py-4 text-center text-white">{{__('No data available')}}.</p>
                        @else
                            @foreach ($callsInQueue as $call)
                                <li class="text-black">{{ $call }}</li>
                                <br>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="my-4 border-t border-gray-300"></div>
            </div>

            
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
                <x-state-agent-card :count="$totalCount" state="Total_agents" :colors="$colors" image="rining"/>
            </div>
        </div>
        
    </div>
    

    <div class="hidden p-4 rounded-lg bg-gray-50 " id="allCampaings" role="tabpanel" aria-labelledby="allCampaings-tab">
        <button id="dropdownCheckboxButton" data-dropdown-toggle="dropdownDefaultCheckbox" class="text-gray-800 bg-gray-100 border border-transparent rounded-t-lg shadow-sm focus:ring focus:ring-blue-300 focus:outline-none focus:border-blue-500 transition appearance-none flex items-center space-x-3 p-4" style="border-bottom: 1px solid black" type="button">
            <span>Select a campaign</span>
            <svg class="w-3 h-3 ml-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg>
        </button>
        

        <div id="dropdownDefaultCheckbox" class="z-10 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow-sm dark:bg-gray-700 dark:divide-gray-600">
            <ul class="p-3 space-y-3 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownCheckboxButton">
                <li>
                    <div class="flex items-center">
                        <input checked id="checkbox-item-1" type="checkbox" data-campaigns="17,18,19,20,21,22,24,25,26" class="campaign-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        <label for="checkbox-item-1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Support</label>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <input checked id="checkbox-item-2" type="checkbox" data-campaigns="4,5,6,7,8,9,10,11,12,13,14,15,16,23" class="campaign-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        <label for="checkbox-item-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Formalities</label>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <input checked id="checkbox-item-3" type="checkbox" data-campaigns="27,28,29,30,31,32,33,34,35,37" class="campaign-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        <label for="checkbox-item-3" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Mobiles</label>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <input checked id="checkbox-item-4" type="checkbox" data-campaigns="1,2,3" class="campaign-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        <label for="checkbox-item-3" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Retention</label>
                    </div>
                </li>
            </ul>
        </div>
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
                    <div data-id="{{ $campaignId }}" class="campaign-item w-72 bg-{{ $bgColor }} text-white rounded-lg shadow-md p-4 transition-transform transform hover:scale-105">
                        <div class="flex justify-between items-center border-b border-gray-700 pb-2">
                            <span class="font-semibold text-[#00acc1] truncate">{{ $campaignId }}. {{ $campaignName }}</span>
                        </div>
                        <div class="pt-2 flex justify-between items-center">
                            <span class="text-sm text-gray-900">{{ $calls }} Calls</span>
                            <button data-modal-target="{{ $modalId }}" data-modal-toggle="{{ $modalId }}" class="bg-[#00acc1] hover:bg-bg-[#00acc1] text-white font-bold py-2 px-6 rounded-lg shadow-lg justify-end">
                                View more
                            </button>
                        </div>  
                    </div>
                    <div id="{{ $modalId }}" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center bg-gray-900 bg-opacity-50">
                        <div class="relative p-4 w-full max-w-2xl max-h-full">
                            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                        {{ $campaignName }}
                                    </h3>
                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="{{ $modalId }}">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <div class="p-4 md:p-5 space-y-4">
                                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                        Detailed information about the campaign {{ $campaignName }}.
                                    </p>
                                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                       {{__('Unanswered calls')}}: {{ $calls }} 
                                    </p>
                                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                        {{__('Connected agents')}}: {{ $calls }} 
                                    </p>
                                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                        {{__('Agents available')}}: {{ $calls }} 
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @endif
                @endforeach
            @endif
        </div>
        
        


    </div>
</div>


@endsection



