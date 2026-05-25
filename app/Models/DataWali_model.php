<?php
class DataWali_model {
    private $db;
    public function __construct() { $this->db = new Database(); }

    public function getByUserId($uid) {
        $this->db->query('SELECT * FROM data_wali WHERE user_id = :uid');
        $this->db->bind('uid', $uid);
        return $this->db->single();
    }

    public function init($uid) {
        if (!$this->getByUserId($uid)) {
            $this->db->query('INSERT INTO data_wali (user_id) VALUES (:uid)');
            $this->db->bind('uid', $uid);
            $this->db->execute();
        }
    }

    public function save($data, $uid) {
        $fields = ['nama_wali','nik_wali','tahun_lahir_wali','pendidikan_wali','pekerjaan_wali','penghasilan_bulanan_wali','kebutuhan_khusus_wali'];
        $sets = implode(',', array_map(fn($f) => "$f = :$f", $fields));
        $this->db->query("UPDATE data_wali SET $sets WHERE user_id = :uid");
        foreach ($fields as $f) $this->db->bind($f, $data[$f] ?? null);
        $this->db->bind('uid', $uid);
        return $this->db->execute();
    }
}
