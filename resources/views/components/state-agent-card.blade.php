@php
    $color = $colors[$state] ?? '#000'; 
    $isTotalAgents = $state === "Total_agents"; 
@endphp

<div class="relative flex flex-col min-w-0 break-words bg-white shadow-md rounded-2xl bg-clip-border cursor-pointer hover:shadow-xl hover:bg-blue-100 transition-all duration-300 mt-2 mb-2">
    <div class="flex-auto p-4">
        <div class="flex flex-row -mx-3">
            <div class="flex items-center justify-center w-12 h-12 rounded-full text-white text-xl mr-4 ml-2" style="background-color: {{ $color }}">
                <img src="{{ asset('images/' . $image . '.svg') }}" alt="Icon_state">
            </div>
            <div class="flex-none w-2/3 max-w-full px-3">
                <div>
                    @if ($isTotalAgents)
                        <p class="mb-0 font-sans text-sm font-semibold leading-normal font-poppins text-gray-400">Total</p>
                        <h5 class="mb-0 font-poppins">
                            {{ $count }}
                            <span class="text-sm leading-normal font-weight-bolder text-black font-poppins" style="color: {{ $color }}">
                                Total Agents conected
                            </span>
                        </h5>
                    @else
                        <p class="mb-0 font-sans text-sm font-semibold leading-normal font-poppins text-gray-400">Users in state</p>
                        <h5 class="mb-0 font-poppins">
                            {{ $count }}
                            <span class="text-sm leading-normal font-weight-bolder text-black font-poppins" style="color: {{ $color }}">
                                {{ ucfirst($state) }}!
                            </span>
                        </h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
