@extends('layouts.auth')

@section('title', 'Login - BAPENDA Karawang')

@section('content')
<!-- Header Link: Belum punya akun? -->
<div class="text-right text-xs">
    <span class="text-slate-500 font-medium">Belum punya akun?</span>
    <a href="{{ route('register') }}" class="font-extrabold text-blue-600 hover:text-blue-800 ml-1">
        Daftar di sini &rarr;
    </a>
</div>

<!-- Title & Subtitle -->
<div class="space-y-1.5 pt-2">
    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Login</h1>
    <p class="text-xs text-slate-500 font-medium">Masuk untuk melanjutkan ke dashboard Peta Capaian PBB-P2</p>
</div>

<!-- Info Akun Bawaan (Helper Box) -->
<div class="bg-blue-50/70 border border-blue-200/80 rounded-xl p-3 text-xs text-blue-900 space-y-1 mt-3">
    <div class="flex items-center font-bold text-blue-800 text-[11px]">
        <i class="fa-solid fa-key mr-1.5 text-blue-600"></i> Akun Demo / Pengujian:
    </div>
    <div class="text-[11px] text-slate-700">
        &bull; <strong>Email / Username:</strong> <code class="bg-white px-1.5 py-0.5 rounded border border-blue-200 font-mono text-blue-700 font-bold">admin@karawangkab.go.id</code> atau <code class="bg-white px-1.5 py-0.5 rounded border border-blue-200 font-mono text-blue-700 font-bold">admin</code>
    </div>
    <div class="text-[11px] text-slate-700">
        &bull; <strong>Password:</strong> <code class="bg-white px-1.5 py-0.5 rounded border border-blue-200 font-mono text-blue-700 font-bold">password</code> atau <code class="bg-white px-1.5 py-0.5 rounded border border-blue-200 font-mono text-blue-700 font-bold">admin123</code>
    </div>
</div>

<!-- Login Form -->
<form action="{{ route('login') }}" method="POST" class="space-y-4 pt-2">
    @csrf

    <!-- Email / Username -->
    <div>
        <label class="block text-xs font-bold text-slate-700 mb-1.5">Email / Username</label>
        <div class="relative">
            <i class="fa-regular fa-envelope absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
            <input type="text" name="email" value="{{ old('email', 'admin@karawangkab.go.id') }}" required 
                   placeholder="Masukkan email dan username" 
                   class="w-full pl-10 pr-4 py-3 bg-white border border-slate-300 rounded-xl text-xs font-semibold focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition-all placeholder-slate-400">
        </div>
    </div>

    <!-- Password -->
    <div>
        <label class="block text-xs font-bold text-slate-700 mb-1.5">Password</label>
        <div class="relative">
            <i class="fa-solid fa-lock absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
            <input type="password" id="passwordField" name="password" value="password" required 
                   placeholder="Masukkan password" 
                   class="w-full pl-10 pr-10 py-3 bg-white border border-slate-300 rounded-xl text-xs font-semibold focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition-all placeholder-slate-400">
            <button type="button" onclick="togglePasswordVisibility()" class="absolute right-3.5 top-3.5 text-slate-400 hover:text-slate-600">
                <i id="eyeIcon" class="fa-regular fa-eye text-xs"></i>
            </button>
        </div>
    </div>

    <!-- Remember Me & Forgot Password -->
    <div class="flex items-center justify-between text-xs pt-1">
        <label class="flex items-center space-x-2 text-slate-600 cursor-pointer">
            <input type="checkbox" name="remember" class="w-4 h-4 rounded text-blue-600 border-slate-300 focus:ring-blue-500">
            <span>Ingat saya</span>
        </label>
        <a href="#" class="font-bold text-blue-600 hover:text-blue-800">Lupa password?</a>
    </div>

    <!-- Submit Button (Matching BERANDA-1.png deep blue) -->
    <button type="submit" class="w-full py-3.5 bg-[#1746a2] hover:bg-[#123682] text-white rounded-xl text-xs font-extrabold shadow-md transition-all flex items-center justify-center space-x-2">
        <i class="fa-solid fa-arrow-right-to-bracket"></i>
        <span>Login</span>
    </button>
</form>

<!-- Divider Atau -->
<div class="relative flex items-center justify-center my-4">
    <div class="border-t border-slate-200 w-full"></div>
    <span class="bg-white px-3 text-[11px] text-slate-400 font-semibold uppercase absolute">atau</span>
</div>

<!-- Login with Google Button (Matching BERANDA-1.png) -->
<button type="button" onclick="alert('Fitur SSO Google Auth siap dikonfigurasikan dengan Google Client ID')" class="w-full py-3 bg-white hover:bg-slate-50 border border-slate-300 rounded-xl text-xs font-bold text-slate-700 shadow-xs transition-all flex items-center justify-center space-x-2.5">
    <svg class="w-4 h-4" viewBox="0 0 24 24">
        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
    </svg>
    <span>Login dengan Google</span>
</button>

<script>
    function togglePasswordVisibility() {
        const field = document.getElementById('passwordField');
        const icon = document.getElementById('eyeIcon');
        if (field.type === 'password') {
            field.type = 'text';
            icon.className = 'fa-regular fa-eye-slash text-xs';
        } else {
            field.type = 'password';
            icon.className = 'fa-regular fa-eye text-xs';
        }
    }
</script>
@endsection

