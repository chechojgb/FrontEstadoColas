@php
    $operation = null;
    
    if (session('operationIndex')) {
        $operationIndex = session('operationIndex') - 1;
        $operation = \App\Http\Controllers\VicidialController::OPERATION_OPTIONS[$operationIndex] ?? $operationIndex;
    } elseif (session('campaignIndex')) {
        $campaignIndex = session('campaignIndex') - 1;
        $operation = \App\Http\Controllers\VicidialController::CAMPAIGN_OPTIONS[$campaignIndex] ?? $campaignIndex;
    }
@endphp

<h2 class="text-xl font-bold mb-4 pt-4">
    {{ $operation }}
</h2>
