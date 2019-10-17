<?php  
     require 'config.php';
     require 'classes/anuncios.class.php';
    $user= new  Anuncio($pdo);

    if(!empty($_GET['id'])) {
        $id=$_GET['id'];
        $user->deleteAnuncio($id);
    } else {
        echo "Erro..";
    }
    ?>