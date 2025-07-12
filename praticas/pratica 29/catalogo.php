<?php
session_start();
if (!isset($_SESSION['carrinho'])) {
	$_SESSION['carrinho'] = array();
}
if (isset($_GET['comprar'])) {
	$_SESSION['carrinho'][] = $_GET['comprar'];
	header('location: ' . $_SERVER['PHP_SELF'] . '?' . SID);
	exit();
}
?>
<html>

<head>
	<meta charset="UTF-8">
	<title>Catálogo - Prática 29</title>
	<link href="estilos.css" rel="stylesheet">
</head>

<body>
	<div class="caixa0">
		<span id="logo"><img src="logo.png"></span>
	</div>
	<div class="caixa1">
		<h2>CATÁLOGO</h2>
		<p>O carrinho tem <?php echo count($_SESSION['carrinho']); ?> i
			tens.</p>
		<p><a href="carrinho.php" class="botao">Ver carrinho</a></p><br>
		<?php
		$itens = array(
			'Dicionário Português', 'Livro de Receitas', 'Livro para Colorir', 'Mapa das Estradas de Portugal'
		);
		$precos = array(9.99, 14.99, 10, 24, 99);
		?>
		<table>
			<thead>
				<tr>
					<th>Nome do Item</th>
					<th>Preço</th>
				</tr>
			</thead>
			<tbody>
				<?php
				for ($i = 0; $i < count($itens); $i++) {
					echo '<tr>';
					echo '<td>' . $itens[$i] . '</td>';
					echo '<td align ="right">' . number_format($precos[$i], 2) . ' €</td>';
					echo '<td><a href="' . $_SERVER['PHP_SELF'] . '?comprar=' . $i . '" class="botao">Comprar</a></td>';
					echo '</tr>';
				}
				?>
			</tbody>
		</table>
	</div>
</body>

</html>
</body>