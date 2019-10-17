<?php
    require_once 'pages/header.php';

    if (empty($_SESSION['cLogin'])) {
        header("Location:login.php");
        exit;
    }
?>
     <div class="container">
     <br/>
         <h1>Meus Anúncios</h1>
         <a href="add-anuncio.php" class="btn btn-warning">Anunciar</a>
         <br/>
         <br/>
     
     <table class=" table table-striped">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Titulo</th>
                <th>Valor</th>
                <th>Ações</th>
            </tr>
        </thead>
     <?php  
     require 'classes/anuncios.class.php';
    $user= new  Anuncio($pdo);

    $anuncios=$user->getMeusAnuncios();

    foreach($anuncios as $anuncio):
    ?>
    <tr>
            <?php if(!empty($anuncio['urli'])): ?>
        <td><img height="50" src="assets/images/anuncios/<?php echo $anuncio['urli'] ?>"/></td>
        <td><?php echo $anuncio['titulo']; ?></td>
        <td>R$<?php echo $anuncio['valor']; ?></td>
        <?php else : ?>
        <td><img src="assets/images/anuncios/default.png" height="50"/></td>
        <td><?php echo $anuncio['titulo']; ?></td>
        <td>R$<?php echo $anuncio['valor']; ?></td>
    <?php endif; ?>
    <td><a class="btn btn-info" href="editar.php?id=<?php echo $anuncio['id']?>">Editar</a>---
    <a class="btn btn-danger" href="excluir.php?id=<?php echo $anuncio['id']?>">Excluir</a></td>
    </tr>

    <?php  endforeach; ?> 
    </table>

     </div>

<?php
    require_once 'pages/footer.php';
?>