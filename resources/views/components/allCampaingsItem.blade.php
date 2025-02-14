<div data-id="{{ $campaignId }}" class="campaign-item w-72 bg-{{ $bgColor }} text-white rounded-lg shadow-md p-4 transition-transform transform hover:scale-105">
    <div class="flex justify-between items-center border-b border-gray-700 pb-2">
        <span class="font-semibold text-[#00acc1] truncate">{{ $campaignId }}. {{ $campaignName }}</span>
    </div>
    <div class="pt-2 flex justify-between items-center">
        <span class="text-sm text-gray-900">{{ $calls }} Calls</span>
        <button data-modal-target="{{ $modalId }}" data-modal-toggle="{{ $modalId }}" class="bg-[#00acc1] hover:bg-bg-[#00acc1] text-white font-bold py-2 px-6 rounded-lg shadow-lg justify-end">
            View more
        </button>
    </div>
</div>
<div id="{{ $modalId }}" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center bg-gray-900 bg-opacity-50">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ $campaignName }}
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="{{ $modalId }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="p-4 md:p-5 space-y-4">
                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                    Detailed information about the campaign {{ $campaignName }}.
                </p>
                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                   {{__('Unanswered calls')}}: {{ $calls }} 
                </p>
            </div>
        </div>
    </div>
</div>
