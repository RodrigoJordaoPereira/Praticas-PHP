<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    die('Acesso negado.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nova_data = $_POST['nova_data'];
    $user_id = $_SESSION['user_id'];

    // Verificar se é do próprio utilizador e se faltam mais de 72 horas
    $stmt = mysqli_prepare($conn, "SELECT * FROM consultas WHERE id = ? AND utilizador_id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $consulta = mysqli_fetch_assoc($result);
    

    if (!$consulta) {
        die('Consulta não encontrada.');
    }

    $data_atual = strtotime($consulta['data_consulta']);
    if ($data_atual - time() < 72 * 3600) {
        die('Não é possível alterar consultas com menos de 72 horas de antecedência.');
    }

    $stmt = mysqli_prepare($conn, "UPDATE consultas SET data_consulta = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "si", $nova_data, $id);
    mysqli_stmt_execute($stmt);
    

    echo "Consulta atualizada com sucesso!";
}
?>
