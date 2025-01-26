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