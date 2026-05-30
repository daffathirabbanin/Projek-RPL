<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Upload Berkas | PPDB MI Nurul Ikhlas Al-Ayubi</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');
body{font-family:'Poppins',sans-serif;background:#f8fafc}
.card-hover{transition:all .3s cubic-bezier(.4,0,.2,1)}.card-hover:hover{transform:translateY(-4px);box-shadow:0 20px 25px -5px rgba(0,0,0,.06)}
</style>
</head>
<body class="text-slate-800 flex h-screen overflow-hidden">
<?php require_once '../app/Views/student/_sidebar.php'; studentSidebar('upload'); ?>

<main class="flex-1 flex flex-col h-full overflow-y-auto">
<header class="bg-white px-8 py-5 border-b border-slate-200/80 sticky top-0 z-30 flex justify-between items-center shadow-sm">
  <div>
    <h2 class="text-2xl font-bold text-[#1a5632] tracking-tight">Upload Berkas Persyaratan</h2>
    <p class="text-[13px] text-slate-500 font-medium mt-1">Unggah dokumen dalam format PDF atau JPG/PNG (Maks. 2MB)</p>
  </div>
</header>

<div class="p-8 max-w-5xl mx-auto w-full pb-20">

<style>
@keyframes toastIn{from{opacity:0;transform:translateX(-50%) translateY(-24px)}to{opacity:1;transform:translateX(-50%) translateY(0)}}
.toast-notif{animation:toastIn .35s cubic-bezier(.4,0,.2,1) forwards}
</style>

<?php if(isset($_GET['error'])): ?>
<div id="toast-error" class="fixed top-6 left-1/2 -translate-x-1/2 z-[100] flex items-center gap-4 bg-white border border-red-200 shadow-2xl rounded-2xl px-6 py-4 min-w-[340px] toast-notif">
  <div class="w-12 h-12 bg-red-100 text-red-500 rounded-xl flex items-center justify-center text-xl flex-shrink-0">
    <i class="fas fa-exclamation-circle"></i>
  </div>
  <div class="flex-1">
    <p class="font-black text-red-600 text-sm">Upload Gagal!</p>
    <p class="text-slate-500 text-xs mt-0.5"><?= $_GET['error']=='invalid' ? 'Format tidak valid. Gunakan PDF untuk dokumen, JPG/PNG untuk foto.' : ($_GET['error']=='oversize' ? 'Ukuran file melebihi batas maksimal 2MB. Silakan kompres berkas Anda.' : 'Terjadi kesalahan, silakan coba lagi.') ?></p>
  </div>
  <button onclick="this.parentElement.remove()" class="text-slate-400 hover:text-slate-600 ml-2"><i class="fas fa-times"></i></button>
</div>
<?php endif; ?>

<?php if(isset($_GET['success'])): ?>
<?php if($_GET['success'] === 'form_submitted'): ?>
<div id="toast-success" class="fixed top-6 left-1/2 -translate-x-1/2 z-[100] flex items-center gap-4 bg-white border border-emerald-200 shadow-2xl rounded-2xl px-6 py-4 min-w-[380px] toast-notif">
  <div class="w-12 h-12 bg-emerald-500 text-white rounded-xl flex items-center justify-center text-xl flex-shrink-0 shadow-md">
    <i class="fas fa-check-circle"></i>
  </div>
  <div class="flex-1">
    <p class="font-black text-emerald-700 text-sm">🎉 Formulir Berhasil Dikirim!</p>
    <p class="text-slate-500 text-xs mt-0.5">Pendaftaran Anda sudah tercatat. Silakan upload berkas di bawah ini.</p>
  </div>
  <button onclick="this.parentElement.remove()" class="text-slate-400 hover:text-slate-600 ml-2"><i class="fas fa-times"></i></button>
</div>
<?php else: ?>
<div id="toast-success" class="fixed top-6 left-1/2 -translate-x-1/2 z-[100] flex items-center gap-4 bg-white border border-emerald-200 shadow-2xl rounded-2xl px-6 py-4 min-w-[340px] toast-notif">
  <div class="w-12 h-12 bg-emerald-100 text-emerald-500 rounded-xl flex items-center justify-center text-xl flex-shrink-0">
    <i class="fas fa-check-circle"></i>
  </div>
  <div class="flex-1">
    <p class="font-black text-emerald-700 text-sm">Berkas Berhasil Diunggah!</p>
    <p class="text-slate-500 text-xs mt-0.5">File Anda telah tersimpan dengan aman.</p>
  </div>
  <button onclick="this.parentElement.remove()" class="text-slate-400 hover:text-slate-600 ml-2"><i class="fas fa-times"></i></button>
</div>
<?php endif; ?>
<?php endif; ?>

<script>
setTimeout(function(){var t=document.getElementById('toast-success');if(t)t.remove();},5000);
setTimeout(function(){var t=document.getElementById('toast-error');if(t)t.remove();},6000);
</script>

<!-- Info Banner -->
<div class="bg-gradient-to-r from-amber-50 to-orange-50 p-6 rounded-2xl border border-amber-200/60 shadow-sm mb-8 flex items-start space-x-4">
  <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0 text-amber-600 text-xl"><i class="fas fa-info-circle"></i></div>
  <div>
    <h3 class="font-bold text-amber-800 mb-1">Persyaratan Dokumen</h3>
    <p class="text-amber-700/80 text-sm font-medium">Unggah file Ijazah/SKL, KK, dan Akta dalam format <strong>PDF</strong>. Pas Foto dalam format <strong>JPG/PNG</strong>. Ukuran maksimal <strong>2MB</strong> per file.</p>
  </div>
</div>

<?php
// Revision detection for upload page
$reg_status_up = $_SESSION['reg_status'] ?? '';
$revisi_json_up = $_SESSION['revisi_json'] ?? '';
$revisi_data_up = !empty($revisi_json_up) ? (json_decode($revisi_json_up, true) ?: []) : [];
$is_revisi_up = ($reg_status_up === 'perlu_revisi' && !empty($revisi_data_up));
$doc_revisi_keys = array_intersect(array_keys($revisi_data_up), ['ijazah','kk','akta','foto_3x4']);
?>

<?php if($is_revisi_up && !empty($doc_revisi_keys)): ?>
<div class="bg-white rounded-2xl border-2 border-red-300 shadow-lg overflow-hidden mb-8" style="animation:pulseGlow 2s ease-in-out infinite">
  <div class="px-6 py-4 bg-gradient-to-r from-red-600 to-rose-600 flex items-center space-x-3">
    <div class="w-9 h-9 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
      <i class="fas fa-exclamation-triangle text-white text-sm animate-pulse"></i>
    </div>
    <div>
      <h4 class="text-white font-black text-sm uppercase tracking-wide">Revisi Berkas Diperlukan</h4>
      <p class="text-red-200 text-[10px] font-bold">Unggah ulang berkas yang ditandai merah oleh admin di bawah ini.</p>
    </div>
  </div>
</div>
<style>@keyframes pulseGlow{0%,100%{box-shadow:0 0 15px rgba(239,68,68,.2)}50%{box-shadow:0 0 35px rgba(239,68,68,.45)}}</style>
<?php endif; ?>

<!-- Unified Document Upload Form -->
<form action="<?= base_url('student/upload_process') ?>" method="POST" enctype="multipart/form-data" id="upload-all-form">
  
  <!-- Document Cards -->
  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
  <?php 
  $docs = [
      'ijazah'  => ['title'=>'Ijazah / SKL','sub'=>'Scan Ijazah (PDF)','icon'=>'fa-graduation-cap','gradient'=>'from-indigo-500 to-blue-600', 'accept'=>'application/pdf'],
      'kk'      => ['title'=>'Kartu Keluarga','sub'=>'Scan KK asli (PDF)','icon'=>'fa-users','gradient'=>'from-teal-500 to-cyan-600', 'accept'=>'application/pdf'],
      'akta'    => ['title'=>'Akta Kelahiran','sub'=>'Scan akta asli (PDF)','icon'=>'fa-child','gradient'=>'from-emerald-500 to-teal-500', 'accept'=>'application/pdf'],
      'foto_3x4'=> ['title'=>'Pas Foto 3x4','sub'=>'Latar merah (JPG/PNG)','icon'=>'fa-portrait','gradient'=>'from-emerald-600 to-emerald-700', 'accept'=>'image/jpeg,image/png,image/jpg']
  ];
  $d = $data['dokumen'] ?? [];
  $is_locked = in_array($data['pendaftaran']['status'] ?? '', ['diterima','ditolak','nunggu_pengumuman']);
  $has_doc_revisi = isset($revisi_data_up);
  
  foreach($docs as $key => $info):
      $path = $d[$key] ?? null;
      $needs_revisi = $is_revisi_up && isset($revisi_data_up[$key]);
      $revisi_note = $revisi_data_up[$key] ?? '';
      // Unlock this specific document input if it needs revision
      $doc_locked = $is_locked && !$needs_revisi;
  ?>
  <div class="bg-white rounded-2xl border <?= $needs_revisi ? 'border-red-300' : 'border-slate-200' ?> overflow-hidden flex flex-col">
    <!-- Card Header -->
    <div class="p-5 flex items-center space-x-4">
      <div class="w-12 h-12 bg-gradient-to-br <?= $needs_revisi ? 'from-red-500 to-rose-600' : $info['gradient'] ?> rounded-xl flex items-center justify-center text-white flex-shrink-0">
        <i class="fas <?= $info['icon'] ?> text-lg"></i>
      </div>
      <div class="flex-1">
        <h4 class="font-bold text-slate-800"><?= $info['title'] ?></h4>
        <p class="text-[11px] text-slate-400 font-medium"><?= $info['sub'] ?></p>
      </div>
      <?php if($needs_revisi): ?>
        <span class="w-8 h-8 bg-red-100 text-red-600 rounded-full flex items-center justify-center text-xs animate-pulse"><i class="fas fa-exclamation"></i></span>
      <?php elseif($path): ?>
        <span class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xs"><i class="fas fa-check"></i></span>
      <?php else: ?>
        <span class="w-8 h-8 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center text-xs"><i class="fas fa-minus"></i></span>
      <?php endif; ?>
    </div>
  
    <div class="px-5 pb-5 flex-1 flex flex-col justify-end border-t <?= $needs_revisi ? 'border-red-100 bg-red-50/30' : 'border-slate-100' ?> pt-4">
      <?php if($needs_revisi && !empty($revisi_note)): ?>
        <div class="mb-3 p-2.5 bg-red-50 border border-red-200 rounded-lg">
          <p class="text-[10px] font-black text-red-600 uppercase tracking-wider mb-0.5"><i class="fas fa-comment-dots mr-1"></i>Catatan Admin</p>
          <p class="text-xs text-red-700 font-medium italic"><?= htmlspecialchars($revisi_note) ?></p>
        </div>
      <?php endif; ?>
      
      <?php if($path): ?>
        <a href="<?= base_url($path) ?>" target="_blank" class="text-sm font-bold text-blue-600 hover:text-blue-700 flex items-center mb-3 transition-colors">
          <i class="fas fa-external-link-alt mr-2 text-xs"></i> Lihat File Tersimpan
        </a>
      <?php endif; ?>
      
      <?php if(!$doc_locked): ?>
        <div class="relative">
          <input type="file" name="<?= $key ?>" id="file-<?= $key ?>" accept="<?= $info['accept'] ?>" class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold <?= $needs_revisi ? 'file:bg-red-100 file:text-red-700 border-red-300' : 'file:bg-slate-100 file:text-slate-700 border-slate-200' ?> hover:file:bg-slate-200 border rounded-lg p-1.5 cursor-pointer mb-1 transition-colors file-input-element">
          <!-- Dynamic selected file label -->
          <div id="label-<?= $key ?>" class="text-[10px] text-emerald-600 font-bold hidden flex items-center mt-1.5"><i class="fas fa-file-import mr-1 text-emerald-500 animate-pulse"></i> Terpilih, siap diunggah!</div>
        </div>
      <?php else: ?>
        <div class="text-xs text-emerald-600 font-bold bg-emerald-50 p-3 rounded-lg text-center border border-emerald-100"><i class="fas fa-lock mr-1"></i> Terkunci — data sudah diverifikasi</div>
      <?php endif; ?>
    </div>
  </div>
  <?php endforeach; ?>
  </div>
  
  <!-- Bottom Status Guidance -->
  <?php
  $all_uploaded = true;
  foreach($docs as $k => $info) {
      if(!isset($d[$k]) || empty($d[$k])) {
          $all_uploaded = false;
          break;
      }
  }
  ?>
  <div class="mt-10 bg-white rounded-2xl border border-slate-200/80 p-6 flex flex-col md:flex-row items-center justify-between shadow-sm animate-fadeUp">
    <?php if($all_uploaded): ?>
      <div class="flex items-center space-x-4 mb-4 md:mb-0">
        <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center text-xl flex-shrink-0"><i class="fas fa-check-double"></i></div>
        <div>
          <h4 class="font-bold text-slate-800">Semua Berkas Lengkap!</h4>
          <p class="text-[11px] text-slate-400 font-medium mt-0.5">Seluruh berkas persyaratan Anda telah sukses terunggah.</p>
        </div>
      </div>
      <div class="flex items-center gap-3">
        <!-- If user selects changes, this button appears dynamically -->
        <button type="submit" id="submit-all-btn" class="hidden px-6 py-3.5 bg-gradient-to-r from-orange-500 to-amber-500 text-white font-bold rounded-xl text-xs uppercase tracking-widest hover:from-orange-600 hover:to-amber-600 transition-all shadow-md shadow-orange-100 flex items-center"><i class="fas fa-paper-plane mr-2 text-sm"></i> Unggah Perubahan</button>
        <a href="<?= base_url('student') ?>" class="px-6 py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold rounded-xl text-xs uppercase tracking-widest hover:from-emerald-700 hover:to-teal-700 transition-all shadow-md shadow-emerald-100 flex items-center"><i class="fas fa-home mr-2 text-sm"></i> Selesai & Ke Dashboard</a>
      </div>
    <?php else: ?>
      <div class="flex items-center space-x-4 mb-4 md:mb-0">
        <div class="w-12 h-12 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center text-xl flex-shrink-0 border border-amber-100/60"><i class="fas fa-tasks text-amber-600"></i></div>
        <div>
          <h4 class="font-bold text-slate-800">Menunggu Unggah Berkas</h4>
          <p class="text-[11px] text-slate-400 font-medium mt-0.5">Pilih berkas-berkas di atas (bisa beberapa sekaligus), lalu klik tombol <strong class="text-slate-600">Unggah Berkas</strong>.</p>
        </div>
      </div>
      <div class="flex items-center gap-3">
        <a href="<?= base_url('student') ?>" class="px-5 py-3.5 bg-white border border-slate-200 text-slate-500 font-bold rounded-xl text-xs uppercase tracking-widest hover:bg-slate-50 transition-colors shadow-sm flex items-center"><i class="fas fa-chevron-left mr-2 text-sm text-slate-400"></i> Dashboard (Draft)</a>
        <button type="submit" id="submit-all-btn" class="px-6 py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold rounded-xl text-xs uppercase tracking-widest hover:from-emerald-700 hover:to-teal-700 transition-all shadow-md shadow-emerald-100 flex items-center pointer-events-none opacity-50" disabled><i class="fas fa-upload mr-2 text-sm"></i> Unggah Berkas</button>
      </div>
    <?php endif; ?>
  </div>
</form>

</div>
</main>

<script>
function showToast(message, type = 'error') {
  // Hapus toast lama jika ada
  const existing = document.getElementById('dynamic-toast');
  if (existing) existing.remove();
  
  const toast = document.createElement('div');
  toast.id = 'dynamic-toast';
  toast.className = `fixed top-6 left-1/2 -translate-x-1/2 z-[100] flex items-center gap-4 bg-white border shadow-2xl rounded-2xl px-6 py-4 min-w-[340px] toast-notif ${
    type === 'success' ? 'border-emerald-200' : 'border-red-200'
  }`;
  
  const iconBg = type === 'success' ? 'bg-emerald-100 text-emerald-500' : 'bg-red-100 text-red-500';
  const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
  const title = type === 'success' ? 'Sukses!' : 'Berkas Terlalu Besar!';
  const titleColor = type === 'success' ? 'text-red-600' : 'text-red-600';
  
  toast.innerHTML = `
    <div class="w-12 h-12 ${iconBg} rounded-xl flex items-center justify-center text-xl flex-shrink-0">
      <i class="fas ${iconClass}"></i>
    </div>
    <div class="flex-1">
      <p class="font-black ${titleColor} text-sm">${title}</p>
      <p class="text-slate-500 text-xs mt-0.5">${message}</p>
    </div>
    <button onclick="this.parentElement.remove()" class="text-slate-400 hover:text-slate-600 ml-2"><i class="fas fa-times"></i></button>
  `;
  
  document.body.appendChild(toast);
  setTimeout(() => {
    if (toast.parentElement) toast.remove();
  }, 6000);
}

const fileInputs = document.querySelectorAll('.file-input-element');
const submitBtn = document.getElementById('submit-all-btn');
const isAllUploadedByDefault = <?php echo ($all_uploaded && !$is_revisi_up) ? 'true' : 'false'; ?>;

function updateSubmitState() {
  let selectedCount = 0;
  fileInputs.forEach(input => {
    const label = document.getElementById('label-' + input.name);
    if (input.files && input.files.length > 0) {
      selectedCount++;
      if (label) {
        label.classList.remove('hidden');
        label.innerText = 'Terpilih, siap diunggah!';
      }
    } else {
      if (label) label.classList.add('hidden');
    }
  });

  if (selectedCount > 0) {
    submitBtn.disabled = false;
    submitBtn.classList.remove('pointer-events-none', 'opacity-50', 'hidden');
    submitBtn.classList.add('from-emerald-600', 'to-teal-600');
    submitBtn.classList.remove('from-orange-500', 'to-amber-500', 'ring-2', 'ring-orange-400', 'ring-offset-2', 'animate-pulse');
    submitBtn.innerHTML = `<i class="fas fa-upload mr-2 text-sm"></i> Unggah ${selectedCount} Berkas`;
  } else {
    if (isAllUploadedByDefault) {
      submitBtn.classList.add('hidden');
    } else {
      submitBtn.disabled = true;
      submitBtn.classList.add('pointer-events-none', 'opacity-50');
      submitBtn.classList.remove('from-orange-500', 'to-amber-500', 'ring-2', 'ring-orange-400', 'ring-offset-2', 'animate-pulse');
      submitBtn.classList.add('from-emerald-600', 'to-teal-600');
      submitBtn.innerHTML = `<i class="fas fa-upload mr-2 text-sm"></i> Unggah Berkas`;
    }
  }
}

fileInputs.forEach(input => {
  input.addEventListener('change', function() {
    if (this.files && this.files.length > 0) {
      const file = this.files[0];
      const maxSize = 2 * 1024 * 1024; // 2MB
      
      if (file.size > maxSize) {
        showToast('Ukuran file ' + (file.size / (1024 * 1024)).toFixed(2) + 'MB melebihi batas maksimal 2MB. Silakan kompres berkas Anda.', 'error');
        this.value = ''; // Reset input file
      }
    }
    updateSubmitState();
  });
});
</script>
</body></html>
