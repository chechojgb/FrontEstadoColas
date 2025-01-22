@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-5">

    <h3 class="text-xl font-bold mb-4">Calls in Queue:</h3>
    <ul>
        @foreach ($callsInQueue as $call)
            <li>{{ $call }}</li>
            <br>
        @endforeach
    </ul>

    <h2 class="text-xl font-bold mb-4">Results for Campaign: {{ $campaign }}</h2>

    @if (isset($agentDetails) && count($agentDetails) > 0)
        <h3 class="text-lg">Connected Agents:</h3>
        <ul>
            @foreach ($agentDetails as $agent)
                <li>
                    <strong>Extension:</strong> {{ $agent['extension'] }}
                    
                    {{-- Verificar si existe el nombre antes de mostrarlo --}}
                    @if (isset($agent['name']))
                        - <strong>Name:</strong> {{ $agent['name'] }}
                    @endif

                    {{-- Verificar si existe el estado de la llamada antes de mostrarlo --}}
                    @if (isset($agent['call_state']))
                        - <strong>Call ID:</strong> {{ $agent['call_id'] }}
                        - <strong>Call State:</strong> {{ $agent['call_state'] }}
                    @endif

                    {{-- Mostrar siempre el estado general --}}
                    - <strong>State:</strong> {{ $agent['state'] }}

                    {{-- Si hay un mensaje adicional, mostrarlo --}}
                    @if (isset($agent['message']))
                        <br><em>{{ $agent['message'] }}</em>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p>{{ $message ?? 'No connected agents found.' }}</p>
    @endif

    
        <br>
    <h3 class="text-xl font-bold mb-4">Queue Members Summary:</h3>
    <ul>
        
        @foreach ($queueMembersSummary as $summary)
            <li>{{ $summary }}</li>
        @endforeach
    </ul>
    <br>
</div>



@endsection