<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['tipo'] !== 'admin') {
    die('Acesso negado.');
}

$result = mysqli_query($conn, "SELECT * FROM utilizadores");
$utilizadores = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Utilizadores</title>
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

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            padding: 12px;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .info {
            font-size: 16px;
            color: #444;
        }

        a.botao-editar {
            padding: 6px 12px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
        }

        a.botao-editar:hover {
            background-color: #0056b3;
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
    <div class="container">
        <h2>Lista de Utilizadores</h2>
        <ul>
            <?php foreach ($utilizadores as $u): ?>
                <li>
                    <span class="info">
                        <?php echo htmlspecialchars($u['nome'] . ' ' . $u['apelido']); ?>
                        (<?php echo htmlspecialchars($u['tipo']); ?>)
                    </span>
                    <a class="botao-editar" href="editar_utilizador.php?id=<?php echo $u['id']; ?>">Editar</a>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="voltar">
            <a href="../index.php">← Voltar à Página Principal</a>
        </div>
    </div>
</body>
</html>
