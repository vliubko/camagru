<?php

require_once("config/config.php");
// session_start();

$inipath = php_ini_loaded_file();

echo "<h4>Debug info:</h4>";

if ($inipath) {
    echo '- php.ini location: ' . $inipath . "<br>";
} else {
    echo '- Файл php.ini не загружен';
}

echo "<br>- Connected to MySQL using PDO successfully!";
?>