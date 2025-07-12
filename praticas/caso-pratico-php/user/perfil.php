<?php 
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = mysqli_prepare($conn, "SELECT * FROM utilizadores WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST['data_consulta'];
    $obs = $_POST['observacoes'];

    $stmt = mysqli_prepare($conn, "INSERT INTO consultas (utilizador_id, data_consulta, observacoes) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iss", $user_id, $data, $obs);

    if (mysqli_stmt_execute($stmt)) {
        $mensagem = "✅ Consulta marcada com sucesso!";
    } else {
        $mensagem = "❌ Erro ao marcar consulta: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Perfil do Utilizador</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 40px;
            display: flex;
            justify-content: center;
        }

        .perfil-container {
            background: white;
            padding: 30px;
            max-width: 600px;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2, h3 {
            color: #333;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            color: #555;
        }

        strong {
            color: #000;
        }

        form {
            margin-top: 30px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
            color: #444;
        }

        input[type="datetime-local"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 14px;
        }

        button {
            margin-top: 20px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
        }

        button:hover {
            background: #0056b3;
        }

        .mensagem {
            margin-top: 15px;
            padding: 10px;
            background-color: #e0ffe0;
            color: #2d6a2d;
            border: 1px solid #2d6a2d;
            border-radius: 6px;
            font-size: 14px;
        }

        .erro {
            background-color: #ffe0e0;
            color: #b32d2d;
            border-color: #b32d2d;
        }

        .voltar {
            text-align: center;
            margin-top: 30px;
        }

        .voltar a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 15px;
        }

        .voltar a:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="perfil-container">
        <h2>Bem-vindo, <?php echo htmlspecialchars($user['nome']); ?>!</h2>

        <h3>Os seus dados:</h3>
        <p><strong>Nome:</strong> <?php echo $user['nome'] . ' ' . $user['apelido']; ?></p>
        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        <p><strong>Telefone:</strong> <?php echo $user['telefone']; ?></p>

        <h3>Marcar Consulta:</h3>

        <?php if (!empty($mensagem)) : ?>
            <div class="mensagem"><?php echo $mensagem; ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>Data da Consulta:</label>
            <input type="datetime-local" name="data_consulta" required>

            <label>Observações:</label>
            <textarea name="observacoes" rows="4" required></textarea>

            <button type="submit">Marcar</button>
        </form>

        <div class="voltar">
            <a href="../index.php">← Voltar à Página Principal</a>
        </div>
    </div>
</body>
</html>
