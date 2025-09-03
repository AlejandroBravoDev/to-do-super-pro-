<?php
require_once 'conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['clave']);

  
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    try {
        $db = new Database();
        $conn = $db->connect();

        $sql = "INSERT INTO users (fullname, email, password) VALUES (:fullname, :email, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $passwordHash);

        if ($stmt->execute()) {
            header('Location: index.php');
        } else {
            echo "Error al registrar el usuario.";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Acceso inválido.";
}
?>