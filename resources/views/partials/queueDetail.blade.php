<div class="mt-6" id="queueDetail">
                  
    @foreach ($callsInQueue as $call)
        <li class="text-white">{{ $call }}</li>
        <br>
    @endforeach

    {{-- <p class="text-white">{{$campaignIndex}}</p>
    <p class="text-white">{{$cleanOutput}}</p> --}}
</div>