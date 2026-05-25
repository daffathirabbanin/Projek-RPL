<?php
class Pendaftar_model {
    private $table = 'pendaftaran';
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getPendaftarByUserId($user_id) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE user_id = :user_id');
        $this->db->bind('user_id', $user_id);
        return $this->db->single();
    }

    public function createPendaftar($user_id) {
        $this->db->query('INSERT INTO ' . $this->table . ' (user_id) VALUES (:user_id)');
        $this->db->bind('user_id', $user_id);
        $this->db->execute();
    }

    public function updatePendaftar($data, $user_id) {
        // Auto-save logic
        $query = "UPDATE " . $this->table . " SET 
                  nik = :nik,
                  nisn = :nisn,
                  jk = :jk,
                  tempat_lahir = :tempat_lahir,
                  tgl_lahir = :tgl_lahir,
                  agama = :agama,
                  alamat = :alamat,
                  asal_sekolah = :asal_sekolah,
                  jurusan = :jurusan
                  WHERE user_id = :user_id";
        
        $this->db->query($query);
        $this->db->bind('nik', $data['nik'] ?? null);
        $this->db->bind('nisn', $data['nisn'] ?? null);
        $this->db->bind('jk', $data['jk'] ?? null);
        $this->db->bind('tempat_lahir', $data['tempat_lahir'] ?? null);
        $this->db->bind('tgl_lahir', $data['tgl_lahir'] ?? null);
        $this->db->bind('agama', $data['agama'] ?? null);
        $this->db->bind('alamat', $data['alamat'] ?? null);
        $this->db->bind('asal_sekolah', $data['asal_sekolah'] ?? null);
        $this->db->bind('jurusan', $data['jurusan'] ?? null);
        $this->db->bind('user_id', $user_id);

        return $this->db->execute();
    }
    
    public function submitPendaftaran($user_id) {
        $this->db->query("UPDATE " . $this->table . " SET status_pendaftaran = 'submitted' WHERE user_id = :user_id");
        $this->db->bind('user_id', $user_id);
        return $this->db->execute();
    }
}
