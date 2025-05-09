<aside class="relative flex flex-col min-h-screen w-80 bg-gray-50 p-4 shadow-lg">
    <div class="h-19.5">
        <i class="absolute top-0 right-0 hidden p-4 opacity-50 cursor-pointer fas fa-times text-slate-400 xl:hidden" sidenav-close></i>
        <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap text-slate-700" href="javascript:;" target="_blank">
          <img src="{{asset('images/soul.png')}}" class="inline h-full max-w-full transition-all duration-200 ease-nav-brand max-h-8" alt="main_logo" />
          <span class="ml-1 font-semibold transition-all duration-200 ease-nav-brand">Mysoul Board </span>
          <p>by Telecomunication</p>
        </a>
    </div>
    <div class="flex flex-col flex-grow overflow-y-auto">
        <div class="container mx-auto mt-5">
            <h2 class="text-xl font-bold mb-4">{{ $title }}</h2>

            <!-- Selector para elegir el filtro -->
            <div class="mb-4">
                <label for="filter_type" class="block text-sm font-medium text-gray-700">How do you want to filter?</label>
                <select id="filter_type" name="filter_type" class="block w-full bg-gray-100 text-gray-800 border border-transparent rounded-lg shadow-sm focus:ring focus:ring-blue-300 focus:outline-none focus:border-blue-500 transition p-3">
                    <option disabled selected hidden>Select Filter</option>
                    <option value="operation">For operation</option>
                    <option value="campaign" >For campaing</option>
                </select>
            </div>

            <!-- Formulario para filtrar por campaña -->
            <form method="POST" action="{{ route('execute.command') }}" id="campaign_form" class="hidden">
                @csrf
                <div class="mb-4">
                    <label for="campaign" class="block text-sm font-medium text-gray-700">Select a campaing</label>
                    <x-select-campaign 
                        name="campaign" 
                        title="Select a campaing" 
                        :options="$campaignOptions" 
                        :selected-value="$selectedCampaign"
                    />
                </div>

                <div class="mt-6 flex">
                    <x-button id="campaign_submit_button"/>
                </div>
            </form>

            <!-- Formulario para filtrar por operación -->
            <form method="POST" action="{{ route('execute.command') }}" id="operation_form" class="hidden">
                @csrf
                <div class="mb-4">
                    <label for="operation" class="block text-sm font-medium text-gray-700">Select a operation</label>
                    <x-select-operation 
                        name="operation" 
                        title="Select a operation" 
                        :options="App\Http\Controllers\VicidialController::OPERATION_OPTIONS" 
                    />
                </div>

                <div class="mt-6 flex">
                    <x-button id="operation_submit_button" />
                </div>
            </form>
        </div>
    </div>
</aside>

<script>
    document.getElementById('filter_type').addEventListener('change', function() {
    const campaignForm = document.getElementById('campaign_form');
    const operationForm = document.getElementById('operation_form');
    
    // Mostrar el formulario correspondiente basado en la selección
    if (this.value === 'campaign') {
        campaignForm.classList.remove('hidden');
        operationForm.classList.add('hidden');
    } else if (this.value === 'operation') {
        operationForm.classList.remove('hidden');
        campaignForm.classList.add('hidden');
    }
});

window.addEventListener('load', function() {
    const filterType = document.getElementById('filter_type');

    if (filterType.value === 'campaign') {
        document.getElementById('campaign_form').classList.remove('hidden');
        document.getElementById('operation_form').classList.add('hidden');
    } else if (filterType.value === 'operation') {
        document.getElementById('operation_form').classList.remove('hidden');
        document.getElementById('campaign_form').classList.add('hidden');
    } else {
        // Si no hay selección, ambos formularios estarán ocultos
        document.getElementById('campaign_form').classList.add('hidden');
        document.getElementById('operation_form').classList.add('hidden');
    }
});

document.getElementById('operation_form').addEventListener('submit', function(e) {
    const operationSelect = document.querySelector('select[name="operation"]');
    const campaignSelect = document.querySelector('select[name="campaign"]');
    if (!operationSelect.value ) {
        e.preventDefault();
    }
});
document.getElementById('campaign_form').addEventListener('submit', function(e) {
    const campaignSelect = document.querySelector('select[name="campaign"]');
    if (!campaignSelect.value ) {
        e.preventDefault();
    }
});


</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Obtener los formularios y botones
        const campaignForm = document.getElementById("campaign_form");
        const operationForm = document.getElementById("operation_form");

        const campaignButton = document.getElementById("campaign_submit_button");
        const operationButton = document.getElementById("operation_submit_button");

        // Función para ocultar el botón después de enviar
        function hideButton(button) {
            if (button) {
                button.style.display = "none"; // Ocultar el botón completamente
            }
        }

        // Evento para el formulario de campaña
        if (campaignForm) {
            campaignForm.addEventListener("submit", function() {
                hideButton(campaignButton);
            });
        }

        // Evento para el formulario de operación
        if (operationForm) {
            operationForm.addEventListener("submit", function() {
                hideButton(operationButton);
            });
        }
    });
</script>
