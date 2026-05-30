<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Formulir Pendaftaran | PPDB MI Nurul Ikhlas Al-Ayubi</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');
body{font-family:'Poppins',sans-serif;background:#f8fafc}
input:focus,select:focus,textarea:focus{border-color:#10b981!important;box-shadow:0 0 0 3px rgba(16,185,129,.1)!important;outline:none}
.step-form{animation:slideIn .3s ease-out}
@keyframes slideIn{from{opacity:0;transform:translateX(20px)}to{opacity:1;transform:translateX(0)}}
.save-flash{animation:flash .6s ease}
@keyframes flash{0%{opacity:0;transform:scale(.95)}50%{opacity:1;transform:scale(1.02)}100%{opacity:1;transform:scale(1)}}
</style>
</head>
<body class="text-slate-800 flex h-screen overflow-hidden">
<?php require_once '../app/Views/student/_sidebar.php'; studentSidebar('form'); ?>

<main class="flex-1 flex flex-col h-full overflow-y-auto">
<!-- Header -->
<header class="bg-white px-8 py-5 border-b border-slate-200/80 sticky top-0 z-30 flex justify-between items-center shadow-sm">
  <div>
    <h2 class="text-2xl font-bold text-[#1a5632] tracking-tight">Formulir Pendaftaran</h2>
    <p class="text-[13px] text-slate-500 font-medium mt-1">Lengkapi data pada setiap tahap pendaftaran Anda.</p>
  </div>
  <div id="save-status" class="hidden items-center text-sm font-bold text-emerald-600 bg-emerald-50 px-4 py-2 rounded-lg border border-emerald-200 shadow-sm save-flash">
    <i class="fas fa-check-circle mr-2"></i>Data Tersimpan!
  </div>
</header>

<div class="p-6 max-w-4xl mx-auto w-full pb-20">

<?php if(isset($_GET['error']) && in_array($_GET['error'], ['incomplete', 'conflict_wali', 'no_parent_wali'])): ?>
<div id="notif-error" class="fixed top-6 left-1/2 -translate-x-1/2 z-[100] flex items-center gap-4 bg-white border border-red-200 shadow-2xl rounded-2xl px-6 py-4 min-w-[340px] animate-notif">
  <div class="w-12 h-12 bg-red-100 text-red-500 rounded-xl flex items-center justify-center text-xl flex-shrink-0">
    <i class="fas fa-exclamation-triangle"></i>
  </div>
  <div class="flex-1">
    <p class="font-black text-red-600 text-sm">
      <?php 
        if($_GET['error'] == 'conflict_wali') echo "Data Ganda!";
        elseif($_GET['error'] == 'no_parent_wali') echo "Data Orang Tua/Wali Kosong!";
        else echo "Formulir Belum Lengkap!";
      ?>
    </p>
    <p class="text-slate-500 text-xs mt-0.5 max-w-sm">
      <?php 
        if($_GET['error'] == 'conflict_wali') echo "Anda tidak bisa mengisi Data Orang Tua dan Data Wali secara bersamaan. Jika Anda memiliki Wali, kosongkan nama Ayah & Ibu.";
        elseif($_GET['error'] == 'no_parent_wali') echo "Anda wajib mengisi Data Orang Tua ATAU Data Wali sebagai penanggung jawab.";
        else {
            $f = $_GET['f'] ?? '';
            if ($f) {
                echo "Field wajib <b>".htmlspecialchars($f)."</b> masih kosong. Pastikan seluruh data terisi.";
            } else {
                echo "Pastikan seluruh data wajib (*) sudah diisi dengan benar.";
            }
        }
      ?>
    </p>
  </div>
  <button onclick="document.getElementById('notif-error').remove()" class="text-slate-400 hover:text-slate-600 ml-2"><i class="fas fa-times"></i></button>
</div>
<style>@keyframes notifIn{from{opacity:0;transform:translateX(-50%) translateY(-20px)}to{opacity:1;transform:translateX(-50%) translateY(0)}}.animate-notif{animation:notifIn .35s cubic-bezier(.4,0,.2,1) forwards}</style>
<?php endif; ?>

<?php
// Revision detection
$reg_status_fw = $_SESSION['reg_status'] ?? '';
$revisi_json_fw = $_SESSION['revisi_json'] ?? '';
$revisi_data_fw = !empty($revisi_json_fw) ? (json_decode($revisi_json_fw, true) ?: []) : [];
$is_revisi = ($reg_status_fw === 'perlu_revisi' && !empty($revisi_data_fw));
$revisi_pribadi = $revisi_data_fw['pribadi'] ?? null;
$revisi_ortu = $revisi_data_fw['ortu'] ?? null;
?>

<?php if($is_revisi): ?>
<div class="bg-white rounded-2xl border-2 border-red-300 shadow-lg overflow-hidden mb-6" style="animation:pulseGlow 2s ease-in-out infinite">
  <div class="px-6 py-4 bg-gradient-to-r from-red-600 to-rose-600 flex items-center space-x-3">
    <div class="w-9 h-9 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
      <i class="fas fa-exclamation-triangle text-white text-sm animate-pulse"></i>
    </div>
    <div>
      <h4 class="text-white font-black text-sm uppercase tracking-wide">Mode Revisi Aktif</h4>
      <p class="text-red-200 text-[10px] font-bold">Perbaiki bagian formulir yang ditandai admin di bawah ini.</p>
    </div>
  </div>
  <div class="p-4 space-y-2">
    <?php if(isset($revisi_data_fw['pribadi'])): ?>
    <div class="flex items-center p-3 bg-red-50 border border-red-200 rounded-xl">
      <i class="fas fa-user text-red-500 mr-3 text-sm"></i>
      <div>
        <p class="text-xs font-bold text-red-800">Biodata Pribadi (Tahap 1)</p>
        <?php if(!empty($revisi_data_fw['pribadi'])): ?><p class="text-[10px] text-red-600/80 italic mt-0.5"><i class="fas fa-comment-dots mr-1"></i><?= htmlspecialchars($revisi_data_fw['pribadi']) ?></p><?php endif; ?>
      </div>
    </div>
    <?php endif; ?>
    <?php if(isset($revisi_data_fw['ortu'])): ?>
    <div class="flex items-center p-3 bg-red-50 border border-red-200 rounded-xl">
      <i class="fas fa-users text-red-500 mr-3 text-sm"></i>
      <div>
        <p class="text-xs font-bold text-red-800">Data Orang Tua / Wali (Tahap 2-4)</p>
        <?php if(!empty($revisi_data_fw['ortu'])): ?><p class="text-[10px] text-red-600/80 italic mt-0.5"><i class="fas fa-comment-dots mr-1"></i><?= htmlspecialchars($revisi_data_fw['ortu']) ?></p><?php endif; ?>
      </div>
    </div>
    <?php endif; ?>
  </div>
</div>
<style>@keyframes pulseGlow{0%,100%{box-shadow:0 0 15px rgba(239,68,68,.2)}50%{box-shadow:0 0 35px rgba(239,68,68,.45)}}</style>
<?php endif; ?>

<!-- Step Indicator (Premium) -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
<div class="flex items-center justify-between">
<?php
$steps = ['Data Pribadi','Data Ayah','Data Ibu','Data Wali','Kontak & Periodik','Upload Berkas'];
$icons = ['fa-user','fa-male','fa-female','fa-user-friends','fa-phone-alt','fa-file-upload'];
foreach($steps as $i=>$s):
  $n=$i+1;
?>
<div class="flex items-center <?= $i > 0 ? 'flex-1' : '' ?>">
  <?php if($i > 0): ?>
  <div class="flex-1 h-0.5 mx-3 step-line bg-slate-200 rounded-full transition-colors duration-300" data-step="<?= $n ?>"></div>
  <?php endif; ?>
  <div class="flex flex-col items-center step-item cursor-pointer" data-step="<?= $n ?>" onclick="goStep(<?= $n ?>)">
    <div class="w-11 h-11 rounded-xl step-circle flex items-center justify-center text-sm font-black border-2 border-slate-200 bg-slate-50 text-slate-400 transition-all duration-300 shadow-sm relative">
      <i class="fas <?= $icons[$i] ?>"></i>
      <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full border-2 border-white hidden error-dot shadow-sm animate-pulse"></span>
    </div>
    <span class="text-[9px] font-bold text-slate-400 mt-1.5 uppercase tracking-wider whitespace-nowrap step-label"><?= $s ?></span>
  </div>
</div>
<?php endforeach; ?>
</div>
</div>

<!-- Step 1: Data Pribadi -->
<form id="form-1" class="step-form space-y-4" data-url="<?=base_url('student/save_pribadi')?>">
<?php if($is_revisi && isset($revisi_data_fw['pribadi'])): ?>
<div class="p-3 bg-red-50 border-2 border-red-300 rounded-xl mb-2 flex items-center">
  <i class="fas fa-exclamation-circle text-red-500 mr-2 text-sm"></i>
  <span class="text-xs font-bold text-red-700">Admin meminta perbaikan pada bagian ini<?= !empty($revisi_data_fw['pribadi']) ? ': <em>'.htmlspecialchars($revisi_data_fw['pribadi']).'</em>' : '' ?></span>
</div>
<?php endif; ?>
<div class="bg-white rounded-2xl border <?= ($is_revisi && isset($revisi_data_fw['pribadi'])) ? 'border-red-300 ring-2 ring-red-100' : 'border-slate-200' ?> shadow-sm overflow-hidden">
<div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r <?= ($is_revisi && isset($revisi_data_fw['pribadi'])) ? 'from-red-50 to-white' : 'from-slate-50 to-white' ?> flex items-center space-x-3">
  <div class="w-8 h-8 <?= ($is_revisi && isset($revisi_data_fw['pribadi'])) ? 'bg-red-100 text-red-600' : 'bg-emerald-100 text-emerald-600' ?> rounded-lg flex items-center justify-center text-sm"><i class="fas fa-user"></i></div>
  <h3 class="font-black text-slate-800 uppercase tracking-tight text-sm">Data Pribadi Siswa</h3>
  <?php if($is_revisi && isset($revisi_data_fw['pribadi'])): ?><span class="ml-auto text-[9px] font-black text-red-600 bg-red-100 px-2 py-0.5 rounded-full uppercase tracking-wider animate-pulse">Revisi</span><?php endif; ?>
</div>
<div class="p-6 space-y-4">
<div class="grid grid-cols-2 gap-4">
<?php
$p = $data['pribadi'] ?? [];
function inp($name,$label,$val,$type='text',$req=true,$extra=''){
  $reqAttr = $req ? 'required' : '';
  $label .= $req ? ' *' : '';
  echo "<div><label class='block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5'>$label</label><input type='$type' name='$name' value='".htmlspecialchars($val??'')."' class='w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm bg-slate-50/50 hover:bg-white transition-colors' $reqAttr $extra></div>";
}
function sel($name,$label,$val,$opts,$req=true){
  $reqAttr = $req ? 'required' : '';
  $label .= $req ? ' *' : '';
  echo "<div><label class='block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5'>$label</label><select name='$name' class='w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm bg-slate-50/50 hover:bg-white transition-colors' $reqAttr><option value=''>Pilih</option>";
  foreach($opts as $k=>$v) echo "<option value='$k'".($val==$k?' selected':'').">$v</option>";
  echo "</select></div>";
}
inp('nama_lengkap','Nama Lengkap *',$p['nama_lengkap']??'');
sel('jenis_kelamin','Jenis Kelamin',$p['jenis_kelamin']??'',['L'=>'Laki-laki','P'=>'Perempuan']);
inp('nisn','NISN',$p['nisn']??'', 'text', true, 'maxlength="10" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,\'\')"');
inp('nik','NIK (16 Digit)',$p['nik']??'', 'text', true, 'maxlength="16" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,\'\')"');
inp('no_kk','No. Kartu Keluarga',$p['no_kk']??'', 'text', true, 'maxlength="16" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,\'\')"');
inp('tempat_lahir','Tempat Lahir',$p['tempat_lahir']??'');
inp('tanggal_lahir','Tanggal Lahir',$p['tanggal_lahir']??'','date');
sel('kewarganegaraan','Kewarganegaraan',$p['kewarganegaraan']??'WNI',['WNI'=>'WNI','WNA'=>'WNA']);
inp('kode_pos','Kode Pos',$p['kode_pos']??'');
?>
</div>
<div><label class='block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5'>Alamat Jalan *</label><textarea name="alamat_jalan" rows="2" required class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm bg-slate-50/50 hover:bg-white transition-colors"><?=htmlspecialchars($p['alamat_jalan']??'')?></textarea></div>
<div class="grid grid-cols-4 gap-4">
<?php inp('rt','RT',$p['rt']??''); inp('rw','RW',$p['rw']??''); inp('kelurahan','Kelurahan/Desa',$p['kelurahan']??''); ?>
</div>
<div class="grid grid-cols-3 gap-4">
<?php
inp('kecamatan','Kecamatan',$p['kecamatan']??'');
inp('anak_ke','Anak Ke-',$p['anak_ke']??'','number');
sel('punya_kip','Punya KIP?',$p['punya_kip']??'tidak',['ya'=>'Ya','tidak'=>'Tidak']);
?>
</div>
<div class="grid grid-cols-2 gap-4">
<?php
sel('tempat_tinggal','Tempat Tinggal',$p['tempat_tinggal']??'',['Bersama Orang Tua'=>'Bersama Orang Tua','Bersama Wali'=>'Bersama Wali','Kos/Kontrak'=>'Kos/Kontrak','Asrama'=>'Asrama']);

?>
</div>
</div></div>
<div class="flex justify-end mt-2">
  <button type="button" onclick="nextStep(2)" class="px-8 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-bold rounded-xl text-sm uppercase tracking-wider hover:from-emerald-700 hover:to-emerald-800 transition-all shadow-md shadow-emerald-200/50">Lanjut <i class="fas fa-arrow-right ml-2"></i></button>
</div>
</form>

<!-- Step 2: Data Ayah -->
<form id="form-2" class="step-form hidden space-y-4" data-url="<?=base_url('student/save_ayah')?>">
<?php if($is_revisi && isset($revisi_data_fw['ortu'])): ?>
<div class="p-3 bg-red-50 border-2 border-red-300 rounded-xl mb-2 flex items-center">
  <i class="fas fa-exclamation-circle text-red-500 mr-2 text-sm"></i>
  <span class="text-xs font-bold text-red-700">Admin meminta perbaikan data orang tua<?= !empty($revisi_data_fw['ortu']) ? ': <em>'.htmlspecialchars($revisi_data_fw['ortu']).'</em>' : '' ?></span>
</div>
<?php endif; ?>
<div class="bg-white rounded-2xl border <?= ($is_revisi && isset($revisi_data_fw['ortu'])) ? 'border-red-300 ring-2 ring-red-100' : 'border-slate-200' ?> shadow-sm overflow-hidden">
<div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r <?= ($is_revisi && isset($revisi_data_fw['ortu'])) ? 'from-red-50 to-white' : 'from-teal-50 to-white' ?> flex items-center space-x-3">
  <div class="w-8 h-8 <?= ($is_revisi && isset($revisi_data_fw['ortu'])) ? 'bg-red-100 text-red-600' : 'bg-teal-100 text-teal-600' ?> rounded-lg flex items-center justify-center text-sm"><i class="fas fa-male"></i></div>
  <h3 class="font-black text-slate-800 uppercase tracking-tight text-sm">Data Ayah Kandung</h3>
  <?php if($is_revisi && isset($revisi_data_fw['ortu'])): ?><span class="ml-auto text-[9px] font-black text-red-600 bg-red-100 px-2 py-0.5 rounded-full uppercase tracking-wider animate-pulse">Revisi</span><?php endif; ?>
</div>
<div class="p-6"><div class="grid grid-cols-2 gap-4">
<?php
$ay=$data['ayah']??[];
$pendidikan=['SD'=>'SD','SMP'=>'SMP','SMA/SMK'=>'SMA/SMK','D3'=>'D3','S1'=>'S1','S2/S3'=>'S2/S3'];
$penghasilan=['<1jt'=>'< Rp 1.000.000','1-3jt'=>'Rp 1-3 Juta','3-5jt'=>'Rp 3-5 Juta','>5jt'=>'> Rp 5 Juta'];
inp('nama_ayah','Nama Ayah',$ay['nama_ayah']??'','text',false);
inp('nik_ayah','NIK Ayah',$ay['nik_ayah']??'','text',false, 'maxlength="16" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,\'\')"');
inp('tahun_lahir_ayah','Tahun Lahir',$ay['tahun_lahir_ayah']??'','number',false);
sel('pendidikan_ayah','Pendidikan',$ay['pendidikan_ayah']??'',$pendidikan,false);
inp('pekerjaan_ayah','Pekerjaan',$ay['pekerjaan_ayah']??'','text',false);
sel('penghasilan_bulanan_ayah','Penghasilan Bulanan',$ay['penghasilan_bulanan_ayah']??'',$penghasilan,false);
inp('kebutuhan_khusus_ayah','Kebutuhan Khusus (jika ada)',$ay['kebutuhan_khusus_ayah']??'','text',false);
?>
</div></div></div>
<div class="flex justify-between mt-2">
  <button type="button" onclick="prevStep(1)" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl text-sm uppercase hover:bg-slate-50 transition-all shadow-sm"><i class="fas fa-arrow-left mr-2"></i> Kembali</button>
  <button type="button" onclick="nextStep(3)" class="px-8 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-bold rounded-xl text-sm uppercase tracking-wider hover:from-emerald-700 hover:to-emerald-800 transition-all shadow-md shadow-emerald-200/50">Lanjut <i class="fas fa-arrow-right ml-2"></i></button>
</div>
</form>

<!-- Step 3: Data Ibu -->
<form id="form-3" class="step-form hidden space-y-4" data-url="<?=base_url('student/save_ibu')?>">
<?php if($is_revisi && isset($revisi_data_fw['ortu'])): ?>
<div class="p-3 bg-red-50 border-2 border-red-300 rounded-xl mb-2 flex items-center">
  <i class="fas fa-exclamation-circle text-red-500 mr-2 text-sm"></i>
  <span class="text-xs font-bold text-red-700">Admin meminta perbaikan data orang tua</span>
</div>
<?php endif; ?>
<div class="bg-white rounded-2xl border <?= ($is_revisi && isset($revisi_data_fw['ortu'])) ? 'border-red-300 ring-2 ring-red-100' : 'border-slate-200' ?> shadow-sm overflow-hidden">
<div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r <?= ($is_revisi && isset($revisi_data_fw['ortu'])) ? 'from-red-50 to-white' : 'from-rose-50 to-white' ?> flex items-center space-x-3">
  <div class="w-8 h-8 <?= ($is_revisi && isset($revisi_data_fw['ortu'])) ? 'bg-red-100 text-red-600' : 'bg-rose-100 text-rose-600' ?> rounded-lg flex items-center justify-center text-sm"><i class="fas fa-female"></i></div>
  <h3 class="font-black text-slate-800 uppercase tracking-tight text-sm">Data Ibu Kandung</h3>
  <?php if($is_revisi && isset($revisi_data_fw['ortu'])): ?><span class="ml-auto text-[9px] font-black text-red-600 bg-red-100 px-2 py-0.5 rounded-full uppercase tracking-wider animate-pulse">Revisi</span><?php endif; ?>
</div>
<div class="p-6"><div class="grid grid-cols-2 gap-4">
<?php
$ib=$data['ibu']??[];
inp('nama_ibu','Nama Ibu',$ib['nama_ibu']??'','text',false);
inp('nik_ibu','NIK Ibu',$ib['nik_ibu']??'','text',false, 'maxlength="16" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,\'\')"');
inp('tahun_lahir_ibu','Tahun Lahir',$ib['tahun_lahir_ibu']??'','number',false);
sel('pendidikan_ibu','Pendidikan',$ib['pendidikan_ibu']??'',$pendidikan,false);
inp('pekerjaan_ibu','Pekerjaan',$ib['pekerjaan_ibu']??'','text',false);
sel('penghasilan_bulanan_ibu','Penghasilan Bulanan',$ib['penghasilan_bulanan_ibu']??'',$penghasilan,false);
inp('kebutuhan_khusus_ibu','Kebutuhan Khusus (jika ada)',$ib['kebutuhan_khusus_ibu']??'','text',false);
?>
</div></div></div>
<div class="flex justify-between mt-2">
  <button type="button" onclick="prevStep(2)" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl text-sm uppercase hover:bg-slate-50 transition-all shadow-sm"><i class="fas fa-arrow-left mr-2"></i> Kembali</button>
  <button type="button" onclick="nextStep(4)" class="px-8 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-bold rounded-xl text-sm uppercase tracking-wider hover:from-emerald-700 hover:to-emerald-800 transition-all shadow-md shadow-emerald-200/50">Lanjut <i class="fas fa-arrow-right ml-2"></i></button>
</div>
</form>

<!-- Step 4: Data Wali -->
<form id="form-4" class="step-form hidden space-y-4" data-url="<?=base_url('student/save_wali')?>">
<?php if($is_revisi && isset($revisi_data_fw['ortu'])): ?>
<div class="p-3 bg-red-50 border-2 border-red-300 rounded-xl mb-2 flex items-center">
  <i class="fas fa-exclamation-circle text-red-500 mr-2 text-sm"></i>
  <span class="text-xs font-bold text-red-700">Admin meminta perbaikan data orang tua / wali</span>
</div>
<?php endif; ?>
<div class="bg-white rounded-2xl border <?= ($is_revisi && isset($revisi_data_fw['ortu'])) ? 'border-red-300 ring-2 ring-red-100' : 'border-slate-200' ?> shadow-sm overflow-hidden">
<div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r <?= ($is_revisi && isset($revisi_data_fw['ortu'])) ? 'from-red-50 to-white' : 'from-amber-50 to-white' ?> flex items-center space-x-3">
  <div class="w-8 h-8 <?= ($is_revisi && isset($revisi_data_fw['ortu'])) ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-600' ?> rounded-lg flex items-center justify-center text-sm"><i class="fas fa-user-friends"></i></div>
  <h3 class="font-black text-slate-800 uppercase tracking-tight text-sm">Data Wali <span class="text-amber-600 font-semibold normal-case text-xs ml-2 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200">Opsional</span></h3>
  <?php if($is_revisi && isset($revisi_data_fw['ortu'])): ?><span class="ml-auto text-[9px] font-black text-red-600 bg-red-100 px-2 py-0.5 rounded-full uppercase tracking-wider animate-pulse">Revisi</span><?php endif; ?>
</div>
<div class="p-6"><div class="grid grid-cols-2 gap-4">
<?php
$wl=$data['wali']??[];
inp('nama_wali','Nama Wali',$wl['nama_wali']??'','text',false);
inp('nik_wali','NIK Wali',$wl['nik_wali']??'','text',false, 'maxlength="16" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,\'\')"');
inp('tahun_lahir_wali','Tahun Lahir',$wl['tahun_lahir_wali']??'','number',false);
sel('pendidikan_wali','Pendidikan',$wl['pendidikan_wali']??'',$pendidikan,false);
inp('pekerjaan_wali','Pekerjaan',$wl['pekerjaan_wali']??'','text',false);
sel('penghasilan_bulanan_wali','Penghasilan Bulanan',$wl['penghasilan_bulanan_wali']??'',$penghasilan,false);
inp('kebutuhan_khusus_wali','Kebutuhan Khusus (jika ada)',$wl['kebutuhan_khusus_wali']??'','text',false);
?>
</div></div></div>
<div class="flex justify-between mt-2">
  <button type="button" onclick="prevStep(3)" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl text-sm uppercase hover:bg-slate-50 transition-all shadow-sm"><i class="fas fa-arrow-left mr-2"></i> Kembali</button>
  <div class="flex space-x-3">
    <button type="button" onclick="saveAndNext(5)" class="px-6 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl text-sm uppercase hover:bg-slate-200 transition-all border border-slate-200">Lewati <i class="fas fa-angle-double-right ml-1"></i></button>
    <button type="button" onclick="nextStep(5)" class="px-8 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-bold rounded-xl text-sm uppercase tracking-wider hover:from-emerald-700 hover:to-emerald-800 transition-all shadow-md shadow-emerald-200/50">Simpan & Lanjut <i class="fas fa-arrow-right ml-2"></i></button>
  </div>
</div>
</form>

<!-- Step 5: Kontak & Periodik + Submit -->
<form id="form-5" class="step-form hidden space-y-4" data-url="<?=base_url('student/save_kontak_periodik')?>">
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
<div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-teal-50 to-white flex items-center space-x-3">
  <div class="w-8 h-8 bg-teal-100 text-teal-600 rounded-lg flex items-center justify-center text-sm"><i class="fas fa-phone-alt"></i></div>
  <h3 class="font-black text-slate-800 uppercase tracking-tight text-sm">Data Kontak</h3>
</div>
<div class="p-6 space-y-4">
<div class="grid grid-cols-2 gap-4">
<?php
$kn=$data['kontak']??[];
inp('notlp_rumah','No. Telepon Rumah',$kn['notlp_rumah']??'');
inp('no_hp','No. HP / WhatsApp *',$kn['no_hp']??'');
inp('email','Email Aktif',$kn['email']??'','email',false);
?>
</div>
<div class="pt-2 border-t border-slate-100 mt-4">
<div class="flex items-center space-x-3 mb-4">
  <div class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center text-sm"><i class="fas fa-ruler-combined"></i></div>
  <h3 class="font-black text-slate-800 uppercase tracking-tight text-sm">Data Periodik</h3>
</div>
<div class="grid grid-cols-3 gap-4">
<?php
$pe=$data['periodik']??[];
inp('tinggi_badan','Tinggi Badan (cm)',$pe['tinggi_badan']??'');
inp('berat_badan','Berat Badan (kg)',$pe['berat_badan']??'');

sel('jarak_tempat_tinggal','Jarak ke Sekolah',$pe['jarak_tempat_tinggal']??'',['kurang_dari_1_km'=>'< 1 KM','lebih_dari_1_km'=>'> 1 KM']);
inp('jarak_km','Jarak (KM)',$pe['jarak_km']??'');
inp('jumlah_saudara_kandung','Jml Saudara Kandung',$pe['jumlah_saudara_kandung']??'','number');
?>
<div class="time-input-wrapper"><label class='block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5'>Waktu Tempuh</label>
<div class="flex space-x-2"><input type="number" name="waktu_jam" placeholder="Jam" value="<?=htmlspecialchars($pe['waktu_jam']??'')?>" required class="w-1/2 px-4 py-2.5 border border-slate-200 rounded-lg text-sm bg-slate-50/50"><input type="number" name="waktu_menit" placeholder="Menit" value="<?=htmlspecialchars($pe['waktu_menit']??'')?>" required class="w-1/2 px-4 py-2.5 border border-slate-200 rounded-lg text-sm bg-slate-50/50"></div></div>
</div>
</div>

<!-- Asal Sekolah TK/PAUD -->
<div class="pt-4 border-t border-slate-100 mt-2">
  <div class="flex items-center space-x-3 mb-4">
    <div class="w-8 h-8 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center text-sm"><i class="fas fa-school"></i></div>
    <h3 class="font-black text-slate-800 uppercase tracking-tight text-sm">Asal Sekolah TK / PAUD</h3>
  </div>
  <div class="grid grid-cols-2 gap-4">
    <?php
    inp('asal_sekolah', 'Nama TK / PAUD Asal', $pe['asal_sekolah'] ?? '', 'text', false);
    sel('jenis_sekolah_asal', 'Jenis Sekolah Asal', $pe['jenis_sekolah_asal'] ?? '', ['TK' => 'TK (Taman Kanak-Kanak)', 'PAUD' => 'PAUD', 'Lainnya' => 'Lainnya'], false);
    ?>
  </div>
</div>
</div></div>

<div class="flex justify-between mt-2">
  <button type="button" onclick="prevStep(4)" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl text-sm uppercase hover:bg-slate-50 transition-all shadow-sm"><i class="fas fa-arrow-left mr-2"></i> Kembali</button>
  <button type="button" onclick="nextStep(6)" class="px-8 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-bold rounded-xl text-sm uppercase tracking-wider hover:from-emerald-700 hover:to-emerald-800 transition-all shadow-md shadow-emerald-200/50">Lanjut <i class="fas fa-arrow-right ml-2"></i></button>
</div>
</form>

<!-- Step 6: Upload Berkas -->
<form id="form-6" class="step-form hidden space-y-4" data-url="<?=base_url('student/save_upload_ajax')?>" enctype="multipart/form-data">
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
<div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-teal-50 to-white flex items-center space-x-3">
  <div class="w-8 h-8 bg-teal-100 text-teal-600 rounded-lg flex items-center justify-center text-sm"><i class="fas fa-file-upload"></i></div>
  <h3 class="font-black text-slate-800 uppercase tracking-tight text-sm">Upload Berkas Persyaratan</h3>
</div>
<div class="p-6">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
  <?php 
  $docs = [
      'ijazah'  => ['title'=>'Ijazah / SKL','sub'=>'Scan Ijazah (PDF)','icon'=>'fa-graduation-cap','gradient'=>'from-indigo-500 to-blue-600', 'accept'=>'application/pdf'],
      'kk'      => ['title'=>'Kartu Keluarga','sub'=>'Scan KK asli (PDF)','icon'=>'fa-users','gradient'=>'from-teal-500 to-cyan-600', 'accept'=>'application/pdf'],
      'akta'    => ['title'=>'Akta Kelahiran','sub'=>'Scan akta asli (PDF)','icon'=>'fa-child','gradient'=>'from-emerald-500 to-teal-500', 'accept'=>'application/pdf'],
      'foto_3x4'=> ['title'=>'Pas Foto 3x4','sub'=>'Latar merah (JPG/PNG)','icon'=>'fa-portrait','gradient'=>'from-emerald-600 to-emerald-700', 'accept'=>'image/jpeg,image/png,image/jpg']
  ];
  $d = $data['dokumen'] ?? [];
  foreach($docs as $key => $info):
      $path = $d[$key] ?? null;
  ?>
  <div class="bg-slate-50 rounded-xl border border-slate-200 p-4 flex flex-col justify-between">
    <div class="flex items-center space-x-3 mb-3">
       <div class="w-10 h-10 bg-gradient-to-br <?= $info['gradient'] ?> rounded-lg flex items-center justify-center text-white flex-shrink-0">
          <i class="fas <?= $info['icon'] ?>"></i>
       </div>
       <div>
          <h4 class="font-bold text-slate-800 text-sm"><?= $info['title'] ?></h4>
          <p class="text-[10px] text-slate-500 font-medium"><?= $info['sub'] ?></p>
       </div>
       <?php if($path): ?><i class="fas fa-check-circle text-emerald-500 ml-auto"></i><?php endif; ?>
    </div>
    <?php if($path): ?>
      <a href="<?= base_url($path) ?>" target="_blank" class="text-[10px] text-blue-600 font-bold mb-2 block"><i class="fas fa-external-link-alt mr-1"></i> Lihat File Tersimpan</a>
    <?php endif; ?>
    <input type="file" name="<?= $key ?>" id="<?= $key ?>" accept="<?= $info['accept'] ?>" <?= !$path ? 'required' : '' ?> class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-colors bg-white rounded-lg border border-slate-200 p-1">
  </div>
  <?php endforeach; ?>
  </div>
</div>
</div>
<div class="flex justify-between mt-2">
  <button type="button" onclick="prevStep(5)" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl text-sm uppercase hover:bg-slate-50 transition-all shadow-sm"><i class="fas fa-arrow-left mr-2"></i> Kembali</button>
  <button type="button" onclick="openModal()" class="px-10 py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-black rounded-xl text-sm uppercase tracking-widest hover:from-emerald-700 hover:to-teal-700 transition-all shadow-lg shadow-emerald-200/50">
    <i class="fas fa-check-circle mr-2"></i> Kirim Pendaftaran
  </button>
</div>
</form>

</div></main>

<!-- Custom Confirm Modal -->
<div id="confirm-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 opacity-0">
  <div id="confirm-modal-box" class="bg-white rounded-2xl shadow-xl border border-slate-200 max-w-sm w-full mx-4 transform scale-95 transition-transform duration-300">
    <div class="p-6 text-center">
      <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fas fa-check-circle text-2xl"></i>
      </div>
      <h3 class="text-lg font-bold text-slate-800 mb-2">Kirim Pendaftaran?</h3>
      <p class="text-[13px] text-slate-500 mb-6 leading-relaxed">Pastikan semua data sudah benar. Setelah dikirim, data tidak bisa diubah karena akan langsung masuk tahap verifikasi admin.</p>
      
      <div class="flex space-x-3">
        <button type="button" onclick="closeModal()" class="flex-1 py-2.5 bg-slate-100 text-slate-600 font-semibold rounded-lg text-[13px] hover:bg-slate-200 transition-colors">Cek Lagi</button>
        <button type="button" id="btn-kirim" onclick="submitFinalForm()" class="flex-1 py-2.5 bg-emerald-600 text-white font-semibold rounded-lg text-[13px] hover:bg-emerald-700 transition-colors">
          <span id="btn-kirim-label"><i class="fas fa-check mr-1.5"></i>Ya, Kirim</span>
          <span id="btn-kirim-loading" class="hidden"><i class="fas fa-circle-notch fa-spin mr-1.5"></i>Proses...</span>
        </button>
      </div>
    </div>
  </div>
</div>

<script>
let currentStep = 1;
const totalSteps = 6;

function showStep(n){
  document.querySelectorAll('.step-form').forEach(f=>f.classList.add('hidden'));
  const f=document.getElementById('form-'+n);
  if(f){f.classList.remove('hidden');f.classList.add('step-form');}
  
  document.querySelectorAll('.step-circle').forEach((c,i)=>{
    const s=i+1;
    if(s<n){
      c.className='w-11 h-11 rounded-xl step-circle flex items-center justify-center text-sm font-black border-2 border-emerald-500 bg-emerald-600 text-white transition-all duration-300 shadow-sm shadow-emerald-200 relative';
    } else if(s===n){
      c.className='w-11 h-11 rounded-xl step-circle flex items-center justify-center text-sm font-black border-2 border-emerald-500 bg-white text-emerald-600 transition-all duration-300 shadow-md shadow-emerald-100 ring-4 ring-emerald-100 relative';
    } else {
      c.className='w-11 h-11 rounded-xl step-circle flex items-center justify-center text-sm font-black border-2 border-slate-200 bg-slate-50 text-slate-400 transition-all duration-300 shadow-sm relative';
    }
  });
  document.querySelectorAll('.step-line').forEach((l,i)=>{
    const s=i+2;
    l.className='flex-1 h-0.5 mx-3 step-line rounded-full transition-colors duration-300 '+(s<=n?'bg-emerald-500':'bg-slate-200');
  });
  document.querySelectorAll('.step-label').forEach((l,i)=>{
    const s=i+1;
    l.className='text-[9px] font-bold mt-1.5 uppercase tracking-wider whitespace-nowrap step-label '+(s<=n?'text-emerald-600':'text-slate-400');
  });
  currentStep=n;
  window.scrollTo({top:0,behavior:'smooth'});
}

function autoSave(step){
  const form=document.getElementById('form-'+step);
  if(!form) return Promise.resolve();
  const url=form.getAttribute('data-url');
  if(!url) return Promise.resolve();
  const fd=new FormData(form);
  return fetch(url,{method:'POST',body:fd}).then(r=>r.json()).then(d=>{
    if(d.status==='success'){
      const s=document.getElementById('save-status');
      s.classList.remove('hidden');s.classList.add('flex');
      setTimeout(()=>{s.classList.add('hidden');s.classList.remove('flex');},2500);
    }
  }).catch(()=>{});
}

function validateForm(step) {
  const form = document.getElementById('form-' + step);
  if (!form) return true;
  
  let isValid = true;
  const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
  
  inputs.forEach(input => {
    const isFieldValid = input.value.trim() !== '';
    if (!isFieldValid) {
      isValid = false;
      // Add red highlighting classes
      input.classList.remove('border-slate-200', 'bg-slate-50/50');
      input.classList.add('border-red-400', 'bg-red-50/10', 'ring-2', 'ring-red-100');
      
      // Add error message if not present
      let errMsg = input.parentNode.querySelector('.input-error-msg');
      if (!errMsg) {
        errMsg = document.createElement('span');
        errMsg.className = 'text-[10px] text-red-500 font-bold block mt-1.5 input-error-msg';
        errMsg.innerHTML = '<i class="fas fa-exclamation-circle mr-1"></i>Kolom ini wajib diisi!';
        input.parentNode.appendChild(errMsg);
      }
    } else {
      // Clear highlight if valid
      input.classList.add('border-slate-200', 'bg-slate-50/50');
      input.classList.remove('border-red-400', 'bg-red-50/10', 'ring-2', 'ring-red-100');
      const errMsg = input.parentNode.querySelector('.input-error-msg');
      if (errMsg) errMsg.remove();
    }
  });
  
  updateErrorDots();
  return isValid;
}

function updateErrorDots() {
  for (let s = 1; s <= totalSteps; s++) {
    const form = document.getElementById('form-' + s);
    if (!form) continue;
    
    let hasEmptyRequired = false;
    const requiredInputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    requiredInputs.forEach(input => {
      if (input.value.trim() === '') {
        hasEmptyRequired = true;
      }
    });
    
    const dot = document.querySelector(`.step-item[data-step="${s}"] .error-dot`);
    if (dot) {
      if (hasEmptyRequired) {
        dot.classList.remove('hidden');
      } else {
        dot.classList.add('hidden');
      }
    }
  }
}

function nextStep(to){
  if (!validateForm(currentStep)) {
    const firstInvalid = document.getElementById('form-' + currentStep).querySelector('.border-red-400');
    if (firstInvalid) firstInvalid.focus();
    return;
  }
  autoSave(currentStep).then(()=>showStep(to));
}
function prevStep(to){showStep(to);}
function saveAndNext(to){showStep(to);}
function goStep(to){
  const urlParams = new URLSearchParams(window.location.search);
  const isFixing = urlParams.get('error') === 'incomplete';
  if (isFixing || to <= currentStep || to === currentStep + 1) {
    if (to > currentStep && !isFixing) {
      if (!validateForm(currentStep)) {
        const firstInvalid = document.getElementById('form-' + currentStep).querySelector('.border-red-400');
        if (firstInvalid) firstInvalid.focus();
        return;
      }
    }
    autoSave(currentStep).then(()=>showStep(to));
  }
}

let timer=null;
document.querySelectorAll('.step-form input, .step-form select, .step-form textarea').forEach(el=>{
  el.addEventListener('change',()=>{clearTimeout(timer);timer=setTimeout(()=>autoSave(currentStep),800);});
});

// Setup instant input clearing and auto-highlight on load if backend reports error
document.querySelectorAll('.step-form input[required], .step-form select[required], .step-form textarea[required]').forEach(input => {
  const handler = () => {
    if (input.value.trim() !== '') {
      input.classList.add('border-slate-200', 'bg-slate-50/50');
      input.classList.remove('border-red-400', 'bg-red-50/10', 'ring-2', 'ring-red-100');
      const errMsg = input.parentNode.querySelector('.input-error-msg');
      if (errMsg) errMsg.remove();
      updateErrorDots();
    }
  };
  input.addEventListener('input', handler);
  input.addEventListener('change', handler);
});

function checkAndHighlightAllOnLoad() {
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('error') === 'incomplete') {
    for (let s = 1; s <= totalSteps; s++) {
      validateForm(s);
    }
  }
}

function openModal() {
  let allValid = true;
  let firstInvalidStep = null;
  
  for (let s = 1; s <= totalSteps; s++) {
    if (!validateForm(s)) {
      allValid = false;
      if (firstInvalidStep === null) {
        firstInvalidStep = s;
      }
    }
  }
  
  if (!allValid) {
    showStep(firstInvalidStep);
    const firstInvalid = document.getElementById('form-' + firstInvalidStep).querySelector('.border-red-400');
    if (firstInvalid) firstInvalid.focus();
    return;
  }
  
  const modal = document.getElementById('confirm-modal');
  const box = document.getElementById('confirm-modal-box');
  modal.classList.remove('hidden');
  modal.classList.add('flex');
  // Trigger animation
  setTimeout(() => {
    modal.classList.remove('opacity-0');
    box.classList.remove('scale-95');
  }, 10);
}

function closeModal() {
  const modal = document.getElementById('confirm-modal');
  const box = document.getElementById('confirm-modal-box');
  modal.classList.add('opacity-0');
  box.classList.add('scale-95');
  setTimeout(() => {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }, 300);
}

function submitFinalForm() {
  // Show loading state
  document.getElementById('btn-kirim-label').classList.add('hidden');
  document.getElementById('btn-kirim-loading').classList.remove('hidden');
  document.getElementById('btn-kirim').disabled = true;

  const f = document.createElement('form');
  f.method = 'POST';
  f.action = '<?=base_url("student/submit_form")?>';
  document.body.appendChild(f);
  f.submit();
}

checkAndHighlightAllOnLoad();
showStep(1);
</script>
</body></html>
