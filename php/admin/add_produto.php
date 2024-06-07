<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name']) && isset($_POST['price']) && isset($_FILES['product_image'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("INSERT INTO products (name, price) VALUES (?, ?)");
    $stmt->bind_param("sd", $name, $price);

    if ($stmt->execute()) {
        $productId = $stmt->insert_id;
        $imagePath = "../../imagemProdutos/{$productId}.jpg";
        move_uploaded_file($_FILES['product_image']['tmp_name'], $imagePath);
        header("Location: ../../paginas/admin.php");
    } else {
        echo "Erro ao cadastrar produto: " . $conn->error;
    }
}

$conn->close();
?>
