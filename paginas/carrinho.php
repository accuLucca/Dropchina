<?php
session_start();
$logged_in = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DropChina - Carrinho</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/paginaCarrinho.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="../img/pandaship.jpeg" alt="Logo DropChina">
        </div>
        <div class="title">DropChina</div>
    </header>
    
    <nav>
        <ul>
            <div class="center-links">
                <li><a href="../index.php">Início</a></li>
                <li><a href="../paginas/sobreNos.html">Sobre Nós</a></li>
                <li><a href="#">Contato</a></li>
                <li><a href="carrinho.php">Carrinho</a></li>
            </div>
            <?php if ($logged_in): ?>
                <li class="right-links"><a href="#"><?php echo htmlspecialchars($_SESSION['username']); ?></a></li>
                <li class="right-links"><a href="../php/logout.php" onclick="return confirm('Tem certeza que deseja sair?');">Logout</a></li>
            <?php else: ?>
                <li class="right-links"><a href="#" id="login-btn">Login/Cadastro</a></li>
            <?php endif; ?>
        </ul>
        <?php if (!$logged_in): ?>
        <div id="login-dropdown" class="dropdown-content">
            <form id="login-form" onsubmit="loginCarrinho(event)">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Login</button>
                <button type="button" id="signup-btn">Cadastre-se</button>
            </form>
            <form id="signup-form" style="display:none;" onsubmit="signupCarrinho(event)">
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
        </ul>
    </nav>

    <main>
        <section class="carrinho">
            <div class="carrinho-container">
                <?php if ($logged_in): ?>
                    <?php
                    $user_id = $_SESSION['user_id'];
                    
                    // Conectando ao banco de dados
                    require_once '../php/db.php';
                    
                    $sql = "SELECT products.id, products.name, carrinhos_de_compra.product_price
                            FROM carrinhos_de_compra 
                            INNER JOIN products ON carrinhos_de_compra.product_id = products.id 
                            WHERE carrinhos_de_compra.user_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    ?>
                    <h1><?php echo htmlspecialchars($_SESSION['username']); ?>, seu carrinho atual</h1>

                    <?php if ($result->num_rows > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Preço</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td>
                                            <img src="../imagemProdutos/<?php echo htmlspecialchars($row['id']); ?>.jpg" alt="<?php echo htmlspecialchars($row['name']); ?>" width="50">
                                            <?php echo htmlspecialchars($row['name']); ?>
                                        </td>
                                        <td>R$ <?php echo number_format($row['product_price'], 2, ',', '.'); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>Seu carrinho está vazio.</p>
                    <?php endif; ?>
                    <?php $stmt->close(); ?>
                    <?php $conn->close(); ?>
                <?php else: ?>
                    <p>Você precisa estar logado para acessar o carrinho.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 DropChina</p>
    </footer>

    <script src="../js/scripts.js"></script>
</body>
</html>
