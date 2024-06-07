<?php
include '../php/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['new-username'];
    $password = $_POST['new-password'];
    $email = $_POST['email'];

    // Verificar se o usuário já existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Usuário ou email já cadastrado.";
    } else {
        // Inserir novo usuário
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO usuarios (username, password, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed_password, $email);

        if ($stmt->execute()) {
            echo "Cadastro bem-sucedido";
        } else {
            echo "Erro ao cadastrar. Tente novamente.";
        }
    }

    $stmt->close();
    $conn->close();
}
?>
