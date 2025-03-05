<button id="dropdownCheckboxButton" data-dropdown-toggle="dropdownDefaultCheckbox" class="text-gray-800 bg-gray-100 border border-transparent rounded-t-lg shadow-sm focus:ring focus:ring-bg-[#00acc1] focus:outline-none focus:border-blue-500 transition appearance-none flex items-center space-x-3 p-4" style="border-bottom: 1px solid black" type="button">
    <span>Select a campaign</span>
    <svg class="w-3 h-3 ml-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
    </svg>
</button>

<div id="dropdownDefaultCheckbox" class="z-10 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow-sm dark:divide-gray-600">
    <ul class="p-3 space-y-3 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownCheckboxButton">
        <li>
            <div class="flex items-center">
                <input checked id="checkbox-item-1" type="checkbox" data-campaigns="17,18,19,20,21,22,24,25,26" class="campaign-checkbox w-4 h-4 text-[#00acc1] bg-gray-100 border-[#00acc1] rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2">
                <label for="checkbox-item-1" class="ms-2 text-sm font-medium text-gray-900">Support</label>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <input checked id="checkbox-item-2" type="checkbox" data-campaigns="4,6,7,8,9,10,11,12,13,14,15" class="campaign-checkbox w-4 h-4 text-[#00acc1] bg-gray-100 border-[#00acc1] rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2">
                <label for="checkbox-item-2" class="ms-2 text-sm font-medium text-gray-900">Formalities</label>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <input checked id="checkbox-item-3" type="checkbox" data-campaigns="27,28,29,30,31,32,33,34,35,37" class="campaign-checkbox w-4 h-4 text-[#00acc1] bg-gray-100 border-[#00acc1] rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2">
                <label for="checkbox-item-3" class="ms-2 text-sm font-medium text-gray-900">Mobiles</label>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <input checked id="checkbox-item-4" type="checkbox" data-campaigns="1,2,3,5,16,23" class="campaign-checkbox w-4 h-4 text-[#00acc1] bg-gray-100 border-[#00acc1] rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2">
                <label for="checkbox-item-3" class="ms-2 text-sm font-medium text-gray-900">Retention</label>
            </div>
        </li>
    </ul>
</div>
