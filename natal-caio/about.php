<?php
session_start();
include 'conexao.php';

$id = $_SESSION['id_usuario'];

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}
if ($_SESSION['tipo'] == "admin") {
    header("Location: admin.php");
    exit();
}
$_SESSION['origem'] = "about.php";
if (isset($_POST['pesquisar'])) {
    $pesquisa = $_POST['pesquisa'];
    $sql = "SELECT produtos.nome,
                   produtos.serial_number,
                   produtos.valor,
                   produtos.quantidade
            FROM produtos WHERE MATCH(nome) AGAINST(':pesquisa' IN NATURAL LANGUAGE MODE)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":pesquisa", $pesquisa);
    $stmt->execute();
    $_SESSION['pesquisa'] = $stmt->fetchAll(PDO::FETC);

    header("Location: pesquisa.php");
    exit();
}

$sql = "SELECT produtos.nome,
               produtos.serial_number,
               produtos.valor,
               produtos.quantidade,
               produtos.foto
FROM produtos";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <title>About | CGS</title>
    <script src="https://kit.fontawesome.com/e5531e1bd1.js" crossorigin="anonymous"></script>
    <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" 
    crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="https://cdn.pixabay.com/photo/2014/03/24/17/18/electric-guitar-295349_1280.png" type="image/x-icon">
</head>
<body>
    <nav class="navbar navbar-expand bg-dark">
        <div class="container-fluid">
            <a class="btn btn-light" role="button" data-bs-toggle="offcanvas" href="#sidemenu" aria-controls="sidemenu"><i class="fa-solid fa-bars" style="color: black;"></i></button></a>
            <a class="navbar-brand d-sm-none d-lg-block " style="color: aliceblue;">CGS<img src="https://cdn.pixabay.com/photo/2014/03/24/17/18/electric-guitar-295349_1280.png" alt="logo" width="100px"></a>
            <a href="index.php" class="nav-link active d-sm-none d-lg-flex " style="color: aliceblue;">Home</a>
            <a href="about.php" class="nav-link d-sm-none d-lg-flex " style="color: aliceblue;">Sobre</a>
            <a href="contact.php" class="nav-link d-sm-none d-lg-flex "  style="color: aliceblue;">Contato</a>
            <form class="d-flex me-5" action="" method="POST">
                <input class="form-control" name="pesquisa" id="pesquisa" placeholder="Search" type="text">
                <button type="submit" class="btn btn-success">Pesquisar</button>
            </form>
            <form action="logoff.php" method="POST">
                <button class="btn btn-success" type="submit">Logoff</button>
            </form>
        </div>
    </nav>
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="sidemenu" aria-labelledby="offcanvasScrollingLabel">
        <div class="offcanvas-header">
          <button type="button" class="btn border-dark" data-bs-dismiss="offcanvas"><i class="fa-solid fa-bars"></i></button>
        </div>
        <div class="offcanvas-body">
            <div class="col">
                <div class="container-fluid d-sm-block d-lg-none" style="background-color: #E6DCB1; border-radius: 13px;">
                    <a class="navbar-brand">CGS<img src="https://cdn.pixabay.com/photo/2014/03/24/17/18/electric-guitar-295349_1280.png" alt="logo" width="100px"></a>
                </div>
                <a href="index.html" class="btn btn-dark d-sm-flex d-lg-none">Home</a>
                <a href="about.html" class="btn btn-dark d-sm-flex d-lg-none">Sobre</a>
                <a href="contact.html" class="btn btn-dark d-sm-flex d-lg-none">Contato</a>
                <h1>Creators Social</h1>
                <p><a href="https://github.com/Caio-Azevedo-O">Github</a></p>
                <p><a href="https://www.linkedin.com/in/caio-azevedo-a4a329234/">LinkedIn</a></p>
            </div>
        </div>
      </div>
      <main class="row" style="text-align: center; background-color: aliceblue;">

          <section class="text-dark">
              <h1>Conheça nossa história</h1>
              <p>A CGS foi fundada por Caio Azevedo de Oliveira com o objetivo de ser uma plataforma de vendas de guitarras, tanto usadas quanto novas, de empresas ou pessoas.
  
              </p>
          </section>
          <section class="row" style="background-color: aliceblue;">
              <h1>VEJA NOSSOS PRODUTOS</h1>
              <div class="row">
                <?php
                foreach ($produtos as $produto) {
                ?>
            <form action="" method="POST" class="col-3">
                <div class="card border-rounded mx-5" style="width: 18rem; float: left; padding: 10px;">
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
            </form>
                <?php
                }
                ?>
            </div>
            <a href="carrinho.php"><div class="container-fluid mt-3 row btn btn-success">
                Ver carrinho
            </div></a>
          </section><br><br>
        </main>
    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
        crossorigin="anonymous">
    </script>
    <footer class="footer-loja">
        <div class="row d-sm-none d-lg-flex border-top border-dark">
            <div class="col">
                <table>
                    <thead>
                        <th>
                            <td><h1>CGS</h1></td>
                            <td><img src="https://cdn.pixabay.com/photo/2014/03/24/17/18/electric-guitar-295349_1280.png" alt="logo" width="100PX"></td>
                        </th>
                    </thead>
                </table>
                <p>Created in 2023</p>
                <p>Creator: Caio Azevedo</p>
            </div>
            <div class="col">
                <h1>Source</h1>
                <p><a href="https://github.com/Caio-Azevedo-O/AV2-4-BIM.git">Github</a></p>
            </div>
            <div class="col">
                <h1>Parceiros</h1>
                <a href="https://www.gibson.com/en-US/">Gibson</a> |
                <a href="https://www.espguitars.com">ESP</a> |
                <a href="https://www.schecterguitars.com">Schecter</a>
            </div>
        </div>
    </footer>
</body>
</html>
