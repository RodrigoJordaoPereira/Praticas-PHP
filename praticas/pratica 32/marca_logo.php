<html>
<head>
    <meta charset="UTF-8">
    <title>Marca de Água - Imagem</title>
    <link href="estilos.css" rel="stylesheet">
</head>

<body>
<?php
    $image = imagecreatefrompng('img.png');
    if (!$image) {
        die('Erro ao carregar a imagem base');
    }

    $stamp = imagecreatefrompng('logo.png');
    if (!$stamp) {
        die('Erro ao carregar logo');
    }

    
    $right = 10;  
    $bottom = 10;  
    $sx = imagesx($stamp);
    $sy = imagesy($stamp);


    imagecopy(
        $image, $stamp,
        imagesx($image) - $sx - $right,
        imagesy($image) - $sy - $bottom,
        0, 0, $sx, $sy
    );

    if (imagepng($image, 'darthvaderr_stamp_imagem.png'))
    imagedestroy($image);
?>

<div class="caixa0">
    <span id="logo"><img src="logo.png"></span>
</div>
<div class="caixa1">
    <img src="darthvaderr_stamp_imagem.png?<?php echo time(); ?>" style="width: 100%;">
</div>
</body>
</html>
