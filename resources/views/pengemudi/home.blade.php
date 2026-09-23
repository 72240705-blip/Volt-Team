@extends('layouts.app')
@section('title', 'Beranda Pengemudi')

@section('content')
<!-- CSS Leaflet Map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div class="space-y-6">

    <!-- HEADER BERANDA PENGEMUDI -->
    <div class="bg-gradient-to-r from-blue-700 to-blue-500 rounded-2xl p-6 text-white shadow-lg flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <span class="text-xs bg-blue-800/60 px-3 py-1 rounded-full border border-blue-400/30">Pengemudi EV</span>
            <h1 class="text-2xl font-bold mt-2">
                Selamat Datang, {{ Auth::check() ? Auth::user()->nama : 'Pengemudi' }}! 👋
            </h1>
            <p class="text-blue-100 text-sm">Temukan stasiun pengisian terdekat dan kelola kendaraan listrik Anda.</p>
        </div>

        <!-- Tombol Aksi Scan QR -->
        <div class="flex items-center gap-3 w-full md:w-auto">
            <button class="flex-1 md:flex-initial bg-amber-400 hover:bg-amber-500 text-gray-900 font-bold px-4 py-2.5 rounded-xl shadow transition flex items-center justify-center gap-2 text-sm">
                <i class="fa-solid fa-qrcode text-base"></i>
                <span>Scan QR Charger</span>
            </button>
            <a href="{{ route('pengemudi.vehicles') }}" class="bg-white/20 hover:bg-white/30 text-white font-medium px-4 py-2.5 rounded-xl transition flex items-center justify-center gap-2 text-sm backdrop-blur-sm">
                <i class="fa-solid fa-car"></i>
                <span class="hidden sm:inline">Kendaraan Saya</span>
            </a>
        </div>
    </div>
    
    <!-- 2. Kartu Sesi Charging Aktif (Hanya Tampil Jika Ada Sesi Berjalan) -->
    @if(isset($activeSession) &&$activeSession)
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between pb-3 border-b border-amber-200">
            <div class="flex items-center gap-2">
                <span class="relative flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
                </span>
                <span class="font-bold text-amber-900 text-sm">Sesi Pengisian Sedang Berlangsung</span>
            </div>
            <span class="text-xs font-semibold bg-amber-200 text-amber-800 px-2.5 py-0.5 rounded-md">
                {{ $activeSession->charger->kode_perangkat ?? 'Port #1' }} - {{ $activeSession->charger->tipe_konektor ?? 'CCS2' }}
            </span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-4 text-center">
            <div class="bg-white p-3 rounded-xl border border-amber-100 shadow-2xs">
                <p class="text-xs text-gray-500 mb-1">Daya Terisi</p>
                <p class="text-lg font-extrabold text-blue-600">{{ $activeSession->energi_kwh ?? 0 }} <span class="text-xs font-normal">kWh</span></p>
            </div>
            <div class="bg-white p-3 rounded-xl border border-amber-100 shadow-2xs">
                <p class="text-xs text-gray-500 mb-1">Persentase</p>
                <p class="text-lg font-extrabold text-green-600">{{ $activeSession->persentase_baterai ?? 0 }}%</p>
            </div>
            <div class="bg-white p-3 rounded-xl border border-amber-100 shadow-2xs">
                <p class="text-xs text-gray-500 mb-1">Durasi</p>
                <p class="text-lg font-extrabold text-gray-800">{{ $activeSession->durasi ?? '00:00:00' }}</p>
            </div>
            <div class="bg-white p-3 rounded-xl border border-amber-100 shadow-2xs">
                <p class="text-xs text-gray-500 mb-1">Estimasi Biaya</p>
                <p class="text-lg font-extrabold text-gray-800">Rp {{ number_format($activeSession->total_biaya ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="mt-4 flex justify-end">
            <button class="bg-red-600 hover:bg-red-700 text-white font-bold text-xs px-4 py-2 rounded-xl transition shadow-xs flex items-center gap-2">
                <i class="fa-solid fa-stop text-xs"></i> Stop Charging
            </button>
        </div>
    </div>
    @endif

    <!-- 3. Section Pencarian & Filter Stasiun -->
    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-xs space-y-3">
        <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-sliders text-blue-600"></i> Cari & Filter Stasiun Pengisian
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400 text-sm"></i>
                <input type="text" placeholder="Cari lokasi / nama stasiun..." class="w-full pl-9 pr-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <select class="w-full py-2 px-3 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none bg-white text-gray-700">
                    <option value="">Semua Tipe Konektor</option>
                    <option value="CCS2">CCS2 (Fast Charging)</option>
                    <option value="Type 2">Type 2 (AC Standard)</option>
                    <option value="CHAdeMO">CHAdeMO</option>
                </select>
            </div>
            <div>
                <select class="w-full py-2 px-3 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none bg-white text-gray-700">
                    <option value="">Semua Status Charger</option>
                    <option value="tersedia">Hanya Yang Tersedia</option>
                    <option value="fast">Daya Tinggi (>50 kW)</option>
                </select>
            </div>
        </div>
    </div>

    <!-- 4. Tampilan Kombinasi: List View (Kiri) & Map View (Kanan) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Sisi Kiri: List View Stasiun (5 Cols) -->
        <div class="lg:col-span-5 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-gray-800 text-sm">Stasiun Pengisian Terdekat</h3>
                <span class="text-xs text-gray-500 font-medium">Klik untuk lihat detail</span>
            </div>

            <!-- Card Stasiun 1 -->
            <div onclick="showStationDetail(0)" class="bg-white p-4 rounded-2xl border border-gray-100 shadow-xs hover:border-blue-500 hover:shadow-md transition cursor-pointer">
                <div class="flex justify-between items-start gap-2">
                    <div>
                        <span class="inline-block text-[10px] bg-green-100 text-green-700 font-bold px-2 py-0.5 rounded-md mb-1">
                            Tersedia
                        </span>
                        <h4 class="font-bold text-gray-900 text-sm">SPKLU UKDW Malioboro</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Jl. Dr. Wahidin Sudirohusodo No.52</p>
                    </div>
                    <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">1.2 km</span>
                </div>

                <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between text-xs">
                    <div class="flex items-center gap-3 text-gray-600">
                        <span><i class="fa-solid fa-bolt text-amber-500"></i> 60 kW</span>
                        <span><i class="fa-solid fa-plug text-blue-500"></i> CCS2, Type 2</span>
                    </div>
                    <span class="font-semibold text-gray-800">Rp 2.467 / kWh</span>
                </div>
            </div>

            <!-- Card Stasiun 2 -->
            <div onclick="showStationDetail(1)" class="bg-white p-4 rounded-2xl border border-gray-100 shadow-xs hover:border-blue-500 hover:shadow-md transition cursor-pointer">
                <div class="flex justify-between items-start gap-2">
                    <div>
                        <span class="inline-block text-[10px] bg-amber-100 text-amber-700 font-bold px-2 py-0.5 rounded-md mb-1">
                            Penuh (2/2 Digunakan)
                        </span>
                        <h4 class="font-bold text-gray-900 text-sm">SPKLU Stasiun Tugu</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Jl. Pasar Kembang No.1</p>
                    </div>
                    <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">2.8 km</span>
                </div>

                <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between text-xs">
                    <div class="flex items-center gap-3 text-gray-600">
                        <span><i class="fa-solid fa-bolt text-amber-500"></i> 100 kW</span>
                        <span><i class="fa-solid fa-plug text-blue-500"></i> CCS2</span>
                    </div>
                    <span class="font-semibold text-gray-800">Rp 2.467 / kWh</span>
                </div>
            </div>

            <!-- Card Stasiun 3 -->
            <div onclick="showStationDetail(2)" class="bg-white p-4 rounded-2xl border border-gray-100 shadow-xs hover:border-blue-500 hover:shadow-md transition cursor-pointer">
                <div class="flex justify-between items-start gap-2">
                    <div>
                        <span class="inline-block text-[10px] bg-green-100 text-green-700 font-bold px-2 py-0.5 rounded-md mb-1">
                            Tersedia
                        </span>
                        <h4 class="font-bold text-gray-900 text-sm">SPKLU Plaza Ambarrukmo</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Jl. Laksda Adisucipto No.80</p>
                    </div>
                    <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">4.5 km</span>
                </div>

                <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between text-xs">
                    <div class="flex items-center gap-3 text-gray-600">
                        <span><i class="fa-solid fa-bolt text-amber-500"></i> 22 kW</span>
                        <span><i class="fa-solid fa-plug text-blue-500"></i> Type 2</span>
                    </div>
                    <span class="font-semibold text-gray-800">Rp 1.650 / kWh</span>
                </div>
            </div>

        </div>

        <!-- Sisi Kanan: Map View Interaktif (7 Cols) -->
        <div class="lg:col-span-7 bg-white p-3 rounded-2xl border border-gray-100 shadow-xs sticky top-20">
            <div class="flex items-center justify-between mb-2 px-1">
                <h3 class="font-bold text-gray-800 text-sm flex items-center gap-1.5">
                    <i class="fa-solid fa-map-location-dot text-blue-600"></i> Peta Lokasi SPKLU
                </h3>
                <span class="text-[10px] bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full font-medium">Yogyakarta</span>
            </div>

            <!-- Elemen Wadah Peta -->
            <div id="map" class="w-full h-[480px] rounded-xl z-10 border border-gray-200"></div>
        </div>

    </div>

</div>

<!-- 5. Modal Popup Deskripsi & Detail Stasiun -->
<div id="stationModal" class="fixed inset-0 bg-gray-900/50 backdrop-blur-xs z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full overflow-hidden shadow-2xl transition-all transform scale-100">
        
        <!-- Header Modal -->
        <div class="bg-gradient-to-r from-blue-700 to-blue-600 p-5 text-white flex justify-between items-start">
            <div>
                <span id="modalBadge" class="text-[10px] bg-green-500/30 border border-green-300 text-green-100 font-bold px-2.5 py-0.5 rounded-md">
                    Tersedia
                </span>
                <h3 id="modalTitle" class="text-lg font-bold mt-1">SPKLU UKDW Malioboro</h3>
                <p id="modalAddress" class="text-xs text-blue-100 flex items-center gap-1 mt-0.5">
                    <i class="fa-solid fa-location-dot"></i> Jl. Dr. Wahidin Sudirohusodo No.52
                </p>
            </div>
            <button onclick="closeModal()" class="text-white/80 hover:text-white bg-white/10 hover:bg-white/20 p-1.5 rounded-lg transition">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Body Modal (Deskripsi lengkap stasiun) -->
        <div class="p-5 space-y-4 max-h-[70vh] overflow-y-auto">
            
            <!-- Deskripsi Stasiun -->
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Deskripsi Stasiun</h4>
                <p id="modalDescription" class="text-sm text-gray-600 leading-relaxed">
                    Stasiun pengisian daya cepat terletak di area parkir depan kampus. Dilengkapi dengan ruang tunggu ber-AC, minimarket, serta fasilitas toilet gratis.
                </p>
            </div>

            <!-- Detail Spesifikasi & Operasional -->
            <div class="grid grid-cols-2 gap-3 bg-gray-50 p-3 rounded-xl border border-gray-100">
                <div>
                    <p class="text-xs text-gray-400">Jam Operasional</p>
                    <p id="modalHours" class="text-xs font-bold text-gray-800">24 Jam Nonstop</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Tarif Pengisian</p>
                    <p id="modalPrice" class="text-xs font-bold text-blue-600">Rp 2.467 / kWh</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Kapasitas Maksimal</p>
                    <p id="modalPower" class="text-xs font-bold text-gray-800">60 kW (Fast Charging)</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Jarak Lokasi</p>
                    <p id="modalDistance" class="text-xs font-bold text-gray-800">1.2 km dari Anda</p>
                </div>
            </div>

            <!-- Daftar Unit Charger / Port Tersedia -->
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Unit Charger Tersedia</h4>
                <div id="modalChargersList" class="space-y-2">
                    <!-- Item charger diisi lewat JS -->
                </div>
            </div>

        </div>

        <!-- Footer Modal Action -->
        <div class="p-4 bg-gray-50 border-t border-gray-100 flex gap-3">
            <button onclick="closeModal()" class="w-1/2 py-2.5 text-xs font-bold text-gray-600 bg-white border border-gray-300 rounded-xl hover:bg-gray-100 transition">
                Tutup
            </button>
            <button onclick="startChargingFromModal()" class="w-1/2 py-2.5 text-xs font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition shadow-sm flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-bolt"></i> Mulai Pengisian
            </button>
        </div>

    </div>
</div>

<!-- JS Leaflet Map & Interaksi Modal -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Data dummy stasiun pengisian
    const stationsData = [
        {
            id: 0,
            name: "SPKLU UKDW Malioboro",
            address: "Jl. Dr. Wahidin Sudirohusodo No.52, Yogyakarta",
            distance: "1.2 km",
            badge: "Tersedia",
            badgeColor: "bg-green-100 text-green-700 border-green-300",
            description: "Stasiun pengisian daya cepat terletak di lokasi strategis pusat kota. Menyediakan fasilitas rest area lengkap, coffee shop, Wi-Fi gratis, dan tempat ibadah.",
            hours: "24 Jam Nonstop",
            price: "Rp 2.467 / kWh",
            power: "60 kW (Fast Charging)",
            lat: -7.7829,
            lng: 110.3788,
            chargers: [
                { port: "Port #1", type: "CCS2 (DC Fast)", power: "60 kW", status: "Tersedia", statusClass: "text-green-600" },
                { port: "Port #2", type: "Type 2 (AC Standard)", power: "22 kW", status: "Tersedia", statusClass: "text-green-600" }
            ]
        },
        {
            id: 1,
            name: "SPKLU Stasiun Tugu",
            address: "Jl. Pasar Kembang No.1, Sosromenduran, Yogyakarta",
            distance: "2.8 km",
            badge: "Penuh",
            badgeColor: "bg-amber-100 text-amber-700 border-amber-300",
            description: "Berada tepat di area parkir Stasiun Tugu Yogyakarta. Sangat nyaman bagi pengemudi yang ingin mengisi daya sambil menunggu kedatangan kereta api.",
            hours: "05:00 - 23:00 WIB",
            price: "Rp 2.467 / kWh",
            power: "100 kW (Ultra Fast)",
            lat: -7.7891,
            lng: 110.3634,
            chargers: [
                { port: "Port #1", type: "CCS2 (DC Ultra)", power: "100 kW", status: "Sedang Digunakan", statusClass: "text-amber-600" },
                { port: "Port #2", type: "CCS2 (DC Ultra)", power: "100 kW", status: "Sedang Digunakan", statusClass: "text-amber-600" }
            ]
        },
        {
            id: 2,
            name: "SPKLU Plaza Ambarrukmo",
            address: "Jl. Laksda Adisucipto No.80, Caturtunggal, Sleman",
            distance: "4.5 km",
            badge: "Tersedia",
            badgeColor: "bg-green-100 text-green-700 border-green-300",
            description: "Terletak di dalam area Gedung Parkir Lt.1 Plaza Ambarrukmo. Cocok untuk melakukan pengisian daya sembari berbelanja atau menikmati hidangan di mall.",
            hours: "10:00 - 22:00 WIB",
            price: "Rp 1.650 / kWh",
            power: "22 kW (AC Charging)",
            lat: -7.7824,
            lng: 110.4012,
            chargers: [
                { port: "Port #1", type: "Type 2 (AC Standard)", power: "22 kW", status: "Tersedia", statusClass: "text-green-600" }
            ]
        }
    ];

    let map;
    let markers = [];

    document.addEventListener("DOMContentLoaded", function() {
        // Inisialisasi Peta
        map = L.map('map').setView([-7.7829, 110.3788], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Tambahkan Marker dan Event Click
        stationsData.forEach((st, index) => {
            let marker = L.marker([st.lat, st.lng]).addTo(map);
            
            marker.bindPopup(`
                <div style="font-family: sans-serif; cursor: pointer;" onclick="showStationDetail(${index})">
                    <strong style="color: #1e40af;">${st.name}</strong><br>
                    <span style="font-size: 11px; color: #4b5563;">Status: ${st.badge}</span><br>
                    <span style="font-size: 11px; color: #2563eb; font-weight: bold;">Klik untuk detail →</span>
                </div>
            `);

            markers.push(marker);
        });
    });

    // Fungsi Menampilkan Detail Stasiun
    function showStationDetail(index) {
        const station = stationsData[index];

        // Set Nilai Elemen Modal
        document.getElementById('modalTitle').innerText = station.name;
        document.getElementById('modalAddress').innerHTML = `<i class="fa-solid fa-location-dot"></i> ${station.address}`;
        document.getElementById('modalBadge').innerText = station.badge;
        document.getElementById('modalDescription').innerText = station.description;
        document.getElementById('modalHours').innerText = station.hours;
        document.getElementById('modalPrice').innerText = station.price;
        document.getElementById('modalPower').innerText = station.power;
        document.getElementById('modalDistance').innerText = station.distance;

        // Render List Charger
        let chargersHTML = '';
        station.chargers.forEach(c => {
            chargersHTML += `
                <div class="flex items-center justify-between p-2.5 bg-gray-50 rounded-xl border border-gray-100 text-xs">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-plug text-blue-600 text-sm"></i>
                        <div>
                            <p class="font-bold text-gray-800">${c.port} - ${c.type}</p>
                            <p class="text-[10px] text-gray-400">Daya Output: ${c.power}</p>
                        </div>
                    </div>
                    <span class="font-bold ${c.statusClass}">${c.status}</span>
                </div>
            `;
        });
        document.getElementById('modalChargersList').innerHTML = chargersHTML;

        // Fokuskan Peta ke Koordinat Stasiun
        map.setView([station.lat, station.lng], 15);
        markers[index].openPopup();

        // Tampilkan Modal
        document.getElementById('stationModal').classList.remove('hidden');
    }

    // Fungsi Menutup Modal
    function closeModal() {
        document.getElementById('stationModal').classList.add('hidden');
    }

    // Aksi Memulai Pengisian
    function startChargingFromModal() {
        alert("Melanjutkan ke alur pemrosesan sesi charging & pembayaran...");
        closeModal();
    }
</script>
@endsection