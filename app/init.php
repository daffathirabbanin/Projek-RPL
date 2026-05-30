<?php
date_default_timezone_set('Asia/Jakarta');

require_once 'Core/App.php';
require_once 'Core/Controller.php';
require_once 'Core/Database.php';
require_once 'Config/config.php';

if (!function_exists('base_url')) {
    function base_url($url = '') {
        return BASEURL . '/' . ltrim($url, '/');
    }
}
