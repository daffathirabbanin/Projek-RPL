<?php
function adminSidebar($active = 'dashboard') {
    $links = [
        'dashboard'    => ['url'=>'admin','icon'=>'fa-tachometer-alt','label'=>'Dashboard'],
        'pendaftar'    => ['url'=>'admin/pendaftar','icon'=>'fa-users','label'=>'Data Pendaftar'],
        'kelola_admin' => ['url'=>'admin/admins','icon'=>'fa-user-shield','label'=>'Kelola Admin'],
        'pengaturan'   => ['url'=>'admin/pengaturan','icon'=>'fa-cog','label'=>'Pengaturan Kuota'],
    ];
?>
<aside class="w-72 bg-gradient-to-b from-slate-900 via-slate-900 to-slate-950 text-slate-100 flex flex-col hidden md:flex h-full shadow-2xl relative overflow-hidden flex-shrink-0">
    <div class="absolute -top-20 -right-20 w-56 h-56 bg-emerald-800/20 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-teal-700/20 rounded-full blur-2xl"></div>
    
    <div class="p-6 border-b border-slate-800/60 relative z-10">
        <div class="flex items-center space-x-3">
            <div class="w-11 h-11 flex items-center justify-center drop-shadow-md bg-white rounded-full p-0.5">
                <img src="<?= base_url('img/logo.jpeg') ?>" alt="Logo" class="w-full h-full object-cover rounded-full">
            </div>
            <div>
                <h1 class="font-black text-white text-sm tracking-wider">ADMIN PPDB</h1>
                <p class="text-[10px] text-emerald-400 font-bold tracking-[0.2em]">MIS NURUL IKHLAS</p>
            </div>
        </div>
    </div>

    <div class="px-5 pt-6 pb-4 relative z-10">
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl p-4 border border-slate-700/30">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-full flex items-center justify-center text-white font-black text-sm shadow-md">A</div>
                <div>
                    <p class="text-sm font-bold text-white">Administrator</p>
                    <p class="text-[10px] text-emerald-400/70 font-bold uppercase tracking-wider">Panitia PPDB</p>
                </div>
            </div>
        </div>
    </div>

    <div class="px-4 flex-1 space-y-1 relative z-10">
        <p class="text-[10px] font-bold text-slate-600 uppercase tracking-[0.2em] px-3 mb-3">Menu Utama</p>
        <?php foreach ($links as $key => $l):
            $isActive = $active == $key;
            $cls = $isActive
                ? 'bg-gradient-to-r from-emerald-600/30 to-transparent text-white border-l-2 border-emerald-400'
                : 'text-slate-400 hover:bg-slate-800/40 hover:text-white border-l-2 border-transparent';
        ?>
        <a href="<?= base_url($l['url']) ?>" class="flex items-center space-x-3 px-4 py-3 <?= $cls ?> rounded-lg font-medium transition-all">
            <i class="fas <?= $l['icon'] ?> w-5 text-center <?= $isActive ? 'text-emerald-400' : '' ?>"></i>
            <span class="text-sm"><?= $l['label'] ?></span>
            <?php if($isActive): ?><div class="ml-auto w-1.5 h-1.5 bg-emerald-400 rounded-full"></div><?php endif; ?>
        </a>
        <?php endforeach; ?>
    </div>

    <div class="p-4 border-t border-slate-800/40 relative z-10">
        <a href="<?= base_url('auth/logout') ?>" class="flex items-center space-x-3 px-4 py-3 text-red-400/80 hover:bg-red-950/30 hover:text-red-300 rounded-lg font-medium transition-all">
            <i class="fas fa-sign-out-alt w-5 text-center"></i><span class="text-sm">Keluar</span>
        </a>
    </div>
</aside>
<?php } ?>
