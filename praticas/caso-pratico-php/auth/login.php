<?php
session_start();
require_once '../includes/db.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  $stmt = mysqli_prepare($conn, "SELECT * FROM utilizadores WHERE username = ?");
  mysqli_stmt_bind_param($stmt, "s", $username);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $user = mysqli_fetch_assoc($result);

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['tipo'] = $user['tipo'];
    header('Location: ../index.php');
    exit;
  } else {
    $erro = "Credenciais inválidas!";
  }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f2f4f8;
      padding: 40px;
    }

    form {
      background: #fff;
      padding: 30px;
      max-width: 350px;
      margin: auto;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #333;
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
      color: #555;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 6px;
      box-sizing: border-box;
    }

    button {
      margin-top: 20px;
      width: 100%;
      padding: 10px;
      background: #0066cc;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
    }

    button:hover {
      background: #004da1;
    }

    .erro {
      text-align: center;
      color: red;
      margin-top: 10px;
    }

    .link-registo {
      text-align: center;
      margin-top: 15px;
    }
  </style>
</head>
<body>
  <h2>Login</h2>

  <?php if (!empty($erro)) echo "<p class='erro'>$erro</p>"; ?>

  <form method="POST" action="login.php">
    <label>Username:</label>
    <input type="text" name="username" required>
    <label>Password:</label>
    <input type="password" name="password" required>
    <button type="submit">Entrar</button>
  </form>

  <div class="link-registo">
    <a href="register.php">Registar</a>
  </div>
</body>
</html>
