<?php
$dsn = 'mysql:host=localhost;dbname=caio2tianatal';
$usuario = 'root';
$senha = '';

try {
   
    $pdo = new PDO($dsn, $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erro na conexão: ' . $e->getMessage();
    exit;
}
?>
