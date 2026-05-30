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
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Official Formal Flat Envelope Styles */
        .envelope-official {
            position: relative;
            width: 520px;
            height: 300px;
            background: #ffffff;
            border-radius: 12px;
            border: 2px solid #1a3a2a; /* Dark green border */
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1), 0 5px 15px rgba(0, 0, 0, 0.05);
            margin: 0 auto 30px auto;
            cursor: pointer;
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 28px;
            text-align: left;
        }

        .envelope-official:hover {
            transform: translateY(-6px) scale(1.01);
            box-shadow: 0 30px 50px rgba(26, 58, 42, 0.18);
        }

        /* Top-left mini kop surat */
        .envelope-kop {
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1.5px solid #1a3a2a;
            padding-bottom: 10px;
            width: 78%;
        }

        /* Recipient address block */
        .envelope-recipient {
            align-self: flex-end;
            background: #fafafa;
            border: 1px dashed #cbd5e1;
            padding: 14px 20px;
            border-radius: 8px;
            width: 62%;
            margin-top: 15px;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.02);
        }

        /* Envelope open state animation */
        .envelope-official.is-open {
            transform: translateY(100px) scale(0.9);
            opacity: 0;
            pointer-events: none;
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .result-card {
            opacity: 0;
            transform: translateY(40px) scale(0.96);
            transition: all 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .result-card.show {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    </style>
</head>
<body class="text-slate-800 flex h-screen overflow-hidden selection:bg-emerald-500 selection:text-white">
<?php require_once '../app/Views/student/_sidebar.php'; studentSidebar('pengumuman'); ?>

<main class="flex-1 flex flex-col h-full overflow-y-auto bg-slate-50 relative">
    <header class="bg-white px-8 py-5 border-b border-slate-200/80 sticky top-0 z-30 flex justify-between items-center shadow-sm">
        <div>
            <h2 class="text-xl font-extrabold text-slate-800 tracking-tight">PENGUMUMAN HASIL SELEKSI</h2>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Sistem Informasi PPDB Nurul Ikhlas</p>
        </div>
        <a href="<?= base_url('student') ?>" class="flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-slate-800 transition-colors">
            <i class="ph-bold ph-arrow-left"></i> Kembali ke Dashboard
        </a>
    </header>

    <div class="p-8 w-full flex-1 flex items-center justify-center relative overflow-hidden">
        
        <!-- Decorative Background Elements -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-teal-100 rounded-full blur-[100px] opacity-60"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-emerald-100 rounded-full blur-[100px] opacity-60"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI4IiBoZWlnaHQ9IjgiPgo8cmVjdCB3aWR0aD0iOCIgaGVpZ2h0PSI4IiBmaWxsPSIjZmZmIiAvPgo8Y2lyY2xlIGN4PSIxIiBjeT0iMSIgcj0iMSIgZmlsbD0iI2U1ZTdlYiIgLz4KPC9zdmc+')] opacity-50"></div>
        </div>

        <?php 
        $status = $data['pendaftaran']['status'] ?? 'belum_mendaftar'; 
        $catatan = $data['pendaftaran']['catatan'] ?? '';
        $isLulus = ($status == 'diterima');
        $isWaiting = in_array($status, ['nunggu_verifikasi', 'dokumen_diterima', 'nunggu_pengumuman', 'perlu_revisi']);
        
        $config = $isLulus ? [
            'theme' => 'emerald',
            'icon' => 'ph-confetti',
            'title' => 'SELAMAT! ANDA LULUS',
            'desc' => 'Selamat datang di keluarga besar MI Nurul Ikhlas Al-Ayubi.',
            'bg' => 'from-emerald-500 to-teal-600',
            'shadow' => 'shadow-emerald-500/30',
            'text' => 'text-emerald-700'
        ] : [
            'theme' => 'red',
            'icon' => 'ph-warning-circle',
            'title' => 'MOHON MAAF, ANDA TIDAK LULUS',
            'desc' => 'Tetap semangat, jangan berkecil hati dan teruslah belajar.',
            'bg' => 'from-red-500 to-rose-600',
            'shadow' => 'shadow-red-500/30',
            'text' => 'text-red-700'
        ];
        ?>

        <div class="w-full max-w-3xl relative z-10 flex flex-col items-center">
            
            <?php if($status === 'belum_mendaftar'): ?>
            <!-- Tampilan Belum Daftar -->
            <div class="w-full bg-white rounded-[32px] border border-slate-200/80 shadow-xl overflow-hidden relative p-10 text-center animate-fadeUp">
                <div class="flex flex-col items-center">
                    <div class="w-20 h-20 bg-amber-50 rounded-3xl flex items-center justify-center text-4xl mb-6 border border-amber-100 shadow-sm">
                        ≡ƒôï
                    </div>
                    <p class="text-[11px] font-black text-amber-500 uppercase tracking-[0.2em] mb-2">Oops!</p>
                    <h2 class="text-2xl font-black text-slate-800 tracking-tight mb-3">Kamu Belum Isi Formulir!</h2>
                    <p class="text-slate-400 font-medium text-sm max-w-sm leading-relaxed mb-8">
                        Halaman ini menampilkan hasil seleksi PPDB. Tapi sepertinya kamu belum mengisi formulir pendaftaran nih&nbsp;≡ƒÿà<br><br>
                        <span class="text-slate-500 font-semibold">Isi dulu yuu, baru bisa lihat pengumuman di sini!</span>
                    </p>
                    <a href="<?= base_url('student/form') ?>" class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-black rounded-2xl text-sm uppercase tracking-widest hover:from-emerald-700 hover:to-teal-700 hover:-translate-y-1 transition-all shadow-lg shadow-emerald-200">
                        <i class="fas fa-edit"></i> Isi Formulir Sekarang
                    </a>
                </div>
            </div>

            <?php elseif($isWaiting): ?>
            <!-- Tampilan Saat Menunggu Verifikasi / Pengumuman (Horizontal & Elegan) -->
            <?php
              $release_time_raw = (new Settings_model())->getSetting('release_announcement_datetime');
              $release_ts = !empty($release_time_raw) ? strtotime($release_time_raw) : 0;
              $show_countdown = ($release_ts > time());
            ?>
            <div class="w-full bg-white rounded-[32px] border border-slate-200/80 shadow-xl overflow-hidden relative p-8 md:p-10 animate-fadeUp">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                    
                    <!-- Left Column: Status Header -->
                    <div class="md:col-span-5 text-center md:border-r md:border-slate-100 md:pr-8 flex flex-col items-center justify-center">
                        <!-- Hourglass Icon (Mini & Animated) -->
                        <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-xl mb-4 border border-amber-200/50 shadow-sm">
                            <i class="fas fa-hourglass-half animate-pulse"></i>
                        </div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-1.5">No. Registrasi: REG-<?= str_pad($data['pendaftaran']['id'] ?? '0', 4, '0', STR_PAD_LEFT) ?></p>
                        <h2 class="text-2xl font-black text-slate-800 tracking-tight uppercase">SEDANG DIPROSES</h2>
                    </div>
                    
                    <!-- Right Column: Details & Actions -->
                    <div class="md:col-span-7 flex flex-col justify-between h-full">
                        <div class="text-slate-500 text-sm font-medium leading-relaxed mb-6 text-center md:text-left">
                            Hai, <span class="font-extrabold text-slate-800"><?= htmlspecialchars($data['pribadi']['nama_lengkap'] ?? $_SESSION['user_name']) ?></span>.<br>
                            <?php if($status == 'nunggu_verifikasi'): ?>
                                Data pendaftaran Anda sedang diverifikasi oleh panitia.
                            <?php elseif($status == 'dokumen_diterima'): ?>
                                Dokumen Anda telah divalidasi. Silakan menunggu rilis pengumuman kelulusan.
                            <?php elseif($status == 'perlu_revisi'): ?>
                                Terdapat data/dokumen yang perlu diperbaiki. Silakan kembali ke dashboard untuk melihat catatan revisi.
                            <?php else: ?>
                                Hasil seleksi belum dapat dibuka. Silakan menunggu rilis pengumuman resmi.
                            <?php endif; ?>
                        </div>

                        <?php if($show_countdown): ?>
                        <!-- Mini Countdown Grid (Ultra Clean & Compact) -->
                        <div class="mb-6 bg-slate-50 border border-slate-200/60 rounded-2xl p-4 flex flex-col sm:flex-row items-center justify-between gap-3 text-center sm:text-left">
                            <div>
                                <p class="text-[8px] font-black text-slate-400 uppercase tracking-wider">Rilis Pengumuman</p>
                                <p class="text-[11px] font-extrabold text-slate-600 mt-0.5"><?= date('d M Y, H:i', $release_ts) ?> WIB</p>
                            </div>
                            
                            <div class="flex gap-1.5" id="mini-countdown">
                                <div class="text-center bg-white border border-slate-200/60 shadow-sm rounded-lg px-1.5 py-1 w-9">
                                    <span class="text-xs font-black text-emerald-600 block leading-tight" id="mini-d">--</span>
                                    <span class="text-[6px] font-bold text-slate-400 uppercase tracking-wider block">Hari</span>
                                </div>
                                <div class="text-center bg-white border border-slate-200/60 shadow-sm rounded-lg px-1.5 py-1 w-9">
                                    <span class="text-xs font-black text-emerald-600 block leading-tight" id="mini-h">--</span>
                                    <span class="text-[6px] font-bold text-slate-400 uppercase tracking-wider block">Jam</span>
                                </div>
                                <div class="text-center bg-white border border-slate-200/60 shadow-sm rounded-lg px-1.5 py-1 w-9">
                                    <span class="text-xs font-black text-emerald-600 block leading-tight" id="mini-m">--</span>
                                    <span class="text-[6px] font-bold text-slate-400 uppercase tracking-wider block">Mnt</span>
                                </div>
                                <div class="text-center bg-white border border-slate-200/60 shadow-sm rounded-lg px-1.5 py-1 w-9">
                                    <span class="text-xs font-black text-emerald-600 block leading-tight" id="mini-s">--</span>
                                    <span class="text-[6px] font-bold text-slate-400 uppercase tracking-wider block">Dtk</span>
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
                            document.getElementById('mini-d').textContent = String(d).padStart(2,'0');
                            document.getElementById('mini-h').textContent = String(h).padStart(2,'0');
                            document.getElementById('mini-m').textContent  = String(m).padStart(2,'0');
                            document.getElementById('mini-s').textContent  = String(s).padStart(2,'0');
                          }
                          tick();
                          setInterval(tick, 1000);
                        })();
                        </script>
                        <?php endif; ?>

                        <!-- Buttons (Simplified & Elegant) -->
                        <div class="flex items-center justify-center md:justify-start gap-3">
                            <a href="<?= base_url('student') ?>" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200/80 text-slate-600 font-bold rounded-xl text-xs uppercase tracking-wider transition-colors">
                                Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                    
                </div>
            </div>

            <?php else: ?>
            <!-- Tampilan Saat Pengumuman Sudah Ada (Diterima / Ditolak) -->

            <!-- Envelope / Button Reveal (Interactive CSS Envelope) -->
            <div id="reveal-container" class="flex flex-col items-center justify-center text-center animate-fadeUp select-none w-full">
                
                <!-- Official Formal Envelope Box -->
                <div id="envelope-box" onclick="revealResult()" class="envelope-official">
                    
                    <!-- Top Section: Kop -->
                    <div class="flex justify-between items-start w-full">
                        <!-- Mini Kop Surat -->
                        <div class="envelope-kop">
                            <img src="<?= base_url('img/logo.jpeg') ?>" alt="Logo" class="w-10 h-10 object-cover rounded-full border border-[#1a3a2a]">
                            <div class="leading-tight">
                                <p class="text-[8px] font-black text-[#1a3a2a] uppercase tracking-wider">PANITIA PPDB ONLINE</p>
                                <p class="text-[9px] font-black text-slate-800 uppercase tracking-tight mt-0.5">MI NURUL IKHLAS AL-AYUBI</p>
                                <p class="text-[6px] text-slate-500 font-semibold mt-0.5">Tahun Pelajaran <?= date('Y') ?>/<?= date('Y', strtotime('+1 year')) ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Middle Section: Recipient Address -->
                    <div class="envelope-recipient leading-tight">
                        <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">Kepada Yth. Calon Siswa:</p>
                        <p class="text-[12px] font-black text-slate-800 uppercase tracking-tight mt-1 truncate">
                            <?= htmlspecialchars($data['pribadi']['nama_lengkap'] ?? $_SESSION['user_name']) ?>
                        </p>
                        <p class="text-[8px] font-semibold text-slate-500 mt-0.5">No. Reg: REG-<?= str_pad($data['pendaftaran']['id'] ?? '0', 4, '0', STR_PAD_LEFT) ?></p>
                        <p class="text-[9px] font-bold text-slate-600 mt-2.5">Di Tempat</p>
                    </div>
                    
                </div>
                
                <h3 class="text-lg font-black text-slate-800 tracking-tight mb-1">Surat Keputusan Hasil Seleksi</h3>
                <p class="text-slate-500 text-xs font-medium mb-6 max-w-md leading-relaxed">
                    Amplop resmi dari Panitia PPDB MI Nurul Ikhlas Al-Ayubi. Klik amplop untuk membuka Surat Keputusan Anda secara resmi.
                </p>
                
                <button onclick="revealResult()" class="w-full max-w-[280px] py-3 bg-slate-900 text-white font-bold rounded-xl text-xs uppercase tracking-widest hover:bg-emerald-600 transition-all flex items-center justify-center gap-2 shadow-md">
                    <i class="fas fa-envelope-open text-xs"></i> Buka Surat Keputusan
                </button>
            </div>

            <!-- The Result Card (Hidden Initially, Compact & Minimalist) -->
            <div id="result-card" class="result-card hidden w-full bg-white rounded-2xl border border-slate-200 shadow-xl overflow-hidden relative">

                <!-- Top Accent Bar -->
                <div class="h-1.5 w-full <?= $isLulus ? 'bg-gradient-to-r from-emerald-500 to-teal-500' : 'bg-gradient-to-r from-red-500 to-rose-500' ?>"></div>

                <div class="p-7 relative z-10">
                    <!-- Compact Header Row -->
                    <div class="flex items-center gap-3 mb-5 pb-5 border-b border-slate-100">
                        <div class="w-10 h-10 <?= $isLulus ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' ?> rounded-xl flex items-center justify-center flex-shrink-0 border <?= $isLulus ? 'border-emerald-100' : 'border-red-100' ?>">
                            <i class="fas <?= $isLulus ? 'fa-check-circle' : 'fa-times-circle' ?> text-base"></i>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Pengumuman Hasil Seleksi PPDB <?= date('Y') ?></p>
                            <h2 class="text-base font-black <?= $isLulus ? 'text-emerald-700' : 'text-red-700' ?> uppercase tracking-tight leading-tight">
                                <?= $isLulus ? 'Selamat! Anda Diterima' : 'Mohon Maaf, Tidak Diterima' ?>
                            </h2>
                        </div>
                        <div class="ml-auto text-right hidden sm:block">
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">No. Peserta</p>
                            <p class="text-xs font-black text-slate-700 tracking-wider"><?= date('y') ?>-<?= str_pad($data['pendaftaran']['id'] ?? '0', 4, '0', STR_PAD_LEFT) ?>-010001</p>
                        </div>
                    </div>

                    <!-- Data Grid (Compact) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                        <div class="space-y-3">
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-wider mb-0.5">Nama Lengkap</p>
                                <p class="text-sm font-extrabold text-slate-800 uppercase"><?= htmlspecialchars($data['pribadi']['nama_lengkap'] ?? $_SESSION['user_name']) ?></p>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-wider mb-0.5">Tanggal Lahir</p>
                                <p class="text-sm font-bold text-slate-700"><?= isset($data['pribadi']['tanggal_lahir']) ? date('d M Y', strtotime($data['pribadi']['tanggal_lahir'])) : '-' ?></p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-wider mb-0.5">Madrasah</p>
                                <p class="text-sm font-bold text-slate-700 uppercase">MI Nurul Ikhlas Al-Ayubi</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-wider mb-0.5">Program / Kelas</p>
                                <p class="text-sm font-bold text-slate-700">Reguler</p>
                            </div>
                        </div>
                    </div>

                    <?php if(!$isLulus && !empty($catatan)): ?>
                    <!-- Catatan (only for rejected) -->
                    <div class="mb-5 p-3.5 bg-red-50 border border-red-100 rounded-xl">
                        <p class="text-[9px] font-black text-red-500 uppercase tracking-wider mb-1"><i class="fas fa-comment-dots mr-1"></i>Catatan Panitia</p>
                        <p class="text-xs text-red-700 font-medium italic">"<?= htmlspecialchars($catatan) ?>"</p>
                    </div>
                    <?php endif; ?>

                    <div class="flex flex-col gap-3">
                        <?php if($isLulus): ?>
                        <a href="<?= base_url('student/cetak_surat') ?>" target="_blank" class="w-full py-3 text-center bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold rounded-xl text-xs uppercase tracking-wider transition-all shadow-md block">
                            <i class="fas fa-file-download mr-1.5"></i> Unduh Surat Kelulusan
                        </a>
                        <?php endif; ?>
                        
                        <a href="<?= base_url('student') ?>" class="w-full py-2.5 text-center bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl text-xs uppercase tracking-wider transition-colors block">
                            <i class="fas fa-arrow-left mr-1.5"></i>Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</main>

