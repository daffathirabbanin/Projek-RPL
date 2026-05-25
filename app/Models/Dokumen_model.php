<?php
class Dokumen_model {
    private $db;
    public function __construct() { $this->db = new Database(); }

    public function getByUserId($uid) {
        $this->db->query('SELECT * FROM dokumen WHERE user_id = :uid');
        $this->db->bind('uid', $uid);
        return $this->db->single();
    }

    public function init($uid) {
        if (!$this->getByUserId($uid)) {
            $this->db->query('INSERT INTO dokumen (user_id) VALUES (:uid)');
            $this->db->bind('uid', $uid);
            $this->db->execute();
        }
    }

    public function saveField($field, $path, $uid) {
        $allowed = ['kk','akta','ijazah','foto_3x4'];
        if (!in_array($field, $allowed)) return false;
        $this->db->query("UPDATE dokumen SET $field = :path WHERE user_id = :uid");
        $this->db->bind('path', $path);
        $this->db->bind('uid', $uid);
        return $this->db->execute();
    }
}
