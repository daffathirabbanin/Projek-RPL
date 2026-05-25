<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($data['title']) ? $data['title'] : 'PPDB MI Nurul Ikhlas Al-Ayubi' ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/style.css">
</head>
<body class="bg-light">
    
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white border-end" id="sidebar-wrapper" style="width: 250px; min-height: 100vh;">
            <div class="sidebar-heading text-center py-4 border-bottom">
                <i class="fa-solid fa-mosque fs-2 text-success mb-2"></i>
                <h5 class="fw-bold text-success m-0">PPDB MIS</h5>
                <small class="text-muted">Nurul Ikhlas Al-Ayubi</small>
            </div>
            <div class="list-group list-group-flush my-3">
                <a href="<?= BASEURL; ?>/dashboard" class="list-group-item list-group-item-action bg-transparent border-0 active fw-semibold text-success">
                    <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
                </a>
                <a href="<?= BASEURL; ?>/dashboard/registration" class="list-group-item list-group-item-action bg-transparent border-0 fw-medium">
                    <i class="fa-solid fa-file-signature me-2"></i> Form Pendaftaran
                </a>
                <a href="<?= BASEURL; ?>/dashboard/status" class="list-group-item list-group-item-action bg-transparent border-0 fw-medium">
                    <i class="fa-solid fa-clipboard-check me-2"></i> Status Seleksi
                </a>
                <a href="<?= BASEURL; ?>/auth/logout" class="list-group-item list-group-item-action bg-transparent border-0 text-danger mt-5 fw-medium">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                </a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper" class="w-100">
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom py-3 px-4">
                <div class="d-flex align-items-center">
                    <h4 class="m-0 fw-bold">Dashboard Siswa</h4>
                </div>
                
                <div class="ms-auto d-flex align-items-center">
                    <span class="fw-medium me-3">Ahmad Siswa</span>
                    <img src="https://ui-avatars.com/api/?name=Ahmad+Siswa&background=198754&color=fff" alt="Avatar" class="rounded-circle" width="40" height="40">
                </div>
            </nav>

            <div class="container-fluid px-4 py-4">
