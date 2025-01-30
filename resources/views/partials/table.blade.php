<tbody id="agent-table">
    @if (empty($agentDetails))
        <tr>
            <td colspan="10" class="px-6 py-4 text-center">{{__('No data available')}}.</td>
        </tr>
    @else
        @foreach ($agentDetails as $agent)
            <tr class="odd:bg-white even:bg-gray-50 border-b">
                <th scope="row" class="px-6 py-4 text-gray-900 whitespace-nowrap">
                    {{ $agent['extension'] }}
                </th>
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
                        {{ $agent['call_state'] }}
                    @endif
                </td>
                <td class="px-6 py-4">
                    {{ $agent['state'] }}
                </td>
            </tr>
        @endforeach
    @endif
</tbody>