<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keputusan Penerimaan | PPDB Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Times+New+Roman&family=Source+Serif+4:opsz,wght@8..60,400;8..60,600;8..60,700&display=swap');
        
        body { 
            font-family: 'Times New Roman', Times, 'Source Serif 4', Georgia, serif; 
            background-color: #cbd5e1; 
            color: #000;
        }
        
        .print-area {
            background-color: white;
            width: 210mm;
            min-height: 297mm; /* A4 */
            margin: 30px auto;
            padding: 25mm 20mm;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .line-double {
            border-top: 4px double #000;
            margin-top: 2px;
            margin-bottom: 20px;
        }

        .table-data td {
            padding: 4px 8px;
            font-size: 14px;
            vertical-align: top;
        }

        .table-panduan {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 15px;
        }
        .table-panduan th {
            background-color: #f1f5f9;
            border: 1px solid #94a3b8;
            padding: 8px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            text-align: left;
        }
        .table-panduan td {
            border: 1px solid #cbd5e1;
            padding: 8px 12px;
            font-size: 13px;
        }

        @media print {
            body { background-color: white; margin: 0; padding: 0; }
            .no-print { display: none !important; }
            .print-area {
                box-shadow: none !important;
                margin: 0 !important;
                padding: 15mm 15mm !important;
                width: 100% !important;
                min-height: auto !important;
            }
            @page { margin: 10mm; size: A4 portrait; }
        }
    </style>
</head>
<body>

    <!-- Print Topbar -->
    <div class="no-print bg-slate-900 p-4 text-center sticky top-0 z-50 flex justify-between items-center px-8 shadow-md">
        <a href="<?= base_url('student/pengumuman') ?>" class="inline-flex items-center gap-2 text-slate-300 hover:text-white font-bold transition-colors text-sm">
            <i class="fas fa-arrow-left"></i> Kembali ke Pengumuman
        </a>
        <button onclick="window.print()" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg shadow-md transition-all text-sm uppercase tracking-wider flex items-center gap-2">
            <i class="fas fa-print"></i> Cetak Surat Resmi
        </button>
    </div>

    <!-- Print Page Area -->
    <div class="print-area">
        
        <!-- KOP SURAT RESMI -->
        <div class="flex items-center gap-5 pb-3">
            <div class="w-[75px] h-[75px] flex-shrink-0 flex items-center justify-center">
                <img src="<?= base_url('img/logo.jpeg') ?>" alt="Logo MIS" class="w-full h-full object-cover rounded-full border-2 border-black">
            </div>
            <div class="flex-1 text-center">
                <p class="text-xs font-bold uppercase tracking-[0.15em] leading-tight">YAYASAN PENDIDIKAN ISLAM NURUL IKHLAS AL-AYUBI</p>
                <h1 class="text-xl font-bold uppercase tracking-wide leading-tight mt-0.5">MADRASAH IBTIDAIYAH (MI) NURUL IKHLAS AL-AYUBI</h1>
                <p class="text-[10px] font-semibold tracking-wider text-slate-500 uppercase">Status Akreditasi: "A" (Unggul) &nbsp;|&nbsp; NSM: 111236030115</p>
                <p class="text-[11px] italic mt-0.5 text-slate-600">Jl. Raya Pagedangan - Legok RT 001/003 Desa Jatake, Kec. Pagedangan, Tangerang</p>
            </div>
            <div class="w-[75px] h-[75px] flex-shrink-0 opacity-0 sm:opacity-100">
                <img src="<?= base_url('img/logo.jpeg') ?>" alt="Logo Right" class="w-full h-full object-cover rounded-full border-2 border-black grayscale opacity-50">
            </div>
        </div>
        
        <!-- Garis Kop Tebal Tipis (Double Line) -->
        <div class="line-double"></div>

        <!-- NOMOR SURAT & KEPUTUSAN -->
        <div class="text-center mb-8">
            <h2 class="text-base font-bold uppercase tracking-widest leading-snug">SURAT KEPUTUSAN KEPALA MADRASAH</h2>
            <h3 class="text-md font-bold uppercase tracking-wider mt-0.5">MI NURUL IKHLAS AL-AYUBI TANGERANG</h3>
            <p class="text-xs font-semibold mt-1">Nomor: 421.2/PPDB/MIS-NIA/<?= date('Y') ?>/<?= str_pad($data['pendaftaran']['id'] ?? '0', 4, '0', STR_PAD_LEFT) ?></p>
            
            <p class="text-sm font-bold uppercase tracking-wider mt-4">TENTANG</p>
            <h2 class="text-sm font-bold uppercase tracking-wide leading-snug mt-1">PENETAPAN HASIL SELEKSI PENERIMAAN PESERTA DIDIK BARU (PPDB)<br>TAHUN PELAJARAN <?= date('Y') ?>/<?= date('Y', strtotime('+1 year')) ?></h2>
        </div>

        <!-- PENGANTAR -->
        <div class="text-justify text-[14px] leading-relaxed mb-4">
            <p class="indent-10">Berdasarkan hasil evaluasi administrasi dan seleksi berkas calon peserta didik baru MI Nurul Ikhlas Al-Ayubi yang diselenggarakan oleh Panitia Pelaksana Penerimaan Peserta Didik Baru (PPDB), maka Kepala Madrasah memutuskan menerangkan bahwa:</p>
        </div>

        <!-- DATA CALON SISWA -->
        <table class="w-full table-data my-4 border border-slate-300 bg-slate-50/50 p-2 rounded-lg">
            <tr>
                <td class="w-[200px] font-semibold text-slate-700">Nomor Registrasi</td>
                <td class="w-4 text-center">:</td>
                <td class="font-bold tracking-wider text-slate-900">REG-<?= str_pad($data['pendaftaran']['id'] ?? '0', 4, '0', STR_PAD_LEFT) ?></td>
            </tr>
            <tr>
                <td class="font-semibold text-slate-700">Nama Lengkap Calon Siswa</td>
                <td class="text-center">:</td>
                <td class="font-bold text-slate-950 uppercase"><?= htmlspecialchars($data['pribadi']['nama_lengkap'] ?? $_SESSION['user_name']) ?></td>
            </tr>
            <tr>
                <td class="font-semibold text-slate-700">Nomor Induk Siswa Nasional (NISN)</td>
                <td class="text-center">:</td>
                <td class="font-semibold text-slate-800"><?= !empty($data['pribadi']['nisn']) ? htmlspecialchars($data['pribadi']['nisn']) : '—' ?></td>
            </tr>
            <tr>
                <td class="font-semibold text-slate-700">Tempat, Tanggal Lahir</td>
                <td class="text-center">:</td>
                <td class="text-slate-800">
                    <?= !empty($data['pribadi']['tempat_lahir']) ? htmlspecialchars($data['pribadi']['tempat_lahir']) : '—' ?>, 
                    <?= !empty($data['pribadi']['tanggal_lahir']) ? date('d F Y', strtotime($data['pribadi']['tanggal_lahir'])) : '—' ?>
                </td>
            </tr>
            <tr>
                <td class="font-semibold text-slate-700">Nama Orang Tua / Wali</td>
                <td class="text-center">:</td>
                <td class="text-slate-800"><?= htmlspecialchars($data['ayah']['nama_ayah'] ?? ($data['ibu']['nama_ibu'] ?? '—')) ?></td>
            </tr>
        </table>

        <!-- PERNYATAAN KELULUSAN -->
        <div class="my-5 p-4 border-l-4 border-emerald-600 bg-emerald-50 text-emerald-950 text-justify text-[14px]">
            <p class="font-bold text-base mb-1">Dinyatakan: &nbsp;<span class="tracking-widest uppercase font-black underline">LULUS / DITERIMA</span></p>
            <p class="leading-relaxed">Sebagai siswa baru kelas I (Satu) Reguler di MI Nurul Ikhlas Al-Ayubi Tangerang untuk Tahun Pelajaran <?= date('Y') ?>/<?= date('Y', strtotime('+1 year')) ?>.</p>
        </div>

        <!-- PANDUAN PPDB DAFTAR ULANG -->
        <div class="text-[13px] leading-relaxed mb-6">
            <h4 class="font-bold text-sm text-slate-900 mb-2 uppercase tracking-wide"><i class="fas fa-file-invoice mr-2 text-emerald-600"></i>Panduan &amp; Persyaratan Daftar Ulang Calon Siswa:</h4>
            <p class="text-slate-600 mb-3">Bagi calon peserta didik baru yang dinyatakan diterima, diwajibkan untuk melaksanakan registrasi daftar ulang dengan ketentuan resmi berikut:</p>
            
            <table class="table-panduan">
                <thead>
                    <tr>
                        <th class="w-12 text-center">No</th>
                        <th>Persyaratan Dokumen &amp; Prosedur Daftar Ulang</th>
                        <th class="w-24 text-center">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center font-bold">1</td>
                        <td>Membawa cetakan resmi <strong>Surat Keputusan Kelulusan / Penerimaan</strong> ini.</td>
                        <td class="text-center text-slate-500 font-semibold">1 Lembar</td>
                    </tr>
                    <tr>
                        <td class="text-center font-bold">2</td>
                        <td>Fotokopi <strong>Kartu Keluarga (KK)</strong> dan <strong>Akta Kelahiran</strong> calon siswa.</td>
                        <td class="text-center text-slate-500 font-semibold">@ 2 Lembar</td>
                    </tr>
                    <tr>
                        <td class="text-center font-bold">3</td>
                        <td>Fotokopi <strong>KTP Kedua Orang Tua</strong> kandung (Ayah &amp; Ibu) atau Wali.</td>
                        <td class="text-center text-slate-500 font-semibold">@ 2 Lembar</td>
                    </tr>
                    <tr>
                        <td class="text-center font-bold">4</td>
                        <td>Pas foto terbaru berwarna latar merah ukuran <strong>3 x 4</strong> cm.</td>
                        <td class="text-center text-slate-500 font-semibold">4 Lembar</td>
                    </tr>
                    <tr>
                        <td class="text-center font-bold">5</td>
                        <td>Menyelesaikan proses administrasi keuangan daftar ulang di Kantor Tata Usaha Madrasah.</td>
                        <td class="text-center text-slate-500 font-semibold">Wajib</td>
                    </tr>
                </tbody>
            </table>
            
            <p class="italic text-slate-500 font-semibold text-xs leading-normal">
                * Catatan: Seluruh kelengkapan berkas fisik dimasukkan ke dalam Map Kertas berwarna Hijau (untuk Laki-laki) dan berwarna Kuning (untuk Perempuan) dan diserahkan kepada sekretariat PPDB Madrasah.
            </p>
        </div>

        <!-- PENUTUP -->
        <div class="text-[14px] leading-relaxed mb-10">
            <p class="indent-10">Demikian Surat Keputusan Penerimaan ini diterbitkan secara sah untuk dipergunakan sebagaimana mestinya. Kami mengucapkan selamat bergabung dan terima kasih atas kepercayaan Bapak/Ibu sekalian.</p>
        </div>

        <!-- TANDA TANGAN (OFFICIAL SIGNATURE BLOCK) -->
        <div class="flex justify-between items-start mt-12">
            <div class="w-48 text-center text-xs text-slate-500 pt-6">
                <!-- Space for barcode / validation qr if necessary -->
            </div>
            
            <div class="text-center text-[14px]">
                <p class="mb-1 text-slate-700">Pagedangan, <?= date('d F Y') ?></p>
                <p class="font-bold uppercase tracking-wider mb-20 text-slate-900">Kepala MI Nurul Ikhlas Al-Ayubi,</p>
                
                <p class="font-bold underline text-slate-950 text-base">H. AHMAD SYARIFUDIN, S.Pd.I</p>
                <p class="text-xs text-slate-600 mt-0.5">NIP. 19791218 200701 1 003</p>
            </div>
        </div>

        <!-- FOOTER BAR -->
        <div class="absolute bottom-5 left-8 right-8 border-t border-slate-300 pt-3 flex justify-between items-center text-[10px] text-slate-400 font-semibold">
            <span>Dokumen PPDB Online MI Nurul Ikhlas Al-Ayubi</span>
            <span>Tanggal Cetak: <?= date('d/m/Y H:i') ?> WIB</span>
            <span>Halaman 1 dari 1</span>
        </div>

    </div>

</body>
</html>
