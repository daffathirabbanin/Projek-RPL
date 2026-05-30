<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?? 'Cetak Formulir Pendaftaran' ?> | PPDB Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');
        
        @media print {
            @page { margin: 0; size: A4; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; background-color: white !important; }
            .no-print { display: none !important; }
        }
        body { font-family: 'Poppins', sans-serif; background-color: #e8e8e8; }
        
        .document {
            font-family: 'Times New Roman', Times, serif;
            background: white;
            color: #1a1a1a;
        }

        .kop-border-outer {
            border: 3px solid #1a3a2a;
        }
        .kop-border-inner {
            border: 1px solid #1a3a2a;
            margin: 3px;
        }

        .doc-table td, .doc-table th {
            padding: 3px 6px;
            font-size: 11px;
            vertical-align: top;
        }

        .section-header {
            background: #1a3a2a;
            color: white;
            font-weight: 700;
            font-size: 10px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 5px 12px;
        }

        .field-row {
            display: grid;
            grid-template-columns: 160px 12px 1fr;
            gap: 0;
            padding: 3px 0;
            border-bottom: 1px dotted #ccc;
            font-size: 11px;
            align-items: baseline;
        }
        .field-row:last-child { border-bottom: none; }
        .field-label { color: #555; font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; }
        .field-value { font-weight: 700; color: #111; font-size: 11px; }

        .sign-box {
            border: 1px solid #333;
            height: 80px;
            background: #fafafa;
        }

        @media print {
            body { background-color: white; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none !important; }
            .document {
                box-shadow: none !important;
                margin: 0 !important;
                width: 210mm !important;
                max-width: 210mm !important;
            }
            @page { margin: 10mm; size: A4 portrait; }
            .page-break { page-break-before: always; }
            main { overflow: visible !important; height: auto !important; }
        }
    </style>
</head>
<body class="text-slate-800 flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <?php require_once '../app/Views/student/_sidebar.php'; studentSidebar('pengumuman'); ?>

    <?php
    $p = $data['pribadi'] ?? [];
    $ayah = $data['ayah'] ?? [];
    $ibu = $data['ibu'] ?? [];
    $wali = $data['wali'] ?? [];
    $kontak = $data['kontak'] ?? [];
    $periodik = $data['periodik'] ?? [];
    $dok = $data['dokumen'] ?? [];
    $pend_id = $data['pendaftaran']['id'] ?? '0';
    $reg_no = 'REG-' . str_pad($pend_id, 4, '0', STR_PAD_LEFT);
    $tahun = date('Y') . '/' . (date('Y')+1);

    function fv($v, $fallback = '—') { return !empty($v) ? htmlspecialchars($v) : $fallback; }

    function frow($label, $value) {
        $v = !empty($value) ? htmlspecialchars($value) : '—';
        echo "<div class='field-row'><span class='field-label'>{$label}</span><span style='color:#555'>:</span><span class='field-value'>{$v}</span></div>";
    }
    ?>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full relative overflow-y-auto">

        <!-- Top Bar (no-print) -->
        <header class="no-print bg-white px-8 py-4 border-b border-slate-200 flex justify-between items-center sticky top-0 z-10 shadow-sm">
            <div>
                <h2 class="text-lg font-black text-slate-800 tracking-tight">CETAK FORMULIR PENDAFTARAN</h2>
                <p class="text-xs text-slate-500 mt-0.5">Dokumen resmi PPDB — harap dicetak pada kertas putih ukuran A4</p>
            </div>
            <button onclick="window.print()" class="px-6 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-lg text-sm uppercase tracking-widest transition-colors shadow-md flex items-center gap-2">
                <i class="fas fa-print"></i> Cetak Sekarang
            </button>
        </header>

        <div class="p-8 flex flex-col items-center bg-slate-300/50 print:bg-white print:p-0 pb-20">

            <!-- ═══════════════════════════════════════════════════════════
                 DOCUMENT
                 ═══════════════════════════════════════════════════════════ -->
            <div class="document w-full max-w-[780px] shadow-2xl">

                <!-- ── KOP SURAT ── -->
                <div class="kop-border-outer">
                    <div class="kop-border-inner p-0">
                        
                        <!-- HEADER AREA (Kop, Judul, Info) menggunakan font Sans-Serif -->
                        <div style="font-family: 'Inter', sans-serif;">
                            <!-- Header KOP -->
                            <div class="flex items-center gap-4 px-6 py-4 border-b-4 border-double border-[#1a3a2a]">
                                <!-- Logo Kiri -->
                                <div class="flex-shrink-0">
                                    <img src="<?= base_url('img/logo.jpeg') ?>" alt="Logo MI" class="w-[72px] h-[72px] object-cover rounded-full border-2 border-[#1a3a2a]">
                                </div>

                                <!-- Teks Tengah -->
                                <div class="flex-1 text-center leading-snug">
                                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#1a3a2a]">KEMENTERIAN AGAMA REPUBLIK INDONESIA</p>
                                    <h1 class="text-[22px] font-black uppercase tracking-widest text-[#1a3a2a] leading-none mt-0.5">MI NURUL IKHLAS AL-AYUBI</h1>
                                    <p class="text-[10px] font-semibold text-slate-600 mt-0.5">Jl. Contoh No. 1, Kel. Kelurahan, Kec. Kecamatan, Kota / Kab.</p>
                                    <p class="text-[10px] text-slate-500">Telp: (021) 000-0000 &nbsp;|&nbsp; Email: ppdb@mi-nuruliikhlas.sch.id &nbsp;|&nbsp; NPSN: 69999999</p>
                                </div>

                                <!-- Lambang Garuda / logo kanan -->
                                <div class="flex-shrink-0 text-center">
                                    <img src="<?= base_url('img/logo.jpeg') ?>" alt="Logo" class="w-[72px] h-[72px] object-cover rounded-full border-2 border-[#1a3a2a] opacity-60 grayscale">
                                </div>
                            </div>

                            <!-- Judul Formulir -->
                            <div class="py-3 text-center border-b border-[#1a3a2a]">
                                <h2 class="text-[15px] font-black uppercase tracking-[0.25em] text-[#1a3a2a]">FORMULIR PENDAFTARAN PESERTA DIDIK BARU</h2>
                                <p class="text-[11px] font-semibold text-slate-600 tracking-widest">TAHUN PELAJARAN <?= $tahun ?></p>
                            </div>

                            <!-- No. Pendaftaran & Tanggal -->
                            <div class="flex justify-between items-center px-6 py-2 bg-[#f0f7f4] border-b border-[#1a3a2a]/30">
                                <div class="flex gap-8">
                                    <div>
                                        <span class="text-[9px] font-bold text-[#1a3a2a] uppercase tracking-wider">No. Pendaftaran</span>
                                        <span class="ml-2 text-[12px] font-black text-[#1a3a2a] font-mono tracking-widest"><?= $reg_no ?></span>
                                    </div>
                                    <div>
                                        <span class="text-[9px] font-bold text-[#1a3a2a] uppercase tracking-wider">Tanggal Daftar</span>
                                        <span class="ml-2 text-[11px] font-bold text-slate-700 tracking-wider"><?= date('d F Y', strtotime($data['pendaftaran']['created_at'] ?? 'now')) ?></span>
                                    </div>
                                    <?php if(!empty($data['jadwal_tes_formatted'])): ?>
                                    <div>
                                        <span class="text-[9px] font-bold text-[#1a3a2a] uppercase tracking-wider">Jadwal Tes</span>
                                        <span class="ml-2 text-[11px] font-bold text-teal-700 tracking-wider"><?= $data['jadwal_tes_formatted'] ?></span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <span class="text-[9px] font-bold text-[#1a3a2a] uppercase tracking-wider">Status</span>
                                    <span class="ml-2 text-[11px] font-black text-[#1a3a2a] uppercase tracking-widest"><?= str_replace('_', ' ', fv($data['pendaftaran']['status'] ?? '', 'Belum Mendaftar')) ?></span>
                                </div>
                            </div>
                        </div>


                        <!-- ════════════════════════════════════════════
                             A. DATA PRIBADI
                             ════════════════════════════════════════════ -->
                        <div>
                            <div class="section-header">A. Data Pribadi Calon Peserta Didik</div>
                            <div class="p-4 grid grid-cols-[1fr_auto]" style="gap: 0 24px;">
                                <!-- Kiri: Data -->
                                <div class="space-y-0">
                                    <?php
                                    frow('Nama Lengkap', $p['nama_lengkap'] ?? ($_SESSION['user_name'] ?? ''));
                                    $jk = ($p['jenis_kelamin'] ?? '') == 'L' ? 'Laki-laki' : (($p['jenis_kelamin'] ?? '') == 'P' ? 'Perempuan' : '-');
                                    frow('Jenis Kelamin', $jk);
                                    frow('Kewarganegaraan', $p['kewarganegaraan'] ?? '');
                                    frow('NISN', $p['nisn'] ?? '');
                                    frow('NIK', $p['nik'] ?? '');
                                    frow('No. Kartu Keluarga', $p['no_kk'] ?? '');
                                    $ttl = (!empty($p['tempat_lahir']) ? $p['tempat_lahir'] : '—') . ', ' . (!empty($p['tanggal_lahir']) ? date('d F Y', strtotime($p['tanggal_lahir'])) : '—');
                                    frow('Tempat, Tanggal Lahir', $ttl);
                                    frow('Agama', $p['agama'] ?? '');
                                    ?>
                                </div>
                                <!-- Kanan: Pas Foto -->
                                <div class="flex flex-col items-center justify-start" style="min-width:100px;">
                                    <div style="width:96px;height:128px;border:2px solid #333;display:flex;align-items:center;justify-content:center;overflow:hidden;background:#f5f5f5;">
                                        <?php if(!empty($dok['foto_3x4'])): ?>
                                            <img src="<?= base_url($dok['foto_3x4']) ?>" alt="Pas Foto" style="width:100%;height:100%;object-fit:cover;">
                                        <?php else: ?>
                                            <span style="font-size:9px;font-weight:700;color:#aaa;text-align:center;text-transform:uppercase;letter-spacing:0.1em;line-height:1.4;">PAS<br>FOTO<br>3×4</span>
                                        <?php endif; ?>
                                    </div>
                                    <p style="font-size:8px;color:#888;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;margin-top:4px;text-align:center;">Pas Foto 3×4</p>
                                </div>
                            </div>
                        </div>

                        <!-- ════════════════════════════════════════════
                             B. ALAMAT
                             ════════════════════════════════════════════ -->
                        <div class="border-t border-[#1a3a2a]/40">
                            <div class="section-header">B. Alamat Tempat Tinggal</div>
                            <div class="p-4 space-y-0">
                                <?php
                                frow('Alamat Jalan', $p['alamat_jalan'] ?? '');
                                $rt_rw = 'RT ' . fv($p['rt'] ?? '') . ' / RW ' . fv($p['rw'] ?? '');
                                frow('RT / RW', $rt_rw);

                                frow('Kelurahan / Desa', $p['kelurahan'] ?? '');
                                frow('Kecamatan', $p['kecamatan'] ?? '');
                                frow('Kode Pos', $p['kode_pos'] ?? '');
                                $tinggal_map = ['ortu'=>'Bersama Orang Tua','wali'=>'Bersama Wali','kos'=>'Kos','asrama'=>'Asrama','panti'=>'Panti Asuhan','lainnya'=>'Lainnya'];
                                frow('Status Tempat Tinggal', $tinggal_map[$p['tempat_tinggal'] ?? ''] ?? ($p['tempat_tinggal'] ?? ''));

                                ?>
                            </div>
                        </div>

                        <!-- ════════════════════════════════════════════
                             C. DATA ORANG TUA / WALI
                             ════════════════════════════════════════════ -->
                        <div class="border-t border-[#1a3a2a]/40">
                            <div class="section-header">C. Data Orang Tua / Wali</div>
                            <div class="p-4">
                                <!-- Sub: Ayah -->
                                <p class="text-[10px] font-black text-[#1a3a2a] uppercase tracking-widest mb-2 pb-1 border-b border-[#1a3a2a]/30">1) Ayah Kandung</p>
                                <div class="space-y-0 mb-4">
                                    <?php
                                    frow('Nama Ayah', $ayah['nama_ayah'] ?? '');
                                    frow('NIK Ayah', $ayah['nik_ayah'] ?? '');
                                    frow('Tahun Lahir', $ayah['tahun_lahir_ayah'] ?? '');
                                    frow('Pendidikan Terakhir', $ayah['pendidikan_ayah'] ?? '');
                                    frow('Pekerjaan', $ayah['pekerjaan_ayah'] ?? '');
                                    frow('Penghasilan / Bulan', $ayah['penghasilan_bulanan_ayah'] ?? '');
                                    ?>
                                </div>

                                <!-- Sub: Ibu -->
                                <p class="text-[10px] font-black text-[#1a3a2a] uppercase tracking-widest mb-2 pb-1 border-b border-[#1a3a2a]/30">2) Ibu Kandung</p>
                                <div class="space-y-0 mb-4">
                                    <?php
                                    frow('Nama Ibu', $ibu['nama_ibu'] ?? '');
                                    frow('NIK Ibu', $ibu['nik_ibu'] ?? '');
                                    frow('Tahun Lahir', $ibu['tahun_lahir_ibu'] ?? '');
                                    frow('Pendidikan Terakhir', $ibu['pendidikan_ibu'] ?? '');
                                    frow('Pekerjaan', $ibu['pekerjaan_ibu'] ?? '');
                                    frow('Penghasilan / Bulan', $ibu['penghasilan_bulanan_ibu'] ?? '');
                                    ?>
                                </div>

                                <?php if(!empty($wali['nama_wali'])): ?>
                                <!-- Sub: Wali -->
                                <p class="text-[10px] font-black text-[#1a3a2a] uppercase tracking-widest mb-2 pb-1 border-b border-[#1a3a2a]/30">3) Wali (Apabila Ada)</p>
                                <div class="space-y-0">
                                    <?php
                                    frow('Nama Wali', $wali['nama_wali'] ?? '');
                                    frow('NIK Wali', $wali['nik_wali'] ?? '');
                                    frow('Tahun Lahir', $wali['tahun_lahir_wali'] ?? '');
                                    frow('Pendidikan Terakhir', $wali['pendidikan_wali'] ?? '');
                                    frow('Pekerjaan', $wali['pekerjaan_wali'] ?? '');
                                    frow('Penghasilan / Bulan', $wali['penghasilan_bulanan_wali'] ?? '');
                                    ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- ════════════════════════════════════════════
                             D. KONTAK & DATA PERIODIK
                             ════════════════════════════════════════════ -->
                        <div class="border-t border-[#1a3a2a]/40">
                            <div class="section-header">D. Kontak &amp; Data Periodik</div>
                            <div class="p-4 space-y-0">
                                <?php
                                frow('No. Telepon Rumah', $kontak['notlp_rumah'] ?? '');
                                frow('No. HP / Whatsapp', $kontak['no_hp'] ?? '');
                                frow('Alamat Email', $kontak['email'] ?? '');
                                frow('Tinggi Badan', !empty($periodik['tinggi_badan']) ? $periodik['tinggi_badan'] . ' cm' : '');
                                frow('Berat Badan', !empty($periodik['berat_badan']) ? $periodik['berat_badan'] . ' kg' : '');

                                frow('Jumlah Saudara Kandung', $periodik['jumlah_saudara_kandung'] ?? '');
                                $waktu = '';
                                if(!empty($periodik['waktu_jam']) || !empty($periodik['waktu_menit'])){
                                    $waktu = ($periodik['waktu_jam'] ?? '0') . ' jam ' . ($periodik['waktu_menit'] ?? '0') . ' menit';
                                }
                                frow('Waktu Tempuh ke Sekolah', $waktu);
                                ?>
                            </div>
                        </div>

                        <?php if(!empty($p['punya_kip']) && $p['punya_kip'] == 'ya'): ?>
                        <!-- ════════════════════════════════════════════
                             E. KIP
                             ════════════════════════════════════════════ -->
                        <div class="border-t border-[#1a3a2a]/40">
                            <div class="section-header">E. Kartu Indonesia Pintar (KIP)</div>
                            <div class="p-4 space-y-0">
                                <?php
                                frow('Memiliki KIP', 'Ya');
                                frow('Status KIP', $p['status_kip'] ?? '');
                                ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- ════════════════════════════════════════════
                             PERNYATAAN & TTD
                             ════════════════════════════════════════════ -->
                        <div class="border-t-2 border-[#1a3a2a]/40 p-5">
                            <p class="text-[10px] text-slate-700 font-semibold leading-relaxed mb-5 text-justify">
                                Yang bertanda tangan di bawah ini, orang tua/wali dari calon peserta didik di atas, menyatakan bahwa
                                data yang tertulis dalam formulir ini adalah <strong>benar dan dapat dipertanggungjawabkan.</strong>
                                Apabila terdapat ketidaksesuaian, kami bersedia menerima konsekuensi sesuai ketentuan yang berlaku.
                            </p>

                            <div class="grid grid-cols-2 gap-10">
                                <!-- TTD Orang Tua -->
                                <div class="text-center">
                                    <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest mb-1">Orang Tua / Wali,</p>
                                    <div class="sign-box mx-auto" style="width:160px;"></div>
                                    <div class="mt-2 border-t border-slate-400 pt-1 mx-auto" style="width:180px;">
                                        <p class="text-[10px] font-bold text-slate-800 text-center">( <?= htmlspecialchars($ayah['nama_ayah'] ?? '........................................') ?> )</p>
                                    </div>
                                </div>
                                <!-- TTD Panitia -->
                                <div class="text-center">
                                    <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest mb-1">
                                        Diterima oleh Panitia PPDB,<br>
                                        <span class="font-normal normal-case tracking-normal text-slate-500">Tanggal: ___________________</span>
                                    </p>
                                    <div class="sign-box mx-auto" style="width:160px;"></div>
                                    <div class="mt-2 border-t border-slate-400 pt-1 mx-auto" style="width:180px;">
                                        <p class="text-[10px] font-bold text-slate-800 text-center">( ......................................... )</p>
                                        <p class="text-[9px] text-slate-500 text-center">NIP / NIK</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Dokumen -->
                        <div style="background:#1a3a2a;color:white;" class="px-6 py-2.5 flex justify-between items-center text-[9px] font-bold uppercase tracking-widest">
                            <span>MI Nurul Ikhlas Al-Ayubi — PPDB <?= $tahun ?></span>
                            <span>No. <?= $reg_no ?> &nbsp;|&nbsp; Dicetak: <?= date('d/m/Y H:i') ?></span>
                            <span class="text-[#4ade80]">★ Dokumen Resmi — Jaga Kerahasiaannya</span>
                        </div>

                    </div><!-- /kop-border-inner -->
                </div><!-- /kop-border-outer -->

            </div><!-- /document -->

        </div>
    </main>

</body>
</html>
