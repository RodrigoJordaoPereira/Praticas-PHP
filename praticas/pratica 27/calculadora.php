<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Calculadora HTML e PHP</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <div class="caixa1">
        <h2>CALCULADORA EM HTML E PHP</h2>
        <br>
        <form method="post">
            <p><u>Primeiro número:</u></p> <input type="number" step="any" name="num1" required> <br>
            <p><u>Segundo número:</u></p> <input type="number" step="any" name="num2" required> <br><br>
            <input type="submit" class="botao" value="+" name="opcao">
            <input type="submit" class="botao" value="-" name="opcao">
            <input type="submit" class="botao" value="*" name="opcao">
            <input type="submit" class="botao" value="/" name="opcao"> 
        </form>

        <?php
        if (isset($_POST['opcao']) && isset($_POST['num1']) && isset($_POST['num2'])) {
            $op = $_POST['opcao'];
            $num1 = $_POST['num1'];
            $num2 = $_POST['num2'];

            if ($op == '/' && $num2 == 0) {
                echo "<p style='color: red;'>Erro: Não é possível dividir por zero!</p>";
            } else {
                switch ($op) {
                    case '+':
                        $resul = $num1 + $num2;
                        break;
                    case '-':
                        $resul = $num1 - $num2;
                        break;
                    case '*':
                        $resul = $num1 * $num2;
                        break;
                    case '/':
                        $resul = $num1 / $num2;
                        break;
                    default:
                        $resul = "Operação inválida";
                }

                echo "<p>O resultado da operação é: <strong>$resul</strong></p>";
            }
        }
        ?>
    </div>
</body>

</html>
