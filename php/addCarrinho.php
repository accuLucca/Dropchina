<?php
// addCarrinho.php

include 'db.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Usuário não está logado"]);
    exit();
}

$user_id = $_SESSION['user_id'];
$product_name = $_POST['name'];
$product_price = $_POST['price'];

// Assumindo que você tenha uma função para obter o ID do produto a partir do nome
$product_id = getProductIdByName($product_name);

$query = "INSERT INTO carrinhos_de_compra (user_id, product_id, product_price) VALUES ('$user_id', '$product_id', '$product_price')";

if (mysqli_query($conn, $query)) {
    echo json_encode(["status" => "success", "message" => "Produto adicionado ao carrinho"]);
} else {
    echo json_encode(["status" => "error", "message" => "Erro: " . mysqli_error($conn)]);
}

function getProductIdByName($name) {
    global $conn;
    $query = "SELECT id FROM products WHERE name = '$name'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['id'];
}
?>
