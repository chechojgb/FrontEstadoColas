<div data-popover id="{{$popoverId}}" role="tooltip" class="absolute z-10 invisible bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800 z-950 inline-block max-w-xs p-4 border border-gray-300 rounded-lg shadow-md bg-white">
    <!-- Icono posicionado fuera del contenedor -->
    <div class="absolute -top-6 bottom-1/2 transform -translate-x-1/2 flex justify-center items-center w-12 h-12 rounded-full bg-soul-1 border border-gray-300" style="top: -15px; left: 20%">
        <img src="{{ asset('images/vector.png') }}" alt="">
    </div>
    <!-- Título -->
    <h2 class="text-center text-lg font-semibold text-gray-800 mb-1 mt-6">User Skills</h2>
    <p class="text-center text-sm text-gray-600 font-medium mb-4">
        HOGARES-POSTVENTA_TRAMITES_FIBRA
    </p>
    <p class="text-center text-sm text-blue-500 mb-4">Detalle de la solicitud <i class="fas fa-info-circle"></i></p>
    <!-- Información -->
    <div class="text-sm text-gray-700 space-y-2">
        <p><span class="font-medium">Agent:</span> </p>
        <p><span class="font-medium">Campaign:</span></p>
    </div>
    <div class="my-4 border-t border-gray-300"></div>
    <!-- Acciones -->
    <div class="flex justify-between mt-4 text-gray-600">
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
    </div>
</div>