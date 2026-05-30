<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB Online | MI Nurul Ikhlas Al-Ayubi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-gradient { background: linear-gradient(135deg, #064e3b 0%, #047857 40%, #10b981 100%); }
        .nav-active { color: #059669; border-bottom: 2px solid #059669; }
        .wave-divider { position: relative; }
        .wave-divider::after { content: ''; position: absolute; bottom: -1px; left: 0; right: 0; height: 80px; background: white; clip-path: ellipse(55% 100% at 50% 100%); }
    </style>
</head>
<body class="bg-white text-slate-800 overflow-x-hidden">

<!-- Navbar -->
<nav class="bg-white shadow-md px-6 lg:px-16 py-4 flex items-center justify-between sticky top-0 z-50 border-b border-slate-100">
    <div class="flex items-center space-x-3">
        <img src="<?= base_url('img/logo.jpeg') ?>" alt="Logo MIS" class="w-10 h-10 rounded-full object-cover shadow-sm" onerror="this.style.display='none'">
        <div>
            <h1 class="font-black text-emerald-800 text-sm uppercase tracking-wide">PPDB MI Nurul Ikhlas Al-Ayubi</h1>
        </div>
    </div>
    <div class="hidden md:flex items-center space-x-8" id="nav-links">
        <a href="#home" class="nav-link text-sm font-bold text-emerald-700 nav-active pb-1 transition-colors" data-section="home">Home</a>
        <a href="#profil" class="nav-link text-sm font-bold text-slate-500 pb-1 transition-colors" data-section="profil">Profil</a>
        <a href="#jadwal" class="nav-link text-sm font-bold text-slate-500 pb-1 transition-colors" data-section="jadwal">Jadwal</a>
        <a href="#informasi" class="nav-link text-sm font-bold text-slate-500 pb-1 transition-colors" data-section="informasi">Informasi</a>
        <a href="#kontak" class="nav-link text-sm font-bold text-slate-500 pb-1 transition-colors" data-section="kontak">Kontak</a>
    </div>
    <a href="<?= base_url('auth/register') ?>" class="px-6 py-2.5 bg-emerald-600 text-white rounded-full font-bold text-sm shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:shadow-emerald-300 transition-all active:scale-95 uppercase tracking-wider flex items-center gap-2">
        Daftar Sekarang <i class="fas fa-arrow-right"></i>
    </a>
</nav>

<!-- Hero Section -->
<section id="home" class="relative overflow-hidden bg-gradient-to-br from-emerald-50/50 via-white to-white pt-28 pb-16 lg:pt-32 lg:pb-24">
    <div class="max-w-6xl mx-auto px-6 lg:px-16 flex flex-col lg:flex-row items-center justify-between relative z-10">
        <!-- Left Text -->
        <div class="lg:w-1/2 mb-12 lg:mb-0" data-aos="fade-right">
            <h2 class="text-4xl lg:text-[46px] font-semibold text-slate-700 leading-tight mb-2">
                Penerimaan Peserta<br>Didik Baru
            </h2>
            <h2 class="text-4xl lg:text-[46px] font-bold text-emerald-500 leading-tight mb-6">
                MI Nurul Ikhlas<br>Al-Ayubi
            </h2>
            <p class="text-slate-600 text-sm font-medium max-w-md mb-8 leading-relaxed">
                Untuk calon pendaftar masuk MI Nurul Ikhlas Al-Ayubi tahun ajaran 2026/2027 bisa mendaftar lewat website ini atau langsung datang ke sekolah MI Nurul Ikhlas Al-Ayubi.
            </p>
            <?php 
                $k = $data['kuota'] ?? 100;
                $t = $data['total_pendaftar'] ?? 0;
                $sisa = max(0, $k - $t);
                $isPenuh = $sisa <= 0;
            ?>
            
            <?php if($isPenuh): ?>
            <div class="inline-flex items-center px-8 py-3.5 bg-red-50 text-red-500 rounded-full font-bold text-sm shadow-sm cursor-not-allowed border border-red-200">
                <i class="fas fa-ban mr-2"></i> Kuota Pendaftaran Penuh
            </div>
            <?php else: ?>
            <a href="<?= base_url('auth/register') ?>" class="inline-flex items-center px-8 py-3.5 bg-emerald-500 text-white rounded-full font-bold text-sm shadow-lg shadow-emerald-500/30 hover:bg-emerald-600 hover:shadow-emerald-600/40 transition-all hover:-translate-y-0.5">
                Daftar Gelombang <?= $data['gelombang_aktif'] ?? 1 ?>
            </a>
            <?php endif; ?>
        </div>

        <!-- Right Logo -->
        <div class="lg:w-1/2 flex justify-center lg:justify-end" data-aos="fade-left" data-aos-delay="200">
            <img src="<?= base_url('img/logo.jpeg') ?>" alt="Logo MIS" class="w-64 h-64 lg:w-96 lg:h-96 object-cover rounded-full drop-shadow-[0_20px_50px_rgba(16,185,129,0.15)] hover:scale-105 transition-transform duration-500 bg-white border-4 border-emerald-50/50" onerror="this.outerHTML='<div class=\'w-64 h-64 lg:w-96 lg:h-96 bg-emerald-50 rounded-full flex items-center justify-center drop-shadow-xl\'><i class=\'fas fa-graduation-cap text-9xl text-emerald-400\'></i></div>'">
        </div>
    </div>
    
    <!-- Decorative subtle shapes -->
    <div class="absolute top-0 right-0 w-1/2 h-full bg-emerald-100/30 rounded-l-full blur-3xl -z-10 translate-x-1/3"></div>
</section>



<!-- Profil & Keunggulan Section -->
<section id="profil" class="pt-16 lg:pt-24 pb-24 bg-white relative border-t border-slate-100">
    <div class="absolute inset-0 z-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(#10b981 1px, transparent 1px); background-size: 40px 40px;"></div>
    
    <div class="max-w-7xl mx-auto px-6 lg:px-16 relative z-10">
        <!-- Content Wrapper -->
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-20 items-center lg:items-end" data-aos="fade-up">
            
            <!-- Left: Heading & Image -->
            <div class="lg:w-1/2 w-full flex flex-col">
                <div class="mb-8 relative inline-block group cursor-default">
                    <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 tracking-tight leading-snug">
                        Profil Singkat <span class="text-emerald-600">Kami</span>
                    </h2>
                    <!-- Animated Green Underline -->
                    <div class="absolute -bottom-3 left-0 w-16 h-1.5 bg-emerald-500 rounded-full transition-all duration-500 group-hover:w-full"></div>
                </div>
                
                <a href="https://www.youtube.com/@MISNURULIKHLASOFFICIAL" target="_blank" class="block overflow-hidden aspect-[4/3] lg:aspect-[16/10] w-full relative group rounded-2xl shadow-sm border border-slate-100">
                    <img src="<?= base_url('img/sekolah.jpg') ?>" alt="Gedung Sekolah" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" onerror="this.outerHTML='<div class=\'w-full h-full bg-emerald-50 flex items-center justify-center\'><i class=\'fas fa-school text-7xl text-emerald-200\'></i></div>'">
                    
                    <!-- Play Button Overlay -->
                    <div class="absolute inset-0 flex items-center justify-center bg-slate-900/10 group-hover:bg-slate-900/20 transition-colors">
                        <div class="w-16 h-16 border-[3px] border-white rounded-full flex items-center justify-center bg-transparent cursor-pointer hover:scale-110 transition-transform">
                            <i class="fas fa-play text-white text-xl ml-1"></i>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- Right: 4 Stats Grid -->
            <div class="lg:w-1/2 w-full mt-10 lg:mt-0">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-12">
                    <!-- Stat 1 -->
                    <div>
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mb-5 text-xl shadow-sm">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4 class="text-[15px] font-bold text-slate-900 mb-2"><?= htmlspecialchars($data['stats_siswa'] ?? '250+') ?> Siswa</h4>
                        <p class="text-[13px] text-slate-500 leading-relaxed">
                            Total siswa aktif yang saat ini sedang menempuh pendidikan.
                        </p>
                    </div>

                    <!-- Stat 2 -->
                    <div>
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mb-5 text-xl shadow-sm">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h4 class="text-[15px] font-bold text-slate-900 mb-2"><?= htmlspecialchars($data['stats_guru'] ?? '15+') ?> Guru</h4>
                        <p class="text-[13px] text-slate-500 leading-relaxed">
                            Tenaga pendidik profesional dan berpengalaman di bidangnya.
                        </p>
                    </div>

                    <!-- Stat 3 -->
                    <div>
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mb-5 text-xl shadow-sm">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <h4 class="text-[15px] font-bold text-slate-900 mb-2"><?= htmlspecialchars($data['stats_eskul'] ?? '8+') ?> Eskul</h4>
                        <p class="text-[13px] text-slate-500 leading-relaxed">
                            Kegiatan ekstrakurikuler unggulan untuk mengembangkan bakat siswa.
                        </p>
                    </div>

                    <!-- Stat 4 -->
                    <div>
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mb-5 text-xl shadow-sm">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h4 class="text-[15px] font-bold text-slate-900 mb-2">Akreditasi <?= htmlspecialchars($data['stats_akreditasi'] ?? 'BAIK') ?></h4>
                        <p class="text-[13px] text-slate-500 leading-relaxed">
                            Terakreditasi resmi oleh Badan Akreditasi Nasional (BAN-S/M).
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Jadwal Section -->
<section id="jadwal" class="py-20 bg-gradient-to-b from-emerald-800 to-emerald-900 text-white">
    <div class="max-w-6xl mx-auto px-6 lg:px-16">
        <div class="text-center mb-14" data-aos="fade-up">
            <h2 class="text-3xl lg:text-4xl font-black tracking-tight mb-3">Jadwal Pendaftaran</h2>
            <div class="w-16 h-1 bg-emerald-400 mx-auto rounded-full mb-4"></div>
            <p class="text-emerald-200/70 font-medium">Berikut ini adalah jadwal seputar pendaftaran :</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" data-aos="fade-up" data-aos-delay="100">
        <?php foreach($data['jadwal'] as $g):
            ?>
            <div data-aos="zoom-in" class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 text-center border border-white/10 hover:bg-white/15 transition-colors">
                <h3 class="text-2xl font-black mb-6"><?= $g['gel'] ?></h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-emerald-300 text-sm font-bold uppercase tracking-wider">Pendaftaran</p>
                        <p class="text-white/80 text-sm font-medium mt-1"><?= $g['daftar'] ?></p>
                    </div>
                    <div>
                        <p class="text-emerald-300 text-sm font-bold uppercase tracking-wider">Tes Baca &amp; Tulis</p>
                        <p class="text-white/80 text-sm font-medium mt-1"><?= $g['sosial'] ?></p>
                    </div>
                    <div>
                        <p class="text-emerald-300 text-sm font-bold uppercase tracking-wider">Pengumuman Hasil</p>
                        <p class="text-white/80 text-sm font-medium mt-1"><?= $g['hasil'] ?></p>
                    </div>
                    <div>
                        <p class="text-emerald-300 text-sm font-bold uppercase tracking-wider">Daftar Ulang</p>
                        <p class="text-white/80 text-sm font-medium mt-1"><?= $g['daftar_ulang'] ?? '-' ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Informasi / Alur Pendaftaran -->
<section id="informasi" class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-6 lg:px-16">
        <div class="text-center mb-14">
            <h2 class="text-3xl lg:text-4xl font-black text-slate-800 tracking-tight mb-3">Informasi</h2>
            <div class="w-16 h-1 bg-emerald-500 mx-auto rounded-full mb-4"></div>
            <p class="text-slate-500 font-medium">Berikut informasi seputar pendaftaran :</p>
        </div>

        <!-- Alur Pendaftaran -->
        <div class="bg-gradient-to-r from-emerald-700 to-teal-700 rounded-3xl p-8 lg:p-12 text-white relative overflow-hidden mb-10">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/3"></div>
            <div class="relative z-10">
                <div class="flex items-center space-x-4 mb-8">
                    <img src="<?= base_url('img/logo.jpeg') ?>" alt="Logo" class="w-16 h-16 rounded-full bg-white p-1 shadow-lg object-cover" onerror="this.style.display='none'">
                    <div>
                        <span class="text-emerald-200 text-xs font-bold uppercase tracking-[0.2em]">PPDB 2026/2027</span>
                        <h3 class="text-2xl lg:text-3xl font-black uppercase tracking-tight">Alur Pendaftaran</h3>
                    </div>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php
                    $alur = [
                        ['no'=>'01','title'=>'Mengisi Formulir','desc'=>'Pendaftaran secara online melalui website ini.','icon'=>'fa-edit'],
                        ['no'=>'02','title'=>'Upload Berkas','desc'=>'Mengunggah dokumen KK, Akta, dan Pas Foto.','icon'=>'fa-cloud-upload-alt'],
                        ['no'=>'03','title'=>'Verifikasi Data','desc'=>'Panitia akan memverifikasi data dan berkas.','icon'=>'fa-search'],
                        ['no'=>'04','title'=>'Pengumuman','desc'=>'Hasil seleksi diumumkan dan cetak kartu.','icon'=>'fa-bullhorn'],
                    ];
                    foreach($alur as $a):
                    ?>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-white text-emerald-700 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                            <span class="text-2xl font-black"><?= $a['no'] ?></span>
                        </div>
                        <div class="w-10 h-10 bg-emerald-500/30 rounded-full flex items-center justify-center mx-auto mb-3 border border-emerald-400/30">
                            <i class="fas <?= $a['icon'] ?> text-sm"></i>
                        </div>
                        <h4 class="font-bold text-sm mb-1"><?= $a['title'] ?></h4>
                        <p class="text-emerald-200/70 text-xs font-medium leading-relaxed"><?= $a['desc'] ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="text-center bg-slate-50 rounded-2xl p-10 border border-slate-200">
            <h3 class="text-2xl font-black text-slate-800 mb-3">Siap Bergabung?</h3>
            <p class="text-slate-500 font-medium mb-6 max-w-md mx-auto">Kuota terbatas untuk <?= htmlspecialchars($data['jadwal'][$data['gelombang_aktif']-1]['gel'] ?? 'Gelombang '.($data['gelombang_aktif'])) ?>. Pastikan Anda mengamankan kursi putra-putri Anda sekarang juga.</p>
            <a href="<?= base_url('auth/register') ?>" class="inline-flex items-center px-8 py-4 bg-emerald-600 text-white rounded-full font-black uppercase tracking-wider shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:-translate-y-1 transition-all">
                Mulai Pendaftaran <i class="fas fa-arrow-right ml-3"></i>
            </a>
        </div>
    </div>
</section>

<!-- Kontak Section -->
<section id="kontak" class="py-20 bg-slate-50 border-t border-slate-200">
    <div class="max-w-6xl mx-auto px-6 lg:px-16">
        <div class="text-center mb-14">
            <h2 class="text-3xl lg:text-4xl font-black text-slate-800 tracking-tight mb-3">Kontak</h2>
            <div class="w-16 h-1 bg-emerald-500 mx-auto rounded-full mb-4"></div>
            <p class="text-slate-500 font-medium">Hubungi kami untuk informasi lebih lanjut</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" data-aos="fade-up" data-aos-delay="100">
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm text-center hover:shadow-md transition-shadow">
                <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-xl"><i class="fas fa-map-marker-alt"></i></div>
                <h4 class="font-bold text-slate-800 mb-2">Alamat</h4>
                <p class="text-sm text-slate-500 font-medium"><?= nl2br(htmlspecialchars($data['kontak_alamat'] ?? '')) ?></p>
            </div>
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm text-center hover:shadow-md transition-shadow">
                <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-xl"><i class="fas fa-phone-alt"></i></div>
                <h4 class="font-bold text-slate-800 mb-2">Telepon</h4>
                <p class="text-sm text-slate-500 font-medium"><?= nl2br(htmlspecialchars($data['kontak_telepon'] ?? '')) ?></p>
            </div>
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm text-center hover:shadow-md transition-shadow">
                <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-xl"><i class="fas fa-envelope"></i></div>
                <h4 class="font-bold text-slate-800 mb-2">Email</h4>
                <p class="text-sm text-slate-500 font-medium"><?= nl2br(htmlspecialchars($data['kontak_email'] ?? '')) ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-emerald-950 pt-10 pb-6 border-t-[6px] border-emerald-600 text-slate-300">
    <div class="max-w-7xl mx-auto px-6">
        <!-- Top Section -->
        <div class="mb-6">
            <div class="flex items-center space-x-4 mb-3">
                <div class="w-10 h-10 flex items-center justify-center bg-white rounded-full p-1 drop-shadow-md">
                    <img src="<?= base_url('img/logo.jpeg') ?>" alt="Logo" class="w-full h-full object-cover rounded-full">
                </div>
                <h4 class="text-white font-black text-base uppercase tracking-widest">MI NURUL IKHLAS AL-AYUBI</h4>
            </div>
            <p class="text-emerald-300/80 text-sm max-w-xl leading-relaxed">
                Portal resmi Sistem Penerimaan Murid Baru online yang mudah, aman, dan terpercaya.
            </p>
        </div>

        <!-- Links Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div>
                <h5 class="text-white font-bold text-sm uppercase tracking-widest mb-4">Menu</h5>
                <ul class="space-y-2 text-sm font-medium">
                    <li><a href="#home" class="hover:text-white transition-colors">Beranda</a></li>
                    <li><a href="#informasi" class="hover:text-white transition-colors">Informasi</a></li>
                    <li><a href="#jadwal" class="hover:text-white transition-colors">Jadwal</a></li>
                    <li><a href="#kontak" class="hover:text-white transition-colors">Kontak</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-white font-bold text-sm uppercase tracking-widest mb-4">Akses Cepat</h5>
                <ul class="space-y-2 text-sm font-medium">
                    <li><a href="<?= base_url('auth/register') ?>" class="hover:text-white transition-colors">Daftar Akun</a></li>
                    <li><a href="<?= base_url('auth') ?>" class="hover:text-white transition-colors">Login</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Website Sekolah</a></li>
                    <li><a href="https://wa.me/6282225600522?text=Assalamualaikum%20saya%20mengalami%20kendala%20bisa%20bantu%20saya" target="_blank" class="hover:text-white transition-colors">Bantuan</a></li>
                </ul>
            </div>
        </div>

        <!-- Bottom Border & Copyright -->
        <div class="pt-6 border-t border-emerald-900/50 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="text-xs text-emerald-500/80">
                <p>&copy; 2026 MI NURUL IKHLAS AL-AYUBI.</p>
                <p class="mt-1">Semua hak dilindungi.</p>
            </div>
            
            <div class="flex items-center space-x-6">
                <!-- Social Media -->
                <div class="flex items-center space-x-3">
                    <a href="https://www.facebook.com/share/1DnrJpJjpE/" target="_blank" class="w-8 h-8 rounded-full bg-emerald-900 flex items-center justify-center text-emerald-500 hover:text-white hover:bg-emerald-700 transition-colors" title="Facebook"><i class="fab fa-facebook-f text-xs"></i></a>
                    <a href="https://www.youtube.com/@MISNURULIKHLASOFFICIAL" target="_blank" class="w-8 h-8 rounded-full bg-emerald-900 flex items-center justify-center text-emerald-500 hover:text-white hover:bg-emerald-700 transition-colors" title="YouTube"><i class="fab fa-youtube text-xs"></i></a>
                </div>
                <!-- Powered By -->
                <div class="text-xs text-emerald-500/80">
                    Powered by Antigravity
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Scroll to Top -->
<a href="#home" class="fixed bottom-6 right-6 w-12 h-12 bg-emerald-600 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-emerald-700 transition-colors z-40">
    <i class="fas fa-arrow-up"></i>
</a>

<!-- Scroll Spy -->
<script>
const navLinks = document.querySelectorAll('.nav-link');
const sections = ['home','profil','jadwal','informasi','kontak'];

function updateActiveNav() {
  let current = 'home';
  const offset = 120;
  
  for (const id of sections) {
    const el = document.getElementById(id);
    if (el && el.getBoundingClientRect().top <= offset) {
      current = id;
    }
  }

  navLinks.forEach(link => {
    const section = link.getAttribute('data-section');
    if (section === current) {
      link.className = 'nav-link text-sm font-bold text-emerald-700 nav-active pb-1 transition-colors';
    } else {
      link.className = 'nav-link text-sm font-bold text-slate-500 pb-1 transition-colors hover:text-emerald-700';
    }
  });
}

window.addEventListener('scroll', updateActiveNav, { passive: true });
updateActiveNav();
</script>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 100,
        easing: 'ease-out-cubic'
    });
</script>

</body>
</html>