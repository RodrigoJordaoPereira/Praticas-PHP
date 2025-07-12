<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['tipo'] !== 'admin') {
    die('Acesso negado.');
}

$result = mysqli_query($conn, "SELECT * FROM projetos");
$projetos = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Projetos</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9fafc;
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

        a.botao-adicionar {
            display: inline-block;
            margin-bottom: 20px;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            padding: 10px;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
        }

        li strong {
            display: block;
            font-size: 18px;
            color: #222;
        }

        li span {
            color: #555;
            font-size: 14px;
        }

        .acoes {
            margin-top: 10px;
        }

        .acoes a {
            margin-right: 10px;
            text-decoration: none;
            font-weight: bold;
        }

        .editar {
            color: green;
        }

        .eliminar {
            color: red;
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
        <h2>Gestão de Projetos</h2>
        <a class="botao-adicionar" href="adicionar_projeto.php">+ Adicionar Projeto</a>

        <ul>
            <?php foreach ($projetos as $p): ?>
                <li>
                    <strong><?php echo htmlspecialchars($p['titulo']); ?></strong>
                    <span><?php echo htmlspecialchars($p['tecnologia']); ?></span>

                    <div class="acoes">
                        <a class="editar" href="editar_projeto.php?id=<?php echo $p['id']; ?>">✏️ Editar</a>
                        <a class="eliminar" href="eliminar_projeto.php?id=<?php echo $p['id']; ?>" onclick="return confirm('Tem certeza que deseja eliminar este projeto?');">🗑️ Eliminar</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="voltar">
            <a href="../index.php">← Voltar à Página Principal</a>
        </div>
    </div>
</body>
</html>
