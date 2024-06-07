<?php
session_start();
$logged_in = isset($_SESSION['user_id']);
$username = $logged_in ? $_SESSION['username'] : '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drop China</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/carrinho.css"> <!-- Link para o CSS do carrinho -->
</head>
<body>
    <header>
        <div class="logo">
            <img src="img/pandaship.jpeg" alt="Logo DropChina">
        </div>
        <div class="title">DropChina</div>
    </header>

    <nav>
        <ul>
            <div class="center-links">
                <li><a href="#">Início</a></li>
                <li><a href="paginas/sobrenos.html">Sobre Nós</a></li>
                <li><a href="#">Contato</a></li>
                <li><a href="paginas/carrinho.php">Carrinho</a></li>
            </div>
            <?php if ($logged_in): ?>
                <li class="right-links"><a href="#"><?php echo htmlspecialchars($username); ?></a></li>
                <li class="right-links"><a href="php/logout.php" onclick="return confirm('Tem certeza que deseja sair?');">Logout</a></li>
            <?php else: ?>
                <li class="right-links"><a href="#" id="login-btn">Login/Cadastro</a></li>
            <?php endif; ?>
        </ul>
        <?php if (!$logged_in): ?>
        <div id="login-dropdown" class="dropdown-content">
            <form id="login-form" onsubmit="login(event)">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Login</button>
                <button type="button" id="signup-btn">Cadastre-se</button>
            </form>
            <form id="signup-form" style="display:none;" onsubmit="signup(event)">
                <label for="new-username">Usuario:</label>
                <input type="text" id="new-username" name="new-username" required>
                <label for="new-password">Senha:</label>
                <input type="password" id="new-password" name="new-password" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <button type="submit">Cadastrar</button>
                <button type="button" id="login-btn-back">Voltar ao Login</button>
            </form>
        </div>
        <?php endif; ?>
    </nav>

    <main>
        <section class="produtos">
            <h2>Produtos em destaque</h2>
            <div class="grid-container">
                <!-- Produtos serão carregados aqui -->
            </div>
        </section>
    </main>

    <!-- Modal HTML -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modalProductImage"></div>
            <h2 id="modalProductName"></h2>
            <p id="modalProductPrice"></p>
            <button id="addToCartButton">Adicionar ao Carrinho</button>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 DropChina</p>
    </footer>

    <script src="js/scripts.js"></script>
    <script src="js/buscaProdutos.js"></script>
</body>
</html>
