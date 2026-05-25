<?php
class DataKontak_model {
    private $db;
    public function __construct() { $this->db = new Database(); }

    public function getByUserId($uid) {
        $this->db->query('SELECT * FROM data_kontak WHERE user_id = :uid');
        $this->db->bind('uid', $uid);
        return $this->db->single();
    }

    public function init($uid) {
        if (!$this->getByUserId($uid)) {
            $this->db->query('INSERT INTO data_kontak (user_id) VALUES (:uid)');
            $this->db->bind('uid', $uid);
            $this->db->execute();
        }
    }

    public function save($data, $uid) {
        $this->db->query('UPDATE data_kontak SET notlp_rumah=:notlp_rumah, no_hp=:no_hp, email=:email WHERE user_id=:uid');
        $this->db->bind('notlp_rumah', $data['notlp_rumah'] ?? null);
        $this->db->bind('no_hp', $data['no_hp'] ?? null);
        $this->db->bind('email', $data['email'] ?? null);
        $this->db->bind('uid', $uid);
        return $this->db->execute();
    }
}