<!-- JS for Reveal Animation -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script>
    const isLulus = <?= $isLulus ? 'true' : 'false' ?>;
    let isRevealing = false;

    function revealResult() {
        if (isRevealing) return;
        isRevealing = true;
        
        const env = document.getElementById('envelope-box');
        const container = document.getElementById('reveal-container');
        const card = document.getElementById('result-card');
        
        // 1. Open the envelope (slides down, fades out)
        env.classList.add('is-open');
        
        // 2. Wait for envelope slide animation to complete (0.7s)
        setTimeout(() => {
            // Fade out the entire envelope wrapper container
            container.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
            container.style.opacity = '0';
            container.style.transform = 'scale(0.96) translateY(20px)';
            
            // 3. Reveal the result letter
            setTimeout(() => {
                container.style.display = 'none';
                card.classList.remove('hidden');
                
                // Trigger reflow to restart CSS animation
                void card.offsetWidth;
                card.classList.add('show');

                // Fire confetti if passed
                if (isLulus) {
                    setTimeout(() => {
                        fireConfetti();
                    }, 300);
                }
            }, 500);
        }, 700);
    }

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
                origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 }
            }));
            confetti(Object.assign({}, defaults, { particleCount,
                origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 }
            }));
        }, 250);
    }
</script>

</body>
</html>
