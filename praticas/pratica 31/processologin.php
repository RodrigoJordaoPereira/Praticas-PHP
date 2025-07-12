<html>

<head>
    <meta charset="UTF-8">
    <title>Login - Prática 31</title>
    <link href="estilos.css" rel="stylesheet">
</head>

<body>

    <div class="caixa0">
        <span id="logo"><img src="logo.png"></span>
    </div>
    <div class="caixa1">
        <h2>LOGIN COM SUCESSO</h2>

        <?php
        $email = htmlspecialchars($_POST["email"]);
        $pwd = htmlspecialchars($_POST["pwd"]);
        $emailLogin = "pratica11@teste.com";
        $senha = "senha";
        $senhaLogin = password_hash($senha, PASSWORD_DEFAULT);
        if (password_verify($pwd, $senhaLogin)) {
            $login = true;
        }
        if ($email == $emailLogin && $login == true) {
            echo "<h2>Olá $email <br> Bemvindo.</h2>";
        } else {
            Header("Location:login.php?invalid=&email=$email");
        }


        ?>

    </div>
</body>

</html>