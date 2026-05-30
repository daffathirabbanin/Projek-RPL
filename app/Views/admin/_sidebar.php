<?php
function adminSidebar($active = 'dashboard') {
    $links = [
        'dashboard'    => ['url'=>'admin','icon'=>'fa-tachometer-alt','label'=>'Dashboard'],
        'pendaftar'    => ['url'=>'admin/pendaftar','icon'=>'fa-clipboard-check','label'=>'Verifikasi Pendaftar'],
        'akun_siswa'   => ['url'=>'admin/akunSiswa','icon'=>'fa-user-graduate','label'=>'Akun Pendaftar'],
        'jadwal_tes'   => ['url'=>'admin/jadwalTes','icon'=>'fa-calendar-check','label'=>'Jadwal Tes Baca & Tulis'],
        'laporan'      => ['url'=>'admin/laporan','icon'=>'fa-file-excel','label'=>'Laporan & Export'],
        'kelola_admin' => ['url'=>'admin/admins','icon'=>'fa-user-shield','label'=>'Kelola Admin'],
        'pengaturan'   => ['url'=>'admin/pengaturan','icon'=>'fa-cog','label'=>'Pengaturan Kuota'],
    ];
?>
<aside class="w-72 bg-white flex flex-col hidden md:flex h-full shadow-[4px_0_24px_rgba(0,0,0,0.02)] relative overflow-hidden border-r border-slate-100/50 z-50">
    
    <!-- Logo -->
    <div class="px-6 pt-8 pb-4 relative z-10 flex items-center mt-2 border-b border-slate-50/50 space-x-4">
        <div class="w-16 h-16 flex items-center justify-center bg-white border border-emerald-100 rounded-full shadow-md p-1 flex-shrink-0">
            <img src="<?= base_url('img/logo.jpeg') ?>" alt="Logo" class="w-full h-full object-cover rounded-full">
        </div>
        <div class="flex-1">
            <h1 class="font-black text-emerald-800 text-[15px] tracking-wide leading-snug">ADMIN PPDB</h1>
            <p class="text-[10px] text-emerald-600 font-bold tracking-wider mt-1">Administrator</p>
        </div>
    </div>

    <!-- Nav Links -->
    <div class="px-5 flex-1 space-y-1.5 relative z-10 mt-6 overflow-y-auto pb-4">
        <?php 
        foreach ($links as $key => $l):
            $isActive = $active == $key;
            
            $cls = $isActive
                ? 'bg-[#378B54] text-white shadow-md shadow-emerald-600/20'
                : 'text-slate-500 hover:bg-emerald-50 hover:text-emerald-700';
        ?>
        <a href="<?= base_url($l['url']) ?>" class="flex items-center space-x-4 px-4 py-3.5 <?= $cls ?> rounded-xl font-bold text-sm transition-all duration-300">
            <i class="fas <?= $l['icon'] ?> w-5 text-center text-lg <?= $isActive ? 'text-white' : 'text-emerald-600/80' ?>"></i>
            <span><?= $l['label'] ?></span>
        </a>
        <?php endforeach; ?>
    </div>

    <!-- Logout -->
    <div class="p-6 relative z-10 bg-white mt-auto">
        <a href="<?= base_url('auth/logout') ?>" class="flex items-center justify-center space-x-2 w-full py-3 border-2 border-slate-100 text-slate-500 hover:bg-slate-50 hover:text-red-500 hover:border-red-100 rounded-xl font-bold text-sm transition-all">
            <i class="fas fa-sign-out-alt"></i>
            <span>Keluar</span>
        </a>
    </div>
</aside>
<?php } ?>
