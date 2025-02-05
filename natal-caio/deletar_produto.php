<?php
session_start();

include 'conexao.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}
if ($_SESSION['tipo'] == "usuario") {
    header("Location: index.php");
    exit();
}
$id = $_SESSION['id_usuario'];

if (isset($_GET['serial'])) {
    $produto_id = $_GET['serial'];

    $sql = "DELETE FROM produtos WHERE user_id = :id AND serial_number = :serial_number";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":serial_number", $produto_id);
    $stmt->execute();

    header("Location: view.php");
    exit();
}
?>