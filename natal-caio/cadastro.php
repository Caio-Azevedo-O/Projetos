<?php
require 'conexao.php';
if (isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $senha = $_POST['pass'];
    $sql = "INSERT INTO usuarios(username, password, tipo) VALUES(:nome, :senha, 'usuario')";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":senha", $senha);
    $stmt->execute();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://kit.fontawesome.com/e5531e1bd1.js" crossorigin="anonymous"></script>
    <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" 
    crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="https://cdn.pixabay.com/photo/2014/03/24/17/18/electric-guitar-295349_1280.png" type="image/x-icon">
</head>
<body class="row">
    <div class="col-4" style="text-align: center; height: 100vh; background-color: aliceblue;">
        <form action="" method="POST" class="bg-dark" style="padding: 30px; border-radius: 10px; margin-top: 20%;">
            <h1 class="text-light">Cadastrar</h1>
            <input type="text" name="nome" class="form-control" placeholder="Nome" require><br>
            <input type="text" name="pass" class="form-control" placeholder="Senha" require><br>
            <button class="btn btn-success" type="submit" name="cadastrar">Cadastrar</button>
            <a href="login.php" class="btn btn-info text-light">Login</a><br>
        </form>
    </div>
    <div class="col-8" style="text-align: center;">
        <div class="row" style="background-color:#E6DCB1; width: 500px;  border-radius: 10px; background-color: #003161; text-align: center; paddin: 30px;">
            <h1 class="text-light" style="margin-top: 30px;">Bem vindo a CGS!</h1>
            <img src="https://cdn.pixabay.com/photo/2014/03/24/17/18/electric-guitar-295349_1280.png" alt="logo" width="400px">
        </div>
    </div>
    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
        crossorigin="anonymous">
    </script>
</body>
</html>