<h1>Hello Camagru!</h1>
<h4>Attempting MySQL connection from php...</h4>

<?php

// session_start();

$inipath = php_ini_loaded_file();

if ($inipath) {
    echo 'php.ini location: ' . $inipath . "<br>";
} else {
    echo 'Файл php.ini не загружен';
}

$host = $_SERVER['MYSQL_HOST'];
$dbname = $_SERVER['MYSQL_DATABASE'];

$dsn = 'mysql:dbname='.$dbname.';host='.$host;
$user = $_SERVER['MYSQL_ROOT_USER'];
$pass = $_SERVER['MYSQL_ROOT_PASSWORD'];

try {
	$pdo = new PDO($dsn, $user, $pass);
}
catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}
echo "<br>Connected to MySQL using PDO successfully!";
?>