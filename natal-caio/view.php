<?php
session_start();

include 'conexao.php';

$id = $_SESSION['id_usuario'];

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}
if ($_SESSION['tipo'] == "usuario") {
    header("Location: index.php");
    exit();
}

$serial = '';
$nome = '';
$preco = '';
$foto = '';
$estoque = '';
$marca = '';

$sql = 'SELECT produtos.serial_number,
               produtos.nome,
               produtos.valor,
               produtos.foto,
               produtos.quantidade,
               marcas.nome_marca
FROM produtos INNER JOIN marcas ON produtos.marca_id = marcas.id WHERE produtos.user_id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CGS | Visualizar seus produtos</title>
    <script src="https://kit.fontawesome.com/e5531e1bd1.js" crossorigin="anonymous"></script>
    <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" 
    crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="https://cdn.pixabay.com/photo/2014/03/24/17/18/electric-guitar-295349_1280.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>
<body>
<nav class="navbar navbar-expand bg-dark fixed-top">
        <div class="container-fluid">
            <a class="btn btn-light" role="button" data-bs-toggle="offcanvas" href="#sidemenu" aria-controls="sidemenu"><i class="fa-solid fa-bars" style="color: black;"></i></button></a>
            
            <a class="navbar-brand d-sm-none d-lg-block " style="color: aliceblue;">CGS<img src="https://cdn.pixabay.com/photo/2014/03/24/17/18/electric-guitar-295349_1280.png" alt="logo" width="100px"></a>
            <a href="admin.php" class="nav-link active d-sm-none d-lg-flex " style="color: aliceblue;">Home</a>
            <a href="view.php" class="nav-link active d-sm-none d-lg-flex " style="color: aliceblue;">Meus itens</a>
            <a href="create.php" class="nav-link d-sm-none d-lg-flex " style="color: aliceblue;">Administrar</a>
            <a href="contactAdmin.php" class="nav-link d-sm-none d-lg-flex "  style="color: aliceblue;">Contato</a>
            <form action="logoff.php" method="POST">
                <button class="btn btn-success" type="submit">Logoff</button>
            </form>
        </div>
    </nav>
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="sidemenu" aria-labelledby="offcanvasScrollingLabel">
        <div class="offcanvas-header">
          <button type="button" class="btn border-dark" data-bs-dismiss="offcanvas" style="background-color:#E6DCB1 ;"><i class="fa-solid fa-bars"></i></button>
        </div>
        <div class="offcanvas-body">
            <div class="col">
                <div class="container-fluid d-sm-block d-lg-none" style="background-color: #E6DCB1; border-radius: 13px;">
                    <a class="navbar-brand">CGS<img src="https://cdn.pixabay.com/photo/2014/03/24/17/18/electric-guitar-295349_1280.png" alt="logo" width="100px"></a>
                </div>
                <a href="admin.php" class="btn btn-dark d-sm-flex d-lg-none">Home</a>
                <a href="view.php" class="nav-link active d-sm-none d-lg-flex " style="color: aliceblue;">Meus itens</a>
                <a href="create.php" class="btn btn-dark d-sm-flex d-lg-none">Administrar</a>
                <a href="contactAdmin.php" class="btn btn-dark d-sm-flex d-lg-none">Contato</a>
                <h1>Creators Social</h1>
                <p><a href="https://github.com/Caio-Azevedo-O">Github</a></p>
                <p><a href="https://www.linkedin.com/in/caio-azevedo-a4a329234/">LinkedIn</a></p>
                
            </div>
        </div>
      </div>
      <main>
            <table class="table" style="margin-top: 10%;">
                <thead>
                    <tr>
                        <th>Serial number</th>
                        <th>Nome do produto</th>
                        <th>Preço</th>
                        <th>Foto</th>
                        <th>Estoque</th>
                        <th>Marca</th>
                        <th>Editar/Deletar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($produtos as $produto) {
                    ?>
                        <tr>
                            <td><?php echo $produto['serial_number']?></td>
                            <td><?php echo $produto['nome']?></td>
                            <td><?php echo "R$".$produto['valor']?></td>
                            <td> <img src="<?php echo $produto['foto']?>" alt="fotoProduto" height="150px"></td>
                            <td><?php echo $produto['quantidade']?></td>
                            <td><?php echo $produto['nome_marca']?></td>
                            <td>
                                <a class="btn btn-primary" href="editar.php?serial=<?php echo $produto['serial_number'];?>&nome=<?php echo $produto['nome'];?>&valor=<?php echo $produto['valor'];?>&foto=<?php echo $produto['foto'];?>&quantidade=<?php echo $produto['quantidade'];?>&marca=<?php echo $produto['nome_marca'];?>" style="width: 150px;">Editar</a><br>
                                <a class="btn btn-danger" style="width: 150px;" onclick="return confirm('Tem certeza que deseja deletar o produto?');" href="deletar_produto.php?serial=<?php echo $produto['serial_number']?>">Deletar</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>  
                </tbody>
            </table>

      </main>
    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
        crossorigin="anonymous">
    </script>
    <footer class="footer-loja" style="height: 30vh;">
        <div class="row p-3 d-sm-none d-lg-flex border-top border-dark">
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