<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVChargeHub - PT Bongkar Turret</title>
    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-800 font-sans min-h-screen flex flex-col">

    <!-- Top Bar Header -->
    <header class="bg-blue-600 text-white shadow-md sticky top-0 z-50">
        <div class="px-6 py-3 flex justify-between items-center">
            <!-- Logo Brand -->
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-bolt text-amber-300 text-xl"></i>
                <span class="text-xl font-bold tracking-wide">EVChargeHub</span>
            </div>

            <!-- Nama Pengguna yang Sedang Login -->
            <div class="flex items-center gap-4">
                <span class="text-xs bg-blue-800 text-blue-100 px-3 py-1 rounded-full font-medium">
                    PT Bongkar Turret
                </span>

                <div class="flex items-center gap-2 pl-4 border-l border-blue-500">
                    <i class="fa-solid fa-circle-user text-2xl text-blue-200"></i>
                    <div class="text-left">
                        <!-- Menampilkan nama user dinamis, jika belum login tampil Pengunjung -->
                        <p class="text-sm font-semibold leading-tight">
                            {{ Auth::check() ? Auth::user()->nama : 'Pengunjung' }}
                        </p>
                        <p class="text-[10px] text-blue-200 capitalize">
                            {{ Auth::check() ? Auth::user()->peran : 'Guest' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Wrapper (Sidebar Kiri + Konten Kanan) -->
    <div class="flex flex-1 container mx-auto px-4 py-6 gap-6">

        <!-- SIDEBAR MENU KIRI (Model E-Class) -->
        <aside class="w-64 bg-white rounded-xl shadow-sm border border-gray-200 p-4 h-fit sticky top-20">
            <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 px-3 pb-2 border-b border-gray-100">
                Menu Utama
            </h2>

            <nav class="space-y-1">
                <!-- Menu Stasiun -->
                <a href="{{ route('pengemudi.home') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('pengemudi.home') ? 'bg-blue-50 text-blue-600 font-bold border-l-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i class="fa-solid fa-map-location-dot w-5 text-center"></i>
                    <span>Stasiun</span>
                </a>

                <!-- Menu Riwayat -->
                <a href="{{ route('pengemudi.history') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('pengemudi.history') ? 'bg-blue-50 text-blue-600 font-bold border-l-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i class="fa-solid fa-clock-rotate-left w-5 text-center"></i>
                    <span>Riwayat</span>
                </a>

                <!-- Menu Kendaraan -->
                <a href="{{ route('pengemudi.vehicles') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('pengemudi.vehicles') ? 'bg-blue-50 text-blue-600 font-bold border-l-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i class="fa-solid fa-car-side w-5 text-center"></i>
                    <span>Kendaraan</span>
                </a>

                <!-- Menu Profil -->
                <a href="{{ route('pengemudi.profile') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('pengemudi.profile') ? 'bg-blue-50 text-blue-600 font-bold border-l-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i class="fa-solid fa-user w-5 text-center"></i>
                    <span>Profil</span>
                </a>
            </nav>
        </aside>

        <!-- KONTEN UTAMA DI SEBELAH KANAN -->
        <main class="flex-1 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            @yield('content')
        </main>

    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-4 text-center text-xs text-gray-500 mt-auto">
        &copy; 2026 <strong>EVChargeHub</strong>. Developed by <strong>PT Bongkar Turret</strong>.
    </footer>

</body>
</html>