<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login') - BAPENDA Kabupaten Karawang</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-karawang.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #ffffff;
        }
    </style>
</head>
<body class="bg-white min-h-screen flex items-center justify-center antialiased">
    <div class="w-full min-h-screen flex flex-col lg:flex-row">
        
        <!-- Left Hero Column (Matching BERANDA-1.png & BERANDA-2.png) -->
        <div class="lg:w-1/2 bg-gradient-to-b from-blue-50/50 via-sky-50/40 to-blue-100/60 p-8 lg:p-12 flex flex-col justify-between relative overflow-hidden">
            <div></div>

            <!-- Regent & Vice Regent Portrait Hero -->
            <div class="relative z-10 my-auto flex flex-col items-center">
                @if(file_exists(public_path('images/bupati-hero.png')))
                    <div class="max-w-lg w-full">
                        <img src="{{ asset('images/bupati-hero.png') }}" alt="Bupati dan Wakil Bupati Karawang" class="w-full object-contain drop-shadow-xl rounded-2xl">
                    </div>
                @else
                    <!-- Fallback if image crop not present -->
                    <div class="max-w-md w-full bg-white/80 backdrop-blur-md rounded-3xl p-8 shadow-xl border border-white text-center">
                        <i class="fa-solid fa-users text-5xl text-blue-600 mb-4"></i>
                        <h3 class="text-lg font-black text-slate-900">Pemerintah Kabupaten Karawang</h3>
                        <p class="text-xs text-slate-500 mt-1">Pajak Anda untuk Pembangunan Karawang Maju</p>
                    </div>
                @endif
            </div>

            <!-- Bottom Note -->
            <div class="relative z-10 text-xs text-slate-500 font-medium">
                &copy; 2026 Badan Pendapatan Daerah Kabupaten Karawang
            </div>

            <!-- Background decorative shapes -->
            <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-blue-200/40 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-20 top-20 w-80 h-80 bg-sky-200/30 rounded-full blur-3xl pointer-events-none"></div>
        </div>

        <!-- Right Form Column -->
        <div class="lg:w-1/2 p-8 lg:p-16 flex flex-col justify-center bg-white relative">
            <div class="max-w-md w-full mx-auto space-y-6">
                @if(session('error'))
                    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl flex items-center space-x-3 text-xs font-bold shadow-xs">
                        <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center space-x-3 text-xs font-bold shadow-xs">
                        <i class="fa-solid fa-circle-check text-emerald-600"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>

    </div>
</body>
</html>

