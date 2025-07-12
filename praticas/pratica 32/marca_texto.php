<html>
<head>
    <meta charset="UTF-8">
    <title>Marca de Água - Texto</title>
    <link href="estilos.css" rel="stylesheet">
</head>

<body>
<?php

    $image = imagecreatefrompng('img.png');
    if (!$image) {
        die('Erro ao carregar a imagem base');
    }

    
    $textStamp = imagecreatetruecolor(300, 80);

    $black = imagecolorallocatealpha($textStamp, 0, 0, 0, 80);
    imagefill($textStamp, 0, 0, $black);

 
    $white = imagecolorallocate($textStamp, 255, 255, 255);
    $text = "MASTER D";
    $fontSize = 5;
    $textWidth = imagefontwidth($fontSize) * strlen($text);
    $textHeight = imagefontheight($fontSize);
    $textX = (300 - $textWidth) / 2;
    $textY = (80 - $textHeight) / 2;

    imagestring($textStamp, $fontSize, $textX, $textY, $text, $white);

  
    imagecopymerge(
        $image, $textStamp,
        30, 
        imagesy($image) - 80 - 30, 
        0, 0, 300, 80, 100 
    );


    imagepng($image, 'darthvaderr_stamp_texto.png');
    imagedestroy($image);
?>
<div class="caixa0">
    <span id="logo"><img src="logo.png"></span>
</div>
<div class="caixa1">
    <img src="darthvaderr_stamp_texto.png?<?php echo time(); ?>" style="width: 100%;">
</div>
</body>
</html>
