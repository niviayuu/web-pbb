@extends('layouts.auth')

@section('title', 'Daftar Akun - BAPENDA Karawang')

@section('content')
<!-- Back to Login -->
<div class="text-left text-xs mb-2">
    <a href="{{ route('login') }}" class="font-extrabold text-blue-600 hover:text-blue-800 flex items-center space-x-1.5">
        <i class="fa-solid fa-arrow-left text-[10px]"></i>
        <span>Kembali ke Login</span>
    </a>
</div>

<!-- Title & Subtitle -->
<div class="space-y-1">
    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Daftar Akun</h1>
    <p class="text-xs text-slate-500 font-medium">Lengkapi data diri Anda untuk membuat akun.</p>
</div>

<!-- Register Form -->
<form action="{{ route('register') }}" method="POST" class="space-y-3.5 pt-2">
    @csrf

    <!-- Nama Lengkap -->
    <div>
        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap</label>
        <div class="relative">
            <i class="fa-regular fa-user absolute left-3.5 top-3 text-slate-400 text-xs"></i>
            <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Masukkan nama lengkap" 
                   class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-300 rounded-xl text-xs font-semibold focus:ring-2 focus:ring-blue-600 outline-none">
        </div>
        @error('nama') <p class="text-rose-600 text-[10px] mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Email -->
    <div>
        <label class="block text-xs font-bold text-slate-700 mb-1">Email</label>
        <div class="relative">
            <i class="fa-regular fa-envelope absolute left-3.5 top-3 text-slate-400 text-xs"></i>
            <input type="email" name="email" value="{{ old('email') }}" required placeholder="Masukkan email aktif" 
                   class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-300 rounded-xl text-xs font-semibold focus:ring-2 focus:ring-blue-600 outline-none">
        </div>
        @error('email') <p class="text-rose-600 text-[10px] mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Nomor HP -->
    <div>
        <label class="block text-xs font-bold text-slate-700 mb-1">Nomor HP</label>
        <div class="relative">
            <i class="fa-solid fa-phone absolute left-3.5 top-3 text-slate-400 text-xs"></i>
            <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="Masukkan nomor HP aktif" 
                   class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-300 rounded-xl text-xs font-semibold focus:ring-2 focus:ring-blue-600 outline-none">
        </div>
    </div>

    <!-- Instansi / Unit Kerja -->
    <div>
        <label class="block text-xs font-bold text-slate-700 mb-1">Instansi / Unit Kerja</label>
        <div class="relative">
            <i class="fa-regular fa-building absolute left-3.5 top-3 text-slate-400 text-xs"></i>
            <select name="instansi" class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-300 rounded-xl text-xs font-semibold focus:ring-2 focus:ring-blue-600 outline-none">
                <option value="">Pilih instansi / unit kerja</option>
                <option value="BAPENDA Kabupaten Karawang">BAPENDA Kabupaten Karawang</option>
                <option value="Kecamatan (Kantor Camat)">Kecamatan (Kantor Camat)</option>
                <option value="Pemerintah Desa / Kelurahan">Pemerintah Desa / Kelurahan</option>
                <option value="Wajib Pajak Perorangan / Badan">Wajib Pajak Perorangan / Badan</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>
    </div>

    <!-- Password -->
    <div>
        <label class="block text-xs font-bold text-slate-700 mb-1">Password</label>
        <div class="relative">
            <i class="fa-solid fa-lock absolute left-3.5 top-3 text-slate-400 text-xs"></i>
            <input type="password" name="password" required placeholder="Minimal 8 karakter" 
                   class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-300 rounded-xl text-xs font-semibold focus:ring-2 focus:ring-blue-600 outline-none">
        </div>
        @error('password') <p class="text-rose-600 text-[10px] mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Konfirmasi Password -->
    <div>
        <label class="block text-xs font-bold text-slate-700 mb-1">Konfirmasi Password</label>
        <div class="relative">
            <i class="fa-solid fa-lock absolute left-3.5 top-3 text-slate-400 text-xs"></i>
            <input type="password" name="password_confirmation" required placeholder="Ulangi password" 
                   class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-300 rounded-xl text-xs font-semibold focus:ring-2 focus:ring-blue-600 outline-none">
        </div>
    </div>

    <!-- Terms Checkbox -->
    <div class="pt-1">
        <label class="flex items-start space-x-2 text-[11px] text-slate-600 cursor-pointer">
            <input type="checkbox" required class="w-4 h-4 rounded text-blue-600 border-slate-300 focus:ring-blue-500 mt-0.5">
            <span>Saya menyetujui <a href="#" class="text-blue-600 font-bold underline">Syarat dan Ketentuan</a> serta <a href="#" class="text-blue-600 font-bold underline">Kebijakan Privasi</a> yang berlaku.</span>
        </label>
    </div>

    <!-- Submit Button (Matching BERANDA-2.png) -->
    <button type="submit" class="w-full py-3.5 bg-[#1746a2] hover:bg-[#123682] text-white rounded-xl text-xs font-extrabold shadow-md transition-all mt-2">
        Daftar
    </button>
</form>
@endsection

