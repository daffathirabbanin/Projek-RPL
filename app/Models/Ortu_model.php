<?php
class Ortu_model {
    private $table = 'data_ortu';
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getOrtuByUserId($user_id) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE user_id = :user_id');
        $this->db->bind('user_id', $user_id);
        return $this->db->single();
    }

    public function createOrtu($user_id) {
        $this->db->query('INSERT INTO ' . $this->table . ' (user_id) VALUES (:user_id)');
        $this->db->bind('user_id', $user_id);
        $this->db->execute();
    }

    public function updateOrtu($data, $user_id) {
        $query = "UPDATE " . $this->table . " SET 
                  nama_ayah = :nama_ayah,
                  pekerjaan_ayah = :pekerjaan_ayah,
                  no_hp_ayah = :no_hp_ayah,
                  nama_ibu = :nama_ibu,
                  pekerjaan_ibu = :pekerjaan_ibu,
                  no_hp_ibu = :no_hp_ibu,
                  alamat_ortu = :alamat_ortu
                  WHERE user_id = :user_id";
        
        $this->db->query($query);
        $this->db->bind('nama_ayah', $data['nama_ayah'] ?? null);
        $this->db->bind('pekerjaan_ayah', $data['pekerjaan_ayah'] ?? null);
        $this->db->bind('no_hp_ayah', $data['no_hp_ayah'] ?? null);
        $this->db->bind('nama_ibu', $data['nama_ibu'] ?? null);
        $this->db->bind('pekerjaan_ibu', $data['pekerjaan_ibu'] ?? null);
        $this->db->bind('no_hp_ibu', $data['no_hp_ibu'] ?? null);
        $this->db->bind('alamat_ortu', $data['alamat_ortu'] ?? null);
        $this->db->bind('user_id', $user_id);

        return $this->db->execute();
    }
}
