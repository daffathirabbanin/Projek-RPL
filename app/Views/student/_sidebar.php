<?php
function studentSidebar($active = 'dashboard') {
    $status = $_SESSION['status_daftar'] ?? 'belum_mendaftar';
    $links = [
        'dashboard' => ['url'=>'student','icon'=>'fa-home','label'=>'Dashboard'],
        'form'      => ['url'=>'student/form','icon'=>'fa-edit','label'=>'Isi Formulir & Berkas'],
        'pengumuman'=> ['url'=>'student/pengumuman','icon'=>'fa-envelope-open-text','label'=>'Cetak & Pengumuman'],
    ];
?>
<aside class="w-72 bg-white flex flex-col hidden md:flex h-full shadow-[4px_0_24px_rgba(0,0,0,0.02)] relative overflow-hidden border-r border-slate-100/50 z-50">
    
    <!-- Logo -->
    <div class="px-6 pt-8 pb-4 relative z-10 flex items-center mt-2 border-b border-slate-50/50 space-x-4">
        <div class="w-16 h-16 flex items-center justify-center bg-white border border-emerald-100 rounded-full shadow-md p-1 flex-shrink-0">
            <img src="<?= base_url('img/logo.jpeg') ?>" alt="Logo" class="w-full h-full object-cover rounded-full">
        </div>
        <div class="flex-1">
            <h1 class="font-black text-emerald-800 text-[15px] tracking-wide leading-snug">MI NURUL IKHLAS AL-AYUBI</h1>
            <p class="text-[10px] text-emerald-700 font-bold tracking-wider mt-1">Cerdas, Berakhlak, Beriman</p>
        </div>
    </div>

    <!-- Nav Links -->
    <div class="px-5 flex-1 space-y-1.5 relative z-10 mt-6">
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
            $isLocked = !$is_sb_editable && $key === 'form';
            
            if ($isLocked) {
                $cls = 'text-slate-300 cursor-not-allowed';
            } else {
                $cls = $isActive
                    ? 'bg-[#378B54] text-white shadow-md shadow-emerald-600/20'
                    : 'text-slate-500 hover:bg-emerald-50 hover:text-emerald-700';
            }
            
            $showBadge = false;
            if ($key === 'dashboard' && $reg_status_sb === 'perlu_revisi') $showBadge = true;
            if ($key === 'form' && ($has_form_revisi || $has_upload_revisi)) $showBadge = true;
        ?>
        <a href="<?= $isLocked ? '#' : base_url($l['url']) ?>" class="flex items-center space-x-4 px-4 py-3.5 <?= $cls ?> rounded-xl font-bold text-sm transition-all duration-300 <?= $isLocked ? 'pointer-events-none' : '' ?>">
            <i class="fas <?= $l['icon'] ?> w-5 text-center text-lg <?= $isActive ? 'text-white' : ($isLocked ? 'text-slate-300' : 'text-emerald-600/80') ?>"></i>
            <span><?= $l['label'] ?></span>
            <?php if($showBadge): ?>
            <span class="ml-auto w-5 h-5 bg-red-500 text-white text-[9px] font-black rounded-full flex items-center justify-center animate-pulse shadow-sm"><i class="fas fa-exclamation" style="font-size:8px"></i></span>
            <?php elseif($isLocked): ?>
            <i class="fas fa-lock ml-auto text-[10px] text-slate-300"></i>
            <?php endif; ?>
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
