<?php
class DataPeriodik_model {
    private $db;
    public function __construct() { $this->db = new Database(); }

    public function getByUserId($uid) {
        $this->db->query('SELECT * FROM data_periodik WHERE user_id = :uid');
        $this->db->bind('uid', $uid);
        return $this->db->single();
    }

    public function init($uid) {
        if (!$this->getByUserId($uid)) {
            $this->db->query('INSERT INTO data_periodik (user_id) VALUES (:uid)');
            $this->db->bind('uid', $uid);
            $this->db->execute();
        }
    }

    public function save($data, $uid) {
        $fields = ['tinggi_badan','berat_badan','lingkar_kepala','jarak_tempat_tinggal','jarak_km','waktu_jam','waktu_menit','jumlah_saudara_kandung','asal_sekolah','jenis_sekolah_asal'];
        $sets = implode(',', array_map(fn($f) => "$f = :$f", $fields));
        $this->db->query("UPDATE data_periodik SET $sets WHERE user_id = :uid");
        foreach ($fields as $f) $this->db->bind($f, $data[$f] ?? null);
        $this->db->bind('uid', $uid);
        return $this->db->execute();
    }
}
