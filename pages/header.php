<?php require './config.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Classificados</title>
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <script type="text/javascript" src="./assets/js/jquery-3.3.1.slim.min.js"></script>
    <script type="text/javascript" src="./assets/js/bootstrap.min.js"></script>
</head>
<body >

     <nav class="navbar navbar-expand-md navbar-dark bg-primary d-flex justify-content-between">
         <div class="container-fluid">
         <a class="navbar-brand" href="#">Classificados</a>
            <div class=" navbar navbar-right">
                <ul class="navbar-nav">

                <?php if(isset($_SESSION['cLogin']) && !empty($_SESSION['cLogin'])): ?>
                
                <li class="nav-item">
                <?php  
                  $id= $_SESSION['cLogin'];

                  $sql= "SELECT * FROM usuarios WHERE id = $id";
                  $sql= $pdo->query($sql);
                  if($sql->rowCount() > 0) {
                      $dados= $sql->fetch();
                      $nome= $dados['nome'];
                  }
                  ?>

                    <a class="nav-link" style="padding-right:50px">Seja Bem-Vindo <?php echo "<strong class='text text-warning'>".$nome."</strong>" ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="meus-anuncios.php">Meus Anúncios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="sair.php">Sair</a>
                </li>
                <?php else : ?>
               
                <li class="nav-item">
                    <a class="nav-link" href="cadastro.php">Cadastre-se</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>

                <?php endif; ?>

                    </ul>
                </div>
            </div>
     </nav>