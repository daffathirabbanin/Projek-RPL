<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan & Export | Admin PPDB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #FAFAFA; }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeUp { animation: fadeUp 0.5s ease-out forwards; }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
    </style>
</head>
<body class="text-slate-800 flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <?php require_once '../app/Views/admin/_sidebar.php'; adminSidebar('laporan'); ?>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-y-auto">
        <!-- Header -->
        <header class="bg-white px-8 py-5 border-b border-slate-200/80 sticky top-0 z-30 flex justify-between items-center shadow-sm">
            <div>
                <h2 class="text-2xl font-black text-emerald-800 tracking-tight">Laporan & Export</h2>
                <p class="text-[13px] text-slate-500 font-bold mt-1 tracking-wide">Export data kelulusan dan absensi siswa</p>
            </div>
            <div class="text-right">
                <p class="text-xs font-bold text-slate-500"><?= date('l, d F Y') ?></p>
                <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest">TA 2026/2027</p>
            </div>
        </header>

        <div class="p-8 max-w-5xl mx-auto w-full pb-20 space-y-8">
            
            <!-- Single Export Card -->
            <div class="w-full max-w-2xl mx-auto bg-white rounded-[24px] border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden animate-fadeUp">
                <div class="p-8">
                    <div class="flex items-center gap-5 mb-8">
                        <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl shadow-sm border border-emerald-100 flex-shrink-0">
                            <i class="fas fa-file-export"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-800 text-xl mb-1">Export Data PPDB</h3>
                            <p class="text-sm text-slate-500 font-medium leading-relaxed">Pilih kategori data yang ingin Anda cetak (PDF) atau unduh dalam format Excel dan CSV.</p>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Kategori Data:</label>
                        <select id="export-filter" onchange="updateExportLinks()" class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-3.5 outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-bold transition-all cursor-pointer">
                            <option value="diterima">Data Diterima (Lulus)</option>
                            <option value="ditolak">Data Ditolak (Tidak Lulus)</option>
                            <option value="tidak_hadir">Tidak Hadir Tes</option>
                        </select>
                    </div>
                    
                    <div class="bg-slate-50 rounded-xl p-4 mb-8 border border-slate-100 flex justify-between items-center">
                        <span class="text-sm font-bold text-slate-600">Total Data Tersedia:</span>
                        <span id="export-total" class="text-xl font-black text-emerald-600">0 siswa</span>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-4">
                        <a id="btn-print" href="#" target="_blank" class="flex flex-col items-center justify-center py-4 bg-white text-slate-700 font-bold rounded-xl text-[11px] uppercase tracking-wider hover:bg-slate-50 border-2 border-slate-200 transition-all hover:-translate-y-1">
                            <i class="fas fa-print text-2xl mb-2 text-slate-400"></i> Print / PDF
                        </a>
                        <a id="btn-excel" href="#" class="flex flex-col items-center justify-center py-4 bg-emerald-50 text-emerald-700 font-bold rounded-xl text-[11px] uppercase tracking-wider hover:bg-emerald-100 border-2 border-emerald-100 transition-all hover:-translate-y-1">
                            <i class="fas fa-file-excel text-2xl mb-2 text-emerald-500"></i> Excel
                        </a>
                        <a id="btn-csv" href="#" class="flex flex-col items-center justify-center py-4 bg-sky-50 text-sky-700 font-bold rounded-xl text-[11px] uppercase tracking-wider hover:bg-sky-100 border-2 border-sky-100 transition-all hover:-translate-y-1">
                            <i class="fas fa-file-csv text-2xl mb-2 text-sky-500"></i> CSV
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Panduan Export -->
            <div class="max-w-2xl mx-auto bg-blue-50/50 border border-blue-100 rounded-[24px] p-6 flex items-start space-x-4 animate-fadeUp delay-1">
                <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center flex-shrink-0 mt-1">
                    <i class="fas fa-info-circle text-lg"></i>
                </div>
                <div>
                    <h4 class="font-bold text-blue-900 mb-2">Panduan Penggunaan File CSV</h4>
                    <ul class="text-sm text-blue-800 space-y-2 list-disc list-inside">
                        <li>File yang diunduh berformat <b>.csv</b> (Comma Separated Values).</li>
                        <li>Anda dapat membuka file ini menggunakan <b>Microsoft Excel</b> atau <b>Google Sheets</b>.</li>
                        <li>Data yang diexport mencakup: ID, Email, Nama Lengkap, NISN, TTL, Jenis Kelamin, Nomor HP, dan Alamat.</li>
                    </ul>
                </div>
            </div>

        </div>
    </main>

    <script>
        const totals = {
            'diterima': <?= $data['diterima'] ?>,
            'ditolak': <?= $data['ditolak'] ?>,
            'tidak_hadir': <?= $data['tidak_hadir'] ?>
        };

        function updateExportLinks() {
            const filter = document.getElementById('export-filter').value;
            const totalText = document.getElementById('export-total');
            const btnPrint = document.getElementById('btn-print');
            const btnExcel = document.getElementById('btn-excel');
            const btnCsv = document.getElementById('btn-csv');
            
            totalText.textContent = totals[filter] + ' siswa';
            
            const baseUrl = '<?= base_url("admin") ?>';
            btnPrint.href = `${baseUrl}/printLaporan/${filter}`;
            btnExcel.href = `${baseUrl}/exportLaporan/${filter}?format=excel`;
            btnCsv.href = `${baseUrl}/exportLaporan/${filter}?format=csv`;
        }
        
        // Inisialisasi saat load
        document.addEventListener("DOMContentLoaded", () => {
            updateExportLinks();
        });
    </script>
</body>
</html>
