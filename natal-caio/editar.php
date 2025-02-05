<?php
session_start();

include 'conexao.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}
if ($_SESSION['tipo'] == 'usuario') {
    header('Location: index.php');
    exit();
}
if (isset($_GET['serial'])) {
    $serial = $_GET['serial'];
    $nome = $_GET['nome'];
    $valor = $_GET['valor'];
    $foto = $_GET['foto'];
    $quantidade = $_GET['quantidade'];
    $marca = $_GET['marca'];

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['marcas'])) {
        $sql = "UPDATE produtos SET nome = :nome, valor = :valor, foto = :foto, quantidade = :quantidade, marca_id = :marca WHERE user_id = :id AND serial_number = :serial_number";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":nome", $_POST['nome']);
        $stmt->bindParam(":valor", $_POST['valor']);
        $stmt->bindParam(":foto", $_POST['foto']);
        $stmt->bindParam(":quantidade", $_POST['quantidade']);
        $stmt->bindParam(":marca", $_POST['marcas']);
        $stmt->bindParam(":id", $_SESSION['id_usuario']);
        $stmt->bindParam(":serial_number", $serial);

        $stmt->execute();

        header("Location: view.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CGS | Editar</title>
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
                <a href="create.php" class="btn btn-dark d-sm-flex d-lg-none">Sobre</a>
                <a href="contactAdmin.php" class="btn btn-dark d-sm-flex d-lg-none">Contato</a>
                <h1>Creators Social</h1>
                <p><a href="https://github.com/Caio-Azevedo-O">Github</a></p>
                <p><a href="https://www.linkedin.com/in/caio-azevedo-a4a329234/">LinkedIn</a></p>
                
            </div>
        </div>
      </div>
      <main style="text-align: center;">
        <h1  style="margin-top: 5%;" class="text-light">Edite o seu produto</h1>
        <div class="row bg-dark" style="padding: 30px;">
            <form class="bg-dark border border-dark rounded col-6" style="width: 750px; padding: 30px;" action="" method="POST">
                <input class="form-control" type="text" name="nome" id="nome" placeholder="Nome" require><br>
                <div class="input-group">
                    <span id="valor" class="input-group-text">R$</span>
                    <input class="form-control" type="number" name="valor" id="valor" placeholder="Preço" require><br>
                </div>
                <input class="form-control" type="text" name="foto" id="foto" placeholder="URL da foto" require><br>
                <input class="form-control" type="number" name="quantidade" id="" placeholder="Quantidade no Estoque" require><br>
                <div class="btn-group">
                    <input class="btn-check" type="radio" name="marcas" id="schecter" value="1" require>
                    <label for="schecter" class="btn btn-light">Schecter</label>
                    <input class="btn-check" type="radio" name="marcas" id="gibson" value="2" require>
                    <label for="gibson" class="btn btn-light">Gibson</label>
                    <input class="btn-check" type="radio" name="marcas" id="esp" value="3" require>
                    <label for="esp" class="btn btn-light">ESP</label>
                </div>
                <button class="btn btn-success">Concluir</button>
            </form>
            <div class="col-6 bg-dark rounded">
                <img class="rounded bg-light" src="<?php echo $foto?>" height="300px" alt="Foto do produto">

            </div>
        </div>

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