<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    die('Acesso negado.');
}

$user_id = $_SESSION['user_id'];
$mensagem = '';

// Lógica de atualização de consulta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nova_data'], $_POST['id'])) {
    $id = $_POST['id'];
    $nova_data = $_POST['nova_data'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM consultas WHERE id = ? AND utilizador_id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $consulta = mysqli_fetch_assoc($result);

    if ($consulta) {
        $data_atual = strtotime($consulta['data_consulta']);
        if ($data_atual - time() >= 72 * 3600) {
            $stmt = mysqli_prepare($conn, "UPDATE consultas SET data_consulta = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "si", $nova_data, $id);
            mysqli_stmt_execute($stmt);
            $mensagem = "✅ Consulta atualizada com sucesso!";
        } else {
            $mensagem = "❌ Não é possível alterar consultas com menos de 72 horas de antecedência.";
        }
    } else {
        $mensagem = "❌ Consulta não encontrada.";
    }
}

// Listagem de consultas
$stmt = mysqli_prepare($conn, "SELECT * FROM consultas WHERE utilizador_id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$consultas = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Minhas Consultas</title>
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
            max-width: 800px;
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
            padding: 15px;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
        }

        form {
            margin-top: 10px;
        }

        input[type="datetime-local"] {
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-right: 10px;
        }

        button {
            padding: 8px 16px;
            background-color: #17a2b8;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background-color: #138496;
        }

        .restrito {
            color: #888;
            font-size: 14px;
        }

        .mensagem {
            text-align: center;
            padding: 10px;
            background-color: #e0ffe0;
            color: #2d6a2d;
            border: 1px solid #2d6a2d;
            border-radius: 6px;
            margin-bottom: 20px;
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
    <div class="container">
        <h2>Consultas Futuras</h2>

        <?php if (!empty($mensagem)) : ?>
            <div class="mensagem"><?php echo $mensagem; ?></div>
        <?php endif; ?>

        <ul>
            <?php foreach ($consultas as $c):
                $data_consulta = strtotime($c['data_consulta']);
                $agora = time();
                $pode_editar = ($data_consulta - $agora) >= (72 * 3600);
            ?>
                <li>
                    <strong><?php echo $c['data_consulta']; ?></strong> - <?php echo $c['estado']; ?> <br>
                    <em><?php echo $c['observacoes']; ?></em><br>

                    <?php if ($pode_editar): ?>
                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $c['id']; ?>">
                            <input type="datetime-local" name="nova_data" required>
                            <button type="submit">Alterar</button>
                        </form>
                    <?php else: ?>
                        <span class="restrito">(não pode ser alterada - menos de 72h)</span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="voltar">
            <a href="../index.php">← Voltar à Página Principal</a>
        </div>
    </div>
</body>
</html>
