<tbody id="agent-table">
    <div id="toast-container" class="fixed top-5 right-5 space-y-2 z-50 flex flex-col"></div>
    @if (empty($agentDetails))
        <tr>
            <td colspan="10" class="px-6 py-4 text-center">{{ __('No data available') }}.</td>
        </tr>
    @else
        @foreach ($agentDetails as $agent)
            @php
                $duration2 = $agent['duration2'] ?? '00:00:00';
                $timeInSeconds = strtotime("1970-01-01 " . $duration2 . " UTC") - strtotime("1970-01-01 00:00:00 UTC");

                if ($agent['state'] == 'Not in use') {
                    $buttonstatus = 'bg-gray-200';
                    $idStatus = 'notUserStatus';
                } elseif ($timeInSeconds <= 600) {
                    $buttonstatus = 'bg-green-500';
                    $idStatus = 'activeStatus';
                } elseif ($timeInSeconds >= 600 && $timeInSeconds <= 900) { 
                    $buttonstatus = 'bg-yellow-500';
                    $idStatus = 'activeStatus';
                } elseif ($timeInSeconds >= 900 && $timeInSeconds <= 1200) { 
                    $buttonstatus = 'bg-orange-500';
                    $idStatus = 'activeStatus';
                } elseif ($timeInSeconds > 1200) { 
                    $buttonstatus = 'bg-red-500';
                    $idStatus = 'activeStatus';
                } else { 
                    $buttonstatus = 'bg-gray-200';
                    $idStatus = 'notUserStatus';
                }
            @endphp

            <tr class="odd:bg-white even:bg-gray-50 border-b">
                <td scope="row" class="px-6 py-4 text-gray-900 whitespace-nowrap">
                    {{ $agent['extension'] }}
                </td>
                <td class="px-6 py-4">
                    @if (isset($agent['name']))
                        {{ $agent['name'] }}
                    @endif
                </td>
                <td class="px-6 py-4">
                    @if (isset($agent['call_state']))
                        {{ $agent['ipUser'] }}
                    @endif
                </td>
                <td class="px-6 py-4">
                    @if (isset($agent['call_state']))
                        @if ($agent['call_state'] == 'Call finished' && 
                            ($agent['duration1'] != "NA" || $agent['duration2'] != "NA") && $agent['call_state'] != 'Not in use')
                            {{ 'In transfer' }} 
                        @else
                            {{ $agent['call_state'] }} 
                        @endif
                    @endif
                </td>
                <td class="px-6 py-4">
                    {{ $agent['state'] }}
                </td>
                <td class="px-6 py-4">
                    @if (isset($agent['call_state']))
                        {{ $agent['duration2'] }}
                    @endif
                </td>
                <td class="px-6 py-4 flex">
                    <button>
                        <img src="{{ asset('images/editButton.svg') }}" alt="editAgent{{ $agent['name'] ?? '' }}">
                    </button>
                    <div class="pt-2">
                        <span class="flex w-3 h-3 me-3 rounded-full ml-4 pt-2 {{ $buttonstatus }} {{$idStatus}}"></span>
                    </div>
                </td>
            </tr>

            {{-- Si el tiempo es mayor a 10 minutos, agregamos un toast con JS --}}
            @if ($timeInSeconds > 600)
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        addToast("{{ $agent['name'] }}", "{{ $agent['duration2'] }}");
                    });
                </script>
            @endif
        @endforeach
    @endif
    
</tbody>

