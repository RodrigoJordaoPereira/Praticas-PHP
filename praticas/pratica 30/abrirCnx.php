<?php  

// host, username, password, database
$conexao = mysqli_connect('localhost', 'root', 'root', 'escola');

if (!$conexao) {  
echo "<p style='color:red;'>Erro: Nao foi possivel conectar ao MySQL.</p>" . PHP_EOL;  
echo "<p>Erro: </p>" . mysqli_connect_errno() . "<br/><br/>" . PHP_EOL ;  
exit;  
}  

echo "<p style='color:green;'>A conexao foi feita com sucesso!</p>". PHP_EOL; 
echo "<p>Informacao da conexao: </p>" .  
mysqli_get_host_info($conexao) . "<br/><br/>" . PHP_EOL;  
?>