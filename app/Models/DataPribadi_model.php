<?php
class DataPribadi_model {
    private $db;
    public function __construct() { $this->db = new Database(); }

    public function getByUserId($uid) {
        $this->db->query('SELECT * FROM data_pribadi WHERE user_id = :uid');
        $this->db->bind('uid', $uid);
        return $this->db->single();
    }

    public function init($uid) {
        if (!$this->getByUserId($uid)) {
            $this->db->query('INSERT INTO data_pribadi (user_id) VALUES (:uid)');
            $this->db->bind('uid', $uid);
            $this->db->execute();
        }
    }

    public function save($data, $uid) {
        $fields = ['nama_lengkap','jenis_kelamin','nisn','nik','no_kk','tempat_lahir','tanggal_lahir','kewarganegaraan','alamat_jalan','rt','rw','dusun','kelurahan','kecamatan','kode_pos','lintang','bujur','tempat_tinggal','moda_transportasi','anak_ke','pekerjaan','punya_kip','status_kip','alasan_tolak_pip'];
        $sets = implode(',', array_map(fn($f) => "$f = :$f", $fields));
        $this->db->query("UPDATE data_pribadi SET $sets WHERE user_id = :uid");
        foreach ($fields as $f) $this->db->bind($f, $data[$f] ?? null);
        $this->db->bind('uid', $uid);
        return $this->db->execute();
    }
}
