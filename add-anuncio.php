<?php require_once 'pages/header.php'; ?>

<div class="container" style="padding-bottom:100px;">

<?php

    if (empty($_SESSION['cLogin'])) {
        header("Location:login.php");
        exit;
    }

require 'classes/anuncios.class.php';
$a =  new Anuncio($pdo);

if (isset($_POST['titulo']) && !empty($_POST['titulo'])) {
    $titulo= $_POST['titulo'];
    $valor= $_POST['valor'];
    $descricao= $_POST['descricao'];
    $estado= $_POST['estado'];
    $categoria= $_POST['categoria'];

    if($a->setAnuncio($titulo, $valor, $descricao, $estado, $categoria)== true) {
        ?>
        
        <div class="alert alert-success">
        Anunciado com Sucesso !
        </div>

    <?php
    } else { ?>

        <div class="alert alert-danger">
        Erro Interno..Tente novamente mais tarde.
        </div>

    <?php
    }
}
?>

    <h2>Novo Anúncio</h2>

    <form method="POST" >
   
    <div class="form-group">
    <label for="categoria">Categoria:</label>
    <select name="categoria" id="categoria" class="form-control">

    <?php
    require 'classes/categorias.class.php';
     $user=  new Categoria($pdo);
    $todos= $user->getLista();
    foreach($todos as $item): ?>

      <option value="<?php echo $item['id']; ?>"><?php echo $item['nome'] ?></option>

    <?php endforeach; ?>
    </select>
    </div> 
    
    <div class="form-group">
    <label for="titulo">Titulo:</label>
    <input  type="text" name="titulo" id="titulo" class="form-control">
    </div>

    <div class="form-group">
    <label for="valor">Valor:</label>
    <input  type="text" name="valor" id="valor" class="form-control">
    </div>

    <div class="form-group">
    <label for="descricao">Descrição:</label>
    <textarea class="form-control" name="descricao"></textarea>
    </div>


    <div class="form-group">
    <label for="estado">Estado de Conservação:</label>
    <select name="estado" id="estado" class="form-control">
    <option value="0">Regular</option>
    <option value="1">Bom</option>
    <option value="2">Ótimo</option>
    </select>
    </div> 

   
    <br/>

    <input type="submit" value="Adicionar" class="btn btn-danger">
    </form>
</div>

<?php
    require_once 'pages/footer.php';
?>