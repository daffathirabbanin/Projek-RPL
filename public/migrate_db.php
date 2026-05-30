<?php
require_once '../app/config/config.php';
require_once '../app/Core/Database.php';

try {
    $db = new Database();
    $db->query("ALTER TABLE pendaftaran ADD COLUMN jadwal_tes DATE NULL DEFAULT NULL AFTER revisi_json");
    $db->execute();
    echo "Migration Success!";
} catch (Exception $e) {
    echo "Migration failed: " . $e->getMessage();
}
