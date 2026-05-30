<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman Hasil Seleksi | PPDB Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Poppins', sans-serif; background-color: #f8fafc; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="text-slate-800 flex h-screen overflow-hidden selection:bg-emerald-500 selection:text-white">
<?php require_once '../app/Views/student/_sidebar.php'; studentSidebar('pengumuman'); ?>

<?php 
$status = $data['pendaftaran']['status'] ?? 'belum_mendaftar'; 
$catatan = $data['pendaftaran']['catatan'] ?? '';
$isLulus = ($status == 'diterima');
$isWaiting = in_array($status, ['nunggu_verifikasi', 'dokumen_diterima', 'nunggu_pengumuman', 'perlu_revisi']);
$release_time_raw = (new Settings_model())->getSetting('release_announcement_datetime');
$release_ts = !empty($release_time_raw) ? strtotime($release_time_raw) : 0;
$show_countdown = ($release_ts > time());
?>

<main class="flex-1 flex flex-col h-full overflow-y-auto bg-slate-50/50 relative">
    <header class="bg-white px-8 py-5 border-b border-slate-200/80 sticky top-0 z-30 flex justify-between items-center shadow-sm">
        <div>
            <h2 class="text-2xl font-bold text-[#1a5632] tracking-tight">Cetak & Pengumuman</h2>
            <p class="text-[13px] text-slate-500 font-medium mt-1">Lihat hasil seleksi dan cetak dokumen penting pendaftaran Anda.</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="bg-[#E8F4EC] rounded-xl px-4 py-2 flex items-center gap-3">
                <i class="fas fa-calendar-alt text-[#419864] text-xl"></i>
                <div class="min-w-[140px]">
                    <p class="text-[10px] text-emerald-800 font-semibold leading-tight">Jadwal Pengumuman</p>
                    <?php if($show_countdown): ?>
                    <div class="flex items-baseline gap-1 mt-0.5">
                        <span class="text-[13px] font-black text-emerald-900 leading-tight" id="hd-d">--</span><span class="text-[9px] font-bold text-emerald-700 uppercase">hr</span>
                        <span class="text-[13px] font-black text-emerald-900 leading-tight ml-0.5" id="hd-h">--</span><span class="text-[9px] font-bold text-emerald-700 uppercase">jm</span>
                        <span class="text-[13px] font-black text-emerald-900 leading-tight ml-0.5" id="hd-m">--</span><span class="text-[9px] font-bold text-emerald-700 uppercase">mn</span>
                        <span class="text-[13px] font-black text-emerald-900 leading-tight ml-0.5" id="hd-s">--</span><span class="text-[9px] font-bold text-emerald-700 uppercase">dt</span>
                    </div>
                    <?php else: ?>
                    <p class="text-[13px] font-black text-emerald-900 leading-tight"><?= $release_ts ? date('d F Y', $release_ts) : 'Menunggu Info' ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <div class="p-8 w-full flex-1 flex flex-col items-center justify-start relative">
        <div class="w-full max-w-5xl">
            
            <?php if($status === 'belum_mendaftar'): ?>
            <!-- Tampilan Belum Daftar (2 Column Grid) -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start animate-fadeUp mt-4">
                
                <!-- Left Column (Status) -->
                <div class="md:col-span-6 bg-white rounded-[24px] border border-slate-200/70 p-10 shadow-sm text-center relative overflow-hidden flex flex-col h-full">
                    
                    <div class="relative z-10 flex flex-col items-center flex-1 w-full">
                        <div class="mb-4 flex justify-center">
                            <svg width="140" height="140" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="100" cy="100" r="90" fill="#E8F4EC"/>
                                <rect x="65" y="45" width="70" height="90" rx="8" fill="#419864"/>
                                <rect x="70" y="55" width="60" height="75" rx="4" fill="#FFFFFF"/>
                                <path d="M85 40 h30 a5 5 0 0 1 5 5 v5 h-40 v-5 a5 5 0 0 1 5 -5 z" fill="#D1E8DA"/>
                                <circle cx="100" cy="45" r="3" fill="#419864"/>
                                <circle cx="82" cy="70" r="5" fill="#419864"/>
                                <path d="M80 70 L82 72 L85 68" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                                <rect x="92" y="68" width="30" height="4" rx="2" fill="#D1E8DA"/>
                                <circle cx="82" cy="85" r="5" fill="#419864"/>
                                <path d="M80 85 L82 87 L85 83" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                                <rect x="92" y="83" width="25" height="4" rx="2" fill="#D1E8DA"/>
                                <rect x="77" y="95" width="10" height="10" rx="2" stroke="#A3D2B5" stroke-width="1.5" fill="none"/>
                                <rect x="92" y="98" width="28" height="4" rx="2" fill="#E2E8F0"/>
                                <rect x="77" y="110" width="10" height="10" rx="2" stroke="#A3D2B5" stroke-width="1.5" fill="none"/>
                                <rect x="92" y="113" width="20" height="4" rx="2" fill="#E2E8F0"/>
                                <circle cx="135" cy="130" r="22" fill="#FFB82E" stroke="white" stroke-width="4"/>
                                <path d="M135 118 v15" stroke="white" stroke-width="4" stroke-linecap="round"/>
                                <circle cx="135" cy="141" r="2.5" fill="white"/>
                            </svg>
                        </div>
                        
                        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight leading-tight mb-2">
                            Formulir Belum Diisi
                        </h2>
                        <p class="text-[13px] font-medium text-slate-500 mb-6 px-4">
                            Anda belum mengisi formulir pendaftaran.<br>Silakan lengkapi formulir terlebih dahulu untuk<br>melihat pengumuman dan mencetak dokumen.
                        </p>
                        
                        <div class="bg-amber-50 border border-amber-200 text-amber-600 px-5 py-1.5 rounded-full text-xs font-bold mb-8">
                            Status: Belum Mengisi Formulir
                        </div>

                        <div class="w-full text-left space-y-4 mb-10 pl-2">
                            <div class="flex items-center gap-10 border-b border-slate-100 pb-3">
                                <div class="flex items-center gap-3 w-[120px]">
                                    <i class="fas fa-user text-slate-400 text-sm"></i>
                                    <p class="text-[12px] text-slate-600 font-medium">Nama Peserta</p>
                                </div>
                                <p class="text-[13px] font-semibold text-slate-800 flex-1"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Calon Siswa') ?></p>
                            </div>
                        </div>

                        <div class="w-full">
                            <a href="<?= base_url('student/form') ?>" class="w-full py-3.5 bg-gradient-to-r from-[#419864] to-teal-600 text-white font-bold rounded-xl text-[13px] transition-all shadow-md hover:from-emerald-700 hover:to-teal-700 flex items-center justify-center gap-2">
                                <i class="fas fa-edit text-xs"></i> Isi Formulir Sekarang
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column (Cetak Dokumen Locked) -->
                <div class="md:col-span-6 space-y-6 flex flex-col h-full">
                    
                    <!-- Cetak Dokumen Card -->
                    <div class="bg-white rounded-[24px] border border-slate-200/70 p-8 shadow-sm opacity-60 pointer-events-none">
                        <h3 class="text-lg font-bold text-[#1a3a2a] mb-1">Cetak Dokumen</h3>
                        <p class="text-xs text-slate-500 font-medium mb-6">Dokumen cetak baru akan tersedia setelah pendaftaran divalidasi.</p>
                        
                        <div class="flex flex-col">
                            <!-- Item 1: Formulir Pendaftaran -->
                            <div class="flex items-center gap-5 py-5 border-b border-slate-100">
                                <div class="w-14 h-14 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center text-2xl flex-shrink-0">
                                    <i class="fas fa-file-invoice"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-slate-800 mb-1">Cetak Formulir Pendaftaran</h4>
                                    <p class="text-xs text-slate-500 leading-relaxed pr-2">Cetak formulir dan kartu peserta.</p>
                                </div>
                                <button class="px-5 py-2 border border-slate-200 text-slate-400 font-bold rounded-xl text-sm flex items-center gap-2">
                                    <i class="fas fa-lock text-xs"></i> Cetak
                                </button>
                            </div>
                            
                            <!-- Item 2: Unduh Hasil Seleksi -->
                            <div class="flex items-center gap-5 py-5 border-b border-slate-100">
                                <div class="w-14 h-14 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center text-2xl flex-shrink-0">
                                    <i class="fas fa-file-pdf"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-slate-800 mb-1">Unduh Hasil Seleksi (PDF)</h4>
                                    <p class="text-xs text-slate-500 leading-relaxed pr-2">Unduh hasil seleksi dalam bentuk PDF.</p>
                                </div>
                                <button class="px-5 py-2 border border-slate-200 text-slate-400 font-bold rounded-xl text-sm flex items-center gap-2">
                                    <i class="fas fa-lock text-xs"></i> Unduh
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <?php elseif($isWaiting): ?>
            <!-- Tampilan Saat Menunggu Verifikasi / Pengumuman -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start animate-fadeUp mt-4">
                
                <!-- Left Column (Status) -->
                <div class="md:col-span-6">
                    <div class="bg-white rounded-[24px] border border-slate-100 p-10 shadow-sm text-center flex flex-col items-center">
                        
                        <!-- Illustration (Custom SVG) -->
                        <div class="mb-8 relative flex justify-center w-full">
                            <svg width="140" height="140" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- Outer light circle -->
                                <circle cx="60" cy="60" r="45" fill="#E8F4EC" />
                                
                                <!-- Clipboard Base -->
                                <rect x="42" y="35" width="36" height="48" rx="4" fill="#F8FAFC" stroke="#A3D2B5" stroke-width="2"/>
                                
                                <!-- Clipboard Clip -->
                                <rect x="52" y="31" width="16" height="8" rx="2" fill="#419864" />
                                <rect x="56" y="33" width="8" height="3" rx="1" fill="#D1E8DA" />

                                <!-- Checkboxes and Lines -->
                                <circle cx="49" cy="46" r="2.5" fill="#419864" />
                                <path d="M47.5 46 L49 47.5 L51 44.5" stroke="white" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/>
                                <rect x="55" y="45" width="16" height="3" rx="1.5" fill="#D1E8DA" />

                                <circle cx="49" cy="55" r="2.5" fill="#419864" />
                                <path d="M47.5 55 L49 56.5 L51 53.5" stroke="white" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/>
                                <rect x="55" y="54" width="16" height="3" rx="1.5" fill="#D1E8DA" />

                                <circle cx="49" cy="64" r="2.5" fill="#E2E8F0" />
                                <rect x="55" y="63" width="10" height="3" rx="1.5" fill="#E2E8F0" />

                                <?php if(in_array($status, ['dokumen_diterima', 'nunggu_pengumuman'])): ?>
                                <!-- Badge Validated (Green Check) -->
                                <circle cx="85" cy="85" r="14" fill="#F8FAFC" />
                                <circle cx="85" cy="85" r="12" fill="#419864" />
                                <path d="M80 85 L83 88 L90 81" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                <?php else: ?>
                                <!-- Badge Warning (Orange Exclamation) -->
                                <circle cx="85" cy="85" r="14" fill="#F8FAFC" />
                                <circle cx="85" cy="85" r="12" fill="#F59E0B" />
                                <path d="M85 79 V86" stroke="white" stroke-width="2.5" stroke-linecap="round" />
                                <circle cx="85" cy="90" r="1.5" fill="white" />
                                <?php endif; ?>
                            </svg>
                        </div>
                        
                        <?php
                        if (in_array($status, ['dokumen_diterima', 'nunggu_pengumuman'])) {
                            $titleText = "Data Sudah Divalidasi";
                            $descText = "Pendaftaran Anda telah divalidasi. Silakan cetak dokumen<br>Anda dan pantau jadwal pengumuman kelulusan resmi.";
                            $statusBadgeBg = "bg-white";
                            $statusBadgeBorder = "border-emerald-200";
                            $statusBadgeText = "text-emerald-500";
                            $statusText = "Status: Data Divalidasi";
                        } else {
                            $titleText = "Sedang Diproses";
                            $descText = "Data pendaftaran Anda sedang dalam tahap verifikasi oleh panitia.<br>Mohon tunggu proses validasi selesai.";
                            $statusBadgeBg = "bg-white";
                            $statusBadgeBorder = "border-amber-200";
                            $statusBadgeText = "text-amber-500";
                            $statusText = "Status: Menunggu Verifikasi";
                        }
                        ?>

                        <h2 class="text-[24px] font-black text-[#1e293b] tracking-tight mb-3">
                            <?= $titleText ?>
                        </h2>
                        
                        <p class="text-[14px] font-medium text-slate-500 mb-6 leading-relaxed">
                            <?= $descText ?>
                        </p>
                        
                        <div class="inline-block <?= $statusBadgeBg ?> border <?= $statusBadgeBorder ?> <?= $statusBadgeText ?> px-5 py-2 rounded-full text-xs font-bold mb-10 tracking-wide">
                            <?= $statusText ?>
                        </div>

                        <!-- Biodata Rows -->
                        <div class="w-full text-left mb-10 px-2">
                            <!-- No Registrasi -->
                            <div class="flex items-center justify-between border-b border-slate-100/70 pb-4 mb-4">
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-id-card text-slate-400 text-sm"></i>
                                    <p class="text-[14px] text-slate-500 font-semibold">No Registrasi</p>
                                </div>
                                <p class="text-[14px] font-bold text-slate-800">REG-<?= str_pad($data['pendaftaran']['id'] ?? '0', 4, '0', STR_PAD_LEFT) ?></p>
                            </div>
                            <!-- Nama Peserta -->
                            <div class="flex items-center justify-between border-b border-slate-100/70 pb-4">
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-user text-slate-400 text-sm"></i>
                                    <p class="text-[14px] text-slate-500 font-semibold">Nama Peserta</p>
                                </div>
                                <p class="text-[14px] font-bold text-slate-800"><?= htmlspecialchars($data['pribadi']['nama_lengkap'] ?? $_SESSION['user_name']) ?></p>
                            </div>
                        </div>
                        
                        <div class="w-full">
                            <a href="<?= base_url('student/dashboard') ?>" class="w-full py-3.5 bg-[#209472] text-white font-bold rounded-xl text-[14px] hover:bg-[#187559] transition-colors flex items-center justify-center gap-2">
                                <i class="fas fa-arrow-left text-xs"></i> Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column (Cetak Dokumen) -->
                <div class="md:col-span-6">
                    <?php $canPrint = in_array($status, ['dokumen_diterima', 'nunggu_pengumuman']); ?>
                    
                    <!-- Cetak Dokumen Card -->
                    <div class="bg-white rounded-[24px] border border-slate-100 p-8 shadow-sm h-full">
                        <h3 class="text-[18px] font-bold text-slate-500 mb-1.5">Cetak Dokumen</h3>
                        <p class="text-[13px] text-slate-400 font-medium mb-8">
                            <?= $canPrint ? 'Silakan unduh atau cetak dokumen penting Anda.' : 'Dokumen cetak baru akan tersedia setelah pendaftaran divalidasi.' ?>
                        </p>
                        
                        <div class="flex flex-col">
                            <!-- Item 1: Formulir Pendaftaran -->
                            <div class="flex items-center justify-between py-5 border-b border-slate-100/60">
                                <div class="flex items-center gap-5">
                                    <div class="w-12 h-12 bg-[#F8FAFC] text-slate-400 rounded-[14px] flex items-center justify-center text-xl flex-shrink-0">
                                        <i class="fas fa-file-invoice"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-[14px] font-bold text-slate-700 mb-0.5">Cetak Formulir Pendaftaran</h4>
                                        <p class="text-[12px] text-slate-400">Cetak formulir dan kartu peserta.</p>
                                    </div>
                                </div>
                                <?php if($canPrint): ?>
                                <a href="<?= base_url('student/cetak') ?>" target="_blank" class="px-5 py-2 bg-white border border-slate-200 text-slate-500 hover:text-slate-700 font-bold rounded-xl text-[13px] flex items-center gap-2 shadow-sm transition-colors">
                                    <i class="fas fa-print text-[11px]"></i> Cetak
                                </a>
                                <?php else: ?>
                                <button class="px-5 py-2 bg-white border border-slate-100 text-slate-300 font-bold rounded-xl text-[13px] flex items-center gap-2 cursor-not-allowed">
                                    <i class="fas fa-lock text-[10px]"></i> Cetak
                                </button>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Item 2: Unduh Hasil Seleksi -->
                            <div class="flex items-center justify-between py-5 border-b border-slate-100/60">
                                <div class="flex items-center gap-5">
                                    <div class="w-12 h-12 bg-[#F8FAFC] text-slate-400 rounded-[14px] flex items-center justify-center text-xl flex-shrink-0">
                                        <i class="fas fa-file-pdf"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-[14px] font-bold text-slate-700 mb-0.5">Unduh Hasil Seleksi (PDF)</h4>
                                        <p class="text-[12px] text-slate-400">Unduh hasil seleksi dalam bentuk PDF.</p>
                                    </div>
                                </div>
                                <button class="px-5 py-2 bg-white border border-slate-100 text-slate-300 font-bold rounded-xl text-[13px] flex items-center gap-2 cursor-not-allowed">
                                    <i class="fas fa-lock text-[10px]"></i> Unduh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php else: ?>
            <!-- Tampilan Diterima / Ditolak (2 Column Grid) -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start animate-fadeUp mt-4">
                
                <!-- Left Column (Hasil Seleksi) -->
                <div class="md:col-span-6 bg-white rounded-[24px] border border-slate-200/70 shadow-sm text-center relative overflow-hidden flex flex-col h-full" id="hasil-container">
                    
                    <!-- Cover State -->
                    <div id="reveal-cover" class="relative w-full h-full bg-gradient-to-b from-white to-[#f8fcf9] z-20 flex flex-col items-center justify-center pt-8 pb-10 transition-opacity duration-500 overflow-hidden rounded-[24px]">
                        
                        

                        <!-- Main Custom Icon -->
                        <div class="relative z-10 w-44 h-44 mb-3 flex items-center justify-center">
                            <svg viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                <defs>
                                    <filter id="soft-shadow" x="-20%" y="-20%" width="140%" height="140%">
                                        <feDropShadow dx="0" dy="4" stdDeviation="4" flood-color="#000000" flood-opacity="0.08"/>
                                    </filter>
                                </defs>
                                
                                <!-- Background Circle -->
                                <circle cx="60" cy="60" r="42" fill="#E8F4EC" />
                                
                                <!-- Sparkles -->
                                <path d="M 35 22 Q 37 22 37 20 Q 37 22 39 22 Q 37 22 37 24 Q 37 22 35 22 Z" fill="#FBBF24" />
                                <path d="M 45 12 Q 47 12 47 10 Q 47 12 49 12 Q 47 12 47 14 Q 47 12 45 12 Z" fill="#FBBF24" />
                                
                                <!-- Back Green Document -->
                                <path d="M 51 26 L 73 26 L 83 36 L 83 64 L 51 64 Z" fill="#52A669" />
                                <!-- Folded flap on back document -->
                                <path d="M 73 26 L 73 36 L 83 36 Z" fill="#87C698" />
                                
                                <!-- White Document -->
                                <rect x="41" y="32" width="36" height="46" rx="3" fill="white" filter="url(#soft-shadow)" />
                                
                                <!-- Document Lines -->
                                <rect x="48" y="42" width="12" height="2.5" rx="1.25" fill="#A5D6B4" />
                                <rect x="48" y="50" width="20" height="2.5" rx="1.25" fill="#A5D6B4" />
                                <rect x="48" y="58" width="20" height="2.5" rx="1.25" fill="#A5D6B4" />
                                <rect x="48" y="66" width="16" height="2.5" rx="1.25" fill="#A5D6B4" />
                                
                                <!-- Checkmark Circle -->
                                <circle cx="76" cy="74" r="14" fill="#1A8643" />
                                <path d="M 70 74 L 74 78 L 82 69" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                            </svg>
                        </div>

                        <!-- Pill Badge -->
                        <div class="relative z-10 inline-flex items-center gap-2 px-5 py-2 bg-[#E8F4EC] text-[#166534] rounded-full text-[13px] font-bold mb-6 shadow-sm border border-[#D1E8DA]">
                            <i class="fas fa-check-circle"></i> Hasil seleksi telah tersedia!
                        </div>

                        <!-- Title -->
                        <h2 class="relative z-10 text-[26px] font-black text-[#111827] mb-3 tracking-tight text-center leading-tight">Hasil Seleksi Penerimaan<br>Peserta Didik Baru</h2>
                        
                        <!-- Subtitle -->
                        <p class="relative z-10 text-[14px] text-slate-500 mb-8 px-4 leading-relaxed font-medium text-center">Hasil seleksi telah dirilis. Silakan buka untuk<br>melihat hasilnya.</p>
                        
                        <!-- Button -->
                        <button onclick="revealResult()" class="relative z-10 px-8 py-3.5 bg-[#166534] text-white font-bold rounded-xl text-[14px] hover:bg-[#14532d] transition-all shadow-md flex items-center gap-3">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                              <polyline points="14 2 14 8 20 8"></polyline>
                              <circle cx="10" cy="13" r="3"></circle>
                              <line x1="12" y1="15" x2="14" y2="17"></line>
                            </svg>
                            Lihat Hasil Kelulusan <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </button>
                    </div>

                    <!-- Revealed Content -->
                    <div id="reveal-content" class="hidden opacity-0 transition-opacity duration-500 relative z-10 flex-col items-center flex-1 w-full h-full p-10">
                    
                    <?php if($isLulus): ?>
                    <!-- Confetti background if lulus -->
                    <div class="absolute inset-0 pointer-events-none z-0 overflow-hidden opacity-80">
                        <i class="fas fa-square text-yellow-400 absolute top-10 left-10 text-xs rotate-12"></i>
                        <i class="fas fa-circle text-blue-400 absolute top-16 right-16 text-[8px]"></i>
                        <i class="fas fa-star text-emerald-400 absolute bottom-32 left-12 text-sm -rotate-12 animate-pulse"></i>
                        <i class="fas fa-play text-rose-400 absolute top-32 right-12 text-[10px] rotate-45"></i>
                        <i class="fas fa-square text-purple-400 absolute bottom-16 right-20 text-[10px] rotate-45"></i>
                        <i class="fas fa-circle text-emerald-400 absolute top-40 left-16 text-[6px]"></i>
                    </div>
                    <?php endif; ?>

                    <div class="relative z-10 flex flex-col items-center flex-1 w-full">
                        <div class="w-20 h-20 <?= $isLulus ? 'bg-[#5CB85C]' : 'bg-red-500' ?> rounded-full flex items-center justify-center text-white text-4xl mb-6 shadow-md border-4 border-white ring-4 <?= $isLulus ? 'ring-emerald-50' : 'ring-red-50' ?>">
                            <i class="fas <?= $isLulus ? 'fa-check' : 'fa-times' ?>"></i>
                        </div>
                        
                        <h2 class="text-2xl font-extrabold <?= $isLulus ? 'text-[#1a3a2a]' : 'text-red-700' ?> uppercase tracking-tight leading-tight mb-1">
                            <?= $isLulus ? 'SELAMAT!' : 'MOHON MAAF!' ?>
                        </h2>
                        <h3 class="text-[17px] font-semibold text-slate-700 mb-2">
                            Anda <span class="<?= $isLulus ? 'text-[#1a3a2a]' : 'text-red-700' ?> font-black uppercase"><?= $isLulus ? 'DITERIMA' : 'TIDAK DITERIMA' ?></span>
                        </h3>
                        <p class="text-[14px] font-medium text-slate-500 mb-6">di MI Nurul Ikhlas Al-Ayubi<br>Tahun Ajaran <?= date('Y') ?>/<?= date('Y', strtotime('+1 year')) ?></p>
                        
                        <div class="bg-[#E8F4EC] text-[#419864] px-5 py-1.5 rounded-full text-xs font-bold mb-10">
                            Gelombang <?= (new Settings_model())->getSetting('gelombang_aktif') ?? 1 ?>
                        </div>

                        <div class="w-full text-left space-y-4 mb-10 pl-2">
                            <div class="flex items-center gap-10 border-b border-slate-100 pb-3">
                                <div class="flex items-center gap-3 w-[120px]">
                                    <i class="fas fa-user text-slate-400 text-sm"></i>
                                    <p class="text-[12px] text-slate-600 font-medium">Nama Lengkap</p>
                                </div>
                                <p class="text-[13px] font-semibold text-slate-800 flex-1"><?= htmlspecialchars($data['pribadi']['nama_lengkap'] ?? $_SESSION['user_name']) ?></p>
                            </div>
                            <div class="flex items-center gap-10 border-b border-slate-100 pb-3">
                                <div class="flex items-center gap-3 w-[120px]">
                                    <i class="fas fa-file-alt text-slate-400 text-sm"></i>
                                    <p class="text-[12px] text-slate-600 font-medium">No. Pendaftaran</p>
                                </div>
                                <p class="text-[13px] font-semibold text-slate-800 flex-1"><?= date('y') ?><?= str_pad($data['pendaftaran']['id'] ?? '0', 4, '0', STR_PAD_LEFT) ?></p>
                            </div>
                            <div class="flex items-center gap-10 border-b border-slate-100 pb-3">
                                <div class="flex items-center gap-3 w-[120px]">
                                    <i class="fas fa-calendar-day text-slate-400 text-sm"></i>
                                    <p class="text-[12px] text-slate-600 font-medium">Tgl. Pengumuman</p>
                                </div>
                                <p class="text-[13px] font-semibold text-slate-800 flex-1"><?= $release_ts ? date('d F Y', $release_ts) : '-' ?></p>
                            </div>
                            <div class="flex items-start gap-10">
                                <div class="flex items-center gap-3 w-[120px] mt-0.5">
                                    <i class="fas fa-info-circle text-slate-400 text-sm"></i>
                                    <p class="text-[12px] text-slate-600 font-medium">Keterangan</p>
                                </div>
                                <p class="text-[12px] font-medium text-slate-600 leading-relaxed flex-1">
                                    <?= $isLulus ? 'Selamat! Anda lolos seleksi PPDB MI Nurul Ikhlas. Silakan lanjut ke tahap daftar ulang sesuai jadwal.' : 'Tetap semangat, jangan berkecil hati. Anda masih bisa mendaftar di sekolah lain.' ?>
                                </p>
                            </div>
                        </div>

                        <div class="mt-auto w-full">
                            <a href="<?= base_url('student/cetak_surat') ?>" target="_blank" class="w-full py-3.5 bg-[#209472] text-white font-bold rounded-xl text-[13px] transition-all shadow-md hover:bg-[#187559] flex items-center justify-center gap-2">
                                <i class="fas fa-external-link-alt text-xs"></i> Lihat Detail Hasil
                            </a>
                        </div>
                    </div>
                    </div> <!-- End Reveal Content -->
                </div>

                <!-- Right Column (Cetak Dokumen & Perhatian) -->
                <div class="md:col-span-6 space-y-6 flex flex-col h-full">
                    
                    <!-- Cetak Dokumen Card -->
                    <div class="bg-white rounded-[24px] border border-slate-200/70 p-8 shadow-sm">
                        <h3 class="text-lg font-bold text-[#1a3a2a] mb-1">Cetak Dokumen</h3>
                        <p class="text-xs text-slate-500 font-medium mb-6">Unduh atau cetak dokumen penting Anda.</p>
                        
                        <div class="flex flex-col">
                            <!-- Item 1: Formulir Pendaftaran -->
                            <div class="flex items-center gap-5 py-5 border-b border-slate-100">
                                <div class="w-14 h-14 bg-[#f0f7f4] text-[#1a5632] rounded-2xl flex items-center justify-center text-2xl flex-shrink-0 transition-colors">
                                    <i class="fas fa-file-invoice"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-slate-800 mb-1">Cetak Formulir Pendaftaran</h4>
                                    <p class="text-xs text-slate-500 leading-relaxed pr-2">Cetak formulir dan kartu peserta.</p>
                                </div>
                                <a href="<?= base_url('student/cetak') ?>" target="_blank" class="px-5 py-2 border border-[#1a5632] text-[#1a5632] hover:bg-[#f0f7f4] transition-colors bg-white font-bold rounded-xl text-sm flex items-center gap-2">
                                    <i class="fas fa-print"></i> Cetak
                                </a>
                            </div>
                            
                            <!-- Item 2: Unduh Hasil Seleksi -->
                            <div class="flex items-center gap-5 py-5 border-b border-slate-100">
                                <div class="w-14 h-14 bg-[#f0f7f4] text-[#1a5632] rounded-2xl flex items-center justify-center text-2xl flex-shrink-0 transition-colors">
                                    <i class="fas fa-file-pdf"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-slate-800 mb-1">Unduh Hasil Seleksi (PDF)</h4>
                                    <p class="text-xs text-slate-500 leading-relaxed pr-2">Unduh hasil seleksi dalam bentuk PDF.</p>
                                </div>
                                <?php if($isLulus): ?>
                                <a href="<?= base_url('student/cetak_surat') ?>" target="_blank" class="px-5 py-2 border border-[#1a5632] text-[#1a5632] hover:bg-[#f0f7f4] transition-colors bg-white font-bold rounded-xl text-sm flex items-center gap-2">
                                    <i class="fas fa-download"></i> Unduh
                                </a>
                                <?php else: ?>
                                <button onclick="alert('Maaf, hasil kelulusan belum dapat diunduh.')" class="px-5 py-2 border border-slate-200 text-slate-400 font-bold rounded-xl text-sm cursor-not-allowed flex items-center gap-2">
                                    <i class="fas fa-download"></i> Unduh
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
            <!-- Scripts for Reveal & Confetti -->
            <script>
                function revealResult() {
                    const cover = document.getElementById('reveal-cover');
                    const content = document.getElementById('reveal-content');
                    
                    cover.style.opacity = '0';
                    setTimeout(() => {
                        cover.classList.add('hidden');
                        content.classList.remove('hidden');
                        // Trigger reflow
                        void content.offsetWidth;
                        content.classList.remove('opacity-0');
                        content.classList.add('animate-fadeUp');
                        
                        <?php if($isLulus): ?>
                        if(typeof fireConfetti === 'function') {
                            fireConfetti();
                        }
                        <?php endif; ?>
                    }, 400);
                }
            </script>
            
            <?php if($isLulus): ?>
            <!-- CSS Confetti -->
            <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
            <script>
                function fireConfetti() {
                    var duration = 3000;
                    var animationEnd = Date.now() + duration;
                    var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 100 };

                    function randomInRange(min, max) {
                        return Math.random() * (max - min) + min;
                    }

                    var interval = setInterval(function() {
                        var timeLeft = animationEnd - Date.now();
                        if (timeLeft <= 0) {
                            return clearInterval(interval);
                        }
                        var particleCount = 50 * (timeLeft / duration);
                        confetti(Object.assign({}, defaults, { particleCount,
                            origin: { x: randomInRange(0.1, 0.4), y: Math.random() - 0.2 }
                        }));
                        confetti(Object.assign({}, defaults, { particleCount,
                            origin: { x: randomInRange(0.6, 0.9), y: Math.random() - 0.2 }
                        }));
                    }, 250);
                }
            </script>
            <?php endif; ?>

            <?php endif; ?>
        </div>
    </div>
