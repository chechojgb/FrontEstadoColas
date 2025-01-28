<aside class="relative flex h-screen min-h-full w-80 flex-col bg-gray-50 p-4 shadow-lg">
    <div class="h-19.5">
        <i class="absolute top-0 right-0 hidden p-4 opacity-50 cursor-pointer fas fa-times text-slate-400 xl:hidden" sidenav-close></i>
        <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap text-slate-700" href="javascript:;" target="_blank">
          <img src="{{asset('images/soul.png')}}" class="inline h-full max-w-full transition-all duration-200 ease-nav-brand max-h-8" alt="main_logo" />
          <span class="ml-1 font-semibold transition-all duration-200 ease-nav-brand">Soul Reporting </span>
        </a>
    </div>
    <div class="items-center block w-auto overflow-y-auto grow basis-full">
        <div class="container mx-auto mt-5">
            <h2 class="text-xl font-bold mb-4">{{ $title }}</h2>

            <!-- Selector para elegir el filtro -->
            <div class="mb-4">
                <label for="filter_type" class="block text-sm font-medium text-gray-700">¿Cómo quieres filtrar?</label>
                <select id="filter_type" name="filter_type" class="block w-full bg-gray-100 text-gray-800 border border-transparent rounded-lg shadow-sm focus:ring focus:ring-blue-300 focus:outline-none focus:border-blue-500 transition p-3">
                    <option value="campaign" selected>Por campaña</option>
                    <option value="operation">Por operación</option>
                </select>
            </div>

            <!-- Formulario para filtrar por campaña -->
            <form method="POST" action="{{ route('execute.command') }}" id="campaign_form" class="hidden">
                @csrf
                <div class="mb-4">
                    <label for="campaign" class="block text-sm font-medium text-gray-700">Selecciona una campaña</label>
                    <x-select-campaign 
                        name="campaign" 
                        title="Selecciona una campaña" 
                        :options="$campaignOptions" 
                        :selected-value="$selectedCampaign"
                    />
                </div>

                <div class="mt-6 flex">
                    <x-button/>
                </div>
            </form>

            <!-- Formulario para filtrar por operación -->
            <form method="POST" action="{{ route('execute.command') }}" id="operation_form" class="hidden">
                @csrf
                <div class="mb-4">
                    <label for="operation" class="block text-sm font-medium text-gray-700">Selecciona una campaña</label>
                    <x-select-operation 
                        name="operation" 
                        title="Selecciona una operacion" 
                        :options="App\Http\Controllers\VicidialController::OPERATION_OPTIONS" 
                    />
                </div>

                <div class="mt-6 flex">
                    <x-button/>
                </div>
            </form>
        </div>
    </div>
</aside>

<script>
    // JavaScript para manejar la visibilidad de los formularios según la elección
    document.getElementById('filter_type').addEventListener('change', function() {
        const campaignForm = document.getElementById('campaign_form');
        const operationForm = document.getElementById('operation_form');
        
        if (this.value === 'campaign') {
            campaignForm.classList.remove('hidden');
            operationForm.classList.add('hidden');
        } else if (this.value === 'operation') {
            campaignForm.classList.add('hidden');
            operationForm.classList.remove('hidden');
        }
    });

    // Inicializar ocultando los formularios hasta que se haga una selección
    window.addEventListener('load', function() {
        document.getElementById('campaign_form').classList.add('hidden');
        document.getElementById('operation_form').classList.add('hidden');
    });
</script>
