<!-- Sidebar Navigation -->
<aside class="w-64 bg-[#182438] text-white flex flex-col flex-shrink-0 z-30 shadow-xl transition-all duration-300">
    <!-- Logo Header (Official Karawang Emblem + BAPENDA KABUPATEN KARAWANG) -->
    <div class="p-5 border-b border-slate-700/60 flex items-center space-x-3.5 bg-[#142032]">
        @if(file_exists(public_path('images/logo-karawang.png')))
            <img src="{{ asset('images/logo-karawang.png') }}" alt="Lambang Kabupaten Karawang" class="h-12 w-auto object-contain flex-shrink-0 drop-shadow-md">
        @elseif(file_exists(public_path('images/bapenda-logo.png')))
            <img src="{{ asset('images/bapenda-logo.png') }}" alt="Lambang Kabupaten Karawang" class="h-12 w-auto object-contain flex-shrink-0 drop-shadow-md">
        @else
            <div class="w-11 h-11 rounded-xl bg-blue-600 flex items-center justify-center text-white font-bold text-lg shadow-md flex-shrink-0">
                <i class="fa-solid fa-landmark"></i>
            </div>
        @endif
        <div class="leading-tight">
            <h1 class="text-base font-black tracking-wider text-white uppercase">BAPENDA</h1>
            <p class="text-[11px] text-slate-200 font-bold tracking-wide uppercase mt-0.5">KABUPATEN KARAWANG</p>
        </div>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 px-3 py-6 space-y-1.5 overflow-y-auto">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('dashboard') ? 'sidebar-item-active text-white shadow-md' : 'text-slate-300 hover:bg-[#24344e] hover:text-white' }}">
            <i class="fa-solid fa-house w-5 text-center"></i>
            <span>Beranda</span>
        </a>

        <a href="{{ route('peta.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('peta.*') ? 'sidebar-item-active text-white shadow-md' : 'text-slate-300 hover:bg-[#24344e] hover:text-white' }}">
            <i class="fa-solid fa-map-location-dot w-5 text-center"></i>
            <span>Peta PBB-P2</span>
        </a>

        <a href="{{ route('realisasi.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('realisasi.*') ? 'sidebar-item-active text-white shadow-md' : 'text-slate-300 hover:bg-[#24344e] hover:text-white' }}">
            <i class="fa-solid fa-chart-line w-5 text-center"></i>
            <span>Realisasi & Target</span>
        </a>

        <a href="{{ route('penggunaan.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('penggunaan.*') ? 'sidebar-item-active text-white shadow-md' : 'text-slate-300 hover:bg-[#24344e] hover:text-white' }}">
            <i class="fa-solid fa-book-open w-5 text-center"></i>
            <span>Penggunaan Pajak</span>
        </a>

        <a href="{{ route('informasi.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('informasi.*') ? 'sidebar-item-active text-white shadow-md' : 'text-slate-300 hover:bg-[#24344e] hover:text-white' }}">
            <i class="fa-solid fa-circle-info w-5 text-center"></i>
            <span>Informasi</span>
        </a>

        <div class="pt-4 pb-2 px-4">
            <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400">Layanan & Sistem</span>
        </div>

        <a href="{{ route('cek-pbb.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('cek-pbb.*') ? 'sidebar-item-active text-white shadow-md' : 'text-slate-300 hover:bg-[#24344e] hover:text-white' }}">
            <i class="fa-solid fa-magnifying-glass-dollar w-5 text-center"></i>
            <span>Cek PBB Online</span>
        </a>

        <a href="{{ route('pengaturan.users') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('pengaturan.users') ? 'sidebar-item-active text-white shadow-md' : 'text-slate-300 hover:bg-[#24344e] hover:text-white' }}">
            <i class="fa-solid fa-users-gear w-5 text-center"></i>
            <span>Manajemen Pengguna</span>
        </a>

        <a href="{{ route('pengaturan.keamanan') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('pengaturan.keamanan') ? 'sidebar-item-active text-white shadow-md' : 'text-slate-300 hover:bg-[#24344e] hover:text-white' }}">
            <i class="fa-solid fa-shield-halved w-5 text-center"></i>
            <span>Keamanan Sistem</span>
        </a>
    </nav>

    <!-- Bottom User Card -->
    <div class="p-4 border-t border-slate-700/60 bg-[#121c2d]">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3 overflow-hidden">
                <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center font-bold text-white text-sm shadow">
                    <i class="fa-regular fa-user"></i>
                </div>
                <div class="truncate">
                    <p class="text-xs font-bold text-white truncate">{{ Auth::user()->nama ?? 'Administrator' }}</p>
                    <p class="text-[10px] text-slate-400 truncate">{{ Auth::user()->email ?? 'admin@karawangkab.go.id' }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" title="Logout" class="p-2 text-slate-400 hover:text-red-400 hover:bg-slate-800 rounded-lg transition-colors">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

