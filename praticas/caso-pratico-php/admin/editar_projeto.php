<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['tipo'] !== 'admin') {
    die('Acesso negado.');
}

if (!isset($_GET['id'])) {
    die('Projeto não especificado.');
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $imagem = $_POST['imagem'];
    $tecnologia = $_POST['tecnologia'];
    $duracao = $_POST['duracao'];
    $inicio = $_POST['data_inicio'];
    $fim = $_POST['data_fim'];

    $stmt = mysqli_prepare($conn, "UPDATE projetos SET titulo=?, descricao=?, imagem=?, tecnologia=?, duracao=?, data_inicio=?, data_fim=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sssssssi", $titulo, $descricao, $imagem, $tecnologia, $duracao, $inicio, $fim, $id);
    mysqli_stmt_execute($stmt);

    echo "<script>alert('✅ Projeto atualizado com sucesso!'); window.location.href='projetos.php';</script>";
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT * FROM projetos WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$projeto = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Editar Projeto</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f2f2f2;
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
        input[type="date"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        button {
            margin-top: 20px;
            background: #ffc107;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
        }

        button:hover {
            background: #e0a800;
        }

        .links {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .links a {
            padding: 10px 20px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
        }

        .links a:hover {
            background-color: #5a6268;
        }

        @media (max-width: 600px) {
            .links {
                flex-direction: column;
                gap: 10px;
                align-items: center;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Editar Projeto</h2>

        <form method="POST">
            <input type="text" name="titulo" value="<?php echo $projeto['titulo']; ?>" placeholder="Título" required>
            <textarea name="descricao" rows="4" placeholder="Descrição"><?php echo $projeto['descricao']; ?></textarea>
            <input type="text" name="imagem" value="<?php echo $projeto['imagem']; ?>" placeholder="Nome do ficheiro da imagem">
            <input type="text" name="tecnologia" value="<?php echo $projeto['tecnologia']; ?>" placeholder="Tecnologia usada">
            <input type="text" name="duracao" value="<?php echo $projeto['duracao']; ?>" placeholder="Duração">
            <input type="date" name="data_inicio" value="<?php echo $projeto['data_inicio']; ?>">
            <input type="date" name="data_fim" value="<?php echo $projeto['data_fim']; ?>">
            <button type="submit">Guardar Alterações</button>
        </form>


        <div class="links">
            <a href="projetos.php">← Voltar à Lista de Projetos</a>
            <a href="../index.php">← Voltar à Página Principal</a>
        </div>
    </div>
</body>

</html>