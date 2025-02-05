<?php
session_start();

include 'conexao.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}
if ($_SESSION['tipo'] == "admin") {
    header("Location: admin.php");
    exit();
}
$id = $_SESSION['id_usuario'];

if (isset($_GET['id_carrinho'])) {
    $carrinho_id = $_GET['id_carrinho'];

    $sql = "DELETE FROM carrinho WHERE usuario_id = :id AND id = :id_carrinho";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":id_carrinho", $carrinho_id);
    $stmt->execute();

    header("Location: carrinho.php");
    exit();
}
?>