</main>
<?php if($show_countdown): ?>
<script>
(function(){
  const target = <?= $release_ts ?> * 1000;
  function tick(){
    const now = Date.now();
    let diff = Math.max(0, Math.floor((target - now)/1000));
    if(diff <= 0){ 
        const zero = '00';
        if(document.getElementById('mini-d')) {
            ['d','h','m','s'].forEach(x => document.getElementById('mini-'+x).textContent = zero);
        }
        if(document.getElementById('hd-d')) {
            ['d','h','m','s'].forEach(x => document.getElementById('hd-'+x).textContent = zero);
        }
        return; 
    }
    const d = String(Math.floor(diff/86400)).padStart(2,'0'); diff %= 86400;
    const h = String(Math.floor(diff/3600)).padStart(2,'0');  diff %= 3600;
    const m = String(Math.floor(diff/60)).padStart(2,'0');
    const s = String(diff % 60).padStart(2,'0');
    
    if(document.getElementById('mini-d')) {
        document.getElementById('mini-d').textContent = d;
        document.getElementById('mini-h').textContent = h;
        document.getElementById('mini-m').textContent = m;
        document.getElementById('mini-s').textContent = s;
    }
    if(document.getElementById('hd-d')) {
        document.getElementById('hd-d').textContent = d;
        document.getElementById('hd-h').textContent = h;
        document.getElementById('hd-m').textContent = m;
        document.getElementById('hd-s').textContent = s;
    }
  }
  tick();
  setInterval(tick, 1000);
})();
</script>
<?php endif; ?>
</body>
</html>
