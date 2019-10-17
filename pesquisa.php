<?php
    require_once 'pages/header.php';


    if(empty($_SESSION['cLogin'])) {
        header("Location:login.php");
        exit;
    }

    require_once 'classes/usuarios.class.php';
    require_once 'classes/anuncios.class.php';
    require_once 'classes/categorias.class.php';

    $a= new Usuario($pdo); 
    $b= new Anuncio($pdo);
    $c= new Categoria($pdo);
    
    $total= $a->totalUsuarios();
    $posts= $b->totalAnuncios();
    $categorias= $c->getLista();

    if(empty($_GET['categoria']) || empty($_GET['valor'])) {
        echo "<div class='alert alert-danger'>Selecione Categoria e Valor para Pesquisa Avançada</div>";
        header("Refresh:3,index.php");
        exit;
    } else {
        $categoria=  $_GET['categoria'];
        $valor=  $_GET['valor'];

        $array=$b->filtroAnuncio($categoria, $valor); 
    
    }

    ?>
     <div class="container-fluid" >
         <div class="jumbotron">
                  <h2>Nós temos hoje <strong> <?php echo $posts ?> </strong> Novos anuncios !</h2>
                  <p>E mais de <strong> <?php echo $total ?> </strong> de usuários cadastrados.</p>
          </div>
     </div>

     <div class="container">
    
            <div class="row">
     <?php foreach($array as $item): ?>

                <div class="jumbotron">
                  <?php if(!empty($item['urli'])): ?>
                   
                    <img id="imageFiltro" class="card-heading" src="assets/images/anuncios/<?php echo $item['urli'] ?>" >
                   
                    <?php else: ?>
                    
                    <img id="imageFiltro"  class="card-heading" src="assets/images/anuncios/default.png" >
                    <?php endif;?>

                

                    <div class="row-sm-4">
                        <h4 class="card-title"><?php echo $item['titulo'] ?></h4>
                        <p class="card-text"><?php echo $item['descricao'] ?></p>
                        <p class="card-footer"><?php echo $item['user'] ?></p>
                        
                        </div>
                       </div>
                       <?php endforeach; ?>
                    </div> 
                    
             </div>
     </div>
     
     

<?php
    require_once 'pages/footer.php';
?>
