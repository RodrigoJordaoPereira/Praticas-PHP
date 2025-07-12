<?php
$host = 'localhost';
$user = 'root';
$password = ''; 
$db = 'projeto_final';
$port = 3306;

$conn = mysqli_connect($host, $user, $password, $db, $port);

if (!$conn) {
    die("Erro na ligação: " . mysqli_connect_error());
}
?>
