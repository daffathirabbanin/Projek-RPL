<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Siswa | PPDB MI Nurul Ikhlas Al-Ayubi</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');
body{font-family:'Poppins',sans-serif;background:#f8fafc}
.card-hover{transition:all .3s cubic-bezier(.4,0,.2,1)}
.card-hover:hover{transform:translateY(-4px);box-shadow:0 20px 25px -5px rgba(0,0,0,.06)}
@keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
.animate-fadeUp{animation:fadeUp .5s ease-out forwards}
.delay-1{animation-delay:.1s}.delay-2{animation-delay:.2s}.delay-3{animation-delay:.3s}
@keyframes pulseGlow{0%,100%{box-shadow:0 0 15px rgba(239,68,68,.2)}50%{box-shadow:0 0 35px rgba(239,68,68,.45)}}
.pulse-glow{animation:pulseGlow 2s ease-in-out infinite}
@keyframes countdownPulse{0%,100%{transform:scale(1)}50%{transform:scale(1.05)}}
.countdown-pulse{animation:countdownPulse 3s ease-in-out infinite}
@keyframes shimmer{0%{background-position:-200% 0}100%{background-position:200% 0}}
.shimmer{background:linear-gradient(90deg,transparent,rgba(255,255,255,.08),transparent);background-size:200% 100%;animation:shimmer 2.5s infinite}
</style>
</head>
<body class="text-slate-800 flex h-screen overflow-hidden">
<?php require_once '../app/Views/student/_sidebar.php'; studentSidebar('dashboard'); ?>

<main class="flex-1 flex flex-col h-full overflow-y-auto">
<!-- Header -->
<header class="bg-white px-8 py-5 border-b border-slate-200/80 sticky top-0 z-30 flex justify-between items-center shadow-sm">
  <div>
    <h2 class="text-2xl font-bold text-[#1a5632] tracking-tight">Dashboard</h2>
    <p class="text-[13px] text-slate-500 font-medium mt-1">Ringkasan Data Pendaftaran</p>
  </div>
  <div class="flex items-center space-x-6">
    <!-- Bell Notification Button -->
    <?php
    $reg_status  = $_SESSION['reg_status']  ?? 'belum_mendaftar';
    $reg_catatan = $_SESSION['reg_catatan'] ?? '';
    $revisi_json_session = $_SESSION['revisi_json'] ?? '';
    $notifs = [];
    if ($reg_status === 'diterima') {
        $notifs[] = ['type'=>'success','icon'=>'fa-check-circle','color'=>'text-emerald-500','msg'=>'Selamat! Anda DITERIMA.','link'=>'student/pengumuman'];
    } elseif ($reg_status === 'ditolak') {
        $notifs[] = ['type'=>'error','icon'=>'fa-times-circle','color'=>'text-red-500','msg'=>'Maaf, pendaftaran Anda tidak diterima.','link'=>'student/pengumuman'];
    } elseif ($reg_status === 'dokumen_diterima') {
        $notifs[] = ['type'=>'success','icon'=>'fa-clipboard-check','color'=>'text-blue-500','msg'=>'PANGGILAN TES BACA TULIS: Berkas diverifikasi. Cek jadwal dan unduh Formulir Peserta.','link'=>'student/pengumuman'];
    } elseif ($reg_status === 'nunggu_pengumuman') {
        $notifs[] = ['type'=>'info','icon'=>'fa-check-double','color'=>'text-blue-500','msg'=>'Formulir & dokumen divalidasi. Menunggu pengumuman kelulusan resmi.','link'=>'student/pengumuman'];
    } elseif ($reg_status === 'diproses') {
        $notifs[] = ['type'=>'success','icon'=>'fa-paper-plane','color'=>'text-emerald-500','msg'=>'Formulir dan dokumen pendaftaran berhasil dikirim. Menunggu verifikasi admin.','link'=>'#'];
    } elseif ($reg_status === 'perlu_revisi') {
        $notifs[] = ['type'=>'error','icon'=>'fa-exclamation-triangle','color'=>'text-red-500','msg'=>'Data/berkas Anda perlu direvisi! Segera perbaiki.','link'=>'student'];
    }
    if (!empty($reg_catatan) && $reg_status === 'nunggu_verifikasi') {
        $notifs[] = ['type'=>'warning','icon'=>'fa-exclamation-circle','color'=>'text-amber-500','msg'=>'Admin memberi catatan: Periksa dokumen Anda!','link'=>'student/form'];
    }
    $notif_count = count($notifs);
    ?>
    <div class="relative" id="notif-wrapper">
      <button onclick="toggleNotif()" id="notif-btn" class="relative w-10 h-10 bg-slate-100 hover:bg-slate-200/80 rounded-xl flex items-center justify-center transition-all duration-200 group border border-slate-200/50">
          <i id="notif-icon" class="far fa-bell text-slate-500 group-hover:text-slate-700 text-lg <?= $notif_count > 0 ? 'animate-bounce text-emerald-600' : '' ?>"></i>
          <?php if($notif_count > 0): ?>
          <span id="notif-badge" class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-[10px] font-black rounded-full flex items-center justify-center shadow-md animate-pulse">
              <?= $notif_count ?>
          </span>
          <?php endif; ?>
      </button>
      
      <!-- Notification Dropdown Panel -->
      <div id="notif-panel" class="hidden absolute right-0 top-13 w-80 bg-white border border-slate-200/80 rounded-2xl shadow-2xl z-[200] overflow-hidden animate-fadeUp">
          <div class="px-5 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
              <div class="flex items-center space-x-2">
                  <i class="fas fa-bell text-emerald-600 text-sm"></i>
                  <p class="text-xs font-black text-slate-700 uppercase tracking-wider">Notifikasi</p>
              </div>
              <?php if($notif_count > 0): ?>
              <span class="text-[10px] font-black bg-red-100 text-red-600 px-2.5 py-0.5 rounded-full"><?= $notif_count ?> Baru</span>
              <?php endif; ?>
          </div>
          <div class="max-h-80 overflow-y-auto">
          <?php if(empty($notifs)): ?>
              <div class="p-8 text-center">
                  <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-3 border border-slate-100">
                      <i class="fas fa-bell-slash text-slate-300 text-lg"></i>
                  </div>
                  <p class="text-xs text-slate-400 font-bold">Tidak ada notifikasi baru</p>
              </div>
          <?php else: foreach($notifs as $n): ?>
              <a href="<?= base_url($n['link']) ?>" class="flex items-start space-x-3.5 px-5 py-4 border-b border-slate-100 hover:bg-slate-50 transition-colors group">
                  <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5
                      <?= $n['type']==='success' ? 'bg-emerald-50 text-emerald-500' : ($n['type']==='error' ? 'bg-red-50 text-red-500' : 'bg-amber-50 text-amber-500') ?>">
                      <i class="fas <?= $n['icon'] ?> text-base"></i>
                  </div>
                  <div class="flex-1 min-w-0">
                      <p class="text-xs font-bold text-slate-700 leading-snug group-hover:text-slate-900 transition-colors"><?= $n['msg'] ?></p>
                      <p class="text-[10px] text-emerald-600 mt-1 flex items-center font-bold uppercase tracking-wider"><i class="fas fa-arrow-right mr-1.5 text-[8px]"></i> Lihat Detail</p>
                  </div>
              </a>
          <?php endforeach; endif; ?>
          </div>
          <?php if($reg_status !== 'belum_mendaftar'): ?>
          <div class="px-5 py-3.5 bg-slate-50/50 border-t border-slate-100 text-center">
              <a href="<?= base_url('student/pengumuman') ?>" class="inline-flex items-center space-x-2 text-[10px] font-black text-emerald-600 hover:text-emerald-700 uppercase tracking-wider transition-colors">
                  <i class="fas fa-envelope-open-text text-xs"></i>
                  <span>Lihat Halaman Pengumuman</span>
              </a>
          </div>
          <?php endif; ?>
      </div>
    </div>

    <!-- Date Info Removed -->
  </div>
</header>

<div class="p-8 max-w-6xl mx-auto w-full pb-20">

<?php if(isset($_GET['error']) && $_GET['error'] === 'not_editable'): ?>
<div class="mb-6 bg-white border border-red-200 shadow-lg rounded-2xl p-5 flex items-center space-x-4 animate-fadeUp">
  <div class="w-12 h-12 bg-red-50 text-red-500 rounded-xl flex items-center justify-center text-xl flex-shrink-0 shadow-sm">
    <i class="fas fa-lock"></i>
  </div>
  <div class="flex-1">
    <h4 class="font-black text-red-600 text-sm uppercase tracking-wide">Akses Terkunci!</h4>
    <p class="text-slate-500 text-xs mt-0.5 font-medium">Data pendaftaran Anda sedang dalam proses verifikasi atau sudah disetujui, sehingga tidak dapat diubah lagi kecuali admin meminta revisi.</p>
  </div>
</div>
<?php endif; ?>

<?php if(isset($_GET['success']) && in_array($_GET['success'], ['resubmitted', 'form_submitted'])): ?>
<div id="main-success-notif" class="mb-6 bg-white border border-emerald-200 shadow-lg rounded-2xl p-5 flex items-start sm:items-center space-x-4 animate-fadeUp relative transition-all duration-300">
  <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl flex-shrink-0 shadow-sm">
    <i class="fas fa-check-circle"></i>
  </div>
  <div class="flex-1 pr-8">
    <h4 class="font-black text-emerald-600 text-sm uppercase tracking-wide">Berhasil Dikirim!</h4>
    <p class="text-slate-500 text-xs mt-0.5 font-medium">
      <?php if($_GET['success'] === 'resubmitted'): ?>
        Data perbaikan pendaftaran Anda telah berhasil dikirim ulang ke panitia PPDB.
      <?php else: ?>
        Formulir dan dokumen pendaftaran berhasil dikirim. Saat ini data Anda sedang menunggu verifikasi admin.
      <?php endif; ?>
    </p>
  </div>
  <button onclick="closeSuccessNotif()" class="absolute top-5 right-5 w-8 h-8 flex items-center justify-center rounded-full bg-slate-50 text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
    <i class="fas fa-times"></i>
  </button>
</div>
<script>
function closeSuccessNotif() {
    const el = document.getElementById('main-success-notif');
    if(el) {
        el.style.opacity = '0';
        el.style.transform = 'translateY(-10px)';
        setTimeout(() => el.remove(), 300);
    }
    // Hapus parameter ?success dari URL agar notif tidak muncul lagi saat di-refresh
    if(window.history.replaceState) {
        const url = new URL(window.location.href);
        url.searchParams.delete('success');
        window.history.replaceState({path:url.href}, '', url.href);
    }
}
// Hilang otomatis setelah 7 detik
setTimeout(closeSuccessNotif, 7000);
</script>
<?php endif; ?>

<?php $status = $data['pendaftaran']['status'] ?? 'belum_mendaftar'; ?>

<!-- Welcome Banner -->
<div class="bg-[#E8F4EC] rounded-3xl p-8 lg:p-10 shadow-[0_8px_30px_rgba(0,0,0,0.04)] mb-8 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden">
  
  <!-- Decorative Elements Background -->
  <div class="absolute inset-0 pointer-events-none overflow-hidden">
      <!-- Soft Glowing Orbs -->
      <div class="absolute -top-20 -right-10 w-72 h-72 bg-white rounded-full blur-3xl opacity-60"></div>
      <div class="absolute -bottom-24 left-1/4 w-80 h-80 bg-emerald-200/30 rounded-full blur-3xl opacity-70"></div>
      
      <!-- Faint Educational Icons (Watermark) -->
      <i class="fas fa-book-open absolute top-6 left-[45%] text-6xl text-emerald-600/[0.03] -rotate-12"></i>
      <i class="fas fa-graduation-cap absolute bottom-4 left-[30%] text-7xl text-emerald-600/[0.03] rotate-12"></i>
      <i class="fas fa-star absolute top-10 right-[35%] text-3xl text-yellow-500/10 animate-pulse"></i>
      <i class="fas fa-pencil-alt absolute bottom-10 right-[42%] text-5xl text-emerald-600/[0.03] -rotate-12"></i>
      <i class="fas fa-atom absolute top-[30%] left-[55%] text-6xl text-emerald-600/[0.03] rotate-45"></i>
  </div>
  
  <div class="relative z-10 flex-1">
    <p class="text-emerald-800 font-bold text-lg mb-1">Assalamu'alaikum,</p>
    <?php
      $hour = (int)date('H');
      if ($hour >= 4 && $hour < 11) {
          $greeting = "Selamat Pagi";
      } elseif ($hour >= 11 && $hour < 15) {
          $greeting = "Selamat Siang";
      } elseif ($hour >= 15 && $hour < 18) {
          $greeting = "Selamat Sore";
      } else {
          $greeting = "Selamat Malam";
      }
    ?>
    <h2 class="text-emerald-950 font-black text-3xl lg:text-4xl mb-3">
      <?= $greeting ?>, <?= htmlspecialchars(explode(' ', trim($_SESSION['user_name'] ?? 'Calon Siswa'))[0]) ?>! <span class="inline-block animate-bounce">👋</span>
    </h2>
    <p class="text-emerald-800/80 font-semibold text-sm max-w-md leading-relaxed">
      Semangat melengkapi berkas hari ini, raih ilmu dan jadi anak shalih/shalihah yang membanggakan. 💚
    </p>
  </div>
  

  
</div>

<!-- 4 Info Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-10 animate-fadeUp delay-2" style="opacity:0">
    <!-- Card 1: Status -->
    <div class="bg-white rounded-[24px] border border-slate-100 p-5 shadow-sm flex items-center gap-5 card-hover">
        <div class="w-16 h-16 rounded-full bg-[#419864] text-white flex items-center justify-center text-2xl flex-shrink-0 shadow-md">
            <i class="fas fa-user-check"></i>
        </div>
        <div class="flex-1">
            <h4 class="font-bold text-slate-500 text-[11px] uppercase tracking-wider mb-0.5">Status Pendaftaran</h4>
            <p class="text-slate-800 font-black text-lg leading-tight mb-0"><?= $status == 'belum_mendaftar' ? 'Belum Daftar' : ucwords(str_replace('_', ' ', $status)) ?></p>
        </div>
    </div>
    
    <!-- Card 2: Panduan -->
    <div class="bg-white rounded-[24px] border border-slate-100 p-5 shadow-sm flex items-center gap-5 card-hover">
        <div class="w-16 h-16 rounded-full bg-[#3E8ED0] text-white flex items-center justify-center text-2xl flex-shrink-0 shadow-md">
            <i class="fas fa-book-open"></i>
        </div>
        <div class="flex-1">
            <h4 class="font-bold text-slate-500 text-[11px] uppercase tracking-wider mb-0.5">Panduan PPDB</h4>
            <p class="text-slate-800 font-black text-lg leading-tight mb-1">Cara Daftar</p>
            <?php if(!empty($data['panduan_ppdb'])): ?>
                <a href="<?= base_url($data['panduan_ppdb']) ?>" target="_blank" class="text-[10px] font-bold text-blue-500 hover:text-blue-600 transition-colors flex items-center mt-1 uppercase tracking-wider">Baca Panduan <i class="fas fa-chevron-right ml-1"></i></a>
            <?php else: ?>
                <span class="text-[10px] font-bold text-slate-400 flex items-center mt-1 uppercase tracking-wider">Belum Tersedia</span>
            <?php endif; ?>
        </div>
    </div>

    <!-- Card 3: Formulir -->
    <div class="bg-white rounded-[24px] border border-slate-100 p-5 shadow-sm flex items-center gap-5 card-hover">
        <div class="w-16 h-16 rounded-full bg-[#FFB82E] text-white flex items-center justify-center text-2xl flex-shrink-0 shadow-md">
            <i class="fas fa-clipboard-list"></i>
        </div>
        <div class="flex-1">
            <h4 class="font-bold text-slate-500 text-[11px] uppercase tracking-wider mb-0.5">Formulir Peserta</h4>
            <p class="text-slate-800 font-black text-lg leading-tight mb-1"><?= in_array($status, ['belum_mendaftar', 'perlu_revisi']) ? ($data['progress_percent'] == 100 ? 'Siap Kirim' : 'Belum Lengkap') : 'Selesai' ?></p>
            <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2">
                <div class="bg-[#FFB82E] h-1.5 rounded-full transition-all duration-700 ease-out" style="width: <?= in_array($status, ['belum_mendaftar', 'perlu_revisi']) ? $data['progress_percent'] . '%' : '100%' ?>"></div>
            </div>
        </div>
    </div>

    <!-- Card 4: Poin/Pengumuman -->
    <div class="bg-white rounded-[24px] border border-slate-100 p-5 shadow-sm flex items-center gap-5 card-hover">
        <div class="w-16 h-16 rounded-full bg-[#9B51E0] text-white flex items-center justify-center text-2xl flex-shrink-0 shadow-md">
            <i class="fas fa-bullhorn"></i>
        </div>
        <div class="flex-1">
            <h4 class="font-bold text-slate-500 text-[11px] uppercase tracking-wider mb-0.5">Pengumuman</h4>
            <p class="text-slate-800 font-black text-lg leading-tight mb-1">Hasil Seleksi</p>
            <a href="<?= base_url('student/pengumuman') ?>" class="text-[10px] font-bold text-purple-500 flex items-center mt-1 uppercase tracking-wider">Cek hasil sekarang <i class="fas fa-chevron-right ml-1"></i></a>
        </div>
    </div>
</div>

<!-- Status & Catatan -->
<?php 
$status = $data['pendaftaran']['status'] ?? 'belum_mendaftar'; 
$catatan = $data['pendaftaran']['catatan'] ?? '';
$revisi_json_raw = $data['pendaftaran']['revisi_json'] ?? '';
$revisi_items = !empty($revisi_json_raw) ? (json_decode($revisi_json_raw, true) ?: []) : [];

$configs = [
  'belum_mendaftar'   => ['text'=>'Belum Mendaftar / Draft','bg'=>'bg-slate-50','border'=>'border-slate-200','text_color'=>'text-slate-600','icon'=>'fa-edit','icon_bg'=>'bg-slate-100 text-slate-500'],
  'nunggu_verifikasi' => ['text'=>'Menunggu Verifikasi Admin','bg'=>'bg-amber-50/60','border'=>'border-amber-200/80','text_color'=>'text-amber-700','icon'=>'fa-clock','icon_bg'=>'bg-amber-100 text-amber-600'],
  'dokumen_diterima'  => ['text'=>'Formulir & Dokumen Diterima','bg'=>'bg-emerald-50/60','border'=>'border-emerald-200/80','text_color'=>'text-emerald-800','icon'=>'fa-check-circle','icon_bg'=>'bg-emerald-100 text-emerald-600'],
  'diterima'          => ['text'=>'Selamat! Anda Diterima','bg'=>'bg-emerald-50/60','border'=>'border-emerald-300/80','text_color'=>'text-emerald-800','icon'=>'fa-check-circle','icon_bg'=>'bg-emerald-100 text-emerald-600'],
  'ditolak'           => ['text'=>'Hasil Seleksi Tersedia','bg'=>'bg-rose-50/60','border'=>'border-rose-200/80','text_color'=>'text-rose-700','icon'=>'fa-times-circle','icon_bg'=>'bg-rose-100 text-rose-600'],
  'nunggu_pengumuman' => ['text'=>'Formulir & Dokumen Diterima','bg'=>'bg-emerald-50/60','border'=>'border-emerald-200/80','text_color'=>'text-emerald-800','icon'=>'fa-check-circle','icon_bg'=>'bg-emerald-100 text-emerald-600'],
  'perlu_revisi'      => ['text'=>'Perlu Revisi Data/Berkas','bg'=>'bg-red-50/60','border'=>'border-red-300/80','text_color'=>'text-red-700','icon'=>'fa-exclamation-triangle','icon_bg'=>'bg-red-100 text-red-600']
];
$c = $configs[$status] ?? $configs['belum_mendaftar'];
?>

<?php if($status === 'dokumen_diterima'): ?>
<!-- ═══════════ ACCEPTED / TEST SCHEDULE CARD ═══════════ -->
<div class="mb-8 animate-fadeUp delay-1" style="opacity:0">
  <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-[3px] shadow-lg overflow-hidden">
    <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-[20px] p-6 lg:p-8 relative overflow-hidden h-full flex flex-col justify-center">
      <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
      <i class="fas fa-calendar-check absolute -bottom-6 -right-6 text-8xl text-white/10 -rotate-12"></i>
      
      <div class="relative z-10 flex items-start gap-4">
        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white text-xl shrink-0 border border-white/30">
          <i class="<?= ($data['pendaftaran']['absensi_tes'] ?? '') === 'hadir' ? 'fas fa-check' : 'fas fa-info' ?>"></i>
        </div>
        <div>
          <h3 class="text-white font-black text-xl lg:text-2xl mb-2 drop-shadow-md">
            <?= ($data['pendaftaran']['absensi_tes'] ?? '') === 'hadir' ? 'Tes Telah Selesai!' : 'Panggilan Tes Baca Tulis' ?>
          </h3>
          
          <?php if(($data['pendaftaran']['absensi_tes'] ?? '') === 'hadir'): ?>
              <p class="text-blue-50 text-sm lg:text-base leading-relaxed mb-4">
                Terima kasih telah hadir dan mengikuti <strong>Tes Baca Tulis & Wawancara</strong>. Tahapan tes Anda telah selesai.
              </p>
              <div class="bg-emerald-500/40 border border-emerald-400/30 rounded-xl p-4 text-xs lg:text-sm font-medium text-emerald-50 flex items-start gap-3">
                <i class="fas fa-clock text-lg text-emerald-300 shrink-0 mt-0.5"></i>
                <p class="leading-relaxed">Silakan menunggu pengumuman hasil seleksi (Lulus/Tidak Lulus) yang akan segera dirilis oleh panitia melalui dashboard ini.</p>
              </div>
          <?php else: ?>
              <p class="text-blue-50 text-sm lg:text-base leading-relaxed mb-4">
                Selamat! Berkas pendaftaran Anda telah diverifikasi oleh admin. Langkah selanjutnya adalah mengikuti <strong>Tes Baca Tulis & Wawancara</strong> secara langsung (offline) di sekolah pada jadwal berikut:
              </p>
              <div class="inline-block px-5 py-2.5 bg-white/20 rounded-xl font-bold border border-white/30 shadow-inner mb-5">
                <i class="fas fa-calendar-alt mr-2 text-blue-200"></i> <?= htmlspecialchars($data['jadwal_tes'] ?? 'Menunggu Info Admin') ?>
              </div>
              <div class="bg-blue-900/40 border border-blue-400/30 rounded-xl p-4 text-xs lg:text-sm font-medium text-blue-100 flex items-start gap-3">
                <i class="fas fa-exclamation-circle text-lg text-amber-300 shrink-0 mt-0.5"></i>
                <p class="leading-relaxed"><strong>Penting:</strong> Anda <u>WAJIB</u> mengunduh dan mencetak <a href="<?= base_url('student/cetak') ?>" target="_blank" class="text-white font-bold underline decoration-blue-400 hover:text-blue-200">Formulir Peserta</a>, lalu membawanya saat datang ke sekolah untuk tes. Hasil seleksi (Lulus/Tidak Lulus) akan diumumkan setelah proses tes ini selesai.</p>
              </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>


<?php if($status === 'perlu_revisi' && !empty($revisi_items)): ?>
<!-- ═══════════ REVISION WARNING CARD ═══════════ -->
<?php
  $revisi_labels = [
    'pribadi'  => ['label'=>'Formulir Biodata Pribadi', 'icon'=>'fa-user', 'link'=>'student/form'],
    'ortu'     => ['label'=>'Data Orang Tua / Wali', 'icon'=>'fa-users', 'link'=>'student/form'],
    'ijazah'   => ['label'=>'Berkas Ijazah / SKL', 'icon'=>'fa-file-alt', 'link'=>'student/form'],
    'kk'       => ['label'=>'Berkas Kartu Keluarga', 'icon'=>'fa-id-card', 'link'=>'student/form'],
    'akta'     => ['label'=>'Berkas Akta Kelahiran', 'icon'=>'fa-file-contract', 'link'=>'student/form'],
    'foto_3x4' => ['label'=>'Pas Foto 3x4', 'icon'=>'fa-camera', 'link'=>'student/form']
  ];
?>
<div class="mb-8 animate-fadeUp delay-1" style="opacity:0">
  <div class="bg-white rounded-2xl border-2 border-red-300 shadow-lg overflow-hidden pulse-glow">
    <div class="px-6 py-4 bg-gradient-to-r from-red-600 to-rose-600 flex items-center space-x-3">
      <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
        <i class="fas fa-exclamation-triangle text-white text-lg animate-pulse"></i>
      </div>
      <div>
        <h4 class="text-white font-black text-sm uppercase tracking-wide">Revisi Diperlukan!</h4>
        <p class="text-red-200 text-[10px] font-bold">Perbaiki data/berkas berikut, lalu kirim ulang pendaftaran Anda.</p>
      </div>
    </div>
    <div class="p-6 space-y-3">
      <?php foreach($revisi_items as $key => $note):
        $info = $revisi_labels[$key] ?? ['label'=>$key,'icon'=>'fa-file','link'=>'student'];
      ?>
      <div class="flex items-start p-4 bg-red-50/60 border border-red-200 rounded-xl">
        <div class="w-9 h-9 bg-red-100 text-red-600 rounded-lg flex items-center justify-center text-sm mr-4 mt-0.5 flex-shrink-0">
          <i class="fas <?= $info['icon'] ?>"></i>
        </div>
        <div class="flex-1 min-w-0">
          <p class="font-bold text-red-800 text-sm"><?= $info['label'] ?></p>
          <?php if(!empty($note)): ?>
          <p class="text-xs text-red-600/80 mt-1 font-medium italic"><i class="fas fa-comment-dots mr-1"></i> <?= htmlspecialchars($note) ?></p>
          <?php endif; ?>
        </div>
        <a href="<?= base_url($info['link']) ?>" class="ml-3 px-3 py-1.5 bg-red-100 text-red-700 text-[10px] font-bold uppercase rounded-lg hover:bg-red-200 transition-colors flex-shrink-0">
          <i class="fas fa-pencil-alt mr-1"></i>Perbaiki
        </a>
      </div>
      <?php endforeach; ?>
      
      <?php if(!empty($catatan)): ?>
      <div class="mt-3 p-4 bg-amber-50 border border-amber-200 rounded-xl">
        <p class="text-[10px] font-black text-amber-600 uppercase tracking-wider mb-1"><i class="fas fa-sticky-note mr-1"></i>Catatan Umum dari Admin</p>
        <p class="text-sm text-amber-800 font-medium italic"><?= htmlspecialchars($catatan) ?></p>
      </div>
      <?php endif; ?>
      
      <!-- Kirim Ulang Button -->
      <form action="<?= base_url('student/kirim_ulang_pendaftaran') ?>" method="POST" class="pt-3">
        <button type="submit" onclick="return confirm('Sudah yakin semua data dan dokumen revisi diperbaiki dengan benar? Klik OK untuk mengirim ulang ke panitia.')" class="w-full py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-sm font-black rounded-xl uppercase tracking-widest hover:from-emerald-700 hover:to-teal-700 transition-all shadow-lg shadow-emerald-200">
          <i class="fas fa-paper-plane mr-2"></i>Kirim Ulang Pendaftaran
        </button>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8 animate-fadeUp delay-2" style="opacity:0">
  <!-- Column 1: Alur Pendaftaran -->
  <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm">
      <div class="flex items-center justify-between mb-6">
          <div class="flex items-center space-x-3">
              <i class="fas fa-list-ol text-[#419864] bg-[#E8F4EC] p-2 rounded-lg"></i>
              <h4 class="font-bold text-slate-800 text-[15px]">Alur Pendaftaran</h4>
          </div>
      </div>
      <div class="space-y-4">
          <div class="flex items-center space-x-4">
              <div class="w-8 h-8 rounded-full <?= $status != 'belum_mendaftar' ? 'bg-[#419864] text-white' : 'bg-slate-100 text-slate-400' ?> flex items-center justify-center text-sm font-bold flex-shrink-0">1</div>
              <div class="flex-1">
                  <p class="text-sm font-bold text-slate-800">Isi Formulir</p>
              </div>
              <p class="text-[10px] <?= $status != 'belum_mendaftar' ? 'text-emerald-600 font-bold' : 'text-slate-400' ?>"><?= $status != 'belum_mendaftar' ? 'Sudah diisi' : 'Belum' ?></p>
          </div>
          <div class="flex items-center space-x-4">
              <div class="w-8 h-8 rounded-full <?= in_array($status, ['nunggu_verifikasi', 'dokumen_diterima', 'diterima', 'ditolak', 'nunggu_pengumuman']) ? 'bg-[#419864] text-white' : 'bg-slate-100 text-slate-400' ?> flex items-center justify-center text-sm font-bold flex-shrink-0">2</div>
              <div class="flex-1">
                  <p class="text-sm font-bold text-slate-800">Upload Berkas</p>
              </div>
              <p class="text-[10px] <?= in_array($status, ['nunggu_verifikasi', 'dokumen_diterima', 'diterima', 'ditolak', 'nunggu_pengumuman']) ? 'text-emerald-600 font-bold' : 'text-slate-400' ?>"><?= in_array($status, ['nunggu_verifikasi', 'dokumen_diterima', 'diterima', 'ditolak', 'nunggu_pengumuman']) ? 'Sudah diunggah' : 'Belum' ?></p>
          </div>
          <div class="flex items-center space-x-4">
              <div class="w-8 h-8 rounded-full <?= in_array($status, ['dokumen_diterima', 'diterima', 'ditolak', 'nunggu_pengumuman']) ? 'bg-[#419864] text-white' : 'bg-slate-100 text-slate-400' ?> flex items-center justify-center text-sm font-bold flex-shrink-0">3</div>
              <div class="flex-1">
                  <p class="text-sm font-bold text-slate-800">Verifikasi Panitia</p>
              </div>
              <p class="text-[10px] <?= in_array($status, ['dokumen_diterima', 'diterima', 'ditolak', 'nunggu_pengumuman']) ? 'text-emerald-600 font-bold' : ($status == 'belum_mendaftar' ? 'text-slate-400' : 'text-amber-500 font-bold') ?>"><?= $status == 'belum_mendaftar' ? 'Menunggu' : (in_array($status, ['nunggu_verifikasi', 'perlu_revisi']) ? 'Proses Cek' : 'Selesai diverifikasi') ?></p>
          </div>
          <div class="flex items-center space-x-4">
              <div class="w-8 h-8 rounded-full <?= in_array($status, ['nunggu_pengumuman', 'diterima', 'ditolak']) ? 'bg-[#419864] text-white' : 'bg-slate-100 text-slate-400' ?> flex items-center justify-center text-sm font-bold flex-shrink-0">4</div>
              <div class="flex-1">
                  <p class="text-sm font-bold text-slate-800">Tes Baca Tulis</p>
              </div>
              <p class="text-[10px] font-bold <?= in_array($status, ['nunggu_pengumuman', 'diterima', 'ditolak']) ? 'text-slate-400' : 'text-[#419864]' ?>"><?= in_array($status, ['nunggu_pengumuman', 'diterima', 'ditolak']) ? 'Selesai' : 'Datang langsung' ?></p>
          </div>
          <div class="flex items-center space-x-4">
              <div class="w-8 h-8 rounded-full <?= in_array($status, ['diterima', 'ditolak']) ? 'bg-[#419864] text-white' : 'bg-slate-100 text-slate-400' ?> flex items-center justify-center text-sm font-bold flex-shrink-0">5</div>
              <div class="flex-1">
                  <p class="text-sm font-bold text-slate-800">Pengumuman</p>
              </div>
              <p class="text-[10px] text-slate-400"><?= in_array($status, ['diterima', 'ditolak']) ? 'Selesai' : 'Menunggu' ?></p>
          </div>
          <div class="flex items-center space-x-4">
              <div class="w-8 h-8 rounded-full <?= $status === 'diterima' ? 'bg-[#419864] text-white' : 'bg-slate-100 text-slate-400' ?> flex items-center justify-center text-sm font-bold flex-shrink-0">6</div>
              <div class="flex-1">
                  <p class="text-sm font-bold text-slate-800">Daftar Ulang</p>
              </div>
              <p class="text-[10px] font-bold <?= $status === 'diterima' ? 'text-emerald-600' : 'text-[#419864]' ?>"><?= $status === 'diterima' ? 'Selesai' : 'Datang langsung' ?></p>
          </div>
      </div>
      <div class="mt-6 bg-[#E8F4EC] rounded-xl p-3 flex items-center space-x-2">
          <i class="fas fa-smile text-[#FFB82E]"></i>
          <p class="text-xs text-[#419864] font-semibold">Ikuti alur dengan tertib ya!</p>
      </div>
  </div>

  <!-- Column 2: Dokumen Persyaratan -->
  <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm">
      <div class="flex items-center justify-between mb-6">
          <div class="flex items-center space-x-3">
              <i class="fas fa-folder-open text-[#3E8ED0] bg-blue-50 p-2 rounded-lg"></i>
              <h4 class="font-bold text-slate-800 text-[15px]">Dokumen Persyaratan</h4>
          </div>
          <a href="<?= base_url('student/form') ?>" class="text-[10px] text-[#419864] font-bold uppercase">Upload</a>
      </div>
      <div class="space-y-4">
          <div class="flex items-start space-x-4 bg-slate-50 p-3 rounded-xl border border-slate-100">
              <div class="w-8 h-8 rounded-lg bg-red-100 text-red-500 flex items-center justify-center text-sm flex-shrink-0"><i class="fas fa-id-card"></i></div>
              <div class="flex-1">
                  <p class="text-sm font-bold text-slate-800">Kartu Keluarga</p>
                  <p class="text-[10px] text-slate-400 mt-0.5">Wajib diunggah</p>
              </div>
          </div>
          <div class="flex items-start space-x-4 bg-slate-50 p-3 rounded-xl border border-slate-100">
              <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-500 flex items-center justify-center text-sm flex-shrink-0"><i class="fas fa-file-contract"></i></div>
              <div class="flex-1">
                  <p class="text-sm font-bold text-slate-800">Akta Kelahiran</p>
                  <p class="text-[10px] text-slate-400 mt-0.5">Wajib diunggah</p>
              </div>
          </div>
          <div class="flex items-start space-x-4 bg-slate-50 p-3 rounded-xl border border-slate-100">
              <div class="w-8 h-8 rounded-lg bg-[#419864]/20 text-[#419864] flex items-center justify-center text-sm flex-shrink-0"><i class="fas fa-image"></i></div>
              <div class="flex-1">
                  <p class="text-sm font-bold text-slate-800">Pas Foto 3x4</p>
                  <p class="text-[10px] text-slate-400 mt-0.5">Latar merah/biru</p>
              </div>
          </div>
          <div class="flex items-start space-x-4 bg-slate-50 p-3 rounded-xl border border-slate-100">
              <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-500 flex items-center justify-center text-sm flex-shrink-0"><i class="fas fa-graduation-cap"></i></div>
              <div class="flex-1">
                  <p class="text-sm font-bold text-slate-800">Ijasah / SKL</p>
                  <p class="text-[10px] text-slate-400 mt-0.5">Wajib diunggah</p>
              </div>
          </div>
      </div>
  </div>

  <!-- Column 3: Pengumuman / Catatan Panitia -->
  <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm">
      <div class="flex items-center justify-between mb-6">
          <div class="flex items-center space-x-3">
              <i class="fas fa-bullhorn text-[#FFB82E] bg-yellow-50 p-2 rounded-lg"></i>
              <h4 class="font-bold text-slate-800 text-[15px]">Pesan Panitia</h4>
          </div>
      </div>
      <div class="space-y-4">
          <?php if(in_array($status, ['dokumen_diterima', 'nunggu_pengumuman'])): ?>
          <?php
            $release_time_raw = (new Settings_model())->getSetting('release_announcement_datetime');
            $release_ts = strtotime($release_time_raw);
          ?>
          <div class="bg-gradient-to-br from-emerald-50 to-teal-50 border border-emerald-100 rounded-xl p-4 shadow-sm text-center">
              <div class="inline-flex items-center px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full mb-3 text-[10px] font-bold uppercase tracking-wider">
                  <i class="fas fa-clock mr-1.5 animate-pulse"></i> Menunggu Pengumuman
              </div>
              <p class="text-[11px] text-emerald-700 font-medium mb-3">Rilis pada: <br><span class="font-bold text-emerald-900"><?= date('d F Y, H:i', $release_ts) ?> WIB</span></p>
              
              <div class="grid grid-cols-4 gap-2" id="countdown-grid">
                  <div class="bg-white border border-emerald-100 shadow-sm rounded-lg p-2 text-center">
                      <div class="text-base font-black text-emerald-600" id="cd-days">--</div>
                      <div class="text-[8px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Hari</div>
                  </div>
                  <div class="bg-white border border-emerald-100 shadow-sm rounded-lg p-2 text-center">
                      <div class="text-base font-black text-emerald-600" id="cd-hours">--</div>
                      <div class="text-[8px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Jam</div>
                  </div>
                  <div class="bg-white border border-emerald-100 shadow-sm rounded-lg p-2 text-center">
                      <div class="text-base font-black text-emerald-600" id="cd-mins">--</div>
                      <div class="text-[8px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Mnt</div>
                  </div>
                  <div class="bg-white border border-emerald-100 shadow-sm rounded-lg p-2 text-center">
                      <div class="text-base font-black text-emerald-600" id="cd-secs">--</div>
                      <div class="text-[8px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Dtk</div>
                  </div>
              </div>
          </div>
          <script>
          (function(){
            const target = <?= $release_ts ?> * 1000;
            function tick(){
              const now = Date.now();
              let diff = Math.max(0, Math.floor((target - now)/1000));
              if(diff <= 0){ 
                  document.getElementById('countdown-grid').innerHTML = '<div class="col-span-4 bg-emerald-100 p-3 rounded-lg text-emerald-800 font-bold text-[12px]">Waktu telah tiba! Menunggu panitia merilis hasil...</div>';
                  return; 
              }
              const d = Math.floor(diff/86400); diff %= 86400;
              const h = Math.floor(diff/3600);  diff %= 3600;
              const m = Math.floor(diff/60);
              const s = diff % 60;
              document.getElementById('cd-days').textContent = String(d).padStart(2,'0');
              document.getElementById('cd-hours').textContent = String(h).padStart(2,'0');
              document.getElementById('cd-mins').textContent  = String(m).padStart(2,'0');
              document.getElementById('cd-secs').textContent  = String(s).padStart(2,'0');
            }
            tick();
            setInterval(tick, 1000);
          })();
          </script>
          
          <?php elseif($catatan): ?>
          <div class="bg-amber-50 rounded-xl p-4 border border-amber-100 flex items-start space-x-3">
              <i class="fas fa-quote-left text-amber-300 text-lg mt-1"></i>
              <div>
                  <p class="text-sm text-amber-800 font-semibold mb-1">Catatan Verifikasi</p>
                  <p class="text-xs text-amber-700/80 leading-relaxed"><?= htmlspecialchars($catatan) ?></p>
              </div>
          </div>
          <?php else: ?>
          <div class="bg-[#E8F4EC] rounded-xl p-4 border border-emerald-100 flex items-start space-x-3">
              <i class="fas fa-info-circle text-[#419864] text-lg mt-1"></i>
              <div>
                  <p class="text-sm text-emerald-800 font-semibold mb-1">Tidak ada catatan</p>
                  <p class="text-xs text-emerald-700/80 leading-relaxed">
                      <?= in_array($status, ['diterima', 'ditolak']) ? 'Pendaftaran Anda telah selesai diproses.' : 'Pendaftaran Anda sedang dalam proses atau belum diverifikasi panitia.' ?>
                  </p>
              </div>
          </div>
          <?php endif; ?>
          
          <a href="https://wa.me/6282225600522?text=Assalamualaikum%20saya%20mengalami%20kendala%20bisa%20bantu%20saya" target="_blank" class="block bg-blue-50 hover:bg-blue-100 rounded-xl p-4 border border-blue-200 flex items-start space-x-3 mt-4 transition-colors cursor-pointer group shadow-sm">
              <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white flex-shrink-0 mt-0.5 group-hover:bg-blue-700 transition-colors shadow-sm">
                  <i class="fab fa-whatsapp text-xl"></i>
              </div>
              <div>
                  <p class="text-sm text-blue-900 font-bold mb-1">Butuh Bantuan?</p>
                  <p class="text-[11px] text-blue-700 font-medium leading-relaxed">Klik untuk chat Admin PPDB via WhatsApp jika Anda mengalami kendala pendaftaran.</p>
              </div>
          </a>
      </div>
  </div>
</div>

<!-- Doa Harian Removed -->





</div>
</main>

<script>
function toggleNotif() {
    const panel = document.getElementById('notif-panel');
    panel.classList.toggle('hidden');
    
    // Sembunyikan badge angka (tanda sudah dibaca) dan matikan animasi lonceng
    const badge = document.getElementById('notif-badge');
    if (badge) badge.style.display = 'none';
    
    const icon = document.getElementById('notif-icon');
    if (icon) icon.classList.remove('animate-bounce', 'text-emerald-600');
}
// Close when clicking outside
document.addEventListener('click', function(e) {
    const wrapper = document.getElementById('notif-wrapper');
    if (wrapper && !wrapper.contains(e.target)) {
        document.getElementById('notif-panel')?.classList.add('hidden');
    }
});
</script>
</body></html>
