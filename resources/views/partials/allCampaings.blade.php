<div class="flex flex-wrap gap-4 mt-4" id="allCampaingsRefresh">
    @if (empty($membersSummaryAll))
        <p class="text-gray-500">No campaign selected</p>
    @else
        @foreach ($membersSummaryAll as $index => $allCampaign)
            @php
                preg_match('/^(\d+)\s.*?(\d+) calls$/', $allCampaign, $matches);
                $campaignId = $matches[1] ?? null;
                $calls = isset($matches[2]) ? (int) $matches[2] : 0;
                if ($calls === 0) {
                    $bgColor = 'gray-100';
                } elseif ($calls > 0 && $calls <= 3) {
                    $bgColor = 'blue-200';
                } else {
                    $bgColor = 'red-300';
                }
                $modalId = $campaignId+1;
                $campaignName = $campaignOptions[$campaignId - 1] ?? "Unknown Campaign";
            @endphp
            @if ($campaignId)
                <x-allCampaingsItem :campaignId="$campaignId" :calls="$calls" :bgColor="$bgColor" :modalId="$modalId" :campaignName="$campaignName" />
            @endif
        @endforeach
    @endif
</div>