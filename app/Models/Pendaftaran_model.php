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
}
