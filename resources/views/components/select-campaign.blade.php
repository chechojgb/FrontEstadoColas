{{-- <div class="w-full max-w-md mx-auto">
    <div class="relative">
        <select 
            class="block w-full bg-gray-100 text-gray-800 border border-transparent rounded-t-lg shadow-sm focus:ring focus:ring-blue-300 focus:outline-none focus:border-blue-500 transition appearance-none p-3 pr-10" 
            style="border-bottom: 1px solid black" 
            name="{{ $name }}">
            <!-- Título como opción deshabilitada -->
            <option value="" disabled selected hidden>{{ __($title) }}</option>

            <!-- Opciones dinámicas -->
            @foreach ($options as $value => $label)
                <option value="{{ $value + 1}}" @selected($value == $selectedValue)>{{ __($label) }}</option>
            @endforeach
        </select>
    </div>
</div> --}}

<div class="w-full max-w-md mx-auto">
    <div class="relative">
        <select 
            class="block w-full bg-gray-100 text-gray-800 border border-transparent rounded-t-lg shadow-sm focus:ring focus:ring-blue-300 focus:outline-none focus:border-blue-500 transition appearance-none p-3 pr-10" 
            style="border-bottom: 1px solid black" 
            name="{{ $name }}">
            <!-- Título como opción deshabilitada -->
            <option value="" disabled selected hidden>{{ __($title) }}</option>

            <!-- Opciones dinámicas -->
            @foreach ($options as $value => $label)
                <option value="{{ $value + 1}}" @selected(session('campaignIndex') == $value)>
                    {{ __($label) }}
                </option>
            @endforeach
        </select>
    </div>
</div>
