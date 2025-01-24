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
            
            <div class="max-w-lg mx-auto mb-8">
                <div class="flex">
                    <label for="search-dropdown" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Your Email</label>
                    
                    <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button">
                            <li>
                                <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" onclick="selectOption('Extension')">Extension</button>
                            </li>
                            <li>
                                <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" onclick="selectOption('User name')">User name</button>
                            </li>
                            <li>
                                <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" onclick="selectOption('State in asterisk')">State in asterisk</button>
                            </li>
                        </ul>
                    </div>
                    <div class="relative w-full">
                        <input type="search" id="search-dropdown" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-s-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" placeholder="Search" required />
                        <button type="button" class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                            <span class="sr-only">Search</span>
                        </button>
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
    

        <div class="relative mx-auto border-gray-800 dark:border-gray-800 bg-gray-800 border-[14px] rounded-xl h-[600px] w-[300px] shadow-xl">
            <div class="mb-6">
                <div class="w-[148px] h-[18px] bg-gray-800 top-0 rounded-b-[1rem] left-1/2 -translate-x-1/2 absolute"></div>
                <div class="h-[32px] w-[3px] bg-gray-800 absolute -start-[17px] top-[72px] rounded-s-lg"></div>
                <div class="h-[46px] w-[3px] bg-gray-800 absolute -start-[17px] top-[124px] rounded-s-lg"></div>
                <div class="h-[46px] w-[3px] bg-gray-800 absolute -start-[17px] top-[178px] rounded-s-lg"></div>
                <div class="h-[64px] w-[3px] bg-gray-800 absolute -end-[17px] top-[142px] rounded-e-lg"></div>
        
                <div class="rounded-xl overflow-hidden w-[272px] h-[572px] bg-white dark:bg-gray-800 p-4">

                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Queue details</h2>
                    <p class="mt-4 text-sm text-gray-600 dark:text-gray-300">
                        Here you can view all details about the current campaign. If you need to make changes or get more information, please follow the links below.
                    </p>

                    <a href="#" class="mt-4 inline-block text-blue-600 dark:text-blue-400 hover:text-blue-800">Learn more about the campaign</a>
                    <div class="mt-6" id="queueDetail">
                        
                        @if (empty($callsInQueue))
                            <p  class="px-6 py-4 text-center text-white">{{__('No data available')}}.</p>
                        @else
                            @foreach ($callsInQueue as $call)
                                <li class="text-white">{{ $call }}</li>
                                <br>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            
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
        </div>
        
    </div>
    

    <div class="hidden p-4 rounded-lg bg-gray-50 " id="allCampaings" role="tabpanel" aria-labelledby="allCampaings-tab">
        
        
        
        <button id="dropdownCheckboxButton" data-dropdown-toggle="dropdownDefaultCheckbox" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Select a campaing <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg>
        </button>
        
        <!-- Dropdown menu -->
        <div id="dropdownDefaultCheckbox" class="z-10 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow-sm dark:bg-gray-700 dark:divide-gray-600">
            <ul class="p-3 space-y-3 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownCheckboxButton">
                <li>
                    <div class="flex items-center">
                        <input checked id="checkbox-item-1" type="checkbox" data-campaigns="1,2,3,4,5" class="campaign-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        <label for="checkbox-item-1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Support</label>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <input checked id="checkbox-item-2" type="checkbox" data-campaigns="6,7,8" class="campaign-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        <label for="checkbox-item-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Formalities</label>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <input checked id="checkbox-item-3" type="checkbox" data-campaigns="9,10" class="campaign-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        <label for="checkbox-item-3" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Mobiles</label>
                    </div>
                </li>
                <!-- Agregar más opciones -->
            </ul>
        </div>
    
    

        <div id="allCampaingsRefresh">
            @if (empty($membersSummaryAll))
                <p class="px-6 py-4 text-center">No campaing selected</p>
            @else
                @foreach ($membersSummaryAll as $allCampaign)
                    @php
                        // Extraemos el ID de la campaña usando una expresión regular
                        preg_match('/^(\d+)\s/', $allCampaign, $matches);
                        $campaignId = $matches[1] ?? null;
                    @endphp
                    @if ($campaignId)
                        <p data-id="{{ $campaignId }}">{{ $allCampaign }}</p>
                    @endif
                @endforeach
            @endif
        </div>

        <script>
            const checkboxes = document.querySelectorAll(".campaign-checkbox");
            const campaignElements = document.querySelectorAll("#allCampaingsRefresh p");

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
                            campaignElement.style.display = "block";
                        } else {
                            campaignElement.style.display = "none";
                        }
                    });
                });
            });

            // Inicializa mostrando todas las campañas
            checkboxes.forEach(checkbox => checkbox.dispatchEvent(new Event("change")));
        </script>
    </div>
</div>

<script>
    document.getElementById('search-dropdown').addEventListener('input', function () {
        const query = this.value.toLowerCase();
        const rows = document.querySelectorAll('#agent-table tr');

        rows.forEach(row => {
            const cells = Array.from(row.getElementsByTagName('td'));
            const rowContent = cells.map(cell => cell.textContent.toLowerCase()).join(' ');

            row.style.display = rowContent.includes(query) ? '' : 'none';
        });
    });
</script>

@endsection





<script>
    const REFRESH_RATE = 60;
    console.log(REFRESH_RATE);
    
    let secondsPassed = 0;
    setInterval(() => {
        secondsPassed++;
        console.log(`Seconds passed: ${secondsPassed}`);
    }, 1000);

    document.addEventListener('DOMContentLoaded', function () {
        let searchValue = ''; // Variable para guardar el valor del filtro

        // Escuchar el cambio del input de búsqueda
        const searchInput = document.querySelector('#search-dropdown');
        searchInput.addEventListener('input', function () {
            searchValue = searchInput.value; // Guardar el valor del filtro
            filterTable(); // Aplicar el filtro en tiempo real
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

                // Reaplicar el filtro después del refresh
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

        async function loadAllCampaings() {
            try {
                const response = await fetch('/real-time-allCampaings-refresh');
                if (!response.ok) throw new Error('Error al cargar los  allCampaings');
                if (response.ok) {
                    console.log('allCampaings actualizados');
                }
                const iconContent = await response.text(); // Obtén el HTML como texto
                document.querySelector('#allCampaingsRefresh').innerHTML = iconContent;
            } catch (error) {
                console.error('Error al actualizar los stateInfo:', error);
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
</script>
