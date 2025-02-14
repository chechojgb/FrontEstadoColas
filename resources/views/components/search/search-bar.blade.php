<div class="relative w-full flex items-center bg-gray-100 rounded-t-lg shadow-sm" style="border-bottom: 1px solid black">
    <button type="button" class="p-3 text-gray-800">
        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
        </svg>
        <span class="sr-only">Search</span>
    </button>
    <input type="search" id="search-dropdown" class="block w-full bg-transparent text-gray-800 border-0 focus:ring focus:ring-blue-300 focus:outline-none focus:border-blue-500 transition appearance-none p-3" placeholder="Search" required />
    <x-info-popover/>
</div>
