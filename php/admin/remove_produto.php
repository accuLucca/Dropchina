<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $imagePath = "../../imagemProdutos/{$id}.jpg";
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        header("Location: ../../paginas/admin.php");
    } else {
        echo "Erro ao excluir produto: " . $conn->error;
    }
}

$conn->close();
?>
