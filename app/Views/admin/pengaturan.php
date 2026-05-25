<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Kuota | PPDB Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
    body{font-family:'Plus Jakarta Sans',sans-serif;background:#f8fafc}
    </style>
</head>
<body class="text-slate-800 flex h-screen overflow-hidden">
    <!-- Admin Sidebar -->
    <?php require_once '../app/Views/admin/_sidebar.php'; adminSidebar('pengaturan'); ?>

    <main class="flex-1 flex flex-col h-full overflow-y-auto">
        <header class="bg-white/80 backdrop-blur-md px-8 py-5 border-b border-slate-200/60 sticky top-0 z-10">
            <h2 class="text-xl font-black text-slate-800 tracking-tight">PENGATURAN SISTEM</h2>
            <p class="text-[11px] text-slate-400 font-bold uppercase tracking-[0.15em] mt-0.5">Konfigurasi batas maksimal pendaftaran</p>
        </header>

        <div class="p-8 max-w-4xl mx-auto w-full pb-20">
            
            <?php if(isset($_GET['success'])): ?>
            <div class="bg-emerald-50 text-emerald-600 px-4 py-3 rounded-xl border border-emerald-200 font-bold text-sm mb-6 flex items-center shadow-sm">
                <i class="fas fa-check-circle mr-3 text-lg"></i> Pengaturan kuota berhasil diperbarui!
            </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Gelombang Aktif -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white flex items-center space-x-3">
                        <div class="w-8 h-8 bg-teal-100 text-teal-600 rounded-lg flex items-center justify-center text-sm"><i class="fas fa-layer-group"></i></div>
                        <h3 class="font-black text-slate-800 text-sm uppercase tracking-tight">Gelombang Aktif</h3>
                    </div>
                    <div class="p-6">
                        <form action="<?= base_url('admin/update_pengaturan') ?>" method="POST" class="space-y-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Gelombang Pendaftaran Saat Ini</label>
                                <div class="grid grid-cols-3 gap-3">
                                    <?php for($g = 1; $g <= 3; $g++): ?>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="gelombang_aktif" value="<?= $g ?>" <?= $data['gelombang_aktif'] == $g ? 'checked' : '' ?> class="sr-only peer">
                                        <div class="text-center py-4 rounded-xl border-2 <?= $data['gelombang_aktif'] == $g ? 'border-emerald-500 bg-emerald-50' : 'border-slate-200 bg-slate-50 hover:bg-slate-100' ?> peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition-all font-black text-slate-700 peer-checked:text-emerald-700">
                                            <div class="text-2xl mb-1"><?= $g ?></div>
                                            <div class="text-[10px] uppercase tracking-wider text-slate-400 peer-checked:text-emerald-500">Gelombang</div>
                                        </div>
                                    </label>
                                    <?php endfor; ?>
                                </div>
                                <p class="mt-3 text-xs text-slate-500 font-medium">Gelombang aktif akan ditampilkan pada tombol "Daftar" di halaman utama.</p>
                            </div>
                            <div class="pt-2 flex justify-end">
                                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-teal-600 to-emerald-600 text-white font-bold rounded-xl shadow-md shadow-teal-200 hover:-translate-y-0.5 transition-all flex items-center space-x-2 text-sm">
                                    <i class="fas fa-save"></i> <span>Simpan</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Kuota Pendaftaran -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white flex items-center space-x-3">
                        <div class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center text-sm"><i class="fas fa-users"></i></div>
                        <h3 class="font-black text-slate-800 text-sm uppercase tracking-tight">Kuota Pendaftaran</h3>
                    </div>
                    <div class="p-6">
                        <form action="<?= base_url('admin/update_pengaturan') ?>" method="POST" class="space-y-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Total Kuota Pendaftaran</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-users text-slate-400"></i>
                                    </div>
                                    <input type="number" name="kuota_pendaftaran" value="<?= htmlspecialchars($data['kuota']) ?>" required min="1" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 font-semibold text-slate-700 transition-all">
                                </div>
                                <p class="mt-2 text-xs text-slate-500 font-medium">Jika jumlah pendaftar mencapai batas ini, sistem akan otomatis menutup pendaftaran baru.</p>
                            </div>
                            <div class="pt-2 flex justify-end">
                                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold rounded-xl shadow-md shadow-emerald-200 hover:-translate-y-0.5 transition-all flex items-center space-x-2 text-sm">
                                    <i class="fas fa-save"></i> <span>Simpan</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Current Status Widget -->
            <div class="mt-8 bg-slate-800 rounded-2xl border border-slate-700 shadow-xl overflow-hidden text-white relative">
                <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
                <div class="p-8 relative z-10 flex items-center justify-between">
                    <div>
                        <h4 class="font-black text-lg tracking-tight mb-1">Status Kuota Saat Ini</h4>
                        <p class="text-slate-400 text-sm font-medium">Berdasarkan data pendaftar yang sudah men-submit formulir.</p>
                    </div>
                    <div class="text-right">
                        <div class="text-4xl font-black text-emerald-400 tracking-tighter">
                            <?= $data['total_pendaftar'] ?> <span class="text-xl text-slate-500 font-medium">/ <?= $data['kuota'] ?></span>
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Siswa Terdaftar</p>
                    </div>
                </div>
                <!-- Progress Bar -->
                <?php 
                    $pct = ($data['kuota'] > 0) ? min(100, ($data['total_pendaftar'] / $data['kuota']) * 100) : 0;
                    $color = $pct >= 100 ? 'bg-red-500' : ($pct > 80 ? 'bg-amber-500' : 'bg-emerald-500');
                ?>
                <div class="h-2 w-full bg-slate-700">
                    <div class="h-full <?= $color ?>" style="width: <?= $pct ?>%"></div>
                </div>
            </div>

            <!-- Statistik Landing Page -->
            <div class="mt-8 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white flex items-center space-x-3">
                    <div class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center text-sm"><i class="fas fa-chart-bar"></i></div>
                    <h3 class="font-black text-slate-800 text-sm uppercase tracking-tight">Statistik Halaman Utama (Landing Page)</h3>
                    <span class="ml-auto text-[10px] text-slate-400 font-bold bg-slate-100 px-3 py-1 rounded-full">Konfigurasi Counter Profil</span>
                </div>
                <div class="p-6">
                    <form action="<?= base_url('admin/update_pengaturan') ?>" method="POST" class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Jumlah Siswa</label>
                                <input type="text" name="stats_siswa" value="<?= htmlspecialchars($data['stats_siswa'] ?? '250+') ?>" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm font-medium text-slate-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                                <p class="mt-1 text-[9px] text-slate-400 font-bold">Contoh: 250+</p>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Jumlah Guru</label>
                                <input type="text" name="stats_guru" value="<?= htmlspecialchars($data['stats_guru'] ?? '15+') ?>" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm font-medium text-slate-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                                <p class="mt-1 text-[9px] text-slate-400 font-bold">Contoh: 15+</p>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Jumlah Eskul</label>
                                <input type="text" name="stats_eskul" value="<?= htmlspecialchars($data['stats_eskul'] ?? '8+') ?>" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm font-medium text-slate-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                                <p class="mt-1 text-[9px] text-slate-400 font-bold">Contoh: 8+</p>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Nilai Akreditasi</label>
                                <input type="text" name="stats_akreditasi" value="<?= htmlspecialchars($data['stats_akreditasi'] ?? 'BAIK') ?>" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm font-medium text-slate-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                                <p class="mt-1 text-[9px] text-slate-400 font-bold">Contoh: BAIK / A</p>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-slate-100 flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold rounded-xl shadow-md shadow-emerald-200 hover:-translate-y-0.5 transition-all flex items-center space-x-2 text-sm">
                                <i class="fas fa-save"></i> <span>Simpan Statistik</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Jadwal Editor -->
            <div class="mt-8 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white flex items-center space-x-3">
                    <div class="w-8 h-8 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center text-sm"><i class="fas fa-calendar-alt"></i></div>
                    <h3 class="font-black text-slate-800 text-sm uppercase tracking-tight">Edit Jadwal Pendaftaran</h3>
                    <span class="ml-auto text-[10px] text-slate-400 font-bold bg-slate-100 px-3 py-1 rounded-full">Tampil di Halaman Utama</span>
                </div>
                <div class="p-6">
                    <form action="<?= base_url('admin/update_pengaturan') ?>" method="POST" class="space-y-6">
                        <?php for($g = 1; $g <= 3; $g++): ?>
                        <div class="border border-slate-100 rounded-xl p-5">
                            <h4 class="font-black text-slate-700 text-sm mb-4 flex items-center space-x-2">
                                <span class="w-6 h-6 bg-emerald-600 text-white rounded-full flex items-center justify-center text-xs font-black"><?= $g ?></span>
                                <span>Gelombang <?= $g ?></span>
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Nama Gelombang</label>
                                    <input type="text" name="jadwal_g<?= $g ?>_nama" value="<?= htmlspecialchars($data['jadwal'][$g-1]['gel'] ?? "Gelombang $g") ?>" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm font-medium text-slate-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Tanggal Pendaftaran</label>
                                    <input type="text" name="jadwal_g<?= $g ?>_daftar" value="<?= htmlspecialchars($data['jadwal'][$g-1]['daftar'] ?? '') ?>" placeholder="Tanggal Pendaftaran" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm font-medium text-slate-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Tes Baca &amp; Tulis</label>
                                    <input type="text" name="jadwal_g<?= $g ?>_sosial" value="<?= htmlspecialchars($data['jadwal'][$g-1]['sosial'] ?? '') ?>" placeholder="Tanggal Tes Baca &amp; Tulis" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm font-medium text-slate-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                                </div>
                                <div class="md:col-span-3">
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Pengumuman Hasil</label>
                                    <input type="text" name="jadwal_g<?= $g ?>_hasil" value="<?= htmlspecialchars($data['jadwal'][$g-1]['hasil'] ?? '') ?>" placeholder="Tanggal Pengumuman Hasil" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm font-medium text-slate-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                                </div>
                            </div>
                        </div>
                        <?php endfor; ?>
                        <div class="flex justify-end pt-2">
                            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-bold rounded-xl shadow-md shadow-amber-200 hover:-translate-y-0.5 transition-all flex items-center space-x-2">
                                <i class="fas fa-save"></i> <span>Simpan Jadwal</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Rilis Pengumuman Kelulusan -->
            <div class="mt-8 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden animate-fadeUp">
                <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white flex items-center space-x-3">
                    <div class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center text-sm"><i class="fas fa-bullhorn"></i></div>
                    <h3 class="font-black text-slate-800 text-sm uppercase tracking-tight">Rilis Pengumuman Kelulusan</h3>
                    <span class="ml-auto text-[10px] text-slate-400 font-bold bg-slate-100 px-3 py-1 rounded-full">Countdown Kelulusan</span>
                </div>
                <div class="p-6">
                    <form action="<?= base_url('admin/update_pengaturan') ?>" method="POST" class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Status Rilis Pengumuman</label>
                                <div class="flex items-center space-x-3 p-3 bg-slate-50 border border-slate-200 rounded-xl">
                                    <input type="checkbox" name="enable_release_schedule" id="enable-schedule" value="1" <?= !empty($data['release_datetime']) ? 'checked' : '' ?> class="w-5 h-5 text-emerald-600 border-slate-300 rounded focus:ring-emerald-500 cursor-pointer">
                                    <label for="enable-schedule" class="text-xs font-bold text-slate-600 cursor-pointer select-none">Aktifkan Penjadwalan Rilis Serentak</label>
                                </div>
                                <p class="mt-2 text-[11px] text-slate-400 font-semibold leading-relaxed">Jika dinonaktifkan, pengumuman dapat langsung dilihat siswa setelah status diverifikasi.</p>
                            </div>
                            
                            <div id="release-time-wrapper" class="<?= empty($data['release_datetime']) ? 'opacity-50 pointer-events-none' : '' ?> transition-opacity duration-200">
                                <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal & Waktu Rilis Resmi</label>
                                <div class="relative">
                                    <input type="datetime-local" name="release_announcement_datetime" id="release-time-input" value="<?= htmlspecialchars($data['release_datetime'] ?? '') ?>" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 font-semibold text-slate-700 transition-all cursor-pointer">
                                </div>
                                <p class="mt-2 text-[11px] text-slate-400 font-semibold">Tentukan kapan hasil kelulusan dibuka serentak untuk seluruh calon siswa.</p>
                            </div>
                        </div>
                        
                        <div class="pt-4 border-t border-slate-100 flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-bold rounded-xl shadow-md shadow-indigo-200 hover:-translate-y-0.5 transition-all flex items-center space-x-2 text-sm">
                                <i class="fas fa-save"></i> <span>Simpan Pengaturan Rilis</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const enableSchedule = document.getElementById('enable-schedule');
    const releaseTimeWrapper = document.getElementById('release-time-wrapper');
    const releaseTimeInput = document.getElementById('release-time-input');

    if (enableSchedule && releaseTimeWrapper) {
        enableSchedule.addEventListener('change', function() {
            if (this.checked) {
                releaseTimeWrapper.classList.remove('opacity-50', 'pointer-events-none');
                releaseTimeInput.required = true;
            } else {
                releaseTimeWrapper.classList.add('opacity-50', 'pointer-events-none');
                releaseTimeInput.required = false;
                releaseTimeInput.value = '';
            }
        });
        
        // Initial state
        if (enableSchedule.checked) {
            releaseTimeInput.required = true;
        }
    }
});
</script>
</body>
</html>
