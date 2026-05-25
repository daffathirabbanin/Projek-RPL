<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pendaftar | Admin PPDB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
    body{font-family:'Plus Jakarta Sans',sans-serif;background:#f8fafc}
    </style>
</head>
<body class="text-slate-800 flex h-screen overflow-hidden">
    <!-- Admin Sidebar -->
    <?php require_once '../app/Views/admin/_sidebar.php'; adminSidebar('pendaftar'); ?>

    <main class="flex-1 flex flex-col h-full overflow-y-auto">
        <header class="bg-white/80 backdrop-blur-md px-8 py-5 border-b border-slate-200/60 sticky top-0 z-10">
            <h2 class="text-xl font-black text-slate-800 tracking-tight">DATA PENDAFTAR</h2>
            <p class="text-[11px] text-slate-400 font-bold uppercase tracking-[0.15em] mt-0.5">Seluruh calon peserta didik baru</p>
        </header>
        <div class="p-8 max-w-6xl mx-auto w-full pb-20">
            <?php if(isset($_GET['success'])): ?>
                <?php if($_GET['success'] == 'reset_pass'): ?>
                <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl text-sm font-bold mb-6 border border-emerald-200 flex items-center shadow-sm">
                    <i class="fas fa-check-circle mr-3 text-lg"></i>
                    Password berhasil direset menjadi "123456".
                </div>
                <?php elseif($_GET['success'] == 'deleted'): ?>
                <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl text-sm font-bold mb-6 border border-emerald-200 flex items-center shadow-sm">
                    <i class="fas fa-check-circle mr-3 text-lg"></i>
                    Akun pendaftar berhasil dihapus permanen.
                </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white flex items-center space-x-3">
                    <div class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center text-sm"><i class="fas fa-table"></i></div>
                    <h3 class="font-black text-slate-800 text-sm uppercase tracking-tight">Tabel Pendaftar</h3>
                    <span id="pendaftar-count" class="ml-auto text-xs font-bold text-slate-400 bg-slate-100 px-3 py-1 rounded-full"><?= count($data['pendaftar'] ?? []) ?> siswa</span>
                </div>
                
                <!-- Controls Bar (Sleek, Minimalist, Horizontal) -->
                <div class="px-6 py-4 bg-slate-50/50 border-b border-slate-100 flex flex-col sm:flex-row gap-4 items-center justify-between">
                    <div class="relative w-full sm:w-72">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                            <i class="fas fa-search text-xs"></i>
                        </span>
                        <input type="text" id="search-input" onkeyup="filterTable()" placeholder="Cari nama atau email..." class="block w-full pl-9 pr-4 py-2.5 border border-slate-200 rounded-xl text-xs bg-white focus:border-emerald-500 focus:outline-none transition-colors">
                    </div>
                    
                    <div class="relative w-full sm:w-56">
                        <select id="filter-status" onchange="filterTable()" class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl text-xs bg-white focus:border-emerald-500 focus:outline-none transition-colors cursor-pointer text-slate-600 font-medium">
                            <option value="all">Semua Status</option>
                            <option value="belum_mendaftar">Draft</option>
                            <option value="nunggu_verifikasi">Menunggu Verifikasi</option>
                            <option value="dokumen_diterima">Berkas Valid (Dokumen Diterima)</option>
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                            <option value="perlu_revisi">Perlu Revisi</option>
                        </select>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead><tr class="bg-slate-50/80 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">
                            <th class="px-6 py-4 w-10">#</th><th class="px-6 py-4">Nama</th><th class="px-6 py-4">Email</th><th class="px-6 py-4">No. HP</th><th class="px-6 py-4">Status</th><th class="px-6 py-4">Aksi</th>
                        </tr></thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if(empty($data['pendaftar'])): ?>
                            <tr><td colspan="6" class="text-center py-16 text-slate-400 font-bold"><i class="fas fa-inbox text-3xl mb-3 block text-slate-300"></i>Belum ada data pendaftar.</td></tr>
                            <?php else: foreach($data['pendaftar'] as $i => $row):
                                $s = $row['status'];
                                $badge = ['belum_mendaftar'=>'bg-slate-100 text-slate-600','nunggu_verifikasi'=>'bg-amber-100 text-amber-700','dokumen_diterima'=>'bg-blue-100 text-blue-700','diterima'=>'bg-emerald-100 text-emerald-700','ditolak'=>'bg-red-100 text-red-700','perlu_revisi'=>'bg-rose-100 text-rose-700'];
                                $label = ['belum_mendaftar'=>'Draft','nunggu_verifikasi'=>'Menunggu Verifikasi','dokumen_diterima'=>'Berkas Valid','diterima'=>'Diterima','ditolak'=>'Ditolak','perlu_revisi'=>'Perlu Revisi'];
                            ?>
                            <tr class="pendaftar-row hover:bg-slate-50/50 transition-colors" data-status="<?= $s ?>" data-search="<?= strtolower(htmlspecialchars($row['nama'] ?? '') . ' ' . htmlspecialchars($row['email'] ?? '')) ?>">
                                <td class="px-6 py-4 text-xs font-bold text-slate-400"><?= $i + 1 ?></td>
                                <td class="px-6 py-4 font-bold text-slate-800"><?= htmlspecialchars($row['nama'] ?? 'Belum Isi') ?></td>
                                <td class="px-6 py-4 text-sm text-slate-500"><?= htmlspecialchars($row['email']) ?></td>
                                <td class="px-6 py-4 text-sm text-slate-500"><?= htmlspecialchars($row['no_hp'] ?? '-') ?></td>
                                <td class="px-6 py-4"><span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider <?= $badge[$s] ?? '' ?>"><?= $label[$s] ?? $s ?></span></td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <a href="<?= base_url('admin/detail/' . $row['id']) ?>" title="Verifikasi" class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center hover:bg-emerald-600 hover:text-white transition-colors"><i class="fas fa-eye text-xs"></i></a>
                                        
                                        <button type="button" onclick="openResetModal('<?= $row['user_id'] ?>', '<?= htmlspecialchars($row['nama'] ?? 'Siswa') ?>')" title="Reset Password" class="w-8 h-8 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center hover:bg-amber-600 hover:text-white transition-colors">
                                            <i class="fas fa-pen text-xs"></i>
                                        </button>
                                        
                                        <a href="<?= base_url('admin/delete_pendaftar/' . $row['user_id']) ?>" onclick="return confirm('Yakin ingin menghapus akun ini secara permanen beserta semua data pendaftarannya?')" title="Hapus Akun" class="w-8 h-8 bg-red-100 text-red-600 rounded-lg flex items-center justify-center hover:bg-red-600 hover:text-white transition-colors"><i class="fas fa-trash text-xs"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Reset Password Modal (Tailwind Modal) -->
    <div id="reset-password-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm opacity-0 transition-opacity duration-300">
        <div id="reset-password-box" class="bg-white rounded-3xl shadow-2xl border border-slate-200 max-w-sm w-full mx-4 transform scale-95 transition-transform duration-300">
            <form action="<?= base_url('admin/reset_password_pendaftar') ?>" method="POST" class="p-8">
                <input type="hidden" name="user_id" id="modal-user-id">
                
                <div class="w-16 h-16 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-5 border-4 border-white shadow-md">
                    <i class="fas fa-key text-2xl"></i>
                </div>
                
                <h3 class="text-lg font-black text-slate-800 text-center mb-1 uppercase tracking-tight">Reset Password</h3>
                <p class="text-[10px] text-slate-400 font-bold text-center mb-6" id="modal-user-name">Nama Siswa</p>
                
                <div class="mb-6">
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Tulis Password Baru *</label>
                    <input type="text" name="password" required placeholder="Masukkan password baru..." class="block w-full px-4 py-3 border border-slate-200 rounded-xl text-xs bg-slate-50/50 hover:bg-white transition-colors focus:border-emerald-500 focus:outline-none">
                </div>
                
                <div class="flex space-x-3">
                    <button type="button" onclick="closeResetModal()" class="flex-1 py-3.5 bg-slate-100 text-slate-600 font-bold rounded-xl text-xs uppercase tracking-wider hover:bg-slate-200 transition-colors">Batal</button>
                    <button type="submit" class="flex-1 py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold rounded-xl text-xs uppercase tracking-wider hover:from-emerald-700 hover:to-teal-700 transition-all shadow-md shadow-emerald-200/50">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    // Live Search & Filter Status
    function filterTable() {
        const searchInput = document.getElementById('search-input');
        const filterStatus = document.getElementById('filter-status');
        const rows = document.querySelectorAll('.pendaftar-row');
        
        const searchVal = searchInput.value.toLowerCase().trim();
        const statusVal = filterStatus.value;
        
        rows.forEach(row => {
            const rowStatus = row.getAttribute('data-status');
            const rowSearch = row.getAttribute('data-search');
            
            const matchesStatus = (statusVal === 'all' || rowStatus === statusVal);
            const matchesSearch = (rowSearch.includes(searchVal));
            
            if (matchesStatus && matchesSearch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        
        // Update Counter
        const visibleRows = Array.from(rows).filter(r => r.style.display !== 'none');
        document.getElementById('pendaftar-count').textContent = visibleRows.length + ' siswa';
    }

    // Reset Password Modal Functions
    function openResetModal(userId, userName) {
        document.getElementById('modal-user-id').value = userId;
        document.getElementById('modal-user-name').textContent = userName;
        
        const modal = document.getElementById('reset-password-modal');
        const box = document.getElementById('reset-password-box');
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            box.classList.remove('scale-95');
        }, 10);
    }
    
    function closeResetModal() {
        const modal = document.getElementById('reset-password-modal');
        const box = document.getElementById('reset-password-box');
        
        modal.classList.add('opacity-0');
        box.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }
    </script>
</body></html>
