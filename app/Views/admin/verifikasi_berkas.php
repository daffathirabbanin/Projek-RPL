<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detail & Verifikasi | Admin PPDB</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
body{font-family:'Plus Jakarta Sans',sans-serif;background:#f8fafc}
.card-hover{transition:all .3s cubic-bezier(.4,0,.2,1)}.card-hover:hover{transform:translateY(-2px);box-shadow:0 10px 15px -3px rgba(0,0,0,.05)}
</style>
</head>
<body class="text-slate-800 flex h-screen overflow-hidden">
    <!-- Admin Sidebar -->
    <?php require_once '../app/Views/admin/_sidebar.php'; adminSidebar('pendaftar'); ?>

    <main class="flex-1 flex flex-col h-full overflow-y-auto">
        <header class="bg-white/80 backdrop-blur-md px-8 py-5 border-b border-slate-200/60 flex items-center space-x-4 sticky top-0 z-10">
            <a href="<?= base_url('admin/pendaftar') ?>" class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center hover:bg-slate-200 transition-colors shadow-sm"><i class="fas fa-arrow-left text-sm text-slate-500"></i></a>
            <div>
                <h2 class="text-xl font-black text-slate-800 tracking-tight">DETAIL & VERIFIKASI</h2>
                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-[0.15em] mt-0.5">REG-<?= str_pad($data['pendaftaran']['id'], 4, '0', STR_PAD_LEFT) ?></p>
            </div>
        </header>

        <div class="p-8 max-w-6xl mx-auto w-full pb-20">
            <?php if(isset($_GET['success'])): ?>
            <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl text-sm font-bold mb-6 border border-emerald-200 flex items-center shadow-sm">
                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center mr-4"><i class="fas fa-check-circle text-lg"></i></div>
                Status berhasil diperbarui!
            </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left: Data -->
                <div class="lg:col-span-2 space-y-6">
                    <?php 
                    function box($title, $icon, $color, $items) {
                        echo '<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden card-hover">';
                        echo '<div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-'.$color.'-50 to-white flex items-center space-x-3">';
                        echo '<div class="w-8 h-8 bg-'.$color.'-100 text-'.$color.'-600 rounded-lg flex items-center justify-center text-sm"><i class="fas '.$icon.'"></i></div>';
                        echo '<h3 class="font-black text-slate-800 text-sm uppercase tracking-tight">'.$title.'</h3></div>';
                        echo '<div class="p-6 grid grid-cols-2 gap-x-8 gap-y-4 text-sm">';
                        foreach($items as $k=>$v) {
                            echo "<div><p class='text-[10px] font-bold text-slate-400 uppercase tracking-[0.12em] mb-1'>$k</p><p class='font-bold text-slate-800'>".($v?:'-')."</p></div>";
                        }
                        echo '</div></div>';
                    }

                    $p = $data['pribadi']??[];
                    box('Data Pribadi Siswa', 'fa-user', 'emerald', [
                        'Nama Lengkap' => $p['nama_lengkap']??'',
                        'Email (Akun)' => $data['pendaftaran']['email']??'',
                        'Jenis Kelamin' => ($p['jenis_kelamin']??'')=='L'?'Laki-laki':(($p['jenis_kelamin']??'')=='P'?'Perempuan':''),
                        'NISN' => $p['nisn']??'',
                        'NIK' => $p['nik']??'',
                        'No. KK' => $p['no_kk']??'',
                        'Tempat, Tgl Lahir' => ($p['tempat_lahir']??'').', '.($p['tanggal_lahir']??''),
                        'Alamat' => ($p['alamat_jalan']??'').' RT '.($p['rt']??'').'/RW '.($p['rw']??'').', '.($p['kelurahan']??'').', '.($p['kecamatan']??'')
                    ]);

                    $a = $data['ayah']??[];
                    if($a) box('Data Ayah Kandung', 'fa-male', 'teal', [
                        'Nama Ayah' => $a['nama_ayah']??'', 'NIK' => $a['nik_ayah']??'', 'Pendidikan' => $a['pendidikan_ayah']??'', 'Pekerjaan' => $a['pekerjaan_ayah']??'', 'Penghasilan' => $a['penghasilan_bulanan_ayah']??''
                    ]);

                    $i = $data['ibu']??[];
                    if($i) box('Data Ibu Kandung', 'fa-female', 'rose', [
                        'Nama Ibu' => $i['nama_ibu']??'', 'NIK' => $i['nik_ibu']??'', 'Pendidikan' => $i['pendidikan_ibu']??'', 'Pekerjaan' => $i['pekerjaan_ibu']??'', 'Penghasilan' => $i['penghasilan_bulanan_ibu']??''
                    ]);

                    $w = $data['wali']??[];
                    if($w && !empty($w['nama_wali'])) box('Data Wali', 'fa-user-friends', 'amber', [
                        'Nama Wali' => $w['nama_wali']??'', 'NIK' => $w['nik_wali']??'', 'Pekerjaan' => $w['pekerjaan_wali']??''
                    ]);

                    $k = $data['kontak']??[];
                    $pe = $data['periodik']??[];
                    box('Kontak & Periodik', 'fa-phone-alt', 'cyan', [
                        'No. HP / WA' => $k['no_hp']??'', 'Telepon Rumah' => $k['notlp_rumah']??'',
                        'Tinggi/Berat' => ($pe['tinggi_badan']??'-').' cm / '.($pe['berat_badan']??'-').' kg',
                        'Jarak' => ($pe['jarak_km']??'-').' km', 'Waktu Tempuh' => ($pe['waktu_jam']??'0').' Jam '.($pe['waktu_menit']??'0').' Menit'
                    ]);
                    ?>

                    <!-- Dokumen -->
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden card-hover">
                        <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-emerald-50 to-white flex items-center space-x-3">
                            <div class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center text-sm"><i class="fas fa-folder-open"></i></div>
                            <h3 class="font-black text-slate-800 text-sm uppercase tracking-tight">Berkas Dokumen</h3>
                        </div>
                        <div class="p-6 space-y-3">
                            <?php 
                            $docs = ['ijazah'=>'Ijazah / SKL','kk'=>'Kartu Keluarga','akta'=>'Akta Kelahiran','foto_3x4'=>'Pas Foto 3x4'];
                            $d = $data['dokumen']??[];
                            foreach($docs as $key => $label):
                                $path = $d[$key] ?? null;
                            ?>
                            <div class="flex items-center justify-between p-4 bg-slate-50/80 rounded-xl border border-slate-100">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 <?= $path ? 'bg-emerald-100 text-emerald-600' : 'bg-red-100 text-red-500' ?> rounded-lg flex items-center justify-center text-xs"><i class="fas <?= $path ? 'fa-check' : 'fa-times' ?>"></i></div>
                                    <p class="font-bold text-slate-800 text-sm"><?= $label ?></p>
                                </div>
                                <?php if($path): ?>
                                    <a href="<?= base_url($path) ?>" target="_blank" class="px-3 py-1.5 bg-teal-100 text-teal-700 text-[10px] font-bold uppercase rounded-lg hover:bg-teal-200 transition-colors"><i class="fas fa-external-link-alt mr-1"></i> Lihat</a>
                                <?php else: ?>
                                    <span class="text-[10px] font-bold text-red-400 uppercase">Belum diunggah</span>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Right: Aksi -->
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden sticky top-24">
                        <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-emerald-50 to-white flex items-center space-x-3">
                            <div class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center text-sm"><i class="fas fa-gavel"></i></div>
                            <h3 class="font-black text-slate-800 text-sm uppercase tracking-tight">Keputusan</h3>
                        </div>
                        <div class="p-6">
                            <?php 
                            $status = $data['pendaftaran']['status'];
                            $badge = [
                                'belum_mendaftar'   => 'bg-slate-100 text-slate-600 border-slate-200',
                                'nunggu_verifikasi' => 'bg-amber-50 text-amber-700 border-amber-200',
                                'dokumen_diterima'  => 'bg-blue-50 text-blue-700 border-blue-200',
                                'diterima'          => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'ditolak'           => 'bg-red-50 text-red-700 border-red-200',
                                'perlu_revisi'      => 'bg-rose-50 text-rose-700 border-rose-200 animate-pulse'
                            ];
                            $lbl = [
                                'belum_mendaftar'   => 'Draft',
                                'nunggu_verifikasi' => 'Menunggu',
                                'dokumen_diterima'  => 'BERKAS VALID',
                                'diterima'          => 'DITERIMA',
                                'ditolak'           => 'DITOLAK',
                                'perlu_revisi'      => 'BUTUH REVISI'
                            ];
                            
                            $revisi_data = [];
                            if (!empty($data['pendaftaran']['revisi_json'])) {
                                $revisi_data = json_decode($data['pendaftaran']['revisi_json'], true) ?: [];
                            }
                            ?>
                            <div class="mb-5 text-center p-4 rounded-xl border <?= $badge[$status] ?? '' ?>">
                                <p class="text-[9px] font-bold uppercase tracking-[0.2em] opacity-60 mb-1">Status Saat Ini</p>
                                <p class="font-black uppercase text-lg"><?= $lbl[$status] ?? $status ?></p>
                            </div>

                            <form action="<?= base_url('admin/update_status') ?>" method="POST" class="space-y-4">
                                <input type="hidden" name="pendaftaran_id" value="<?= $data['pendaftaran']['id'] ?>">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Ubah Status</label>
                                    <select name="status" id="status-select" class="block w-full px-4 py-3 border border-slate-200 rounded-xl text-sm bg-slate-50/50 hover:bg-white transition-colors focus:border-emerald-500 focus:outline-none">
                                        <option value="nunggu_verifikasi" <?= $status == 'nunggu_verifikasi' ? 'selected' : '' ?>>Menunggu Verifikasi</option>
                                        <option value="dokumen_diterima" <?= $status == 'dokumen_diterima' ? 'selected' : '' ?>>Formulir & Dokumen Diterima</option>
                                        <option value="perlu_revisi" <?= $status == 'perlu_revisi' ? 'selected' : '' ?>>Kembalikan untuk Revisi</option>
                                        <option value="diterima" <?= $status == 'diterima' ? 'selected' : '' ?>>DITERIMA (Lulus)</option>
                                        <option value="ditolak" <?= $status == 'ditolak' ? 'selected' : '' ?>>DITOLAK (Tidak Lulus)</option>
                                    </select>
                                </div>
                                
                                <!-- Checklist Revisi -->
                                <div id="revision-checklist-container" class="hidden p-4 bg-amber-50/50 border border-amber-200 rounded-xl space-y-3 mt-4">
                                    <p class="text-[10px] font-black text-amber-700 uppercase tracking-widest mb-1 flex items-center">
                                        <i class="fas fa-exclamation-triangle mr-1.5 text-xs"></i> Checklist Bagian Bermasalah
                                    </p>
                                    
                                    <!-- Biodata -->
                                    <div class="space-y-1.5">
                                        <label class="flex items-center space-x-2.5 cursor-pointer text-xs font-bold text-slate-700 select-none">
                                            <input type="checkbox" name="revisi_items[]" value="pribadi" <?= isset($revisi_data['pribadi']) ? 'checked' : '' ?> class="revisi-checkbox w-4 h-4 text-amber-600 border-slate-300 rounded cursor-pointer">
                                            <span>Formulir Biodata Pribadi</span>
                                        </label>
                                        <input type="text" name="revisi_note_pribadi" value="<?= htmlspecialchars($revisi_data['pribadi'] ?? '') ?>" placeholder="cth: NIK tidak valid / Alamat kurang RT/RW..." class="revisi-note <?= isset($revisi_data['pribadi']) ? '' : 'hidden' ?> w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs bg-white focus:border-amber-500 focus:outline-none">
                                    </div>

                                    <!-- Data Ortu -->
                                    <div class="space-y-1.5">
                                        <label class="flex items-center space-x-2.5 cursor-pointer text-xs font-bold text-slate-700 select-none">
                                            <input type="checkbox" name="revisi_items[]" value="ortu" <?= isset($revisi_data['ortu']) ? 'checked' : '' ?> class="revisi-checkbox w-4 h-4 text-amber-600 border-slate-300 rounded cursor-pointer">
                                            <span>Data Orang Tua / Wali</span>
                                        </label>
                                        <input type="text" name="revisi_note_ortu" value="<?= htmlspecialchars($revisi_data['ortu'] ?? '') ?>" placeholder="cth: Nama ibu kandung harus lengkap..." class="revisi-note <?= isset($revisi_data['ortu']) ? '' : 'hidden' ?> w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs bg-white focus:border-amber-500 focus:outline-none">
                                    </div>

                                    <!-- Ijazah -->
                                    <div class="space-y-1.5">
                                        <label class="flex items-center space-x-2.5 cursor-pointer text-xs font-bold text-slate-700 select-none">
                                            <input type="checkbox" name="revisi_items[]" value="ijazah" <?= isset($revisi_data['ijazah']) ? 'checked' : '' ?> class="revisi-checkbox w-4 h-4 text-amber-600 border-slate-300 rounded cursor-pointer">
                                            <span>Berkas Ijazah / SKL</span>
                                        </label>
                                        <input type="text" name="revisi_note_ijazah" value="<?= htmlspecialchars($revisi_data['ijazah'] ?? '') ?>" placeholder="cth: Scan buram / tidak terbaca..." class="revisi-note <?= isset($revisi_data['ijazah']) ? '' : 'hidden' ?> w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs bg-white focus:border-amber-500 focus:outline-none">
                                    </div>

                                    <!-- KK -->
                                    <div class="space-y-1.5">
                                        <label class="flex items-center space-x-2.5 cursor-pointer text-xs font-bold text-slate-700 select-none">
                                            <input type="checkbox" name="revisi_items[]" value="kk" <?= isset($revisi_data['kk']) ? 'checked' : '' ?> class="revisi-checkbox w-4 h-4 text-amber-600 border-slate-300 rounded cursor-pointer">
                                            <span>Berkas Kartu Keluarga (KK)</span>
                                        </label>
                                        <input type="text" name="revisi_note_kk" value="<?= htmlspecialchars($revisi_data['kk'] ?? '') ?>" placeholder="cth: File KK buram / terpotong..." class="revisi-note <?= isset($revisi_data['kk']) ? '' : 'hidden' ?> w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs bg-white focus:border-amber-500 focus:outline-none">
                                    </div>

                                    <!-- Akta -->
                                    <div class="space-y-1.5">
                                        <label class="flex items-center space-x-2.5 cursor-pointer text-xs font-bold text-slate-700 select-none">
                                            <input type="checkbox" name="revisi_items[]" value="akta" <?= isset($revisi_data['akta']) ? 'checked' : '' ?> class="revisi-checkbox w-4 h-4 text-amber-600 border-slate-300 rounded cursor-pointer">
                                            <span>Berkas Akta Kelahiran</span>
                                        </label>
                                        <input type="text" name="revisi_note_akta" value="<?= htmlspecialchars($revisi_data['akta'] ?? '') ?>" placeholder="cth: Scan akta asli buram..." class="revisi-note <?= isset($revisi_data['akta']) ? '' : 'hidden' ?> w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs bg-white focus:border-amber-500 focus:outline-none">
                                    </div>

                                    <!-- Foto -->
                                    <div class="space-y-1.5">
                                        <label class="flex items-center space-x-2.5 cursor-pointer text-xs font-bold text-slate-700 select-none">
                                            <input type="checkbox" name="revisi_items[]" value="foto_3x4" <?= isset($revisi_data['foto_3x4']) ? 'checked' : '' ?> class="revisi-checkbox w-4 h-4 text-amber-600 border-slate-300 rounded cursor-pointer">
                                            <span>Pas Foto 3x4</span>
                                        </label>
                                        <input type="text" name="revisi_note_foto_3x4" value="<?= htmlspecialchars($revisi_data['foto_3x4'] ?? '') ?>" placeholder="cth: Pas foto harus latar merah..." class="revisi-note <?= isset($revisi_data['foto_3x4']) ? '' : 'hidden' ?> w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs bg-white focus:border-amber-500 focus:outline-none">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Catatan Umum untuk Siswa</label>
                                    <textarea name="catatan" rows="4" class="block w-full px-4 py-3 border border-slate-200 rounded-xl text-sm bg-slate-50/50 hover:bg-white transition-colors focus:border-emerald-500 focus:outline-none" placeholder="Contoh: Berkas KK buram..."><?= htmlspecialchars($data['pendaftaran']['catatan'] ?? '') ?></textarea>
                                </div>
                                <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white text-sm font-black rounded-xl uppercase tracking-widest hover:from-emerald-700 hover:to-emerald-800 transition-all shadow-lg shadow-emerald-200 mt-2">
                                    <i class="fas fa-save mr-2"></i> Simpan Keputusan
                                </button>
                            </form>
                        </div>

                    </div>
                 </div>
            </div>
        </div>
    </main>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('status-select');
        const checklistContainer = document.getElementById('revision-checklist-container');
        
        function toggleChecklist() {
            if (statusSelect.value === 'perlu_revisi') {
                checklistContainer.classList.remove('hidden');
            } else {
                checklistContainer.classList.add('hidden');
            }
        }
        
        statusSelect.addEventListener('change', toggleChecklist);
        toggleChecklist(); // Run on load
        
        // Handle checklist checkboxes
        const checkboxes = document.querySelectorAll('.revisi-checkbox');
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const noteInput = this.closest('.space-y-1.5').querySelector('.revisi-note');
                if (this.checked) {
                    noteInput.classList.remove('hidden');
                    noteInput.focus();
                } else {
                    noteInput.classList.add('hidden');
                }
            });
        });
    });
    </script>
</body>
</html>
