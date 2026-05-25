<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Siswa | PPDB MI Nurul Ikhlas Al-Ayubi</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
body{font-family:'Plus Jakarta Sans',sans-serif;background:#f1f5f9}
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
<header class="bg-white/80 backdrop-blur-md px-8 py-5 border-b border-slate-200/60 flex justify-between items-center sticky top-0 z-10">
  <div>
    <h2 class="text-xl font-black text-slate-800 tracking-tight">DASHBOARD</h2>
    <p class="text-[11px] text-slate-400 font-bold uppercase tracking-[0.15em] mt-0.5">Panel Calon Peserta Didik Baru</p>
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
    } elseif ($reg_status === 'nunggu_pengumuman') {
        $notifs[] = ['type'=>'info','icon'=>'fa-check-double','color'=>'text-blue-500','msg'=>'Dokumen diterima! Menunggu jadwal rilis pengumuman resmi.','link'=>'student/pengumuman'];
    } elseif ($reg_status === 'dokumen_diterima') {
        $notifs[] = ['type'=>'info','icon'=>'fa-check-double','color'=>'text-blue-500','msg'=>'Formulir & dokumen Anda sudah diterima panitia. Menunggu pengumuman kelulusan.','link'=>'student/pengumuman'];
    } elseif ($reg_status === 'perlu_revisi') {
        $notifs[] = ['type'=>'error','icon'=>'fa-exclamation-triangle','color'=>'text-red-500','msg'=>'Data/berkas Anda perlu direvisi! Segera perbaiki.','link'=>'student'];
    }
    if (!empty($reg_catatan) && $reg_status === 'nunggu_verifikasi') {
        $notifs[] = ['type'=>'warning','icon'=>'fa-exclamation-circle','color'=>'text-amber-500','msg'=>'Admin memberi catatan: Periksa dokumen Anda!','link'=>'student/upload'];
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

    <!-- Date Info -->
    <div class="text-right border-l border-slate-200/80 pl-6 hidden sm:block">
      <p class="text-xs font-bold text-slate-500"><?= date('l, d F Y') ?></p>
      <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest mt-0.5">TA 2026/2027</p>
    </div>
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

<?php if(isset($_GET['success']) && $_GET['success'] === 'resubmitted'): ?>
<div class="mb-6 bg-white border border-emerald-200 shadow-lg rounded-2xl p-5 flex items-center space-x-4 animate-fadeUp">
  <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl flex-shrink-0 shadow-sm">
    <i class="fas fa-paper-plane"></i>
  </div>
  <div class="flex-1">
    <h4 class="font-black text-emerald-600 text-sm uppercase tracking-wide">Berhasil Dikirim!</h4>
    <p class="text-slate-500 text-xs mt-0.5 font-medium">Data perbaikan pendaftaran Anda telah berhasil dikirim ulang ke panitia PPDB.</p>
  </div>
</div>
<?php endif; ?>

<?php $status = $data['pendaftaran']['status'] ?? 'belum_mendaftar'; ?>

<!-- Welcome Banner -->
<div class="bg-gradient-to-br from-emerald-600 to-teal-800 rounded-3xl border border-emerald-500/30 p-8 lg:p-12 shadow-xl shadow-emerald-900/10 mb-8 animate-fadeUp delay-1 text-center sm:text-left relative overflow-hidden" style="opacity:0">
  <div class="absolute inset-0 opacity-30 pointer-events-none">
    <div class="absolute top-0 right-0 w-80 h-80 bg-emerald-400 rounded-full blur-[80px] -translate-y-1/2 translate-x-1/3"></div>
    <div class="absolute bottom-0 left-10 w-64 h-64 bg-teal-400 rounded-full blur-[60px] translate-y-1/2 -translate-x-1/4"></div>
  </div>
  <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-10">
    <div class="flex-1 max-w-2xl">
      <h2 class="text-emerald-100 font-bold text-xl lg:text-2xl mb-3 tracking-tight">Hi, Calon Siswa!</h2>
      <h3 class="text-white font-black text-2xl lg:text-3xl mb-5 tracking-tight leading-tight">
        Selamat datang di PPDB Online<br>MI Nurul Ikhlas Al-Ayubi
      </h3>
      <p class="text-emerald-50/90 text-sm font-medium mb-8 leading-relaxed">
        Tahun Ajaran 2026/2027 telah dibuka. Segera daftarkan putra/putri Anda untuk mendapatkan pendidikan berkualitas berbasis nilai-nilai Islam.
      </p>
      <div class="flex flex-col sm:flex-row items-center gap-4">
        <a href="<?= base_url('student/form') ?>" class="inline-flex items-center justify-center px-7 py-3.5 bg-white text-emerald-800 hover:bg-emerald-50 hover:text-emerald-900 rounded-xl text-sm font-bold shadow-lg transition-all transform hover:-translate-y-0.5 min-w-[180px]">
          <i class="fas fa-user-plus mr-3 text-lg text-emerald-600"></i> Daftar Sekarang
        </a>
        <a href="<?= base_url('home/panduan') ?>" target="_blank" class="inline-flex items-center justify-center px-7 py-3.5 bg-emerald-900/30 hover:bg-emerald-900/50 text-white border border-emerald-400/40 rounded-xl text-sm font-bold shadow-md transition-all transform hover:-translate-y-0.5 backdrop-blur-sm min-w-[180px]">
          <i class="fas fa-book-open mr-3 text-lg text-emerald-300"></i> Panduan PPDB
        </a>
      </div>
    </div>
    
    <!-- Right Illustration -->
    <div class="hidden lg:flex w-64 h-64 relative items-center justify-center">
       <div class="absolute inset-0 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
       <i class="fas fa-graduation-cap text-[130px] text-white drop-shadow-2xl z-10 transform -rotate-12 hover:rotate-0 transition-transform duration-500"></i>
       <i class="fas fa-book-open text-6xl text-emerald-300 absolute bottom-4 right-0 drop-shadow-lg transform rotate-12 z-20"></i>
       <i class="fas fa-star text-4xl text-yellow-300 absolute top-0 left-0 drop-shadow-lg animate-bounce z-20"></i>
       <i class="fas fa-pencil-alt text-5xl text-teal-200 absolute top-10 right-0 drop-shadow-lg transform rotate-45 z-0 opacity-60"></i>
    </div>
  </div>
</div>

<!-- 3 Info Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 animate-fadeUp delay-2" style="opacity:0">
    <!-- Card 1: Jadwal -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex items-start gap-4 card-hover">
        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl flex-shrink-0">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <div>
            <h4 class="font-bold text-slate-800 text-sm mb-1">Jadwal Pendaftaran</h4>
            <p class="text-xs text-slate-500 font-medium mb-3"><?= htmlspecialchars($data['jadwal_daftar'] ?? '01 Mar - 30 Jun 2026') ?></p>
            <span class="inline-block px-3 py-1 bg-blue-50 border border-blue-100 text-blue-600 text-[10px] font-bold uppercase tracking-wider rounded-lg">Sedang Berlangsung</span>
        </div>
    </div>
    
    <!-- Card 2: Formulir Peserta -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex items-start gap-4 card-hover">
        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl flex-shrink-0">
            <i class="fas fa-file-contract"></i>
        </div>
        <div>
            <h4 class="font-bold text-slate-800 text-sm mb-1">Formulir Peserta</h4>
            <p class="text-xs text-slate-500 font-medium mb-3">Unduh bukti pendaftaran Anda</p>
            <?php if(in_array($status, ['dokumen_diterima', 'nunggu_pengumuman', 'diterima', 'ditolak'])): ?>
            <a href="<?= base_url('student/cetak') ?>" target="_blank" class="inline-block px-3 py-1 bg-purple-50 border border-purple-100 text-purple-600 text-[10px] font-bold uppercase tracking-wider rounded-lg transition-colors hover:bg-purple-100"><i class="fas fa-print mr-1"></i> Cetak Formulir</a>
            <?php else: ?>
            <span class="inline-block px-3 py-1 bg-slate-50 border border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider rounded-lg"><i class="fas fa-lock mr-1"></i> Belum Tersedia</span>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Card 3: Status -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex items-start gap-4 card-hover">
        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl flex-shrink-0">
            <i class="fas fa-info-circle"></i>
        </div>
        <div>
            <h4 class="font-bold text-slate-800 text-sm mb-1">Status Pendaftaran</h4>
            <p class="text-xs text-slate-500 font-medium mb-3">Cek status pendaftaran Anda</p>
            <a href="#status-panel" class="inline-block px-2 py-1 bg-transparent text-emerald-600 hover:text-emerald-700 text-[11px] font-bold uppercase tracking-wider transition-colors"><i class="fas fa-arrow-right mr-1"></i> Cek Status</a>
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
<!-- ═══════════ TES BACA TULIS NOTIFICATION ═══════════ -->
<div class="mb-8 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-6 lg:p-8 shadow-xl shadow-blue-900/10 text-white relative overflow-hidden animate-fadeUp delay-1">
  <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4 pointer-events-none"></div>
  <div class="relative z-10 flex flex-col md:flex-row items-center gap-6">
    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center text-3xl shrink-0 backdrop-blur-sm border border-white/30">
      <i class="fas fa-clipboard-check"></i>
    </div>
    <div class="flex-1 w-full">
      <h3 class="text-xl font-black mb-2 tracking-wide">PANGGILAN TES BACA TULIS</h3>
      <p class="text-blue-50 text-sm leading-relaxed mb-4">
        Selamat! Berkas pendaftaran Anda telah diverifikasi oleh admin. Langkah selanjutnya adalah mengikuti <strong>Tes Baca Tulis & Wawancara</strong> secara langsung (offline) di sekolah pada jadwal berikut:
      </p>
      <div class="inline-block px-5 py-2.5 bg-white/20 rounded-xl font-bold border border-white/30 shadow-inner mb-5">
        <i class="fas fa-calendar-alt mr-2 text-blue-200"></i> <?= htmlspecialchars($data['jadwal_tes'] ?? 'Menunggu Info Admin') ?>
      </div>
      <div class="bg-blue-900/40 border border-blue-400/30 rounded-xl p-4 text-xs lg:text-sm font-medium text-blue-100 flex items-start gap-3">
        <i class="fas fa-exclamation-circle text-lg text-amber-300 shrink-0 mt-0.5"></i>
        <p class="leading-relaxed"><strong>Penting:</strong> Anda <u>WAJIB</u> mengunduh dan mencetak <a href="<?= base_url('student/cetak') ?>" target="_blank" class="text-white font-bold underline decoration-blue-400 hover:text-blue-200">Formulir Peserta</a>, lalu membawanya saat datang ke sekolah untuk tes. Hasil seleksi (Lulus/Tidak Lulus) akan diumumkan setelah proses tes ini selesai.</p>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<?php if($status === 'nunggu_pengumuman'): ?>
<!-- ═══════════ COUNTDOWN CARD ═══════════ -->
<?php
  $release_time_raw = (new Settings_model())->getSetting('release_announcement_datetime');
  $release_ts = strtotime($release_time_raw);
?>
<div class="mb-8 animate-fadeUp delay-1" style="opacity:0">
  <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-6 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
    <div class="flex-1 text-center md:text-left">
      <div class="inline-flex items-center px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full mb-3 text-[10px] font-bold uppercase tracking-wider">
        <i class="fas fa-clock mr-1.5 animate-pulse"></i> Menunggu Pengumuman
      </div>
      <h3 class="text-lg font-black text-emerald-900 mb-1">Pengumuman Segera Dirilis</h3>
      <p class="text-emerald-700 text-xs font-medium">Hasil seleksi akan diumumkan pada: <span class="font-bold"><?= date('d F Y, H:i', $release_ts) ?> WIB</span></p>
    </div>
    
    <!-- Countdown Timer -->
    <div class="flex gap-3" id="countdown-grid">
      <div class="bg-white border border-emerald-100 shadow-sm rounded-xl p-3 w-16 text-center">
        <div class="text-xl font-black text-emerald-600" id="cd-days">--</div>
        <div class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Hari</div>
      </div>
      <div class="bg-white border border-emerald-100 shadow-sm rounded-xl p-3 w-16 text-center">
        <div class="text-xl font-black text-emerald-600" id="cd-hours">--</div>
        <div class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Jam</div>
      </div>
      <div class="bg-white border border-emerald-100 shadow-sm rounded-xl p-3 w-16 text-center">
        <div class="text-xl font-black text-emerald-600" id="cd-mins">--</div>
        <div class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Mnt</div>
      </div>
      <div class="bg-white border border-emerald-100 shadow-sm rounded-xl p-3 w-16 text-center">
        <div class="text-xl font-black text-emerald-600" id="cd-secs">--</div>
        <div class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Dtk</div>
      </div>
    </div>
  </div>
</div>
<script>
(function(){
  const target = <?= $release_ts ?> * 1000;
  function tick(){
    const now = Date.now();
    let diff = Math.max(0, Math.floor((target - now)/1000));
    if(diff <= 0){ location.reload(); return; }
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
<?php endif; ?>

<?php if($status === 'perlu_revisi' && !empty($revisi_items)): ?>
<!-- ═══════════ REVISION WARNING CARD ═══════════ -->
<?php
  $revisi_labels = [
    'pribadi'  => ['label'=>'Formulir Biodata Pribadi', 'icon'=>'fa-user', 'link'=>'student/form'],
    'ortu'     => ['label'=>'Data Orang Tua / Wali', 'icon'=>'fa-users', 'link'=>'student/form'],
    'ijazah'   => ['label'=>'Berkas Ijazah / SKL', 'icon'=>'fa-file-alt', 'link'=>'student/upload'],
    'kk'       => ['label'=>'Berkas Kartu Keluarga', 'icon'=>'fa-id-card', 'link'=>'student/upload'],
    'akta'     => ['label'=>'Berkas Akta Kelahiran', 'icon'=>'fa-file-contract', 'link'=>'student/upload'],
    'foto_3x4' => ['label'=>'Pas Foto 3x4', 'icon'=>'fa-camera', 'link'=>'student/upload']
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

<div class="grid grid-cols-1 <?= $catatan && !in_array($status, ['perlu_revisi']) ? 'lg:grid-cols-5' : '' ?> gap-6 mb-8 animate-fadeUp delay-1" style="opacity:0">
  <!-- Status Card -->
  <div id="status-panel" class="<?= $catatan && !in_array($status, ['perlu_revisi']) ? 'lg:col-span-3' : '' ?> bg-white rounded-2xl border <?= $c['border'] ?> shadow-sm card-hover overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
      <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.15em]">Status Pendaftaran Anda</h4>
    </div>
    <div class="p-6">
      <div class="flex items-center space-x-5 p-5 rounded-xl <?= $c['bg'] ?> border <?= $c['border'] ?>">
        <div class="w-14 h-14 <?= $c['icon_bg'] ?> rounded-xl flex items-center justify-center text-2xl flex-shrink-0 shadow-sm">
          <i class="fas <?= $c['icon'] ?>"></i>
        </div>
        <div>
          <p class="font-black text-lg <?= $c['text_color'] ?> uppercase tracking-tight"><?= $c['text'] ?></p>
          <?php if($status == 'belum_mendaftar'): ?>
          <p class="text-xs text-slate-500 mt-1 font-medium">Silakan lengkapi formulir, lalu klik "Kirim Pendaftaran" di tahap akhir.</p>
          <?php elseif($status == 'nunggu_verifikasi'): ?>
          <p class="text-xs text-amber-600 mt-1 font-medium">Data Anda sedang diperiksa oleh panitia PPDB.</p>
          <?php elseif($status == 'diterima'): ?>
          <p class="text-xs text-emerald-700 mt-1 font-medium mb-3">Selamat! Hasil seleksi menyatakan Anda DITERIMA.</p>
          <a href="<?= base_url('student/pengumuman') ?>" class="inline-block px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-[11px] font-bold uppercase tracking-wider rounded-lg hover:from-emerald-700 hover:to-teal-700 transition-all shadow-md"><i class="fas fa-envelope-open-text mr-1.5 text-sm"></i> Cek Kelulusan Sekarang</a>
          <?php elseif($status == 'ditolak'): ?>
          <p class="text-xs text-rose-700 mt-1 font-medium mb-3">Hasil akhir seleksi Anda sudah dirilis.</p>
          <a href="<?= base_url('student/pengumuman') ?>" class="inline-block px-5 py-2.5 bg-gradient-to-r from-rose-600 to-red-700 text-white text-[11px] font-bold uppercase tracking-wider rounded-lg hover:from-rose-700 hover:to-red-800 transition-all shadow-md"><i class="fas fa-envelope-open-text mr-1.5 text-sm"></i> Cek Kelulusan Sekarang</a>
          <?php elseif($status == 'nunggu_pengumuman' || $status == 'dokumen_diterima'): ?>
          <p class="text-xs text-emerald-700 mt-1 font-medium">Dokumen dan formulir Anda telah diterima oleh panitia. Hasil seleksi akan dirilis sesuai jadwal yang ditentukan.</p>
          <?php elseif($status == 'perlu_revisi'): ?>
          <p class="text-xs text-red-600 mt-1 font-medium">Segera perbaiki data/berkas yang ditandai oleh admin di atas.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <?php if($catatan && !in_array($status, ['diterima', 'ditolak', 'perlu_revisi'])): ?>
  <!-- Catatan Panitia -->
  <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm card-hover overflow-hidden border-l-4 border-l-emerald-500">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
      <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.15em]">Catatan Panitia PPDB</h4>
    </div>
    <div class="p-6">
      <div class="bg-slate-50 p-5 rounded-xl border border-slate-100">
        <i class="fas fa-quote-left text-slate-200 text-xl mb-2"></i>
        <p class="text-sm font-medium text-slate-700 italic leading-relaxed"><?= htmlspecialchars($catatan) ?></p>
      </div>
    </div>
  </div>
  <?php endif; ?>
</div>





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
