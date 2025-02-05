<?php
session_start();
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $usuario = $_POST['user'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $usuario);
    $stmt->execute();
    $user = $stmt->fetch();

    var_dump($usuario);

    if($usuario){
        
        echo "Senha do formulário: ".$pass."</br>";
        echo "Senha do banco de dados: ".$user["password"]."</br>";

        if ($pass == $user["password"]) {
            $_SESSION['id_usuario'] = $user['id'];
            $_SESSION['tipo'] = $user['tipo'];
            $_SESSION['user'] = $user['user'];

            if ($_SESSION['tipo'] == "usuario") {
                header("Location: index.php");

            }elseif ($_SESSION['tipo'] == "admin") {
                header("Location: admin.php");

            }
        }else {
            echo '<p class="mensagemPHP">Senha incorreta</p>';

        }
    }else {
        echo '<p class="mensagemPHP">Usuário não encontrado<p/>';

    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
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
    <div class="col-4 bg-light borer-right border-dark" style="height: 100vh; text-align: center">
        <h1 style="margin-top: 30px;">Login</h1>
        <div class="formulario-login bg-dark" style=" border-radius: 5px; padding: 35px;">
            <form action="" method="POST">
                <input class="form-control" type="text" name="user" id="user" placeholder="Usuário"><br>
                <input class="form-control" type="text" name="password" id="password" placeholder="Senha"><br>
                <button class="btn btn-success" name="submit" type="submit">Entrar</button>
                <a href="cadastro.php" class="btn btn-info text-light">Cadastrar</a>
            </form>
        </div>
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