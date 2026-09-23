@extends('layouts.auth')
@section('title', 'Daftar Akun')

@section('content')
<h2 class="text-xl font-bold text-gray-800 mb-6 text-center">Buat Akun Pengemudi</h2>

<!-- Menampilkan Pesan Error Validasi Jika Ada -->
@if ($errors->any())
    <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 rounded-xl text-xs space-y-1">
        <p class="font-bold flex items-center gap-1.5">
            <i class="fa-solid fa-triangle-exclamation"></i> Pendaftaran Gagal:
        </p>
        <ul class="list-disc pl-5 space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('register.post') }}" method="POST" class="space-y-4">
    @csrf

    <!-- Input Nama Lengkap -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-user text-gray-400 text-sm"></i>
            </div>
            <input type="text" name="nama" value="{{ old('nama') }}" required 
                   class="w-full pl-10 pr-4 py-2 border @error('nama') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-blue-500 text-sm outline-none" 
                   placeholder="Contoh: Budi Santoso">
        </div>
    </div>

    <!-- Input Email -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-envelope text-gray-400 text-sm"></i>
            </div>
            <input type="email" name="email" value="{{ old('email') }}" required 
                   class="w-full pl-10 pr-4 py-2 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-blue-500 text-sm outline-none" 
                   placeholder="budi@email.com">
        </div>
    </div>

    <!-- Input No Telepon -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-phone text-gray-400 text-sm"></i>
            </div>
            <input type="tel" name="no_telepon" value="{{ old('no_telepon') }}" required 
                   class="w-full pl-10 pr-4 py-2 border @error('no_telepon') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-blue-500 text-sm outline-none" 
                   placeholder="08123456789">
        </div>
    </div>

    <!-- Input Password -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi (Min. 6 Karakter)</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-lock text-gray-400 text-sm"></i>
            </div>
            <input type="password" name="password" required 
                   class="w-full pl-10 pr-4 py-2 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-blue-500 text-sm outline-none" 
                   placeholder="••••••••">
        </div>
    </div>

    <!-- Tombol Submit -->
    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2.5 rounded-xl hover:bg-blue-700 transition shadow-sm mt-4">
        Daftar Akun
    </button>
</form>

<p class="text-center text-sm text-gray-600 mt-6">
    Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">Masuk di sini</a>
</p>
@endsection