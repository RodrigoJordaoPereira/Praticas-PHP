<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['tipo'] !== 'admin') {
    die('Acesso negado.');
}

if (!isset($_GET['id'])) {
    die('ID não fornecido.');
}

$id = $_GET['id'];

$stmt = mysqli_prepare($conn, "DELETE FROM projetos WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

header("Location: projetos.php");
exit;
?>
