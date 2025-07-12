<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $resumo = $_POST['resumo'];
    $conteudo = $_POST['conteudo'];
    $imagem = $_POST['imagem'];
    $data = $_POST['data_publicacao'];

    $sql = "INSERT INTO noticias (titulo, resumo, conteudo, imagem, data_publicacao)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql); 

    mysqli_stmt_execute($stmt);

    echo json_encode(["status" => "ok"]);
}
?>