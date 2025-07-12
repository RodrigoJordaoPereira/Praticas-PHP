<?php  
    $email = htmlspecialchars($_POST["email"]); 
    $pwd = htmlspecialchars($_POST["pwd"]); 

    if ($email == "pratica@teste.com" && $pwd == "senha") { 
        // echo "<h2>Olá $email <br> Bem-vindo.</h2>"; 
        // Entrar no carrinho de compras 
        header("Location: catalogo.php"); 
        exit(); 
    } else { 
        // header("Location: pratica8.php?invalid=&email=$email"); 
        echo "<h2>Login inválido</h2>"; 
    } 
?>
