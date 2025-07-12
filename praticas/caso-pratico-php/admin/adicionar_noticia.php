<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['tipo'] !== 'admin') {
    die('Acesso negado.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $resumo = $_POST['resumo'];
    $conteudo = $_POST['conteudo'];
    $imagem = $_POST['imagem'];

    $stmt = mysqli_prepare($conn, "INSERT INTO noticias (titulo, resumo, conteudo, imagem) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $titulo, $resumo, $conteudo, $imagem);
    mysqli_stmt_execute($stmt);

    header("Location: noticias.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Notícia</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f2f4f8;
            margin: 0;
            padding: 40px;
            display: flex;
            justify-content: center;
        }

        .container {
            background: white;
            padding: 30px;
            max-width: 600px;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"],
        textarea {
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }

        button:hover {
            background-color: #0056b3;
        }

        .links {
            text-align: center;
            margin-top: 30px;
        }

        .links a {
            display: inline-block;
            margin: 5px 10px;
            padding: 10px 20px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
        }

        .links a:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Nova Notícia</h2>
        <form method="POST">
            <input type="text" name="titulo" placeholder="Título" required>
            <textarea name="resumo" placeholder="Resumo" required></textarea>
            <textarea name="conteudo" placeholder="Conteúdo completo" required></textarea>
            <input type="text" name="imagem" placeholder="Nome da imagem (opcional)">
            <button type="submit">Guardar Notícia</button>
        </form>

        <div class="links">
            <a href="noticias.php">← Voltar à Lista de Notícias</a>
            <a href="../index.php">← Voltar à Página Principal</a>
        </div>
    </div>
</body>
</html>
