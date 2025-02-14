<div role="tooltip" class="relative z-10 bg-white border border-gray-200 rounded-lg shadow-sm z-950 inline-block max-w-xs p-4 border border-gray-300 rounded-lg shadow-md bg-white">
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
                <p class="px-6 py-4 text-center text-white">{{ __('No data available') }}.</p>
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
