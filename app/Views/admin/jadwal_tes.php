<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal & Presensi Tes | Admin PPDB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
    body{font-family:'Plus Jakarta Sans',sans-serif;background:#FAFAFA}
    .card-hover{transition:all .3s cubic-bezier(.4,0,.2,1)}.card-hover:hover{transform:translateY(-4px);box-shadow:0 20px 25px -5px rgba(0,0,0,.06)}
    @keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
    .animate-fadeUp{animation:fadeUp .5s ease-out forwards}
    </style>
</head>
<body class="text-slate-800 flex h-screen overflow-hidden">
    <!-- Admin Sidebar -->
    <?php require_once '../app/Views/admin/_sidebar.php'; adminSidebar('jadwal_tes'); ?>

    <main class="flex-1 flex flex-col h-full overflow-y-auto relative">
        <header class="bg-white/80 backdrop-blur-md px-8 py-5 border-b border-slate-200/60 sticky top-0 z-10 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-black text-emerald-800 tracking-tight">Jadwal & Presensi Tes</h2>
                <p class="text-[13px] text-slate-500 font-bold mt-1 tracking-wide">Kelola jadwal ujian dan data kehadiran calon siswa</p>
            </div>
        </header>

        <div class="p-8 max-w-6xl mx-auto w-full pb-20 animate-fadeUp">
            
            <!-- Page Header Controls -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-6">
                <div>
                    <h3 class="font-black text-slate-800 text-sm uppercase tracking-tight"><i class="fas fa-calendar-check text-emerald-500 mr-2"></i>Daftar Hadir</h3>
                </div>
                
                <!-- Date Filter Form -->
                <form method="GET" action="<?= base_url('admin/jadwalTes') ?>" class="flex items-center space-x-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-calendar-alt text-slate-400"></i>
                        </div>
                        <input type="date" name="tanggal" value="<?= htmlspecialchars($filter_tanggal ?? '') ?>" class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full pl-10 p-2.5 outline-none transition-all">
                    </div>
                    <button type="submit" class="p-2.5 px-4 text-sm font-medium text-white bg-gradient-to-r from-emerald-600 to-teal-600 rounded-lg hover:from-emerald-700 hover:to-teal-700 transition-colors focus:ring-4 focus:outline-none focus:ring-emerald-300">
                        Filter
                    </button>
                    <?php if($filter_tanggal): ?>
                        <a href="<?= base_url('admin/jadwalTes') ?>" class="p-2.5 px-4 text-sm font-medium text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200 transition-colors">
                            Reset
                        </a>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Table Content -->
            <div class="bg-white rounded-[24px] shadow-[0_8px_30px_rgba(0,0,0,0.04)] border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] bg-slate-50/80 border-b border-slate-100">
                            <tr>
                                <th scope="col" class="px-6 py-4">Peserta</th>
                                <th scope="col" class="px-6 py-4">Jadwal Tes</th>
                                <th scope="col" class="px-6 py-4">Kontak (WA)</th>
                                <th scope="col" class="px-6 py-4 text-center">Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if(empty($jadwal)): ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-16 text-center text-slate-400 font-bold">
                                        <i class="fas fa-inbox text-4xl mb-3 text-slate-300 block"></i>
                                        Tidak ada jadwal tes <?= $filter_tanggal ? 'pada tanggal ini' : '' ?>.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($jadwal as $j): ?>
                                <tr class="bg-white hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-800 text-sm"><?= htmlspecialchars($j['nama']) ?></div>
                                        <div class="text-xs text-slate-500 mt-0.5">ID: #<?= str_pad($j['id'], 4, '0', STR_PAD_LEFT) ?> | <?= htmlspecialchars($j['email']) ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="date" value="<?= $j['jadwal_tes'] ? date('Y-m-d', strtotime($j['jadwal_tes'])) : '' ?>" onchange="updateJadwalDate(this, <?= $j['id'] ?>)" class="bg-white border border-slate-200 text-xs rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 outline-none transition-all font-bold text-slate-700 <?= empty($j['jadwal_tes']) ? 'border-amber-300 ring-2 ring-amber-100 bg-amber-50' : '' ?>" <?= empty($j['jadwal_tes']) ? 'title="Jadwal belum diatur"' : '' ?>>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if(!empty($j['no_hp'])): ?>
                                            <?php 
                                            $bulanIndo = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
                                            $tgl_tes = '...';
                                            if ($j['jadwal_tes']) {
                                                $timestamp = strtotime($j['jadwal_tes']);
                                                $tgl_tes = date('d', $timestamp) . ' ' . $bulanIndo[date('m', $timestamp)] . ' ' . date('Y', $timestamp);
                                            }
                                            $wa_text = 'Assalamualaikum ' . $j['nama'] . ', jangan lupa datang tes seleksi PPDB pada tanggal ' . $tgl_tes . ' yaaa';
                                            $wa_link = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $j['no_hp']) . '?text=' . urlencode($wa_text);
                                            ?>
                                            <a href="<?= $wa_link ?>" target="_blank" class="inline-flex items-center text-emerald-600 hover:text-emerald-700 font-medium transition-colors">
                                                <i class="fab fa-whatsapp text-lg mr-1.5"></i> <?= htmlspecialchars($j['no_hp']) ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-slate-400 italic text-xs">Tidak ada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <select onchange="updateAbsensi(this, <?= $j['id'] ?>)" class="bg-slate-50 border border-slate-200 text-xs rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 outline-none transition-all font-bold <?= $j['absensi_tes'] == 'hadir' ? 'text-emerald-600 bg-emerald-50 border-emerald-200' : ($j['absensi_tes'] == 'tidak_hadir' ? 'text-red-600 bg-red-50 border-red-200' : 'text-slate-600') ?>">
                                            <option value="menunggu" <?= $j['absensi_tes'] == 'menunggu' ? 'selected' : '' ?>>Menunggu</option>
                                            <option value="hadir" <?= $j['absensi_tes'] == 'hadir' ? 'selected' : '' ?>>Hadir</option>
                                            <option value="tidak_hadir" <?= $j['absensi_tes'] == 'tidak_hadir' ? 'selected' : '' ?>>Tidak Hadir</option>
                                        </select>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-5 right-5 transform translate-y-20 opacity-0 transition-all duration-300 z-50 flex items-center w-full max-w-xs p-4 text-slate-500 bg-white rounded-2xl shadow-xl border border-slate-100" role="alert">
        <div id="toast-icon" class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg">
            <i class="fas fa-check"></i>
        </div>
        <div id="toast-message" class="ml-3 text-sm font-bold text-slate-800 tracking-tight">Status berhasil diperbarui.</div>
    </div>

    <script>
    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toast-message');
        const toastIcon = document.getElementById('toast-icon');
        
        toastMessage.textContent = message;
        
        if (type === 'success') {
            toastIcon.className = 'inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600';
            toastIcon.innerHTML = '<i class="fas fa-check"></i>';
        } else {
            toastIcon.className = 'inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg bg-red-100 text-red-500';
            toastIcon.innerHTML = '<i class="fas fa-times"></i>';
        }
        
        toast.classList.remove('translate-y-20', 'opacity-0');
        
        setTimeout(() => {
            toast.classList.add('translate-y-20', 'opacity-0');
        }, 3000);
    }

    function updateJadwalDate(inputElement, id) {
        const tanggal = inputElement.value;
        
        // Remove amber highlighting if date is set
        if(tanggal) {
            inputElement.classList.remove('border-amber-300', 'ring-2', 'ring-amber-100', 'bg-amber-50');
        } else {
            inputElement.classList.add('border-amber-300', 'ring-2', 'ring-amber-100', 'bg-amber-50');
        }
        
        fetch('<?= base_url("admin/update_jadwal_date") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${id}&tanggal=${tanggal}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Jadwal tes berhasil diperbarui.', 'success');
            } else {
                showToast(data.message || 'Gagal mengubah jadwal', 'error');
            }
        });
    }

    function updateAbsensi(selectElement, id) {
        const status = selectElement.value;
        
        // Update styling immediately for better UX
        selectElement.className = "bg-slate-50 border border-slate-200 text-xs rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 outline-none transition-all font-bold";
        if (status === 'hadir') {
            selectElement.classList.add('text-emerald-600', 'bg-emerald-50', 'border-emerald-200');
        } else if (status === 'tidak_hadir') {
            selectElement.classList.add('text-red-600', 'bg-red-50', 'border-red-200');
        } else {
            selectElement.classList.add('text-slate-600');
        }

        // Send AJAX request
        const formData = new FormData();
        formData.append('id', id);
        formData.append('status', status);

        fetch('<?= base_url('admin/update_absensi') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Kehadiran tes berhasil diperbarui!', 'success');
            } else {
                showToast('Gagal memperbarui kehadiran.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Terjadi kesalahan jaringan.', 'error');
        });
    }
    </script>
</body>
</html>
