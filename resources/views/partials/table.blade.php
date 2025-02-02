<tbody id="agent-table">
    @if (empty($agentDetails))
        <tr>
            <td colspan="10" class="px-6 py-4 text-center">{{__('No data available')}}.</td>
        </tr>
    @else
        @foreach ($agentDetails as $agent)
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
                            ($agent['duration1'] != "NA" || $agent['duration2'] != "NA"))
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
                        {{ $agent['duration1'] }} / {{ $agent['duration2'] }}
                    @endif
                </td>
                <td class="px-6 py-4">
                    <button>
                        <img src="{{asset('images/editButton.svg')}}" class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" alt="">
                    </button>
                </td>
            </tr>
        @endforeach
    @endif
</tbody>