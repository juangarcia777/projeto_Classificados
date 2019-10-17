<?php 
require 'classes/anuncios.class.php'; 
require 'config.php'; 

$user= new Anuncio($pdo);

if(!empty($_GET['id'])) {
    
    $id_anuncio=$user->excluiFoto($_GET['id']);
    header("Location:editar.php?id=".$id_anuncio);

} else {
    echo "ERRO...";
}

?>
