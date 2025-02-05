<?php
session_start();

include 'conexao.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}
if (isset($_SESSION['pesquisa'])) {
    $pesquisa = $_SESSION['pesquisa'];
}else {
    $origem = $_SESSION['origem'];
    header("Location: $origem");
    exit();
}
if (isset($_POST['adicionar-produto'])) {
    $id_produto = $_POST['serial'];
    $valor_produto = $_POST['valor'];
    $sql = "INSERT INTO carrinho(usuario_id, produto_id, valor_total) VALUES(:user_id, :produto_id, :valor)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":user_id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":produto_id", $id_produto, PDO::PARAM_INT);
    $stmt->bindParam(":valor", $valor_produto, PDO::PARAM_INT);
    $stmt->execute();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="row">
        <form action="" method="POST">
            <?php
            foreach ($pesquisa as $produto) {
                if ($produto) {
            ?>
            <div class="card border-rounded mx-5 col-4" style="width: 18rem; float: left; padding: 10px;">
                <img src="<?php echo $produto['foto']?>" alt="<?php echo $produto['nome']?>">
                <div class="card-body border-top border-dark">
                    <input name="serial" type="number" style="visibility: hidden;" value="<?php echo $produto['serial_number'];?>">
                    <input type="number" name="valor" style="visibility: hidden;" value="<?php echo $produto['valor'];?>">
                    <h5><?php echo $produto['nome'];?></h5>
                    <p>Preço: R$<?php echo $produto['valor'];?></p>
                    <p>Estoque: <?php echo $produto['quantidade'];?></p>
                    <button type="submit" name="adicionar-produto" class="btn btn-success">Adicionar ao carrinho</button>
                </div>
            </div>
            <?php
                }
            }
            ?>
            <div class="container-fluid mt-3 row">
                <a href="carrinho.php" class="btn btn-success">Ver carrinho</a>
            </div>
        </form>
    </div>
</body>
</html>