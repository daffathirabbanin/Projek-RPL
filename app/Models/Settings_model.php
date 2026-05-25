<?php
class Settings_model {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getSetting($key) {
        $this->db->query('SELECT setting_value FROM settings WHERE setting_key = :key');
        $this->db->bind('key', $key);
        $result = $this->db->single();
        return $result ? $result['setting_value'] : null;
    }

    public function updateSetting($key, $value) {
        $this->db->query('INSERT INTO settings (setting_key, setting_value) VALUES (:key, :value) ON DUPLICATE KEY UPDATE setting_value = :value');
        $this->db->bind('key', $key);
        $this->db->bind('value', $value);
        return $this->db->execute();
    }
}
