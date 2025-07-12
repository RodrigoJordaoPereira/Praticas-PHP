<?php session_start(); ?>


<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caso Prático</title>
    <link rel="stylesheet" href="assets/css/css.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAV6GvzoTTYEDxgtS1V4IJfN-CjYoyBiOE&callback=initMap" async defer></script>
    <script src="assets/js/javascript.js"></script>
</head>

<body>
    <header>
       <nav id="navbar">
            <ul>
                <li><a href="#index" onclick="loadContent('index.html')">Início</a></li>
                <li><a href="#portfolio" onclick="loadContent('portfolio.html')">Portfólio</a></li>
                <li><a href="#orcamento" onclick="loadContent('orcamento.html')">Pedido de Orçamento</a></li>
                <li><a href="#contactos" onclick="loadContent('contactos.html')">Contactos</a></li>

                <?php if (isset($_SESSION['user_id'])) : ?>
                    <li><a href="user/perfil.php">Perfil</a></li>
                    <li><a href="user/consultas.php">Consultas</a></li>

                    <?php if ($_SESSION['tipo'] === 'admin') : ?>
                         <li><a href="admin/utilizadores.php">Utilizadores</a></li>
                        <li><a href="admin/projetos.php">Projetos</a></li>
                        <li><a href="admin/noticias.php">Notícias</a></li>
                    <?php endif; ?>

                    <li><a href="auth/logout.php">Logout</a></li>
                <?php else : ?>
                    <li><a href="auth/login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>


    </header>



    <main id="content">

        <div id="main-content">
            <h1>Bem-vindo ao nosso site!</h1>
            <p>Aqui você encontra os melhores serviços de desenvolvimento web.</p>
            <div id="featured-elements">
                <h2>Elementos em Destaque</h2>
                <ul>
                    <li><strong>Portfólio:</strong> Veja nossos projetos anteriores.</li>
                    <li><strong>Orçamento:</strong> Faça um orçamento para seu site.</li>
                    <li><strong>Contactos:</strong> Entre em contato conosco.</li>
                </ul>
            </div>
        </div>
    </main>

    <aside id="rss-feed">
        <h2>Últimas Notícias</h2>
        <ul>
            <?php
            require_once 'includes/db.php';
            $result = mysqli_query($conn, "SELECT id, titulo, resumo FROM noticias ORDER BY data_publicacao DESC LIMIT 5");

            if ($result) {
                while ($n = mysqli_fetch_assoc($result)) {
                    echo "<li><strong>{$n['titulo']}</strong><br>{$n['resumo']}<br><a href='noticia.php?id={$n['id']}'>Ler mais</a></li><br>";
                }
            } else {
                echo "<li>Erro ao carregar notícias: " . mysqli_error($conn) . "</li>";
            }
            ?>


        </ul>
    </aside>





    <section id="portfolio">
  <h2>Portfólio</h2>
  <div class="gallery">
    <?php
    require_once 'includes/db.php';
    $result = mysqli_query($conn, "SELECT * FROM projetos ORDER BY id DESC");
    if ($result) :
        while ($p = mysqli_fetch_assoc($result)) :
    ?>
        <div>
            <img
                src="assets/img/<?php echo htmlspecialchars($p['imagem']); ?>"
                alt="<?php echo htmlspecialchars($p['titulo']); ?>"
                onclick="openModal(
                    'assets/img/<?php echo htmlspecialchars($p['imagem']); ?>',
                    '<?php echo htmlspecialchars($p['titulo']); ?>',
                    `<?php echo nl2br(htmlspecialchars($p['descricao'])); ?>`
                )"
            >
            <p><?php echo htmlspecialchars($p['titulo']); ?></p>
        </div>
    <?php
        endwhile;
    else :
        echo "<p>Erro ao carregar projetos: " . mysqli_error($conn) . "</p>";
    endif;
    ?>
  </div>
</section>






    <div id="image-modal" class="modal">
        <div class="modal-content">
            <button class="close-btn" onclick="closeModal()">X</button>
            <h2 id="modal-title">Título do Projeto</h2>
            <img id="modal-image" src="img/imagem1.webp" alt="Imagem do projeto">
            <p id="modal-description"></p>
        </div>
    </div>

    <section id="orcamento">
        <div class="conteiner">
            <h2>Orçamento</h2>
            <h3>Dados</h3>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome"><br><br>

            <label for="apelido">Apelido:</label>
            <input type="text" id="apelido" name="apelido"><br><br>

            <label for="telefone">Telemóvel:</label>
            <input type="text" id="telefone" name="telefone"><br><br>

            <h2>Pedido de orçamento</h2>
            <label for="tipo_pagina">Tipo de página web:</label>
            <select id="tipo_pagina" name="tipo_pagina" onchange="calcularOrcamento()">
                <option value="">Selecione</option>
                <option value="500">Básica - 500€</option>
                <option value="800">Intermédia - 800€</option>
                <option value="1200">Avançada - 1200€</option>
                <option value="2000">Premium - 2000€</option>
            </select><br><br>

            <label for="prazo">Prazo em meses:</label>
            <input type="number" id="prazo" name="prazo" min="1" onchange="calcularOrcamento()"><br><br>

            <h3>Marque os separadores desejados</h3>
            <input type="checkbox" id="quem_somos" name="separadores" value="quem_somos" onchange="calcularOrcamento()">
            <label for="quem_somos">Quem somos</label>

            <input type="checkbox" id="onde_estamos" name="separadores" value="onde_estamos" onchange="calcularOrcamento()">
            <label for="onde_estamos">Onde estamos</label><br>

            <input type="checkbox" id="galeria" name="separadores" value="galeria" onchange="calcularOrcamento()">
            <label for="galeria">Galeria de fotografias</label>

            <input type="checkbox" id="ecommerce" name="separadores" value="ecommerce" onchange="calcularOrcamento()">
            <label for="ecommerce">eCommerce</label><br>

            <input type="checkbox" id="gestao" name="separadores" value="gestao" onchange="calcularOrcamento()">
            <label for="gestao">Gestão interna</label>

            <input type="checkbox" id="noticias" name="separadores" value="noticias" onchange="calcularOrcamento()">
            <label for="noticias">Notícias</label><br>

            <input type="checkbox" id="redes_sociais" name="separadores" value="redes_sociais" onchange="calcularOrcamento()">
            <label for="redes_sociais">Redes sociais</label><br><br>

            <h3>Orçamento estimado</h3>
            <p>(É um valor meramente indicativo, pode sofrer alterações)</p>
            <p>Orçamento Total <span id="orcamento-total">0€</span></p>
        </div>
    </section>

    <section id="mapa">
        <h2>Contactos</h2>
        <p>Encontre-nos no mapa abaixo:</p>
        <div id="map" style="width: 100%; height: 400px;"></div>
        <button onclick="getRoute()">Calcular Rota</button>
        <p id="route-info"></p>
    </section>


    <section id="contactos">
        <h2>Formulário de Contato</h2>
        <form id="form-contato" onsubmit="return validarFormulario()">
            <label for="nome">Nome:</label>
            <input type="text" id="con-nome" name="nome" required>

            <label for="apelido">Apelido:</label>
            <input type="text" id="con-apelidoo" name="apelido" required>

            <label for="telefone">Telemóvel:</label>
            <input type="text" id="con-telefonee" name="telefone" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="data">Data da Reunião:</label>
            <input type="date" id="data" name="data" required>

            <label for="motivo">Motivo do Contacto:</label>
            <textarea id="motivo" name="motivo" rows="4" cols="50" required></textarea><br><br>

            <button type="submit">Enviar</button>
        </form>
    </section>
</body>

</html>