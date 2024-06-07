<?php
session_start();
include '../php/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password, is_admin FROM usuarios WHERE username = ?");
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $nome, $hashed_password, $is_admin);

        if ($stmt->num_rows > 0) {
            $stmt->fetch();
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $nome;
                $_SESSION['is_admin'] = $is_admin;
                if ($is_admin) {
                    echo "/AdminProjeto/paginas/admin.php";
                } else {
                    echo "/AdminProjeto/index.php";
                }
            } else {
                echo "Senha incorreta.";
            }
        } else {
            echo "Usuário não encontrado.";
        }

        $stmt->close();
    } else {
        echo "Erro ao preparar a declaração SQL.";
        error_log("Erro ao preparar a declaração SQL: " . $conn->error);
    }

    $conn->close();
} else {
    echo "Método de requisição inválido.";
}
?>
