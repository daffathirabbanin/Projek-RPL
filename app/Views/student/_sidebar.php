<?php
function studentSidebar($active = 'dashboard') {
    $status = $_SESSION['status_daftar'] ?? 'belum_mendaftar';
    $links = [
        'dashboard' => ['url'=>'student','icon'=>'fa-home','label'=>'Dashboard'],
        'form'      => ['url'=>'student/form','icon'=>'fa-edit','label'=>'Isi Formulir'],
        'upload'    => ['url'=>'student/upload','icon'=>'fa-file-upload','label'=>'Upload Berkas'],
        'pengumuman'=> ['url'=>'student/pengumuman','icon'=>'fa-envelope-open-text','label'=>'Cetak & Pengumuman'],
    ];
?>
<aside class="w-72 bg-gradient-to-b from-emerald-950 via-emerald-950 to-slate-950 text-emerald-100 flex flex-col hidden md:flex h-full shadow-2xl relative overflow-hidden">
    <!-- Decorative circles -->
    <div class="absolute -top-20 -right-20 w-56 h-56 bg-emerald-800/20 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-teal-700/15 rounded-full blur-2xl"></div>

    <!-- Logo -->
    <div class="p-6 border-b border-emerald-800/40 relative z-10">
        <div class="flex items-center space-x-3">
            <div class="w-11 h-11 flex items-center justify-center drop-shadow-md bg-white rounded-full p-0.5">
                <img src="<?= base_url('img/logo.jpeg') ?>" alt="Logo" class="w-full h-full object-cover rounded-full">
            </div>
            <div>
                <h1 class="font-black text-white text-sm tracking-wider">PPDB ONLINE</h1>
                <p class="text-[10px] text-emerald-400/80 font-bold tracking-[0.2em]">MIS NURUL IKHLAS</p>
            </div>
        </div>
    </div>

    <!-- User Info Card -->
    <div class="px-5 pt-6 pb-4 relative z-10">
        <div class="bg-emerald-900/40 backdrop-blur-sm rounded-xl p-4 border border-emerald-800/30">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-full flex items-center justify-center text-white font-black text-sm shadow-md">
                    <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-white truncate"><?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></p>
                    <p class="text-[10px] text-emerald-400/70 font-bold uppercase tracking-wider">Calon Peserta Didik</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Nav Links -->
    <div class="px-4 flex-1 space-y-1 relative z-10">
        <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-[0.2em] px-3 mb-3">Menu Utama</p>
        <?php 
        $revisi_json_sb = $_SESSION['revisi_json'] ?? '';
        $revisi_data_sb = !empty($revisi_json_sb) ? (json_decode($revisi_json_sb, true) ?: []) : [];
        $reg_status_sb = $_SESSION['reg_status'] ?? '';
        $has_form_revisi = false;
        $has_upload_revisi = false;
        if ($reg_status_sb === 'perlu_revisi' && !empty($revisi_data_sb)) {
            foreach ($revisi_data_sb as $rk => $rv) {
                if (in_array($rk, ['pribadi','ortu'])) $has_form_revisi = true;
                if (in_array($rk, ['ijazah','kk','akta','foto_3x4'])) $has_upload_revisi = true;
            }
        }
        
        $is_sb_editable = in_array($reg_status_sb, ['belum_mendaftar', 'perlu_revisi']);
        
        foreach ($links as $key => $l):
            $isActive = $active == $key;
            $isLocked = !$is_sb_editable && in_array($key, ['form', 'upload']);
            
            if ($isLocked) {
                $cls = 'text-emerald-300/30 border-l-2 border-transparent cursor-not-allowed';
            } else {
                $cls = $isActive
                    ? 'bg-gradient-to-r from-emerald-600/30 to-transparent text-white border-l-2 border-emerald-400'
                    : 'text-emerald-300/70 hover:bg-emerald-900/40 hover:text-white border-l-2 border-transparent';
            }
            
            $showBadge = false;
            if ($key === 'dashboard' && $reg_status_sb === 'perlu_revisi') $showBadge = true;
            if ($key === 'form' && $has_form_revisi) $showBadge = true;
            if ($key === 'upload' && $has_upload_revisi) $showBadge = true;
        ?>
        <a href="<?= $isLocked ? '#' : base_url($l['url']) ?>" class="flex items-center space-x-3 px-4 py-3 <?= $cls ?> rounded-lg font-medium transition-all duration-200 <?= $isLocked ? 'pointer-events-none' : '' ?>">
            <i class="fas <?= $l['icon'] ?> w-5 text-center <?= $isActive ? 'text-emerald-400' : ($isLocked ? 'text-emerald-300/20' : '') ?>"></i>
            <span class="text-sm"><?= $l['label'] ?></span>
            <?php if($showBadge): ?>
            <span class="ml-auto w-5 h-5 bg-red-500 text-white text-[9px] font-black rounded-full flex items-center justify-center animate-pulse shadow-md shadow-red-500/30"><i class="fas fa-exclamation" style="font-size:8px"></i></span>
            <?php elseif($isLocked): ?>
            <i class="fas fa-lock ml-auto text-[10px] text-emerald-300/20"></i>
            <?php elseif($isActive): ?>
            <div class="ml-auto w-1.5 h-1.5 bg-emerald-400 rounded-full"></div>
            <?php endif; ?>
        </a>
        <?php endforeach; ?>
    </div>

    <!-- Logout -->
    <div class="p-4 border-t border-emerald-800/30 relative z-10">
        <a href="<?= base_url('auth/logout') ?>" class="flex items-center space-x-3 px-4 py-3 text-red-400/80 hover:bg-red-950/30 hover:text-red-300 rounded-lg font-medium transition-all">
            <i class="fas fa-sign-out-alt w-5 text-center"></i>
            <span class="text-sm">Keluar</span>
        </a>
    </div>
</aside>
<?php } ?>
