<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Admin | PPDB Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
    body{font-family:'Plus Jakarta Sans',sans-serif;background:#f8fafc}
    @keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
    .animate-fadeUp{animation:fadeUp .5s ease-out forwards}
    </style>
</head>
<body class="text-slate-800 flex h-screen overflow-hidden">
    <?php require_once '../app/Views/admin/_sidebar.php'; adminSidebar('kelola_admin'); ?>

    <main class="flex-1 flex flex-col h-full overflow-y-auto">
        <header class="bg-white/80 backdrop-blur-md px-8 py-5 border-b border-slate-200/60 sticky top-0 z-10">
            <h2 class="text-xl font-black text-slate-800 tracking-tight">KELOLA ADMIN</h2>
            <p class="text-[11px] text-slate-400 font-bold uppercase tracking-[0.15em] mt-0.5">Manajemen akun panitia PPDB</p>
        </header>

        <div class="p-8 max-w-6xl mx-auto w-full pb-20 space-y-8">

            <?php if(isset($_GET['success'])): ?>
            <div class="bg-emerald-50 text-emerald-700 px-4 py-3 rounded-xl border border-emerald-200 font-bold text-sm flex items-center shadow-sm animate-fadeUp">
                <i class="fas fa-check-circle mr-3 text-lg"></i>
                <?= $_GET['success'] == 'added' ? 'Admin baru berhasil ditambahkan!' : 'Admin berhasil dihapus.' ?>
            </div>
            <?php endif; ?>
            <?php if(isset($_GET['error'])): ?>
            <div class="bg-red-50 text-red-700 px-4 py-3 rounded-xl border border-red-200 font-bold text-sm flex items-center shadow-sm animate-fadeUp">
                <i class="fas fa-exclamation-circle mr-3 text-lg"></i>
                <?= $_GET['error'] == 'exists' ? 'Email tersebut sudah terdaftar.' : 'Terjadi kesalahan.' ?>
            </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Form Tambah Admin -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden animate-fadeUp lg:col-span-1">
                    <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white flex items-center space-x-3">
                        <div class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center text-sm">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <h3 class="font-black text-slate-800 text-sm uppercase tracking-tight">Tambah Admin Baru</h3>
                    </div>
                    <div class="p-6">
                        <form action="<?= base_url('admin/add_admin') ?>" method="POST" class="space-y-4">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-[0.15em] mb-1.5">Nama Lengkap</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400"><i class="fas fa-user text-sm"></i></div>
                                    <input type="text" name="name" required placeholder="Nama Admin" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-sm font-medium text-slate-700 transition-all">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-[0.15em] mb-1.5">Alamat Email</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400"><i class="fas fa-envelope text-sm"></i></div>
                                    <input type="email" name="email" required placeholder="Email Admin" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-sm font-medium text-slate-700 transition-all">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-[0.15em] mb-1.5">Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400"><i class="fas fa-lock text-sm"></i></div>
                                    <input type="password" name="password" required minlength="6" placeholder="Password" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-sm font-medium text-slate-700 transition-all">
                                </div>
                            </div>
                            <div class="pt-2">
                                <button type="submit" class="w-full px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold rounded-xl shadow-md shadow-emerald-200 hover:from-emerald-700 hover:to-teal-700 hover:-translate-y-0.5 transition-all flex items-center justify-center space-x-2">
                                    <i class="fas fa-plus"></i> <span>Tambah Admin</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Daftar Admin -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden animate-fadeUp lg:col-span-2">
                    <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white flex items-center space-x-3">
                        <div class="w-8 h-8 bg-teal-100 text-teal-600 rounded-lg flex items-center justify-center text-sm">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <h3 class="font-black text-slate-800 text-sm uppercase tracking-tight">Daftar Admin Aktif</h3>
                        <span class="ml-auto text-xs font-bold text-slate-400 bg-slate-100 px-3 py-1 rounded-full"><?= count($data['admins']) ?> admin</span>
                    </div>
                    <div class="divide-y divide-slate-100">
                        <?php if(empty($data['admins'])): ?>
                        <div class="text-center py-16 text-slate-400">
                            <i class="fas fa-user-shield text-4xl mb-3 block text-slate-200"></i>
                            <p class="font-bold">Belum ada admin.</p>
                        </div>
                        <?php else: foreach($data['admins'] as $admin): ?>
                        <div class="flex items-center justify-between px-6 py-4 hover:bg-slate-50/70 transition-colors">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-full flex items-center justify-center text-white font-black text-sm shadow-md shadow-emerald-200/50">
                                    <?= strtoupper(substr($admin['name'], 0, 1)) ?>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 text-sm"><?= htmlspecialchars($admin['name']) ?></p>
                                    <p class="text-xs text-slate-400 font-medium"><?= htmlspecialchars($admin['email']) ?></p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <?php if($admin['id'] == $_SESSION['user_id']): ?>
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-bold uppercase tracking-wider rounded-full">Anda</span>
                                <?php else: ?>
                                <a href="<?= base_url('admin/delete_admin/' . $admin['id']) ?>"
                                   onclick="return confirm('Hapus admin <?= htmlspecialchars($admin['name']) ?>? Tindakan ini tidak dapat dibatalkan.')"
                                   class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-400 hover:bg-red-100 hover:text-red-600 transition-colors" title="Hapus Admin">
                                    <i class="fas fa-trash text-xs"></i>
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
