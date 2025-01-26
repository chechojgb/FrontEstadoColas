@extends('layouts.app')

@section('content')


{{-- <section class="fixed max-w-md p-4 mx-auto bg-white border border-gray-200 dark:bg-gray-800 left-12 bottom-16 dark:border-gray-700 rounded-2xl">
    <h2 class="font-semibold text-gray-800 dark:text-white">🍪 Cookie Notice</h2>

    <p class="mt-4 text-sm text-gray-600 dark:text-gray-300">We use cookies to ensure that we give you the best experience on our website. <a href="#" class="text-blue-500 hover:underline">Read cookies policies</a>. </p>
    
    <div class="flex items-center justify-between mt-4 gap-x-4 shrink-0">
        <button class="text-xs text-gray-800 underline transition-colors duration-300 dark:text-white dark:hover:text-gray-400 hover:text-gray-600 focus:outline-none">
            Manage your preferences
        </button>

        <button class=" text-xs bg-gray-900 font-medium rounded-lg hover:bg-gray-700 text-white px-4 py-2.5 duration-300 transition-colors focus:outline-none">
            Accept
        </button>
    </div>
</section> --}}




{{-- <div class="w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-8 dark:bg-gray-800 dark:border-gray-700">
    <div class="flex items-center justify-between mb-4">
        <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Skills of campaings selected</h5>
   </div>
   <div class="flow-root">
        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
            <li class="py-3 sm:py-4">
                <div class="flex items-center">
                    <div class="shrink-0">
                        <img class="w-8 h-8 rounded-full" src="/docs/images/people/profile-picture-1.jpg" alt="Neil image">
                    </div>
                    <div class="flex-1 min-w-0 ms-4">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                            1 
                        </p>
                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                            email@windster.com
                        </p>
                    </div>
                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                        $320
                    </div>
                </div>
            </li>
        </ul>
   </div>
</div> --}}








 
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
        <!-- Contenedor de la tabla -->
        <div class="w-full pr-4" >
            
            <div class="max-w-lg ml-auto mb-4">
                <div class="flex">
                    {{-- Busqueda --}}
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
                            {{__('Last Call ID')}}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{__('Call State')}}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{__('State in asterisk')}}
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
                                        {{ $agent['call_id'] }}
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if (isset($agent['call_state']))
                                        {{ $agent['call_state'] }}
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    {{ $agent['state'] }}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    

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
                <!-- Acciones -->
                {{-- <div class="flex justify-between mt-4 text-gray-600">
                    <button class="flex items-center space-x-2 text-sm hover:text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.28 0 4-1.72 4-4s-1.72-4-4-4-4 1.72-4 4 1.72 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>
                        <span>Ver</span>
                    </button>
                    <button class="flex items-center space-x-2 text-sm hover:text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19.14 7.64l-3.79-3.79-8.73 8.73 3.79 3.79 8.73-8.73zM4.73 19.27l.7.7 3.79-3.79-1.44-1.44-3.05 3.05v1.48z" />
                        </svg>
                        <span>Editar</span>
                    </button>
                    <button class="flex items-center space-x-2 text-sm hover:text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.28 0 4-1.72 4-4s-1.72-4-4-4-4 1.72-4 4 1.72 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>
                        <span>Gestionar</span>
                    </button>
                </div> --}}
            </div>

            
            <div id="stateInfo">

                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-md rounded-2xl bg-clip-border cursor-pointer hover:shadow-xl hover:bg-blue-100 transition-all duration-300 mt-2 mb-2">
                    <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex items-center justify-center w-12 h-12 bg-[#50d71e] rounded-full text-white text-xl  mr-4 ml-2" style="background-color: #51B0CB">
                            <img src="{{ asset('images/vector.png') }}" alt="">
                        </div>
                        @php
                            $countInCall = !empty($agentDetails) ? collect($agentDetails)->filter(function ($agent) {
                                return isset($agent['state']) && $agent['state'] === 'in call';
                            })->count() : 0;
                        @endphp 
                        
                        <div class="flex-none w-2/3 max-w-full px-3">
                        <div>
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal font-poppins text-gray-400">Users in state</p>
                            <h5 class="mb-0 font-poppins">{{$countInCall}}
                            <span class="text-sm leading-normal font-weight-bolder text-black font-poppins text-blue-300">In call!</span>
                            </h5>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-md rounded-2xl bg-clip-border cursor-pointer hover:shadow-xl hover:bg-blue-100 transition-all duration-300 mt-2 mb-2">
                    <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex items-center justify-center w-12 h-12 bg-[#50d71e] rounded-full text-white text-xl  mr-4 ml-2" style="background-color: #51B0CB">
                            <img src="{{ asset('images/vector.png') }}" alt="">
                        </div>
                        @php
                            $countOnHold = !empty($agentDetails) ? collect($agentDetails)->filter(function ($agent) {
                                return isset($agent['state']) && $agent['state'] === 'On Hold';
                            })->count() : 0;
                        @endphp 
                        
                        <div class="flex-none w-2/3 max-w-full px-3">
                        <div>
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal font-poppins text-gray-400">Users in state</p>
                            <h5 class="mb-0 font-poppins">{{$countOnHold}}
                            <span class="text-sm leading-normal font-weight-bolder text-black font-poppins text-red-300">On hold.</span>
                            </h5>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-md rounded-2xl bg-clip-border cursor-pointer hover:shadow-xl hover:bg-blue-100 transition-all duration-300 mt-2 mb-2">
                    <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex items-center justify-center w-12 h-12 bg-[#50d71e] rounded-full text-white text-xl  mr-4 ml-2" style="background-color: #51B0CB">
                            <img src="{{ asset('images/vector.png') }}" alt="">
                        </div>
                        @php
                            $countBusy = !empty($agentDetails) ? collect($agentDetails)->filter(function ($agent) {
                                return isset($agent['state']) && $agent['state'] === 'Busy';
                            })->count() : 0;
                        @endphp  
                        
                        <div class="flex-none w-2/3 max-w-full px-3">
                        <div>
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal font-poppins text-gray-400">Users in state</p>
                            <h5 class="mb-0 font-poppins">{{$countBusy}}
                            <span class="text-sm leading-normal font-weight-bolder text-black font-poppins text-green-300">Busy.</span>
                            </h5>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-md rounded-2xl bg-clip-border cursor-pointer hover:shadow-xl hover:bg-blue-100 transition-all duration-300 mt-2 mb-2">
                    <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex items-center justify-center w-12 h-12 bg-[#50d71e] rounded-full text-white text-xl  mr-4 ml-2" style="background-color: #51B0CB">
                            <img src="{{ asset('images/vector.png') }}" alt="">
                        </div>
                        @php
                            $countNotInUse = !empty($agentDetails) ? collect($agentDetails)->filter(function ($agent) {
                                return isset($agent['state']) && $agent['state'] === 'Not in use';
                            })->count() : 0;
                        @endphp 
                        
                        <div class="flex-none w-2/3 max-w-full px-3">
                        <div>
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal font-poppins text-gray-400">Users in state</p>
                            <h5 class="mb-0 font-poppins">{{$countNotInUse}}
                            <span class="text-sm leading-normal font-weight-bolder text-black font-poppins text-gray-800">Not in use!</span>
                            </h5>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-md rounded-2xl bg-clip-border cursor-pointer hover:shadow-xl hover:bg-blue-100 transition-all duration-300 mt-2 mb-2">
                    <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex items-center justify-center w-12 h-12 bg-[#50d71e] rounded-full text-white text-xl  mr-4 ml-2" style="background-color: #51B0CB">
                            <img src="{{ asset('images/vector.png') }}" alt="">
                        </div>
                        @php
                            $countInRinging = !empty($agentDetails) ? collect($agentDetails)->filter(function ($agent) {
                                return isset($agent['state']) && $agent['state'] === 'Ringing';
                            })->count() : 0;
                        @endphp 
                        
                        <div class="flex-none w-2/3 max-w-full px-3">
                        <div>
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal font-poppins text-gray-400">Users in state</p>
                            <h5 class="mb-0 font-poppins">{{$countInRinging}}
                            <span class="text-sm leading-normal font-weight-bolder text-black font-poppins text-gray-300">Ringing!</span>
                            </h5>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                
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
        <div class="flex flex-col gap-4 p-4">
            <div class="bg-gray-200 rounded-lg flex-grow overflow-auto max-h-96 p-4">
                <div class="bg-gray-200 rounded-lg flex-grow overflow-auto max-h-96">
                    <div class="flex flex-wrap gap-2" id="allCampaingsRefresh">
                        @if (empty($membersSummaryAll))
                            <p class="text-gray-500">No campaign selected</p>
                        @else
                            @foreach ($membersSummaryAll as $index => $allCampaign)
                                @php
                                    // Extraemos el ID de la campaña y la cantidad de llamadas
                                    preg_match('/^(\d+)\s.*?(\d+) calls$/', $allCampaign, $matches);
                                    $campaignId = $matches[1] ?? null;
                                    $calls = isset($matches[2]) ? (int) $matches[2] : 0;
                
                                    // Determinamos el color según la cantidad de llamadas
                                    if ($calls === 0) {
                                        $bgColor = 'gray-100';
                                    } elseif ($calls > 0 && $calls <= 3) {
                                        $bgColor = 'blue-200';
                                    } else {
                                        $bgColor = 'red-300';
                                    }
                
                                    // Obtenemos el nombre de la campaña desde las opciones pasadas
                                    $campaignName = $campaignOptions[$campaignId] ?? "Unknown Campaign";
                                @endphp
                                @if ($campaignId)
                                    <span 
                                        data-id="{{ $campaignId }}" 
                                        class="campaign-item bg-{{ $bgColor }} text-{{ $bgColor }}-800 text-sm font-medium px-2.5 py-0.5 rounded-sm dark:bg-{{ $bgColor }}-900 dark:text-{{ $bgColor }}-300"
                                    >
                                        {{ $index + 1 }}. {{ $campaignName }} {{ $calls }} calls
                                    </span>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
                
            </div>
            
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                <div class="h-32 bg-gray-200 rounded-lg"></div>
                <div class="h-32 bg-gray-200 rounded-lg"></div>
                <div class="h-32 bg-gray-200 rounded-lg"></div>
                <div class="h-32 bg-gray-200 rounded-lg"></div>
                <div class="h-32 bg-gray-200 rounded-lg"></div>
            </div>
        </div>
        
        
        
        <!-- Dropdown menu -->
        
    

        
        {{-- <script>
            const checkboxes = document.querySelectorAll(".campaign-checkbox");
            const campaignContainer = document.querySelector("#allCampaingsRefresh");
            
            // Función para inicializar la visibilidad de los elementos dinámicos
            const initializeFilter = () => {
                const campaignElements = campaignContainer.querySelectorAll(".campaign-item");
        
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener("change", () => {
                        // Obtener todos los IDs activos de las campañas seleccionadas
                        const activeCampaigns = Array.from(checkboxes)
                            .filter(checkbox => checkbox.checked)
                            .flatMap(checkbox => checkbox.dataset.campaigns.split(",").map(Number)); // Convertimos a números
        
                        // Mostrar/ocultar las campañas dinámicamente
                        campaignElements.forEach(campaignElement => {
                            const campaignId = parseInt(campaignElement.dataset.id, 10); // ID como número
                            if (activeCampaigns.includes(campaignId)) {
                                campaignElement.style.display = "inline-block";
                            } else {
                                campaignElement.style.display = "none";
                            }
                        });
                    });
                });
        
                // Inicializa mostrando todas las campañas
                checkboxes.forEach(checkbox => checkbox.dispatchEvent(new Event("change")));
            };
        
            // Reejecutar el filtro después del refresh
            document.addEventListener("DOMContentLoaded", initializeFilter);
        </script> --}}
        
    </div>
</div>

{{-- <script>
    document.getElementById('search-dropdown').addEventListener('input', function () {
        const query = this.value.toLowerCase();
        const rows = document.querySelectorAll('#agent-table tr');

        rows.forEach(row => {
            const cells = Array.from(row.getElementsByTagName('td'));
            const rowContent = cells.map(cell => cell.textContent.toLowerCase()).join(' ');

            row.style.display = rowContent.includes(query) ? '' : 'none';
        });
    });
</script> --}}

@endsection




{{-- 
<script>
    const REFRESH_RATE = 8;
    console.log(REFRESH_RATE);
    
    let secondsPassed = 0;
    setInterval(() => {
        secondsPassed++;
        console.log(`Seconds passed: ${secondsPassed}`);
    }, 1000);

    document.addEventListener('DOMContentLoaded', function () {
        let searchValue = '';

        const searchInput = document.querySelector('#search-dropdown');
        searchInput.addEventListener('input', function () {
            searchValue = searchInput.value; 
            filterTable(); 
        });

        // Función para aplicar el filtro
        function filterTable() {
            const rows = document.querySelectorAll('#agent-table tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchValue.toLowerCase())) {
                    row.style.display = ''; // Mostrar fila
                } else {
                    row.style.display = 'none'; // Ocultar fila
                }
            });
        }

        // Refrescar la tabla manteniendo el filtro
        async function loadTableContent() {
            try {
                const response = await fetch('/real-time-table-refresh');
                if (!response.ok) throw new Error('Error al cargar la tabla');
                const tableContent = await response.text();
                document.querySelector('#agent-table').innerHTML = tableContent;

                filterTable();
                console.log('Tabla actualizada');
            } catch (error) {
                console.error('Error al actualizar la tabla:', error);
            }
        }
        async function loadQueueDetail() {
            try {
                const response = await fetch('/real-time-queueDetail-refresh');
                if (!response.ok) throw new Error('Error al cargar los detail queue');
                if (response.ok) {
                    console.log('queueDetail actualizados');
                }
                const iconContent = await response.text(); // Obtén el HTML como texto
                document.querySelector('#queueDetail').innerHTML = iconContent;
            } catch (error) {
                console.error('Error al actualizar los queueDetail:', error);
            }
        }

        async function loadstateInfo() {
            try {
                const response = await fetch('/real-time-stateInfo-refresh');
                if (!response.ok) throw new Error('Error al cargar los  stateInfo');
                if (response.ok) {
                    console.log('stateInfo actualizados');
                }
                const iconContent = await response.text(); // Obtén el HTML como texto
                document.querySelector('#stateInfo').innerHTML = iconContent;
            } catch (error) {
                console.error('Error al actualizar los stateInfo:', error);
            }
        }

    



        function assignCheckboxEvents() {
            const checkboxes = document.querySelectorAll(".campaign-checkbox");
            const campaignElements = document.querySelectorAll(".campaign-item"); // Cambiado a ".campaign-item" para span dinámicos

            // Escucha los cambios en los checkboxes
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", () => {
                    // Obtener todos los IDs activos de las campañas seleccionadas
                    const activeCampaigns = Array.from(checkboxes)
                        .filter(checkbox => checkbox.checked)
                        .flatMap(checkbox => checkbox.dataset.campaigns.split(",").map(Number)); // Convertimos a números

                    // Mostrar/ocultar las campañas dinámicamente
                    campaignElements.forEach(campaignElement => {
                        const campaignId = parseInt(campaignElement.dataset.id, 10); // ID como número
                        if (activeCampaigns.includes(campaignId)) {
                            campaignElement.style.display = "inline-block";
                        } else {
                            campaignElement.style.display = "none";
                        }
                    });
                });
            });

            // Inicializa mostrando todas las campañas
            checkboxes.forEach(checkbox => checkbox.dispatchEvent(new Event("change")));
        }


        // Guarda la selección de los checkboxes
        function saveCheckboxState() {
            const checkboxes = document.querySelectorAll(".campaign-checkbox");
            const selectedCampaigns = [];

            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    selectedCampaigns.push(checkbox.id); // Usa el ID del checkbox como referencia
                }
            });

            // Guarda los IDs de los checkboxes seleccionados en localStorage
            localStorage.setItem("selectedCampaigns", JSON.stringify(selectedCampaigns));
        }

        // Restaura el estado de los checkboxes
        function restoreCheckboxState() {
            const selectedCampaigns = JSON.parse(localStorage.getItem("selectedCampaigns")) || [];

            const checkboxes = document.querySelectorAll(".campaign-checkbox");

            checkboxes.forEach(checkbox => {
                checkbox.checked = selectedCampaigns.includes(checkbox.id);
            });
        }

        // Llama a saveCheckboxState cada vez que cambie un checkbox
        document.querySelectorAll(".campaign-checkbox").forEach(checkbox => {
            checkbox.addEventListener("change", saveCheckboxState);
        });

        // Llama a restoreCheckboxState después de cargar las campañas
        async function loadAllCampaings() {
            try {
                const response = await fetch('/real-time-allCampaings-refresh');
                if (!response.ok) throw new Error('Error al cargar los allCampaings');
                
                // Obtén el HTML del nuevo contenido
                const iconContent = await response.text();
                
                // Reemplaza el contenido del contenedor
                document.querySelector('#allCampaingsRefresh').innerHTML = iconContent;

                console.log('allCampaings actualizados');

                // Restaurar el estado de los checkboxes después de la actualización
                restoreCheckboxState();

                // Reasignar eventos a los nuevos elementos
                assignCheckboxEvents();

                // Aplicar el filtro inicial
                document.querySelectorAll(".campaign-checkbox").forEach(checkbox => {
                    checkbox.dispatchEvent(new Event("change"));
                });
            } catch (error) {
                console.error('Error al actualizar los allCampaings:', error);
            }
        }



        
        function loadContent() {
            loadTableContent();
            loadQueueDetail();
            loadstateInfo();
            loadAllCampaings();
        }

        setInterval(loadContent, REFRESH_RATE * 1000); 
    });
</script> --}}
