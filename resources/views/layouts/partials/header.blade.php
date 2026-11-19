<!-- Topbar Header -->
<header class="bg-white/80 backdrop-blur-md sticky top-0 z-20 border-b border-slate-200/80 px-6 py-4 flex items-center justify-between shadow-xs">
    <div>
        <h2 class="text-xl font-bold text-slate-900 tracking-tight leading-snug">@yield('page-title', 'Halo, Admin')</h2>
        <p class="text-xs text-slate-500 font-medium">@yield('page-subtitle', 'Selamat datang di Peta Capaian PBB-P2')</p>
    </div>

    <div class="flex items-center space-x-3 sm:space-x-4">
        <!-- Date Range Filter Trigger & Dropdown -->
        <div class="relative" id="dateFilterContainer">
            <!-- Filter Button Pill (Matching UI mockup) -->
            <button type="button" 
                    id="dateFilterBtn"
                    onclick="toggleDateFilterDropdown()" 
                    class="flex items-center space-x-2 border rounded-xl px-3.5 py-1.5 text-xs font-semibold shadow-xs transition-all {{ ($isFiltered ?? false) ? 'bg-blue-50 border-blue-300 text-blue-700 ring-2 ring-blue-500/20' : 'bg-slate-100/90 border-slate-200 text-slate-700 hover:bg-slate-200/80 hover:border-slate-300' }}">
                <i class="fa-regular fa-calendar {{ ($isFiltered ?? false) ? 'text-blue-600' : 'text-slate-500' }}"></i>
                <span id="dateFilterDisplayLabel">{{ $filterLabel ?? '1 Jan 2026 - 31 Des 2026' }}</span>
                @if($isFiltered ?? false)
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                @endif
                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
            </button>

            <!-- Calendar & Range Dropdown -->
            <div id="dateFilterDropdown" class="hidden absolute right-0 mt-2 w-[320px] sm:w-[350px] bg-white border border-slate-200 rounded-2xl shadow-2xl p-5 z-50 text-slate-800">
                <!-- Dropdown Header -->
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-sm shadow-xs">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-900 leading-tight">Filter Rentang Waktu</h4>
                            <p class="text-[10px] text-slate-500">Pilih rentang tanggal data capaian & laporan</p>
                        </div>
                    </div>
                    <button type="button" onclick="toggleDateFilterDropdown()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <!-- Custom Range Form -->
                <form id="dateFilterForm" action="{{ url()->current() }}" method="GET" class="space-y-3.5">
                    @foreach(request()->except(['start_date', 'end_date', 'tahun']) as $k => $v)
                        @if(is_array($v))
                            @foreach($v as $subV)
                                <input type="hidden" name="{{ $k }}[]" value="{{ $subV }}">
                            @endforeach
                        @else
                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                        @endif
                    @endforeach

                    <div class="space-y-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-700 mb-1">
                                <i class="fa-regular fa-calendar text-blue-500 mr-1"></i> Dari Tanggal:
                            </label>
                            <input type="date" 
                                   id="filterInputStart" 
                                   name="start_date" 
                                   value="{{ $filterStartDate ?? '2026-01-01' }}" 
                                   onchange="updateDateSpanHelper()"
                                   class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-slate-700 mb-1">
                                <i class="fa-regular fa-calendar-check text-emerald-500 mr-1"></i> Sampai Tanggal:
                            </label>
                            <input type="date" 
                                   id="filterInputEnd" 
                                   name="end_date" 
                                   value="{{ $filterEndDate ?? '2026-12-31' }}" 
                                   onchange="updateDateSpanHelper()"
                                   class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-[11px] text-slate-500 pt-1">
                        <span id="dateDurationInfo" class="font-medium text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md">
                            <i class="fa-solid fa-clock-rotate-left mr-1"></i> Rentang: <span id="daysCount">365</span> hari
                        </span>
                        <a href="{{ url()->current() }}" class="text-slate-400 hover:text-red-500 underline text-[11px]">
                            Reset default
                        </a>
                    </div>

                    <!-- Footer Action Buttons -->
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-end space-x-2">
                        <button type="button" onclick="toggleDateFilterDropdown()" class="px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white shadow-sm flex items-center space-x-1.5 transition-colors">
                            <i class="fa-solid fa-check"></i>
                            <span>Terapkan Filter</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Reset Button -->
        <a href="{{ url()->current() }}" title="Reset Rentang Tanggal" class="flex items-center space-x-1.5 bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-blue-600 px-3 py-1.5 rounded-xl text-xs font-semibold shadow-xs transition-colors">
            <i class="fa-solid fa-rotate text-slate-400 hover:text-blue-500"></i>
            <span>Reset</span>
        </a>

        <!-- User Dropdown Menu -->
        <div class="relative">
            <button onclick="document.getElementById('userMenuDropdown').classList.toggle('hidden')" class="flex items-center space-x-2 bg-white border border-slate-200 rounded-xl px-3 py-1.5 shadow-xs hover:border-slate-300 text-xs font-semibold text-slate-800">
                <i class="fa-regular fa-circle-user text-base text-slate-500"></i>
                <span>{{ Auth::user()->nama ?? 'Admin' }}</span>
                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
            </button>
            <div id="userMenuDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white border border-slate-100 rounded-xl shadow-xl py-2 z-50">
                <div class="px-4 py-2 border-b border-slate-100">
                    <p class="text-xs font-bold text-slate-900">{{ Auth::user()->nama ?? 'Administrator' }}</p>
                    <p class="text-[10px] text-slate-500">{{ Auth::user()->instansi ?? 'BAPENDA Karawang' }}</p>
                </div>
                <a href="{{ route('pengaturan.users') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50">
                    <i class="fa-solid fa-user-gear mr-2 text-slate-400"></i> Manajemen Pengguna
                </a>
                <a href="{{ route('pengaturan.keamanan') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50">
                    <i class="fa-solid fa-shield-halved mr-2 text-slate-400"></i> Keamanan Sistem
                </a>
                <div class="border-t border-slate-100 my-1"></div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50 flex items-center">
                        <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<script>
    function toggleDateFilterDropdown() {
        const dd = document.getElementById('dateFilterDropdown');
        if (dd) {
            dd.classList.toggle('hidden');
            if (!dd.classList.contains('hidden')) {
                updateDateSpanHelper();
            }
        }
    }

    function updateDateSpanHelper() {
        const startVal = document.getElementById('filterInputStart')?.value;
        const endVal = document.getElementById('filterInputEnd')?.value;
        if (startVal && endVal) {
            const d1 = new Date(startVal);
            const d2 = new Date(endVal);
            const diffTime = d2 - d1;
            const diffDays = Math.max(1, Math.round(diffTime / (1000 * 60 * 60 * 24)) + 1);
            const daysSpan = document.getElementById('daysCount');
            if (daysSpan) {
                daysSpan.textContent = isNaN(diffDays) ? '?' : diffDays;
            }
        }
    }

    // Close on click outside
    document.addEventListener('click', function(e) {
        const container = document.getElementById('dateFilterContainer');
        const dropdown = document.getElementById('dateFilterDropdown');
        if (container && dropdown && !container.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', updateDateSpanHelper);
    } else {
        updateDateSpanHelper();
    }
</script>
