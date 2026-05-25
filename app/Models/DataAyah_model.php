<?php
class DataAyah_model {
    private $db;
    public function __construct() { $this->db = new Database(); }

    public function getByUserId($uid) {
        $this->db->query('SELECT * FROM data_ayah WHERE user_id = :uid');
        $this->db->bind('uid', $uid);
        return $this->db->single();
    }

    public function init($uid) {
        if (!$this->getByUserId($uid)) {
            $this->db->query('INSERT INTO data_ayah (user_id) VALUES (:uid)');
            $this->db->bind('uid', $uid);
            $this->db->execute();
        }
    }

    public function save($data, $uid) {
        $fields = ['nama_ayah','nik_ayah','tahun_lahir_ayah','pendidikan_ayah','pekerjaan_ayah','penghasilan_bulanan_ayah','kebutuhan_khusus_ayah'];
        $sets = implode(',', array_map(fn($f) => "$f = :$f", $fields));
        $this->db->query("UPDATE data_ayah SET $sets WHERE user_id = :uid");
        foreach ($fields as $f) $this->db->bind($f, $data[$f] ?? null);
        $this->db->bind('uid', $uid);
        return $this->db->execute();
    }
}
