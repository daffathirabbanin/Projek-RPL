<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Password Baru | MI Nurul Ikhlas Al-Ayubi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 h-screen flex overflow-hidden">

    <!-- Left Screen (Image / Graphic) -->
    <div class="hidden lg:flex w-1/2 relative items-end justify-start overflow-hidden p-12">
        <img src="<?= base_url('img/sekolah.jpg') ?>" alt="Sekolah MIS Nurul Ikhlas" class="absolute inset-0 w-full h-full object-cover" onerror="this.outerHTML='<div class=\'absolute inset-0 w-full h-full bg-slate-200\'></div>'">
        
        <div class="absolute inset-0 bg-gradient-to-t from-emerald-950 via-emerald-900/80 to-emerald-900/20 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-emerald-950 via-emerald-900/50 to-transparent"></div>
        
        <div class="relative z-10 flex flex-col items-start text-left w-full mb-8">
            <div class="w-24 h-24 flex items-center justify-center mb-6 relative z-10 group-hover:scale-110 transition-transform duration-500 bg-white rounded-full p-1.5 shadow-xl border border-white/20">
                <img src="<?= base_url('img/logo.jpeg') ?>" alt="Logo" class="w-full h-full object-cover rounded-full">
            </div>
            <h1 class="text-4xl lg:text-5xl font-black text-white mb-4 uppercase tracking-tight leading-tight drop-shadow-md">
                Password <br> <span class="text-emerald-400">Baru</span>
            </h1>
            <p class="text-emerald-50 text-lg max-w-md font-medium leading-relaxed drop-shadow-sm">
                Silakan buat password baru Anda untuk akun <br><strong><?= $_SESSION['reset_email'] ?? '' ?></strong>.
            </p>
            
            <div class="mt-10 inline-flex items-center space-x-3 px-5 py-2.5 bg-white/10 backdrop-blur-md border border-white/20 rounded-full shadow-lg">
                <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                <span class="text-white text-[11px] font-bold tracking-[0.2em] uppercase drop-shadow-sm">
                    Tahun Ajaran 2026/2027
                </span>
            </div>
        </div>
    </div>

    <!-- Right Screen (Form) -->
    <div class="w-full lg:w-1/2 flex flex-col items-center justify-center p-6 sm:p-8 lg:p-12 relative h-full bg-white overflow-y-auto">
        <div class="w-full max-w-[420px] py-8 lg:py-0">
            <!-- Back Button -->
            <a href="<?= base_url('auth/login') ?>" class="inline-flex items-center space-x-2 text-slate-400 hover:text-emerald-600 transition-all font-bold text-xs uppercase tracking-[0.1em] group mb-8">
                <div class="w-8 h-8 rounded-full bg-slate-100 group-hover:bg-emerald-50 flex items-center justify-center transition-colors">
                    <i class="fas fa-times group-hover:scale-110 transition-transform text-sm"></i>
                </div>
                <span>Batalkan</span>
            </a>

            <div class="text-center lg:text-left mb-6">
                <div class="w-16 h-16 flex items-center justify-center mb-4 lg:hidden mx-auto bg-white rounded-full p-1 shadow-md border border-slate-100">
                    <img src="<?= base_url('img/logo.jpeg') ?>" alt="Logo" class="w-full h-full object-cover rounded-full">
                </div>
                <h2 class="text-3xl font-black text-slate-800 uppercase tracking-tight mb-2">Buat Password Baru</h2>
                <p class="text-slate-500 font-medium text-sm">Verifikasi berhasil! Silakan buat password baru Anda di bawah ini.</p>
            </div>

            <!-- Pesan Notifikasi -->
            <?php if(isset($_GET['error'])): ?>
                <div class="bg-red-50 text-red-600 p-4 rounded-lg text-sm font-bold mb-6 border border-red-200 flex items-center shadow-sm">
                    <i class="fas fa-exclamation-circle mr-3 text-lg"></i>
                    <?php 
                        if($_GET['error'] == 'password_mismatch') echo "Password dan konfirmasi tidak cocok!";
                    ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/reset_password_process') ?>" method="POST" class="space-y-4">
                <!-- Password Baru -->
                <div>
                    <label for="password" class="block text-[10px] font-bold text-slate-500 uppercase tracking-[0.15em] mb-1.5">Password Baru</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none transition-colors group-focus-within:text-emerald-600 text-slate-400">
                            <i class="fas fa-lock text-sm"></i>
                        </div>
                        <input type="password" id="password" name="password" class="block w-full pl-10 pr-12 py-3 border-2 border-slate-200/80 rounded-lg text-sm text-slate-800 placeholder-slate-400 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-0 focus:border-emerald-500 transition-all shadow-sm" placeholder="Buat Password Baru" required minlength="6">
                    </div>
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="confirm_password" class="block text-[10px] font-bold text-slate-500 uppercase tracking-[0.15em] mb-1.5">Konfirmasi Password Baru</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none transition-colors group-focus-within:text-emerald-600 text-slate-400">
                            <i class="fas fa-check-circle text-sm"></i>
                        </div>
                        <input type="password" id="confirm_password" name="confirm_password" class="block w-full pl-10 pr-12 py-3 border-2 border-slate-200/80 rounded-lg text-sm text-slate-800 placeholder-slate-400 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-0 focus:border-emerald-500 transition-all shadow-sm" placeholder="Ulangi Password Baru" required minlength="6">
                    </div>
                </div>

                <button type="submit" class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-lg shadow-lg shadow-emerald-600/20 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 hover:shadow-emerald-600/30 transition-all active:scale-[0.98] uppercase tracking-[0.15em] mt-6 group">
                    <span>Simpan Password Baru</span>
                    <i class="fas fa-save ml-3 group-hover:scale-110 transition-transform"></i>
                </button>
            </form>
        </div>
    </div>
</body>
</html>
