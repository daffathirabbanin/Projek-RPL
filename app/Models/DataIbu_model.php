<?php
class DataIbu_model {
    private $db;
    public function __construct() { $this->db = new Database(); }

    public function getByUserId($uid) {
        $this->db->query('SELECT * FROM data_ibu WHERE user_id = :uid');
        $this->db->bind('uid', $uid);
        return $this->db->single();
    }

    public function init($uid) {
        if (!$this->getByUserId($uid)) {
            $this->db->query('INSERT INTO data_ibu (user_id) VALUES (:uid)');
            $this->db->bind('uid', $uid);
            $this->db->execute();
        }
    }

    public function save($data, $uid) {
        $fields = ['nama_ibu','nik_ibu','tahun_lahir_ibu','pendidikan_ibu','pekerjaan_ibu','penghasilan_bulanan_ibu','kebutuhan_khusus_ibu'];
        $sets = implode(',', array_map(fn($f) => "$f = :$f", $fields));
        $this->db->query("UPDATE data_ibu SET $sets WHERE user_id = :uid");
        foreach ($fields as $f) $this->db->bind($f, $data[$f] ?? null);
        $this->db->bind('uid', $uid);
        return $this->db->execute();
    }
}
