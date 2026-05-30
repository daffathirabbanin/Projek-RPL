<?php
class Pendaftaran_model {
    private $db;
    public function __construct() { $this->db = new Database(); }

    public function getByUserId($uid) {
        $this->db->query('SELECT * FROM pendaftaran WHERE user_id = :uid');
        $this->db->bind('uid', $uid);
        return $this->db->single();
    }

    public function init($uid) {
        if (!$this->getByUserId($uid)) {
            $this->db->query("INSERT INTO pendaftaran (user_id, status) VALUES (:uid, 'belum_mendaftar')");
            $this->db->bind('uid', $uid);
            $this->db->execute();
        }
    }

    public function submit($uid) {
        $this->db->query("UPDATE pendaftaran SET status = 'nunggu_verifikasi' WHERE user_id = :uid");
        $this->db->bind('uid', $uid);
        return $this->db->execute();
    }

    public function resubmit($uid) {
        $this->db->query("UPDATE pendaftaran SET status = 'nunggu_verifikasi', revisi_json = NULL WHERE user_id = :uid");
        $this->db->bind('uid', $uid);
        return $this->db->execute();
    }

    public function updateStatus($status, $catatan, $pendaftaran_id, $revisi_json = null) {
        $this->db->query("UPDATE pendaftaran SET status = :status, catatan = :catatan, revisi_json = :revisi_json, verified_at = NOW() WHERE id = :id");
        $this->db->bind('status', $status);
        $this->db->bind('catatan', $catatan);
        $this->db->bind('revisi_json', $revisi_json);
        $this->db->bind('id', $pendaftaran_id);
        return $this->db->execute();
    }

    public function getAllWithUser() {
        $this->db->query("SELECT p.*, u.name, u.email FROM pendaftaran p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC");
        return $this->db->resultSet();
    }

    public function getJadwalTes($tanggal = null) {
        $sql = "SELECT p.*, dp.nama_lengkap as nama, dk.no_hp, u.email 
                FROM pendaftaran p 
                JOIN users u ON p.user_id = u.id 
                LEFT JOIN data_pribadi dp ON p.user_id = dp.user_id
                LEFT JOIN data_kontak dk ON p.user_id = dk.user_id
                WHERE (p.jadwal_tes IS NOT NULL OR p.status = 'dokumen_diterima')";
        
        if ($tanggal) {
            $sql .= " AND p.jadwal_tes = :tanggal";
        }
        
        $sql .= " ORDER BY p.jadwal_tes IS NULL DESC, p.jadwal_tes ASC, p.created_at ASC";
        
        $this->db->query($sql);
        
        if ($tanggal) {
            $this->db->bind('tanggal', $tanggal);
        }
        
        return $this->db->resultSet();
    }

    public function updateAbsensiTes($id, $status) {
        $this->db->query("UPDATE pendaftaran SET absensi_tes = :status WHERE id = :id");
        $this->db->bind('status', $status);
        $this->db->bind('id', $id);
        return $this->db->execute();
    }
    
    public function updateJadwalTesDate($id, $tanggal) {
        $this->db->query("UPDATE pendaftaran SET jadwal_tes = :tanggal WHERE id = :id");
        $this->db->bind('tanggal', $tanggal);
        $this->db->bind('id', $id);
        return $this->db->execute();
    }

    public function assignJadwalTes($id, $start_date, $end_date, $quota) {
        if (empty($start_date) || empty($end_date) || empty($quota)) return false;

        $this->db->query("SELECT jadwal_tes FROM pendaftaran WHERE id = :id");
        $this->db->bind('id', $id);
        $current = $this->db->single();
        if ($current && !empty($current['jadwal_tes'])) {
            return true; // Already assigned
        }

        // Find assigned counts per day
        $this->db->query("SELECT jadwal_tes, COUNT(*) as total FROM pendaftaran WHERE jadwal_tes >= :sd AND jadwal_tes <= :ed GROUP BY jadwal_tes");
        $this->db->bind('sd', $start_date);
        $this->db->bind('ed', $end_date);
        $counts = $this->db->resultSet();
        
        $assigned_counts = [];
        foreach ($counts as $row) {
            if ($row['jadwal_tes']) {
                $assigned_counts[$row['jadwal_tes']] = $row['total'];
            }
        }

        $assigned_date = $end_date; // Fallback to end date if all full
        
        // Loop through dates
        $start = new DateTime($start_date);
        $end = new DateTime($end_date);
        $interval = new DateInterval('P1D');
        $period = new DatePeriod($start, $interval, $end->modify('+1 day')); // Inclusive end
        
        foreach ($period as $date) {
            $d = $date->format('Y-m-d');
            $c = $assigned_counts[$d] ?? 0;
            if ($c < $quota) {
                $assigned_date = $d;
                break;
            }
        }

        $this->db->query("UPDATE pendaftaran SET jadwal_tes = :jadwal WHERE id = :id");
        $this->db->bind('jadwal', $assigned_date);
        $this->db->bind('id', $id);
        return $this->db->execute();
    }
}
