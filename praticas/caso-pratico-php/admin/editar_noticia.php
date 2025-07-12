<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['tipo'] !== 'admin') {
    die('Acesso negado.');
}

if (!isset($_GET['id'])) {
    die('ID da notícia não fornecido.');
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $resumo = $_POST['resumo'];
    $conteudo = $_POST['conteudo'];
    $imagem = $_POST['imagem'];

    $stmt = mysqli_prepare($conn, "UPDATE noticias SET titulo=?, resumo=?, conteudo=?, imagem=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssssi", $titulo, $resumo, $conteudo, $imagem, $id);
    mysqli_stmt_execute($stmt);

    echo "<script>alert('✅ Notícia atualizada com sucesso!'); window.location.href='noticias.php';</script>";
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT * FROM noticias WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$noticia = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Notícia</title>
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
            max-width: 700px;
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
            padding: 12px 20px;
            background-color: #ffc107;
            color: black;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background-color: #e0a800;
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
        <h2>Editar Notícia</h2>

        <form method="POST">
            <input type="text" name="titulo" value="<?php echo $noticia['titulo']; ?>" placeholder="Título" required>
            <textarea name="resumo" rows="3" placeholder="Resumo"><?php echo $noticia['resumo']; ?></textarea>
            <textarea name="conteudo" rows="6" placeholder="Conteúdo"><?php echo $noticia['conteudo']; ?></textarea>
            <input type="text" name="imagem" value="<?php echo $noticia['imagem']; ?>" placeholder="Nome do ficheiro da imagem">
            <button type="submit">Guardar Alterações</button>
        </form>

        <div class="links">
            <a href="noticias.php">← Voltar à Lista de Notícias</a>
            <a href="../index.php">← Voltar à Página Principal</a>
        </div>
    </div>
</body>
</html>
