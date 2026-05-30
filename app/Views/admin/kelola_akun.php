<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Akun Pendaftar | Admin PPDB</title>
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
    </style>
</head>
<body class="text-slate-800 flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <?php require_once '../app/Views/admin/_sidebar.php'; adminSidebar('akun_siswa'); ?>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-y-auto relative">
        <!-- Header -->
        <header class="bg-white px-8 py-5 border-b border-slate-200/80 sticky top-0 z-30 flex justify-between items-center shadow-sm">
            <div>
                <h2 class="text-2xl font-black text-emerald-800 tracking-tight">Akun Pendaftar</h2>
                <p class="text-[13px] text-slate-500 font-bold mt-1 tracking-wide">Kelola seluruh akun calon siswa terdaftar</p>
            </div>
            <div class="text-right">
                <p class="text-xs font-bold text-slate-500"><?= date('l, d F Y') ?></p>
                <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest">TA 2026/2027</p>
            </div>
        </header>

        <div class="p-8 max-w-6xl mx-auto w-full pb-20">
            <?php if(isset($_GET['success'])): ?>
                <?php if($_GET['success'] == 'reset_pass'): ?>
                <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl text-sm font-bold mb-6 border border-emerald-200 flex items-center shadow-sm">
                    <i class="fas fa-check-circle mr-3 text-lg"></i>
                    Password berhasil direset.
                </div>
                <?php elseif($_GET['success'] == 'deleted'): ?>
                <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl text-sm font-bold mb-6 border border-emerald-200 flex items-center shadow-sm">
                    <i class="fas fa-check-circle mr-3 text-lg"></i>
                    Akun berhasil dihapus permanen.
                </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="bg-white rounded-[24px] border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden animate-fadeUp">
                <div class="px-6 py-5 border-b border-slate-100 bg-white flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-[14px] flex items-center justify-center text-lg"><i class="fas fa-user-graduate"></i></div>
                        <h3 class="font-black text-slate-800 text-sm uppercase tracking-tight">Daftar Akun</h3>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="relative w-64">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                                <i class="fas fa-search text-xs"></i>
                            </span>
                            <input type="text" id="search-input" onkeyup="filterTable()" placeholder="Cari email atau nama..." class="block w-full pl-9 pr-4 py-2.5 border border-slate-200 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-emerald-500 focus:outline-none transition-colors">
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="pendaftar-table">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100">
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-wider">Info Akun</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-wider">Tanggal Daftar</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-wider">Status Berkas</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if(empty($data['akun'])): ?>
                            <tr><td colspan="4" class="text-center py-16 text-slate-400 font-bold"><i class="fas fa-inbox text-3xl mb-3 block text-slate-300"></i>Belum ada akun pendaftar.</td></tr>
                            <?php else: foreach($data['akun'] as $row):
                                $s = $row['status'] ?? 'belum_mendaftar';
                                $badge = ['belum_mendaftar'=>'bg-slate-100 text-slate-600','nunggu_verifikasi'=>'bg-amber-100 text-amber-700','dokumen_diterima'=>'bg-teal-100 text-teal-700','diterima'=>'bg-emerald-100 text-emerald-700','ditolak'=>'bg-red-100 text-red-700','perlu_revisi'=>'bg-rose-100 text-rose-700'];
                                $label = ['belum_mendaftar'=>'Draft','nunggu_verifikasi'=>'Menunggu Verifikasi','dokumen_diterima'=>'Berkas Valid','diterima'=>'Diterima','ditolak'=>'Ditolak','perlu_revisi'=>'Perlu Revisi'];
                            ?>
                            <tr class="pendaftar-row hover:bg-slate-50/50 transition-colors" data-search="<?= strtolower(htmlspecialchars($row['name']) . ' ' . htmlspecialchars($row['email'])) ?>">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800 text-sm"><?= htmlspecialchars($row['name']) ?></div>
                                    <div class="text-[11px] text-slate-500 mt-1"><i class="fas fa-envelope text-slate-400 mr-1"></i> <?= htmlspecialchars($row['email']) ?></div>
                                </td>
                                <td class="px-6 py-4 text-xs font-bold text-slate-600">
                                    <?= date('d M Y, H:i', strtotime($row['created_at'])) ?>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider <?= $badge[$s] ?? 'bg-slate-100 text-slate-600' ?>"><?= $label[$s] ?? $s ?></span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button type="button" onclick="openResetModal('<?= $row['user_id'] ?>', '<?= htmlspecialchars($row['name']) ?>')" title="Reset Password" class="w-8 h-8 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center hover:bg-amber-600 hover:text-white transition-colors shadow-sm">
                                            <i class="fas fa-key text-xs"></i>
                                        </button>
                                        <a href="<?= base_url('admin/delete_akun/' . $row['user_id']) ?>" onclick="return confirm('Yakin ingin menghapus akun ini secara permanen? Data yang telah diisi juga akan terhapus.')" title="Hapus Akun" class="w-8 h-8 bg-red-100 text-red-500 rounded-lg flex items-center justify-center hover:bg-red-600 hover:text-white transition-colors shadow-sm">
                                            <i class="fas fa-trash text-xs"></i>
                                        </a>
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

    <!-- Modal Reset Password -->
    <div id="reset-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden items-center justify-center z-50 transition-all opacity-0">
        <div class="bg-white rounded-[24px] shadow-2xl w-full max-w-sm mx-4 transform scale-95 transition-all overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                <h3 class="font-black text-slate-800 text-sm uppercase tracking-tight"><i class="fas fa-key text-emerald-500 mr-2"></i>Reset Password</h3>
                <button onclick="closeResetModal()" class="text-slate-400 hover:text-red-500 transition-colors"><i class="fas fa-times text-lg"></i></button>
            </div>
            <form action="<?= base_url('admin/reset_password_akun') ?>" method="POST" class="p-6">
                <input type="hidden" name="user_id" id="reset-user-id">
                
                <p class="text-xs text-slate-500 font-medium mb-4">Reset password untuk akun: <span id="reset-user-name" class="font-bold text-slate-800"></span></p>
                
                <div class="mb-6">
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Tulis Password Baru *</label>
                    <input type="text" name="password" required placeholder="Masukkan password baru..." class="block w-full px-4 py-3 border border-slate-200 rounded-xl text-xs bg-slate-50 focus:bg-white focus:border-emerald-500 focus:outline-none transition-colors">
                </div>
                
                <div class="flex space-x-3">
                    <button type="button" onclick="closeResetModal()" class="flex-1 py-3.5 bg-slate-100 text-slate-600 font-bold rounded-xl text-xs uppercase tracking-wider hover:bg-slate-200 transition-colors">Batal</button>
                    <button type="submit" class="flex-1 py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold rounded-xl text-xs uppercase tracking-wider hover:from-emerald-700 hover:to-teal-700 transition-all shadow-md shadow-emerald-200/50">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function filterTable() {
            let input = document.getElementById('search-input').value.toLowerCase();
            let rows = document.querySelectorAll('.pendaftar-row');
            
            rows.forEach(row => {
                let searchData = row.getAttribute('data-search');
                let matchSearch = searchData.includes(input);
                if (matchSearch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function openResetModal(userId, userName) {
            document.getElementById('reset-user-id').value = userId;
            document.getElementById('reset-user-name').textContent = userName;
            const modal = document.getElementById('reset-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            // Allow display block to render before animating opacity
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.children[0].classList.remove('scale-95');
                modal.children[0].classList.add('scale-100');
            }, 10);
        }

        function closeResetModal() {
            const modal = document.getElementById('reset-modal');
            modal.classList.add('opacity-0');
            modal.children[0].classList.remove('scale-100');
            modal.children[0].classList.add('scale-95');
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 300); // match transition duration
        }
    </script>
</body>
</html>
