<?php
session_start();
session_unset();   
session_destroy();  
session_start();    

require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome = $_POST['nome'];
  $apelido = $_POST['apelido'];
  $email = $_POST['email'];
  $telefone = $_POST['telefone'];
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $tipo = 'cliente';

  $check = mysqli_prepare($conn, "SELECT id FROM utilizadores WHERE username = ? OR email = ?");
  mysqli_stmt_bind_param($check, "ss", $username, $email);
  mysqli_stmt_execute($check);
  mysqli_stmt_store_result($check);
  
  if (mysqli_stmt_num_rows($check) > 0) {
      echo "<p class='erro'>❌ Já existe utilizador com este nome ou email.</p>";
      exit;
  }

  $stmt = mysqli_prepare($conn, 'INSERT INTO utilizadores (nome, apelido, email, telefone, username, password, tipo) VALUES (?, ?, ?, ?, ?, ?, ?)');
  if ($stmt) {
      mysqli_stmt_bind_param($stmt, 'sssssss', $nome, $apelido, $email, $telefone, $username, $password, $tipo);
      if (mysqli_stmt_execute($stmt)) {
          // Sessão para o novo utilizador
          $_SESSION['user_id'] = mysqli_insert_id($conn);
          $_SESSION['tipo'] = $tipo;
          header('Location: ../index.php');
          exit;
      } else {
          echo '<p class="erro">❌ Erro ao inserir dados: ' . mysqli_stmt_error($stmt) . '</p>';
      }
  } else {
      echo '<p class="erro">❌ Erro ao preparar statement: ' . mysqli_error($conn) . '</p>';
  }
}
?>


<style>
  body {
    font-family: 'Segoe UI', sans-serif;
    background: #f0f2f5;
    margin: 0;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .container {
    text-align: center;
  }

  h2 {
    color: #333;
    margin-bottom: 20px;
  }

  form {
    background: white;
    padding: 25px;
    max-width: 400px;
    margin: 0 auto;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    text-align: left;
  }

  label {
    font-weight: bold;
    margin-top: 10px;
    display: block;
    color: #555;
  }

  input[type="text"],
  input[type="email"],
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
    background: #28a745;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 15px;
  }

  button:hover {
    background: #218838;
  }

  .sucesso {
    color: green;
    margin-top: 15px;
  }

  .erro {
    color: red;
    margin-top: 15px;
  }
</style>

<div class="container">
  <h2>Registo de novo utilizador</h2>
  <form method="POST" action="register.php">
    <label>Nome:</label>
    <input type="text" name="nome" required>
    <label>Apelido:</label>
    <input type="text" name="apelido" required>
    <label>Email:</label>
    <input type="email" name="email" required>
    <label>Telefone:</label>
    <input type="text" name="telefone">
    <label>Username:</label>
    <input type="text" name="username" required>
    <label>Password:</label>
    <input type="password" name="password" required><br>
    <button type="submit">Registar</button>
  </form>
</div>
