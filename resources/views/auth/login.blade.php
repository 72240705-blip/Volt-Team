@extends('layouts.auth')
@section('title', 'Masuk')

@section('content')
<h2 class="text-xl font-bold text-gray-800 mb-6 text-center">Masuk ke Akun Anda</h2>

<!-- Form Login -->
<form action="{{ route('login.post') }}" method="POST" class="space-y-4">
    @csrf

    <!-- Pesan Error jika Login Gagal -->
    @if($errors->any())
        <div class="bg-red-50 text-red-600 text-xs p-3 rounded-xl border border-red-200 flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation text-red-500"></i>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <!-- Input Email -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-envelope text-gray-400 text-sm"></i>
            </div>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus 
                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none transition" 
                   placeholder="Masukkan email terdaftar">
        </div>
    </div>

    <!-- Input Password -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-lock text-gray-400 text-sm"></i>
            </div>
            <input type="password" name="password" required 
                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none transition" 
                   placeholder="••••••••">
        </div>
        <div class="flex justify-end mt-1">
            <a href="#" class="text-xs text-blue-600 hover:underline font-medium">Lupa sandi?</a>
        </div>
    </div>

    <!-- Tombol Submit -->
    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2.5 rounded-xl hover:bg-blue-700 transition shadow-sm mt-4">
        Masuk
    </button>
</form>

<!-- Link ke Halaman Registrasi -->
<p class="text-center text-sm text-gray-600 mt-6">
    Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:underline">Daftar sekarang</a>
</p>
@endsection