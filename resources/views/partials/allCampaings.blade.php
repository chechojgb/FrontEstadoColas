<div class="flex flex-wrap gap-2" id="allCampaingsRefresh">
    @if (empty($membersSummaryAll))
        <p class="text-gray-500">No campaign selected</p>
    @else
        @foreach ($membersSummaryAll as $index => $allCampaign)
            @php
                // Extraemos el ID de la campaña y la cantidad de llamadas
                preg_match('/^(\d+)\s.*?(\d+) calls$/', $allCampaign, $matches);
                $campaignId = $matches[1] ?? null;
                $calls = isset($matches[2]) ? (int) $matches[2] : 0;

                // Determinamos el color según la cantidad de llamadas
                if ($calls === 0) {
                    $bgColor = 'gray-100';
                } elseif ($calls > 0 && $calls <= 3) {
                    $bgColor = 'blue-200';
                } else {
                    $bgColor = 'red-300';
                }

                $campaignName = $campaignOptions[$campaignId - 1] ?? "Unknown Campaign";
            @endphp
            @if ($campaignId)
                <span 
                    data-id="{{ $campaignId }}" 
                    class="campaign-item bg-{{ $bgColor }} text-{{ $bgColor }}-800 text-sm font-medium px-2.5 py-0.5 rounded-sm dark:bg-{{ $bgColor }}-900 dark:text-{{ $bgColor }}-300"
                >
                {{$campaignId}}. {{ $campaignName }} <strong>{{ $calls }}</strong> calls
            </span>
            {{-- {{ $index + 1 }}. --}}
            @endif
        @endforeach
    @endif
</div>