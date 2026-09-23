<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
// =========================================================================
// DATA DUMMY LOKASI CHARGING STATION DI JOGJA
// Anda bisa mengganti/menghubungkan data ini dengan database MySQL/PostgreSQL
// =========================================================================
$charging_stations = [
    [
        'id' => 'CS-JOG-001',
        'nama' => 'EVChargeHub Malioboro Mall',
        'alamat' => 'Jl. Malioboro No. 52-54, Sosromenduran, Gedongtengen, Kota Yogyakarta',
        'lat' => -7.7925,
        'lng' => 110.3658,
        'total_charger' => 4,
        'tersedia' => 3,
        'terpakai' => 1,
        'status' => 'Operasional', // Operasional, Perbaikan, Non-Aktif
        'tipe_charger' => ['CCS2 (60kW)', 'Type 2 (22kW)']
    ],
    [
        'id' => 'CS-JOG-002',
        'nama' => 'EVChargeHub Tugu Yogyakarta',
        'alamat' => 'Jl. Jend. Sudirman No. 1, Gowongan, Jetis, Kota Yogyakarta',
        'lat' => -7.7829,
        'lng' => 110.3671,
        'total_charger' => 6,
        'tersedia' => 2,
        'terpakai' => 4,
        'status' => 'Operasional',
        'tipe_charger' => ['CCS2 (120kW)', 'CHAdeMO (50kW)', 'Type 2 (22kW)']
    ],
    [
        'id' => 'CS-JOG-003',
        'nama' => 'EVChargeHub Ambarrukmo Plaza',
        'alamat' => 'Jl. Laksda Adisucipto No. 80, Caturtunggal, Depok, Sleman',
        'lat' => -7.7828,
        'lng' => 110.4012,
        'total_charger' => 4,
        'tersedia' => 4,
        'terpakai' => 0,
        'status' => 'Operasional',
        'tipe_charger' => ['CCS2 (100kW)', 'Type 2 (22kW)']
    ],
    [
        'id' => 'CS-JOG-004',
        'nama' => 'EVChargeHub Pakuwon Mall Jogja',
        'alamat' => 'Jl. Ring Road Utara, Ring Road Utara, Depok, Sleman',
        'lat' => -7.7588,
        'lng' => 110.3952,
        'total_charger' => 8,
        'tersedia' => 5,
        'terpakai' => 3,
        'status' => 'Operasional',
        'tipe_charger' => ['CCS2 (150kW Ultra Fast)', 'Type 2 (22kW)']
    ],
    [
        'id' => 'CS-JOG-005',
        'nama' => 'EVChargeHub Bandara YIA (Kulon Progo)',
        'alamat' => 'Area Parkir A2, Bandara Internasional Yogyakarta, Temon, Kulon Progo',
        'lat' => -7.9016,
        'lng' => 110.0573,
        'total_charger' => 4,
        'tersedia' => 0,
        'terpakai' => 0,
        'status' => 'Perbaikan',
        'tipe_charger' => ['CCS2 (60kW)']
    ],
    [
        'id' => 'CS-JOG-006',
        'nama' => 'EVChargeHub Candi Prambanan',
        'alamat' => 'Jl. Raya Solo - Yogyakarta Km. 16, Bokoharjo, Prambanan, Sleman',
        'lat' => -7.7520,
        'lng' => 110.4914,
        'total_charger' => 2,
        'tersedia' => 1,
        'terpakai' => 1,
        'status' => 'Operasional',
        'tipe_charger' => ['Type 2 (22kW)']
    ]
];

// Perhitungan Ringkasan Statistik
$total_stasiun = count($charging_stations);$total_charger = 0;
$total_tersedia = 0;
$total_terpakai = 0;
$total_perbaikan = 0;

