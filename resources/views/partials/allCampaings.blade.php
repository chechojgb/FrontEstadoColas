<div id="allCampaingsRefresh">
    @if (empty($membersSummaryAll))
        <p class="px-6 py-4 text-center">No campaing selected</p>
    @else
        @foreach ($membersSummaryAll as $allCampaign)
            @php
                // Extraemos el ID de la campaña usando una expresión regular
                preg_match('/^(\d+)\s/', $allCampaign, $matches);
                $campaignId = $matches[1] ?? null;
            @endphp
            @if ($campaignId)
                <p data-id="{{ $campaignId }}">{{ $allCampaign }}</p>
            @endif
        @endforeach
    @endif
</div>