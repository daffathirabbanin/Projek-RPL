DROP DATABASE IF EXISTS ppdb_web;
CREATE DATABASE ppdb_web CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ppdb_web;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE data_pribadi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    nama_lengkap VARCHAR(150),
    jenis_kelamin ENUM('L','P'),
    nisn VARCHAR(20),
    nik VARCHAR(20),
    no_kk VARCHAR(20),
    tempat_lahir VARCHAR(100),
    tanggal_lahir DATE,
    kewarganegaraan VARCHAR(30) DEFAULT 'WNI',
    alamat_jalan TEXT,
    rt VARCHAR(5),
    rw VARCHAR(5),
    dusun VARCHAR(100),
    kelurahan VARCHAR(100),
    kecamatan VARCHAR(100),
    kode_pos VARCHAR(10),
    lintang VARCHAR(50),
    bujur VARCHAR(50),
    tempat_tinggal VARCHAR(50),
    moda_transportasi VARCHAR(50),
    anak_ke INT,
    pekerjaan VARCHAR(100),
    punya_kip ENUM('ya','tidak') DEFAULT 'tidak',
    status_kip VARCHAR(50),
    alasan_tolak_pip TEXT,
    status_daftar ENUM('menunggu','diterima','ditolak') DEFAULT 'menunggu',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE data_ayah (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    nama_ayah VARCHAR(150),
    nik_ayah VARCHAR(20),
    tahun_lahir_ayah YEAR,
    pendidikan_ayah VARCHAR(50),
    pekerjaan_ayah VARCHAR(100),
    penghasilan_bulanan_ayah VARCHAR(50),
    kebutuhan_khusus_ayah VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE data_ibu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    nama_ibu VARCHAR(150),
    nik_ibu VARCHAR(20),
    tahun_lahir_ibu YEAR,
    pendidikan_ibu VARCHAR(50),
    pekerjaan_ibu VARCHAR(100),
    penghasilan_bulanan_ibu VARCHAR(50),
    kebutuhan_khusus_ibu VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE data_wali (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    nama_wali VARCHAR(150),
    nik_wali VARCHAR(20),
    tahun_lahir_wali YEAR,
    pendidikan_wali VARCHAR(50),
    pekerjaan_wali VARCHAR(100),
    penghasilan_bulanan_wali VARCHAR(50),
    kebutuhan_khusus_wali VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE data_kontak (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    notlp_rumah VARCHAR(20),
    no_hp VARCHAR(20),
    email VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE data_periodik (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    tinggi_badan DECIMAL(5,2),
    berat_badan DECIMAL(5,2),
    lingkar_kepala DECIMAL(5,2),
    jarak_tempat_tinggal ENUM('kurang_dari_1_km','lebih_dari_1_km'),
    jarak_km DECIMAL(6,2),
    waktu_jam INT DEFAULT 0,
    waktu_menit INT DEFAULT 0,
    jumlah_saudara_kandung INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE dokumen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    kk VARCHAR(255),
    akta VARCHAR(255),
    ijazah VARCHAR(255),
    foto_3x4 VARCHAR(255),
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE pendaftaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    status ENUM('belum_mendaftar','nunggu_verifikasi','diterima','ditolak') DEFAULT 'belum_mendaftar',
    catatan TEXT,
    verified_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
