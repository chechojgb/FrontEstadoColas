<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ asset('images/soul.png') }}" type="image/x-icon">

        <title>{{ config('app.name', 'RUTY') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css"  rel="stylesheet" />
        {{-- POPI --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

        <!-- Font Awesome Icons -->

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script src="https://unpkg.com/@popperjs/core@2"></script>



    </head>
    <body id="reload" class="flex flex-col min-h-screen">
        <div class="flex flex-1">

            <x-dashboard-campaings 
                title="Select a Campaign" 
                :action-route="route('execute.command')" 
                :campaign-options="App\Http\Controllers\VicidialController::CAMPAIGN_OPTIONS" 
                :selected-campaign="$selectedCampaign ?? null"
                class="flex-shrink-0 bg-gray-50 w-80 min-h-full"
            />
            <main class="flex-1 p-4 bg-white">
                @yield('content')
            </main>
        </div>
    
        @vite('resources/js/app.js')
    </body>
    



</html>
