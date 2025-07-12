<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['tipo'] !== 'admin') {
    die('Acesso negado.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $imagem = $_POST['imagem'];
    $tecnologia = $_POST['tecnologia'];
    $duracao = $_POST['duracao'];

    $stmt = mysqli_prepare($conn, "INSERT INTO projetos (titulo, descricao, imagem, tecnologia, duracao) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssss", $titulo, $descricao, $imagem, $tecnologia, $duracao);
    mysqli_stmt_execute($stmt);

    header("Location: projetos.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Projeto</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f2f4f8;
            display: flex;
            justify-content: center;
            padding: 40px;
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
            padding: 12px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
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
        <h2>Adicionar Projeto</h2>
        <form method="POST">
            <input type="text" name="titulo" placeholder="Título" required>
            <textarea name="descricao" placeholder="Descrição" rows="4" required></textarea>
            <input type="text" name="imagem" placeholder="Nome do ficheiro da imagem (ex: projeto1.png)" required>
            <input type="text" name="tecnologia" placeholder="Tecnologia usada (ex: HTML, CSS, PHP)">
            <input type="text" name="duracao" placeholder="Duração (ex: 2 semanas, 3 meses)">
            <button type="submit">Guardar Projeto</button>
        </form>

        <div class="links">
            <a href="projetos.php">← Voltar à Lista de Projetos</a>
            <a href="../index.php">← Voltar à Página Principal</a>
        </div>
    </div>
</body>
</html>
