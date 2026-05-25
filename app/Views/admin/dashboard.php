<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?? 'Dashboard Admin' ?> | PPDB Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
    body{font-family:'Plus Jakarta Sans',sans-serif;background:#f8fafc}
    .card-hover{transition:all .3s cubic-bezier(.4,0,.2,1)}.card-hover:hover{transform:translateY(-4px);box-shadow:0 20px 25px -5px rgba(0,0,0,.06)}
    @keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
    .animate-fadeUp{animation:fadeUp .5s ease-out forwards}
    .delay-1{animation-delay:.1s}.delay-2{animation-delay:.2s}.delay-3{animation-delay:.3s}
    </style>
</head>
<body class="text-slate-800 flex h-screen overflow-hidden">
    <!-- Admin Sidebar -->
    <?php require_once '../app/Views/admin/_sidebar.php'; adminSidebar('dashboard'); ?>

    <main class="flex-1 flex flex-col h-full overflow-y-auto">
        <header class="bg-white/80 backdrop-blur-md px-8 py-5 border-b border-slate-200/60 flex justify-between items-center sticky top-0 z-10">
            <div>
                <h2 class="text-xl font-black text-slate-800 tracking-tight">DASHBOARD ADMIN</h2>
                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-[0.15em] mt-0.5">Ringkasan Data PPDB</p>
            </div>
            <div class="text-right">
                <p class="text-xs font-bold text-slate-500"><?= date('l, d F Y') ?></p>
                <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest">TA 2026/2027</p>
            </div>
        </header>

        <div class="p-8 max-w-6xl mx-auto w-full pb-20">
            <!-- Stats Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-5 mb-8">
                <?php
                $stats = [
                    ['label'=>'Pendaftar / Kuota','val'=>$data['total'] . ' / ' . $data['kuota'],'icon'=>'fa-users','gradient'=>'from-emerald-500 to-teal-600','shadow'=>'shadow-emerald-200/50'],
                    ['label'=>'Menunggu Verifikasi','val'=>$data['menunggu'],'icon'=>'fa-clock','gradient'=>'from-amber-500 to-orange-500','shadow'=>'shadow-amber-200/50'],
                    ['label'=>'Berkas Valid','val'=>$data['berkas_valid'],'icon'=>'fa-check-double','gradient'=>'from-blue-500 to-indigo-500','shadow'=>'shadow-blue-200/50'],
                    ['label'=>'Diterima','val'=>$data['diterima'],'icon'=>'fa-check-circle','gradient'=>'from-teal-500 to-emerald-500','shadow'=>'shadow-teal-200/50'],
                    ['label'=>'Ditolak','val'=>$data['ditolak'],'icon'=>'fa-times-circle','gradient'=>'from-red-500 to-pink-500','shadow'=>'shadow-red-200/50'],
                ];
                foreach($stats as $i => $s): ?>
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm card-hover p-6 animate-fadeUp delay-<?= $i+1 ?>" style="opacity:0">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br <?= $s['gradient'] ?> rounded-xl flex items-center justify-center text-white shadow-md <?= $s['shadow'] ?>">
                            <i class="fas <?= $s['icon'] ?> text-lg"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-black text-slate-800 mb-1"><?= $s['val'] ?></p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em]"><?= $s['label'] ?></p>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Latest Registrations -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden animate-fadeUp delay-3" style="opacity:0">
                    <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center text-sm"><i class="fas fa-list"></i></div>
                            <h3 class="font-black text-slate-800 text-sm uppercase tracking-tight">Pendaftar Terbaru</h3>
                        </div>
                        <a href="<?= base_url('admin/pendaftar') ?>" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 uppercase tracking-wider">Lihat Semua <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                    <div class="overflow-x-auto flex-1">
                        <table class="w-full">
                            <thead><tr class="bg-slate-50/80 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">
                                <th class="px-6 py-4">Nama</th><th class="px-6 py-4">Email</th><th class="px-6 py-4">No. HP</th><th class="px-6 py-4">Status</th><th class="px-6 py-4">Aksi</th>
                            </tr></thead>
                            <tbody class="divide-y divide-slate-100">
                                <?php if(empty($data['latest'])): ?>
                                <tr><td colspan="5" class="text-center py-16 text-slate-400 font-bold"><i class="fas fa-inbox text-3xl mb-3 block text-slate-300"></i>Belum ada data pendaftar.</td></tr>
                                <?php else: foreach($data['latest'] as $row): ?>
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-slate-800"><?= htmlspecialchars($row['nama'] ?? 'Belum Isi') ?></td>
                                    <td class="px-6 py-4 text-sm text-slate-500"><?= htmlspecialchars($row['email']) ?></td>
                                    <td class="px-6 py-4 text-sm text-slate-500"><?= htmlspecialchars($row['no_hp'] ?? '-') ?></td>
                                    <td class="px-6 py-4">
                                        <?php 
                                        $s = $row['status'];
                                        $badge = [
                                            'belum_mendaftar'  =>'bg-slate-100 text-slate-600',
                                            'nunggu_verifikasi'=>'bg-amber-100 text-amber-700',
                                            'dokumen_diterima' =>'bg-blue-100 text-blue-700',
                                            'diterima'         =>'bg-emerald-100 text-emerald-700',
                                            'ditolak'          =>'bg-red-100 text-red-700',
                                            'perlu_revisi'     =>'bg-rose-100 text-rose-700',
                                        ];
                                        $label = [
                                            'belum_mendaftar'  =>'Draft',
                                            'nunggu_verifikasi'=>'Menunggu',
                                            'dokumen_diterima' =>'Berkas Valid',
                                            'diterima'         =>'Diterima',
                                            'ditolak'          =>'Ditolak',
                                            'perlu_revisi'     =>'Perlu Revisi',
                                        ];
                                        ?>
                                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider <?= $badge[$s] ?? 'bg-slate-100 text-slate-600' ?>"><?= $label[$s] ?? ucfirst($s) ?></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="<?= base_url('admin/detail/' . $row['id']) ?>" class="px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-[10px] font-bold rounded-lg uppercase tracking-wider hover:from-emerald-700 hover:to-teal-700 transition-all shadow-sm shadow-emerald-200">
                                            Detail <i class="fas fa-eye ml-1"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body></html>
