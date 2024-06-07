<?php
include '../php/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['name']) && isset($_POST['price']) && isset($_FILES['product_image'])) {
        $name = $_POST['name'];
        $price = $_POST['price'];

        $stmt = $conn->prepare("INSERT INTO products (name, price) VALUES (?, ?)");
        $stmt->bind_param("sd", $name, $price);

        if ($stmt->execute()) {
            $productId = $stmt->insert_id;
            $imagePath = "../imagemProdutos/{$productId}.jpg";
            move_uploaded_file($_FILES['product_image']['tmp_name'], $imagePath);
            $message = "Produto cadastrado com sucesso!";
        } else {
            $message = "Erro ao cadastrar produto: " . $conn->error;
        }
    } elseif (isset($_POST['id'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $imagePath = "../imagemProdutos/{$id}.jpg";
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $message = "Produto excluído com sucesso!";
        } else {
            $message = "Erro ao excluir produto: " . $conn->error;
        }
    }
}

$result = $conn->query("SELECT * FROM products");
$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração - Drop China</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <header>
        <h1>Administração de Produtos</h1>
    </header>
    <main>
        <section class="admin-section">
            <h2>Cadastrar Produto</h2>
            <form id="add-product-form" action="admin.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Nome do Produto" required>
                <input type="number" name="price" placeholder="Preço do Produto" step="0.01" required>
                <input type="file" name="product_image" required>
                <button type="submit">Cadastrar Produto</button>
            </form>
        </section>
        <section class="admin-section">
            <h2>Excluir Produto</h2>
            <form id="delete-product-form" action="admin.php" method="POST">
                <input type="number" name="id" placeholder="ID do Produto" required>
                <button type="submit">Excluir Produto</button>
            </form>
        </section>
        <section class="admin-section">
            <h2>Produtos Cadastrados</h2>
            <ul id="product-list">
                <?php
                if (count($products) > 0) {
                    foreach ($products as $product) {
                        echo "<li>ID: {$product['id']} - Nome: {$product['name']} - Preço: R$ {$product['price']}</li>";
                    }
                } else {
                    echo "<li>Nenhum produto cadastrado.</li>";
                }
                ?>
            </ul>
        </section>
        <?php if (isset($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <section class="admin-section">
            <button onclick="window.location.href='../index.php'">Voltar à Página Principal</button>
        </section>
    </main>
    <script src="../js/admin.js"></script>
</body>
</html>
