<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Pendaftaran PPDB | MI Nurul Ikhlas Al-Ayubi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap');
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f1f5f9; 
        }

        /* Printable area sizing and styling */
        .document-paper {
            background-color: #ffffff;
            width: 210mm;
            min-height: 297mm;
            padding: 25mm 20mm 20mm 20mm;
            margin: 0 auto;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            position: relative;
            box-sizing: border-box;
            border: 1px solid #e2e8f0;
        }

        /* Official Letterhead Line separator */
        .kop-border {
            border-bottom: 4px double #1e3a8a;
            margin-top: 10px;
            margin-bottom: 25px;
        }

        /* Styling for print media */
        @media print {
            body {
                background-color: #ffffff;
                color: #000000;
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            .document-paper {
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
                width: 100% !important;
                min-height: auto !important;
                padding: 0 !important;
            }
            a[href]:after {
                content: none !important;
            }
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>
<body class="text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Top Navigation Bar (no-print) -->
    <header class="no-print bg-white border-b border-slate-200 sticky top-0 z-50 px-6 py-4 flex items-center justify-between shadow-sm">
        <div class="flex items-center space-x-3">
            <a href="<?= base_url() ?>" class="w-10 h-10 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-600 hover:bg-emerald-100 transition-colors">
                <i class="ph-bold ph-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="font-extrabold text-slate-800 text-base leading-tight uppercase tracking-tight">Panduan PPDB Resmi</h1>
                <p class="text-xs text-slate-500 font-semibold mt-0.5">MI Nurul Ikhlas Al-Ayubi</p>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'user'): ?>
                <a href="<?= base_url('student') ?>" class="px-4 py-2 text-xs font-bold text-slate-600 hover:text-slate-900 border border-slate-200 hover:border-slate-300 rounded-xl transition-all">
                    <i class="ph-bold ph-layout mr-1 text-sm"></i> Dashboard Siswa
                </a>
            <?php else: ?>
                <a href="<?= base_url() ?>" class="px-4 py-2 text-xs font-bold text-slate-600 hover:text-slate-900 border border-slate-200 hover:border-slate-300 rounded-xl transition-all">
                    <i class="ph-bold ph-house mr-1 text-sm"></i> Halaman Utama
                </a>
            <?php endif; ?>
            <button onclick="window.print()" class="px-5 py-2.5 bg-emerald-600 text-white rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-emerald-700 shadow-md shadow-emerald-100 transition-all flex items-center gap-2">
                <i class="ph-bold ph-printer text-sm"></i> Cetak Panduan
            </button>
        </div>
    </header>

    <div class="flex-1 max-w-7xl mx-auto w-full px-6 py-8 flex flex-col lg:flex-row gap-8">
        
        <!-- Left Side Navigation / Quick Links (no-print) -->
        <aside class="no-print lg:w-80 flex-shrink-0 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm sticky top-24">
                <h3 class="font-extrabold text-slate-900 text-sm uppercase tracking-wider mb-4 pb-3 border-b border-slate-100">
                    <i class="ph-bold ph-list-bullets mr-1.5 text-emerald-600"></i> Daftar Isi Panduan
                </h3>
                
                <nav class="space-y-1.5">
                    <a href="#kop-surat" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">
                        <span class="w-6 h-6 bg-slate-100 text-slate-600 rounded-lg flex items-center justify-center flex-shrink-0 text-[10px]">01</span>
                        <span>Surat Keputusan Resmi</span>
                    </a>
                    <a href="#persyaratan" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">
                        <span class="w-6 h-6 bg-slate-100 text-slate-600 rounded-lg flex items-center justify-center flex-shrink-0 text-[10px]">02</span>
                        <span>Persyaratan Pendaftaran</span>
                    </a>
                    <a href="#alur" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">
                        <span class="w-6 h-6 bg-slate-100 text-slate-600 rounded-lg flex items-center justify-center flex-shrink-0 text-[10px]">03</span>
                        <span>Alur Pendaftaran Online</span>
                    </a>
                    <a href="#jadwal" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">
                        <span class="w-6 h-6 bg-slate-100 text-slate-600 rounded-lg flex items-center justify-center flex-shrink-0 text-[10px]">04</span>
                        <span>Jadwal Pelaksanaan</span>
                    </a>
                    <a href="#kontak" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">
                        <span class="w-6 h-6 bg-slate-100 text-slate-600 rounded-lg flex items-center justify-center flex-shrink-0 text-[10px]">05</span>
                        <span>Kontak & Bantuan</span>
                    </a>
                </nav>

                <div class="mt-6 pt-5 border-t border-slate-100 bg-slate-50 -mx-5 -mb-5 p-5 rounded-b-2xl">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-2">Informasi Cetak</p>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">
                        Halaman ini didesain khusus agar ramah cetak (print-ready) menggunakan kertas A4 secara rapi tanpa potongan margin.
                    </p>
                    <button onclick="window.print()" class="w-full mt-3.5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-bold text-xs uppercase tracking-widest transition-colors flex items-center justify-center gap-2">
                        <i class="ph-bold ph-printer"></i> Cetak Sekarang
                    </button>
                </div>
            </div>
        </aside>

        <!-- Right Side: Official Printable Document -->
        <main class="flex-1 flex justify-center">
            
            <article class="document-paper select-none">
                
                <!-- KOP SURAT (Letterhead) -->
                <div id="kop-surat" class="flex items-center justify-between gap-4 pb-2">
                    <img src="<?= base_url('img/logo.jpeg') ?>" alt="Logo MIS" class="w-20 h-20 object-cover rounded-full p-1 border border-slate-200">
                    <div class="flex-1 text-center">
                        <h4 class="text-sm font-black text-blue-900 uppercase tracking-widest leading-none">YAYASAN NURUL IKHLAS AL-AYUBI</h4>
                        <h2 class="text-lg font-black text-emerald-800 uppercase tracking-wide leading-tight mt-1">MADRASAH IBTIDAIYAH SWASTA NURUL IKHLAS</h2>
                        <p class="text-[9px] font-bold text-slate-500 uppercase tracking-wider mt-0.5">NSM: 111236030095 | NPSN: 60723456</p>
                        <p class="text-[9px] text-slate-600 font-medium leading-tight mt-1">
                            Jl. Raya Pagedangan - Legok RT. 001/003 Desa Jatake, Kec. Pagedangan, Kab. Tangerang, Banten
                        </p>
                    </div>
                    <!-- Spacer for layout alignment -->
                    <div class="w-20"></div>
                </div>
                
                <!-- Double Line separator -->
                <div class="kop-border"></div>

                <!-- SURAT PENGUMUMAN / KEPUTUSAN -->
                <div class="text-center mb-8">
                    <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider underline">SURAT PANDUAN PELAKSANAAN PPDB ONLINE</h3>
                    <p class="text-xs text-slate-500 font-semibold mt-1">Nomor: 045/PAN-PPDB/MIS-NI/V/2026</p>
                </div>

                <!-- INTRO -->
                <div class="text-xs text-slate-700 leading-relaxed space-y-4 mb-6">
                    <p class="indent-8 font-medium">
                        Dalam rangka pelaksanaan Penerimaan Peserta Didik Baru (PPDB) Madrasah Ibtidaiyah Swasta (MIS) Nurul Ikhlas Al-Ayubi Tahun Ajaran 2026/2027, panitia pelaksana menerbitkan surat panduan resmi ini sebagai acuan teknis pendaftaran bagi calon pendaftar dan orang tua/wali murid calon peserta didik.
                    </p>
                    <p class="font-medium">
                        Berikut adalah syarat, alur pendaftaran, jadwal, serta ketentuan administrasi yang wajib dipenuhi oleh calon siswa baru:
                    </p>
                </div>

                <!-- SECTION 1: PERSYARATAN -->
                <section id="persyaratan" class="mb-8">
                    <h4 class="text-xs font-black text-slate-900 uppercase tracking-wider mb-3.5 pb-1 border-b border-slate-200 flex items-center gap-2">
                        <span class="w-5 h-5 bg-slate-900 text-white rounded-md flex items-center justify-center text-[10px]">1</span>
                        <span>Persyaratan Pendaftaran Calon Siswa Baru</span>
                    </h4>
                    
                    <div class="text-xs text-slate-700 space-y-3 pl-2">
                        <div class="flex items-start gap-2">
                            <span class="font-extrabold text-emerald-600">A.</span>
                            <div>
                                <strong class="text-slate-900">Persyaratan Usia Calon Siswa:</strong>
                                <ul class="list-disc pl-5 mt-1 space-y-1 font-medium">
                                    <li>Berusia minimal 6 (enam) tahun pada tanggal 1 Juli 2026.</li>
                                    <li>Mempunyai kesiapan belajar secara fisik maupun mental untuk mengikuti jenjang pendidikan MI.</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-2">
                            <span class="font-extrabold text-emerald-600">B.</span>
                            <div>
                                <strong class="text-slate-900">Dokumen Administrasi yang Wajib Diunggah (Format Digital):</strong>
                                <table class="w-full mt-2 border border-slate-200 text-[11px] leading-normal">
                                    <thead>
                                        <tr class="bg-slate-50 border-b border-slate-200">
                                            <th class="border-r border-slate-200 px-2 py-1.5 text-left font-bold text-slate-800 w-12">No.</th>
                                            <th class="border-r border-slate-200 px-3 py-1.5 text-left font-bold text-slate-800">Nama Berkas Berkas</th>
                                            <th class="border-r border-slate-200 px-3 py-1.5 text-left font-bold text-slate-800 w-28">Format File</th>
                                            <th class="px-3 py-1.5 text-left font-bold text-slate-800 w-32">Batas Maks. Ukuran</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200 font-medium">
                                        <tr>
                                            <td class="border-r border-slate-200 px-2 py-1.5 text-center">1</td>
                                            <td class="border-r border-slate-200 px-3 py-1.5">Kartu Keluarga (KK) Asli / Legalisir</td>
                                            <td class="border-r border-slate-200 px-3 py-1.5">PDF Document</td>
                                            <td class="px-3 py-1.5">2 Megabytes (2MB)</td>
                                        </tr>
                                        <tr>
                                            <td class="border-r border-slate-200 px-2 py-1.5 text-center">2</td>
                                            <td class="border-r border-slate-200 px-3 py-1.5">Akta Kelahiran Calon Siswa</td>
                                            <td class="border-r border-slate-200 px-3 py-1.5">PDF Document</td>
                                            <td class="px-3 py-1.5">2 Megabytes (2MB)</td>
                                        </tr>
                                        <tr>
                                            <td class="border-r border-slate-200 px-2 py-1.5 text-center">3</td>
                                            <td class="border-r border-slate-200 px-3 py-1.5">Ijazah / Surat Keterangan Lulus RA/TK/PAUD</td>
                                            <td class="border-r border-slate-200 px-3 py-1.5">PDF Document</td>
                                            <td class="px-3 py-1.5">2 Megabytes (2MB)</td>
                                        </tr>
                                        <tr>
                                            <td class="border-r border-slate-200 px-2 py-1.5 text-center">4</td>
                                            <td class="border-r border-slate-200 px-3 py-1.5">Pas Foto Calon Siswa Terbaru (Warna, Rasio 3x4)</td>
                                            <td class="border-r border-slate-200 px-3 py-1.5">JPG / JPEG / PNG</td>
                                            <td class="px-3 py-1.5">2 Megabytes (2MB)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="page-break"></div>

                <!-- SECTION 2: ALUR -->
                <section id="alur" class="mb-8">
                    <h4 class="text-xs font-black text-slate-900 uppercase tracking-wider mb-3.5 pb-1 border-b border-slate-200 flex items-center gap-2">
                        <span class="w-5 h-5 bg-slate-900 text-white rounded-md flex items-center justify-center text-[10px]">2</span>
                        <span>Alur Pendaftaran Penerimaan Peserta Didik Baru</span>
                    </h4>
                    
                    <div class="text-[11px] text-slate-700 font-medium space-y-3.5 pl-2 leading-relaxed">
                        <div class="flex gap-3">
                            <span class="font-extrabold text-blue-900 flex-shrink-0">Step 1:</span>
                            <p>
                                <strong class="text-slate-900">Pembuatan Akun PPDB Online:</strong> Orang tua/wali calon murid mengakses website PPDB, mengisi formulir pendaftaran akun (Nama, Email, Password) untuk memperoleh akses masuk ke sistem pendaftaran.
                            </p>
                        </div>
                        <div class="flex gap-3">
                            <span class="font-extrabold text-blue-900 flex-shrink-0">Step 2:</span>
                            <p>
                                <strong class="text-slate-900">Pengisian Formulir Pendaftaran:</strong> Calon pendaftar wajib masuk (login) ke dashboard, lalu mengisi secara lengkap 6 kategori data formulir: Data Calon Siswa (Pribadi), Data Ayah Kandung, Data Ibu Kandung, Data Wali (opsional), Kontak Darurat, dan Data Periodik.
                            </p>
                        </div>
                        <div class="flex gap-3">
                            <span class="font-extrabold text-blue-900 flex-shrink-0">Step 3:</span>
                            <p>
                                <strong class="text-slate-900">Mengunggah File Berkas Kelengkapan:</strong> Calon pendaftar mengunggah berkas scan KK, Akta Kelahiran, Ijazah TK/RA, dan Pas Foto Berwarna 3x4 pada tab menu berkas yang telah disediakan.
                            </p>
                        </div>
                        <div class="flex gap-3">
                            <span class="font-extrabold text-blue-900 flex-shrink-0">Step 4:</span>
                            <p>
                                <strong class="text-slate-900">Verifikasi & Penilaian Berkas oleh Panitia:</strong> Panitia melakukan validasi berkas dan formulir yang dikirimkan. Apabila terdapat data/dokumen yang salah, status akan diubah menjadi <span class="text-red-600 font-bold">"Perlu Revisi"</span> dan siswa diberikan kesempatan mengunggah ulang.
                            </p>
                        </div>
                        <div class="flex gap-3">
                            <span class="font-extrabold text-blue-900 flex-shrink-0">Step 5:</span>
                            <p>
                                <strong class="text-slate-900">Proses Sosialisasi & Wawancara:</strong> Calon siswa beserta orang tua/wali menghadiri wawancara dan sosialisasi di lingkungan madrasah sesuai jadwal gelombang yang aktif.
                            </p>
                        </div>
                        <div class="flex gap-3">
                            <span class="font-extrabold text-blue-900 flex-shrink-0">Step 6:</span>
                            <p>
                                <strong class="text-slate-900">Rilis Pengumuman & Cetak Surat Kelulusan:</strong> Hasil seleksi diumumkan sesuai jadwal rilis yang telah ditentukan di sistem. Calon siswa yang dinyatakan <span class="text-emerald-700 font-bold">"Diterima"</span> wajib mengunduh Surat Keputusan Kelulusan untuk keperluan daftar ulang.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- SECTION 3: JADWAL -->
                <section id="jadwal" class="mb-8">
                    <h4 class="text-xs font-black text-slate-900 uppercase tracking-wider mb-3.5 pb-1 border-b border-slate-200 flex items-center gap-2">
                        <span class="w-5 h-5 bg-slate-900 text-white rounded-md flex items-center justify-center text-[10px]">3</span>
                        <span>Jadwal Pelaksanaan Kegiatan PPDB</span>
                    </h4>
                    
                    <div class="pl-2">
                        <table class="w-full border border-slate-200 text-[11px] leading-normal">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200">
                                    <th class="border-r border-slate-200 px-3 py-2 text-left font-bold text-slate-800">Gelombang / Kategori Kegiatan</th>
                                    <th class="border-r border-slate-200 px-3 py-2 text-left font-bold text-slate-800">Batas Masa Pendaftaran</th>
                                    <th class="border-r border-slate-200 px-3 py-2 text-left font-bold text-slate-800">Masa Wawancara & Sosialisasi</th>
                                    <th class="px-3 py-2 text-left font-bold text-slate-800">Pengumuman Kelulusan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 font-medium">
                                <?php foreach($jadwal as $index => $g): ?>
                                <tr class="<?= ($index + 1) == $gelombang_aktif ? 'bg-emerald-50/50' : '' ?>">
                                    <td class="border-r border-slate-200 px-3 py-2">
                                        <strong><?= htmlspecialchars($g['gel']) ?></strong>
                                        <?php if(($index + 1) == $gelombang_aktif): ?>
                                            <span class="ml-1 text-[8px] bg-emerald-600 text-white font-bold px-1.5 py-0.5 rounded-full uppercase no-print">Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="border-r border-slate-200 px-3 py-2"><?= htmlspecialchars($g['daftar']) ?></td>
                                    <td class="border-r border-slate-200 px-3 py-2"><?= htmlspecialchars($g['sosial']) ?></td>
                                    <td class="px-3 py-2"><?= htmlspecialchars($g['hasil']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <p class="text-[9px] text-slate-400 mt-2 italic font-semibold">
                            * Catatan: Jadwal dapat berubah sewaktu-waktu sesuai dengan ketetapan rapat koordinasi panitia pelaksana PPDB.
                        </p>
                    </div>
                </section>

                <!-- SECTION 4: KONTAK -->
                <section id="kontak" class="mb-12">
                    <h4 class="text-xs font-black text-slate-900 uppercase tracking-wider mb-3.5 pb-1 border-b border-slate-200 flex items-center gap-2">
                        <span class="w-5 h-5 bg-slate-900 text-white rounded-md flex items-center justify-center text-[10px]">4</span>
                        <span>Pusat Informasi & Layanan Bantuan (Helpdesk)</span>
                    </h4>
                    
                    <div class="text-xs text-slate-700 font-medium space-y-2 pl-2">
                        <p>
                            Apabila terdapat kesulitan dalam pendaftaran online, berkas dokumen bermasalah, maupun pertanyaan seputar administrasi PPDB, silakan hubungi kontak panitia di bawah ini:
                        </p>
                        <ul class="list-disc pl-5 mt-1 space-y-1">
                            <li><strong class="text-slate-800">Sekretariat Panitia:</strong> Gedung Admin PPDB MIS Nurul Ikhlas (Setiap hari kerja, Pukul 08.00 s/d 14.00 WIB)</li>
                            <li><strong class="text-slate-800">Telepon / WhatsApp:</strong> 0812-3456-7890 (Layanan Helpdesk PPDB)</li>
                            <li><strong class="text-slate-800">Email Hubungan Masyarakat:</strong> ppdb@misnurulikhlas.sch.id / info@misnurulikhlas.sch.id</li>
                        </ul>
                    </div>
                </section>

                <!-- SIGNATURE SECTION -->
                <div class="flex justify-between items-start mt-10">
                    <div class="w-48 text-center text-xs text-slate-400 font-semibold pt-6">
                        <!-- Space for barcode / stamp validation -->
                    </div>
                    
                    <div class="text-center text-xs font-medium">
                        <p class="mb-1 text-slate-700">Tangerang, Banten, <?= date('d F Y') ?></p>
                        <p class="font-bold uppercase tracking-wider mb-20 text-slate-900">Kepala MIS Nurul Ikhlas,</p>
                        
                        <p class="font-bold underline text-slate-950 text-[13px]">H. AHMAD SYARIFUDIN, S.Pd.I</p>
                        <p class="text-[10px] text-slate-500 mt-0.5">NIP. 19791218 200701 1 003</p>
                    </div>
                </div>

                <!-- FOOTER DOKUMEN -->
                <div class="absolute bottom-5 left-8 right-8 border-t border-slate-200 pt-3 flex justify-between items-center text-[9px] text-slate-400 font-bold uppercase tracking-wider">
                    <span>Dokumen Informasi Resmi PPDB MIS Nurul Ikhlas Al-Ayubi</span>
                    <span>Tanggal Cetak: <?= date('d/m/Y H:i') ?> WIB</span>
                </div>

            </article>

        </main>
        
    </div>

    <!-- Page Footer (no-print) -->
    <footer class="no-print bg-slate-900 border-t border-slate-800 py-6 mt-12 text-slate-500 text-xs text-center">
        <div class="max-w-7xl mx-auto px-6">
            <p>&copy; <?= date('Y') ?> MI Nurul Ikhlas Al-Ayubi. Semua hak dilindungi.</p>
            <p class="mt-1 text-[10px] text-slate-600 uppercase tracking-widest font-black">Powered by Antigravity</p>
        </div>
    </footer>

</body>
</html>
