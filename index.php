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

    $p= 1;
    if(isset($_GET['p']) && !empty($_GET['p'])) {
        $p=  $_GET['p'];
    }

    $por_pagina= 2;
    $total_paginas= ceil($posts / $por_pagina);
    $ultimos= $b->getUltimosAnuncios($p, 3);

    $categorias= $c->getLista(); 

    

    ?>
     <div class="container-fluid">
         <div class="jumbotron">
                  <h2>Nós temos hoje <strong> <?php echo $posts ?> </strong> Novos anuncios !</h2>
                  <p>E mais de <strong> <?php echo $total ?> </strong> de usuários cadastrados.</p>
          </div>
     </div>
     <div class="container" >
        <div class="row">
            <div class="col-sm-3 jumbotron">
                <h3>Pesquisa Avançada</h3>
                <form action="pesquisa.php" method="GET">

                    <div class="form-group">
                        <label for="categoria">Categorias:</label> 
                        <select name="categoria" class="form-control" required>
                        <option></option>
                        <?php foreach($categorias as $item): ?>
                        <option value="<?php echo  $item['id'] ?>"><?php echo $item['nome']; ?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                    <label for="valor">Valor:</label> 
                        <select name="valor" class="form-control" required>
                        <option></option>
                        <option value="0/100">0-100</option>
                        <option value="101/300">101-300</option>
                        <option value="301/500">301-500</option>
                        <option value="501/1000000">500-Acima</option>
                        </select>
                    </div>

                    <input type="submit" value="Filtrar" class="btn btn-warning">

                </form>
            </div>
            <div class="col-sm-9">
                <h3>Ultimos Anúncios</h3>
                <div class="row">
    
                <?php foreach($ultimos as $item): ?>
                <?php if(!empty($item['urli'])): ?>

                <div class="img-thumbnail" id="ultimosAnuncios">
                <a><img src="assets/images/anuncios/<?php echo $item['urli'] ?>" width="250" height="150"><br/>
                <strong><a href="produto.php?id=<?php echo $item['id'] ?>&user=<?php echo $item['id_usuario'] ?>"><?php echo $item['titulo'] ?></a></strong><br/>
                <?php echo $item['descricao'] ?><br/></a>
                </div>

                <?php else : ?>

                <div class="img-thumbnail" id="ultimosAnuncios">
                <div><img src="assets/images/anuncios/default.png" height="150" width="250"><br/>
                <strong><a href="produto.php?id=<?php echo $item['id'] ?>&user=<?php echo $item['id_usuario'] ?>"><?php echo $item['titulo'] ?></a></strong><br/>
                <?php echo $item['descricao'] ?><br/></div>
                </div>

                <?php endif; ?>
                
                <?php endforeach;  ?>
                        
                    </div>
                    <hr/>
                    <ul class="pagination">
                    <?php for($q=1; $q<$total_paginas; $q++): ?>
                    <a class="text-light" href="index.php?p=<?php echo $q ?>"><li class="btn btn-info"><?php echo $q ?></li></a>
                    <?php endfor; ?>
                    </ul>
                
                </div>
            </div>
        </div>
     </div>

<?php
    require_once 'pages/footer.php';
?>
