<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Peta Capaian PBB-P2') - BAPENDA Kabupaten Karawang</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-karawang.png') }}">

    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        bapenda: {
                            sidebar: '#182438',
                            hover: '#24344e',
                            active: '#2c59b2',
                            primary: '#2563eb',
                            secondary: '#3b82f6',
                            bg: '#f1f5fa',
                            card: '#ffffff',
                            success: '#10b981',
                            warning: '#eab308',
                            orange: '#f97316',
                            danger: '#ef4444',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Leaflet CSS & JS for Interactive Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5fa;
            color: #0f172a;
        }
        .sidebar-item-active {
            background-color: #2c59b2 !important;
            color: #ffffff !important;
        }
        .leaflet-popup-content-wrapper {
            border-radius: 14px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            padding: 0;
            overflow: hidden;
        }
        .leaflet-popup-content {
            margin: 0 !important;
            line-height: 1.4;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-[#f1f5fa] min-h-screen flex flex-col antialiased">
    <div class="flex flex-1 min-h-screen">
        @include('layouts.partials.sidebar')

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            @include('layouts.partials.header')

            <!-- Main Page Body -->
            <main class="flex-1 p-6 md:p-8 space-y-6">
                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center space-x-3 text-sm font-medium shadow-xs">
                        <i class="fa-solid fa-circle-check text-emerald-600"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl flex items-center space-x-3 text-sm font-medium shadow-xs">
                        <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>

            @include('layouts.partials.footer')
        </div>
    </div>

    @stack('scripts')
</body>
</html>

