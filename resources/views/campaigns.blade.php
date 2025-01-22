@extends('layouts.app')

@section('content')



<div class="mb-4 border-b border-gray-200 border-gray-700">
    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
        <li class="me-2" role="presentation">
            <button class="  inline-block p-4 border-b-2 rounded-t-lg hover:border-[#00acc1] hover:text-[#00acc1]" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Campaings Selected</button>
        </li>
        <li class="me-2" role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-[#00acc1] hover:text-[#00acc1]" id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">Alls campaings</button>
        </li>

    </ul>
</div>
<div id="default-tab-content">
    <div class="flex p-4 rounded-lg bg-gray-50 " id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <!-- Contenedor de la tabla -->
        <div class="w-full pr-4">
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
                <tbody>
                    @if (empty($agentDetails))
                        <tr>
                            <td colspan="10" class="px-6 py-4 text-center">{{__('No data available')}}.</td>
                        </tr>
                    @else
                        @foreach ($agentDetails as $agent)
                            <tr class="odd:bg-white even:bg-gray-50 border-b">
                                <th scope="row" class="px-6 py-4 text-gray-900 whitespace-nowrap">
                                    {{ $agent['extension'] }}
                                </th>
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
    
        <!-- Contenedor de la imagen (o div con contenido adicional) -->
        <div class="relative mx-auto border-gray-800 dark:border-gray-800 bg-gray-800 border-[14px] rounded-xl h-[600px] w-[300px] shadow-xl">
            <div class="w-[148px] h-[18px] bg-gray-800 top-0 rounded-b-[1rem] left-1/2 -translate-x-1/2 absolute"></div>
            <div class="h-[32px] w-[3px] bg-gray-800 absolute -start-[17px] top-[72px] rounded-s-lg"></div>
            <div class="h-[46px] w-[3px] bg-gray-800 absolute -start-[17px] top-[124px] rounded-s-lg"></div>
            <div class="h-[46px] w-[3px] bg-gray-800 absolute -start-[17px] top-[178px] rounded-s-lg"></div>
            <div class="h-[64px] w-[3px] bg-gray-800 absolute -end-[17px] top-[142px] rounded-e-lg"></div>
        
            <!-- Contenido con texto en lugar de imágenes -->
            <div class="rounded-xl overflow-hidden w-[272px] h-[572px] bg-white dark:bg-gray-800 p-4">
                <!-- Título -->
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Queue details</h2>
        
                <!-- Descripción -->
                <p class="mt-4 text-sm text-gray-600 dark:text-gray-300">
                    Here you can view all details about the current campaign. If you need to make changes or get more information, please follow the links below.
                </p>
        
                <!-- Enlace -->
                <a href="#" class="mt-4 inline-block text-blue-600 dark:text-blue-400 hover:text-blue-800">Learn more about the campaign</a>
        
                <!-- Otro texto o información -->
                <div class="mt-6" id="queueDetail">
                  
                        @foreach ($callsInQueue as $call)
                            <li class="text-white">{{ $call }}</li>
                            <br>
                        @endforeach
                </div>
            </div>
        </div>
        
    </div>
    

    <div class="hidden p-4 rounded-lg bg-gray-50 " id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
        @if (empty($membersSummaryAll))
            <p class="px-6 py-4 text-center">No campaing selected</p>
        @else
            @foreach ($membersSummaryAll as $allCampaign)
                <p>{{ $allCampaign }}</p>
            @endforeach
        @endif
    </div>
</div>

@endsection




<script>
    const REFRESH_RATE = 4;
    console.log(REFRESH_RATE);
    
    let secondsPassed = 0;
    setInterval(() => {
        secondsPassed++;
        console.log(`Seconds passed: ${secondsPassed}`);
    }, 1000);

    document.addEventListener('DOMContentLoaded', function () {
        async function loadTableContent() {
            try {
                const response = await fetch('/real-time-table-refresh');
                if (!response.ok) throw new Error('Error al cargar la tabla');
                const tableContent = await response.text(); 
                document.querySelector('table tbody').innerHTML = tableContent; 

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




        function loadContent() {
            loadTableContent();
            loadQueueDetail();
        }

        setInterval(loadContent, REFRESH_RATE * 1000); 
    });
</script>
