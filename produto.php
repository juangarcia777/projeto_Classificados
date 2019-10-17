<?php
    require_once 'pages/header.php';


    if(empty($_SESSION['cLogin'])) {
        header("Location:login.php");
        exit;
    }

    require_once 'classes/usuarios.class.php';
    require_once 'classes/anuncios.class.php';

    $b= new Anuncio($pdo);
    $a= new Usuario($pdo);
     
    if(!empty($_GET['user'])){
    $user= $_GET['user'];
    $lista=$a->getUsuario($user);
    }

    if (!empty($_GET['id'])) {
     $id= $_GET['id'];
     $array= $b->getInfo($id);
    }
?>
 <div class="container-fluid">
 <br/>
	<div class="row">
		<div class="col-sm-5">
			
			<div class="carousel slide" data-ride="carousel" id="meuCarousel">
				<div class="carousel-inner">

					<?php foreach($array['fotos'] as $chave => $foto): ?>
					<div class="carousel-item <?php echo ($chave=='0')?'active':''; ?>">
						<img id="imageProduto" src="assets/images/anuncios/<?php echo $foto['urli']; ?>"  />
					</div>
					<?php endforeach; ?>
				</div>
                <hr/>
				<a class="left carousel-control btn btn-info" href="#meuCarousel" role="button" data-slide="prev"><span><</span></a>
				<a class="right carousel-control btn btn-info" href="#meuCarousel" role="button" data-slide="next"><span>></span></a>
			</div>

		</div>
		<div class="col-sm-7">
			<h1><?php echo $array['titulo']; ?></h1>
			<p><?php echo $array['descricao']; ?></p>
			<br/>
			<h3>R$ <?php echo $array['valor']; ?></h3>
			<h4>Telefone: <?php echo $lista['telefone']; ?></h4>
		</div>
	</div>
</div>
<?php
    require_once 'pages/footer.php';
?>
    