<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $imagem = $_POST['imagem'];
    $tecnologia = $_POST['tecnologia'];
    $duracao = $_POST['duracao'];
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];
    
    $stmt = mysqli_prepare($conn, "INSERT INTO projetos (titulo, descricao, imagem, tecnologia, duracao, data_inicio, data_fim) VALUES (?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssssss", $titulo, $descricao, $imagem, $tecnologia, $duracao, $data_inicio, $data_fim);
    mysqli_stmt_execute($stmt);
    

    echo json_encode(["status" => "ok"]);
}
?>