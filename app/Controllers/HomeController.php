<?php

class HomeController extends Controller {
    public function index() {
        $settings = $this->model('Settings_model');
        $data['kuota']           = $settings->getSetting('kuota_pendaftaran') ?? 100;
        $data['gelombang_aktif'] = $settings->getSetting('gelombang_aktif') ?? 1;
        
        $data['stats_siswa']      = $settings->getSetting('stats_siswa')      ?? '250+';
        $data['stats_guru']       = $settings->getSetting('stats_guru')       ?? '15+';
        $data['stats_eskul']      = $settings->getSetting('stats_eskul')      ?? '8+';
        $data['stats_akreditasi'] = $settings->getSetting('stats_akreditasi') ?? 'BAIK';
        
        $db = new Database();
        $db->query("SELECT COUNT(*) as total FROM pendaftaran WHERE status != 'belum_mendaftar'");
        $data['total_pendaftar'] = $db->single()['total'];
        
        // Load jadwal from settings
        $data['jadwal'] = [];
        for ($g = 1; $g <= 3; $g++) {
            $data['jadwal'][] = [
                'gel'    => $settings->getSetting("jadwal_g{$g}_nama")   ?? "Gelombang $g",
                'daftar' => $settings->getSetting("jadwal_g{$g}_daftar") ?? '-',
                'sosial' => $settings->getSetting("jadwal_g{$g}_sosial") ?? '-',
                'hasil'  => $settings->getSetting("jadwal_g{$g}_hasil")  ?? '-',
            ];
        }
        
        $this->view('home/index', $data);
    }

    public function panduan() {
        $settings = $this->model('Settings_model');
        $data['gelombang_aktif'] = $settings->getSetting('gelombang_aktif') ?? 1;
        
        // Load jadwal from settings
        $data['jadwal'] = [];
        for ($g = 1; $g <= 3; $g++) {
            $data['jadwal'][] = [
                'gel'    => $settings->getSetting("jadwal_g{$g}_nama")   ?? "Gelombang $g",
                'daftar' => $settings->getSetting("jadwal_g{$g}_daftar") ?? '-',
                'sosial' => $settings->getSetting("jadwal_g{$g}_sosial") ?? '-',
                'hasil'  => $settings->getSetting("jadwal_g{$g}_hasil")  ?? '-',
            ];
        }
        
        $this->view('home/panduan', $data);
    }
}