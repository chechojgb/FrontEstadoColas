<aside class="relative flex h-screen w-80 flex-col bg-gray-50 p-4 shadow-lg">
    <div class="h-19.5">
        <i class="absolute top-0 right-0 hidden p-4 opacity-50 cursor-pointer fas fa-times text-slate-400 xl:hidden" sidenav-close></i>
        <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap text-slate-700" href="javascript:;" target="_blank">
          <img src="{{asset('images/soul.png')}}" class="inline h-full max-w-full transition-all duration-200 ease-nav-brand max-h-8" alt="main_logo" />
          <span class="ml-1 font-semibold transition-all duration-200 ease-nav-brand">Soul Reporting </span>
        </a>
    </div>
    <div class="items-center block w-auto max-h-screen overflow-auto h-sidenav grow basis-full">
        <div class="container mx-auto mt-5">
            <h2 class="text-xl font-bold mb-4">{{ $title }}</h2>
            <form method="POST" action="{{ $actionRoute }}">
                @csrf
                <x-select-campaign 
                    name="campaign" 
                    title="Selecciona una campaña" 
                    :options="$campaignOptions" 
                    :selected-value="$selectedCampaign"
                />
        
                <div class="mt-6 flex">
                    <x-button/>
                </div>
            </form>
        </div>
    </div>
</aside>