foreach ($charging_stations as$st) {
    $total_charger +=$st['total_charger'];
    $total_tersedia +=$st['tersedia'];
    $total_terpakai +=$st['terpakai'];
    if ($st['status'] === 'Perbaikan') {$total_perbaikan++;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVChargeHub - Lokasi Charging Jogja</title>
    
    <!-- Tailwind CSS (via CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Leaflet OpenStreetMap CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        #map { z-index: 1; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-[#1e293b] text-slate-300 flex flex-col justify-between hidden md:flex min-h-screen">
        <div>
            <!-- Logo Header -->
            <div class="px-6 py-5 flex items-center gap-3 border-b border-slate-700">
                <i class="fa-solid fa-bolt text-emerald-400 text-2xl"></i>
                <span class="text-xl font-bold text-white tracking-wide">EVChargeHub</span>
            </div>

            <!-- Profile Info -->
            <div class="p-4 bg-slate-800/50 m-3 rounded-lg flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center">
                    OE
                </div>
                <div>
                    <p class="text-sm font-semibold text-white">Operator EVCharge</p>
                    <p class="text-xs text-emerald-400 flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 inline-block"></span> Online
                    </p>
                </div>
            </div>

            <!-- Menu Operasional -->
            <div class="px-4 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                Operasional
            </div>
            <nav class="space-y-1 px-3">
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
                    <i class="fa-solid fa-gauge w-5 text-center"></i> Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-emerald-600 text-white font-medium shadow-md">
                    <i class="fa-solid fa-charging-station w-5 text-center"></i> Lokasi Charging
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
                    <i class="fa-solid fa-plug w-5 text-center"></i> Charging Session
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
                    <i class="fa-solid fa-file-invoice-dollar w-5 text-center"></i> Transaksi
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
                    <i class="fa-solid fa-chart-line w-5 text-center"></i> Laporan
                </a>
                <a href="#" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-bell w-5 text-center"></i> Notifikasi
                    </div>
                    <span class="bg-rose-500 text-white text-xs px-2 py-0.5 rounded-full">3</span>
                </a>
            </nav>

            <!-- Menu Akun -->
            <div class="px-4 py-2 mt-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                Akun
            </div>
            <nav class="space-y-1 px-3">
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
                    <i class="fa-solid fa-user w-5 text-center"></i> Profile
                </a>
            </nav>
        </div>

        <div class="p-4 border-t border-slate-700">
            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-rose-400 hover:bg-rose-500/10 transition">
                <i class="fa-solid fa-right-from-bracket w-5 text-center"></i> Logout
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- Top Header Navigation -->
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-4">
                <button class="md:hidden text-gray-600 focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h1 class="text-xl font-bold text-gray-800">Tampilan Lokasi Charging (DI Yogyakarta)</h1>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="relative">
                    <button class="p-2 text-gray-500 hover:text-gray-700 relative">
                        <i class="fa-solid fa-bell"></i>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-rose-500 rounded-full"></span>
                    </button>
                </div>
                <div class="flex items-center gap-2 border-l pl-4 border-gray-200">
                    <i class="fa-solid fa-circle-user text-gray-400 text-2xl"></i>
                    <span class="text-sm font-medium text-gray-700">Operator EVCharge</span>
                </div>
            </div>
        </header>

        <!-- Main Body -->
        <main class="p-6 space-y-6 flex-1 overflow-y-auto">

            <!-- Breadcrumb & Title Section -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Stasiun Pengisian EV - Wilayah Yogyakarta</h2>
                    <p class="text-sm text-gray-500">Monitoring lokasi, ketersediaan charger, dan status stasiun real-time.</p>
                </div>
                <div class="text-sm text-gray-500">
                    <span>Home</span> / <span class="text-gray-800 font-medium">Lokasi Charging</span>
                </div>
            </div>

            <!-- STATS CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Card 1 -->
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Stasiun (Jogja)</p>
                        <h3 class="text-3xl font-extrabold text-gray-800 mt-1"><?= $total_stasiun ?></h3>
                    </div>
                    <div class="w-12 h-12 bg-cyan-100 text-cyan-600 rounded-lg flex items-center justify-center text-xl">
                        <i class="fa-solid fa-charging-station"></i>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Charger Tersedia</p>
                        <h3 class="text-3xl font-extrabold text-emerald-600 mt-1"><?= $total_tersedia ?> <span class="text-sm font-normal text-gray-500">/ <?= $total_charger ?></span></h3>
                    </div>
                    <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center text-xl">
                        <i class="fa-solid fa-[#00aa55]"></i>
                        <i class="fa-solid fa-square-check"></i>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Sedang Digunakan</p>
                        <h3 class="text-3xl font-extrabold text-amber-500 mt-1"><?= $total_terpakai ?></h3>
                    </div>
                    <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center text-xl">
                        <i class="fa-solid fa-plug-circle-bolt"></i>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Dalam Perbaikan</p>
                        <h3 class="text-3xl font-extrabold text-rose-500 mt-1"><?= $total_perbaikan ?></h3>
                    </div>
                    <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-lg flex items-center justify-center text-xl">
                        <i class="fa-solid fa-wrench"></i>
                    </div>
                </div>
            </div>

            <!-- MAP SECTION -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-map-location-dot text-emerald-600"></i> Peta Persebaran Charging Station Yogyakarta
                    </h3>
                    <span class="text-xs bg-emerald-100 text-emerald-700 px-2.5 py-1 rounded-full font-medium">Interaktif</span>
                </div>
                <!-- Leaflet Container -->
                <div id="map" class="w-full h-80 sm:h-[400px]"></div>
            </div>

            <!-- DATA TABLE SECTION -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <h3 class="font-bold text-gray-800">Daftar Lokasi & Status Real-Time</h3>
                    <button class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm px-4 py-2 rounded-lg font-medium transition flex items-center gap-2 self-start sm:self-auto">
                        <i class="fa-solid fa-plus"></i> Tambah Lokasi Baru
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-xs font-semibold uppercase tracking-wider border-b border-gray-200">
                                <th class="px-6 py-3">ID Stasiun</th>
                                <th class="px-6 py-3">Nama & Alamat</th>
                                <th class="px-6 py-3">Tipe Charger</th>
                                <th class="px-6 py-3 text-center">Ketersediaan</th>
                                <th class="px-6 py-3 text-center">Status</th>
                                <th class="px-6 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm">
                            <?php foreach ($charging_stations as$st): ?>
                            <tr class="hover:bg-gray-50/80 transition">
                                <td class="px-6 py-4 font-semibold text-gray-700"><?= htmlspecialchars($st['id']) ?></td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-800"><?= htmlspecialchars($st['nama']) ?></div>
                                    <div class="text-xs text-gray-500 mt-0.5 max-w-sm truncate"><?= htmlspecialchars($st['alamat']) ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        <?php foreach ($st['tipe_charger'] as$tipe): ?>
                                            <span class="bg-slate-100 text-slate-700 text-[11px] font-medium px-2 py-0.5 rounded border border-slate-200">
                                                <?= htmlspecialchars($tipe) ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-bold text-emerald-600"><?= $st['tersedia'] ?></span>
                                    <span class="text-gray-400">/ <?= $st['total_charger'] ?> Unit</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <?php if ($st['status'] === 'Operasional'): ?>
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Operasional
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-rose-100 text-rose-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Perbaikan
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-emerald-600 hover:text-emerald-800 text-xs font-semibold px-2 py-1 rounded border border-emerald-200 hover:border-emerald-600 transition">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    <!-- JAVASCRIPT LEAFLET MAP INTEGRATION -->
    <script>
        // Data dari PHP di-convert ke JSON untuk JavaScript
        const stationsData = <?php echo json_encode($charging_stations); ?>;

        // Inisialisasi Peta (Pusat di Yogyakarta)
        const map = L.map('map').setView([-7.797061, 110.370529], 11);

        // Tambahkan Tile Layer (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Tambahkan Marker untuk Setiap Stasiun
        stationsData.forEach(stasiun => {
            const isOperational = stasiun.status === 'Operasional';
            
            // Marker Pop-up Content
            const popupContent = `
                <div style="font-family: 'Inter', sans-serif; padding: 2px;">
                    <b style="font-size: 14px; color: #1e293b;">${stasiun.nama}</b><br>
                    <span style="font-size: 11px; color: #64748b;">${stasiun.alamat}</span><br>
                    <hr style="margin: 6px 0; border-color: #e2e8f0;">
                    <div style="font-size: 12px;">
                        <b>Status:</b> <span style="color: ${isOperational ? '#10b981' : '#ef4444'}; font-weight: bold;">${stasiun.status}</span><br>
                        <b>Tersedia:</b> <b>${stasiun.tersedia}</b> / ${stasiun.total_charger} Charger
                    </div>
                </div>
            `;

            L.marker([stasiun.lat, stasiun.lng])
                .addTo(map)
                .bindPopup(popupContent);
        });
    </script>
</body>
</html>
</body>
</html>