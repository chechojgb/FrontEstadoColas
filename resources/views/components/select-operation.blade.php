<div class="w-full max-w-md mx-auto">
    <div class="relative">
        <select class="block w-full bg-gray-100 text-gray-800 border border-transparent rounded-t-lg shadow-sm focus:ring focus:ring-blue-300 focus:outline-none focus:border-blue-500 transition appearance-none p-3 pr-10" style="border-bottom: 1px solid black" name="{{ $name }}">

            {{-- <button id="dropdownCheckboxButton" data-dropdown-toggle="dropdownDefaultCheckbox" 
            class="text-gray-800 bg-gray-100 border border-transparent rounded-t-lg shadow-sm focus:ring focus:ring-blue-300 focus:outline-none focus:border-blue-500 transition appearance-none p-3 pr-10" type="button">Select a campaing <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button> --}}

            <option value="" disabled selected hidden>{{ __($title) }}</option>
            @foreach ($options as $value => $label)
                <option value="{{ $value + 1}}" @selected(session('operationIndex') == $value + 1)>
                    {{ __($label) }}
                </option>
            @endforeach
        </select>
        
    </div>
    
</div>

