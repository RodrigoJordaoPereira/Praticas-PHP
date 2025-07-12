<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['tipo'] !== 'admin') {
    die('Acesso negado.');
}

if (!isset($_GET['id'])) {
    die('ID de utilizador não fornecido.');
}

$id = $_GET['id'];
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $apelido = $_POST['apelido'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $tipo = $_POST['tipo'];

    $stmt = mysqli_prepare($conn, "UPDATE utilizadores SET nome=?, apelido=?, email=?, telefone=?, tipo=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sssssi", $nome, $apelido, $email, $telefone, $tipo, $id);
    mysqli_stmt_execute($stmt);

    $mensagem = "✅ Dados atualizados com sucesso!";
}

$stmt = mysqli_prepare($conn, "SELECT * FROM utilizadores WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Utilizador</title>
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

        .mensagem {
            text-align: center;
            margin-top: 10px;
            padding: 10px;
            background-color: #e0ffe0;
            color: #2d6a2d;
            border: 1px solid #2d6a2d;
            border-radius: 6px;
            font-size: 14px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"],
        input[type="email"],
        select {
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
            background-color: #ffc107;
            color: black;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
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
        <h2>Editar Utilizador</h2>

        <?php if (!empty($mensagem)) : ?>
            <div class="mensagem"><?php echo $mensagem; ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="nome" value="<?php echo $user['nome']; ?>" required>
            <input type="text" name="apelido" value="<?php echo $user['apelido']; ?>" required>
            <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
            <input type="text" name="telefone" value="<?php echo $user['telefone']; ?>" required>
            <select name="tipo">
                <option value="cliente" <?php if ($user['tipo'] === 'cliente') echo 'selected'; ?>>Cliente</option>
                <option value="admin" <?php if ($user['tipo'] === 'admin') echo 'selected'; ?>>Administrador</option>
            </select>
            <button type="submit">Guardar Alterações</button>
        </form>

        <div class="links">
            <a href="utilizadores.php">← Voltar à Lista de Utilizadores</a>
            <a href="../index.php">← Voltar à Página Principal</a>
        </div>
    </div>
</body>
</html>
