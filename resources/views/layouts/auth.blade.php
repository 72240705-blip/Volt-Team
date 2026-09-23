<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - EVChargeHub</title>
    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    
    <div class="w-full max-w-md p-6 bg-white rounded-2xl shadow-lg border border-gray-100">
        <!-- Logo & Judul -->
        <div class="text-center mb-8">
            <i class="fa-solid fa-bolt text-5xl text-blue-600 mb-2"></i>
            <h1 class="text-2xl font-bold text-gray-800 tracking-wide">EVChargeHub</h1>
            <p class="text-xs text-gray-500 mt-1">Sistem Manajemen Pengisian Daya Kendaraan Listrik</p>
        </div>

        <!-- Form Konten -->
        @yield('content')
        
        <!-- Footer Vendor -->
        <div class="text-center mt-8 pt-4 border-t border-gray-100">
            <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-widest">Powered by PT Bongkar Turret</p>
        </div>
    </div>

</body>
</html>