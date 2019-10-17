<?php
    
    class Anuncio {

        private $pdo;

        public function __construct($pdo) {
            $this->pdo= $pdo;
        }

        public function getMeusAnuncios() {
            $array = array();

            $sql= $this->pdo->prepare("SELECT *,(select anuncios_imagens.urli
             from anuncios_imagens where anuncios_imagens.id_anuncio = anuncios.id limit 1)as urli FROM anuncios WHERE id_usuario = :id");
            $sql->bindValue(":id", $_SESSION['cLogin']);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                $array= $sql->fetchAll();
            }

            return $array;
        }

        public function getUltimosAnuncios($page,$perPage) {
            $offset= ($page - 1) * $perPage;

            $array = array();

            $sql= $this->pdo->query("SELECT *,(select anuncios_imagens.urli
            from anuncios_imagens where anuncios_imagens.id_anuncio = anuncios.id limit 1)
            as urli FROM anuncios ORDER BY id DESC LIMIT $offset,$perPage");
            
            $array= $sql->fetchAll();
            
            return $array;
        }

        public function setAnuncio($titulo, $valor, $descricao, $estado, $categoria) {
            $sql= $this->pdo->prepare("INSERT INTO anuncios SET id_categorias= :categoria, 
            id_usuario=  :id_usuario, titulo= :titulo, valor= :valor, descricao= :descricao, estado= :estado");
            $sql->bindValue(":categoria", $categoria);
            $sql->bindValue(":id_usuario", $_SESSION['cLogin']);
            $sql->bindValue(":titulo", $titulo);
            $sql->bindValue(":valor", $valor);
            $sql->bindValue(":descricao", $descricao);
            $sql->bindValue(":estado", $estado);
            $sql->execute();
            
            return true;
        }

        public function deleteAnuncio($id) {
            $sql= $this->pdo->prepare("DELETE FROM anuncios WHERE id= :id");
            $sql->bindValue(":id", $id);
            $sql->execute();

            $sql= $this->pdo->prepare("DELETE FROM anuncios_imagens
             WHERE id_anuncio= :id");
            $sql->bindValue(":id", $id);
            $sql->execute();

            header("Location:meus-anuncios.php");
            exit;
        }

        public function excluiFoto($id)  {
            $sql= $this->pdo->prepare("SELECT id_anuncio FROM anuncios_imagens WHERE id= :id");
            $sql->bindValue(":id", $id);
            $sql->execute();

            if($sql->rowCount() > 0) {
            $row= $sql->fetch();
            $id_anuncio= $row['id_anuncio'];
            }

            $sql= $this->pdo->prepare("DELETE FROM anuncios_imagens WHERE id= :id");
            $sql->bindValue(":id", $id);
            $sql->execute();

            return $id_anuncio;
        }

        public function getInfo($id) {
            $array= array();
            $sql= $this->pdo->prepare("SELECT * FROM anuncios WHERE id= :id");
            $sql->bindValue(":id", $id);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                $array= $sql->fetch();
                $array['fotos']= array();

            $sql= $this->pdo->prepare("SELECT id,urli 
            FROM anuncios_imagens WHERE id_anuncio= :id");
            $sql->bindValue(":id", $id);
            $sql->execute();

            if($sql->rowCount() > 0) {
            $array['fotos']= $sql->fetchAll();
            }

        }
     
        return $array;
        }

        public function editAnuncio($titulo, $valor, $descricao, $estado, $categoria, $fotos,$id) {
            $array= array();
            $sql= $this->pdo->prepare("UPDATE anuncios SET id_categorias= :categoria,id_usuario= :id_usuario,
             titulo= :titulo,valor= :valor, descricao= :descricao,
              estado= :estado  WHERE id= :id");
            $sql->bindValue(":categoria", $categoria);
            $sql->bindValue(":id_usuario", $_SESSION['cLogin']);
            $sql->bindValue(":titulo", $titulo);
            $sql->bindValue(":valor", $valor);
            $sql->bindValue(":descricao", $descricao);
            $sql->bindValue(":estado", $estado);
            $sql->bindValue(":id", $id);
            $sql->execute();

            if (count($fotos)> 0) {
                for($q=0;$q<count($fotos['tmp_name']);$q++) {
                    $tipo= $fotos['type'][$q];
                    if (in_array($tipo,array('image/jpeg','image/png'))) {
                        $tmpname= time().'.jpg';
                        move_uploaded_file($fotos['tmp_name'][$q],'assets/images/anuncios/'.$tmpname);
                        
                        list($width_orig, $height_orig) = getimagesize('assets/images/anuncios/'.$tmpname);
                        $ratio= $width_orig/$height_orig;

                        $width= 250;
                        $height= 250;

                        if($width/$height > $ratio) {
                            $width= $height*$ratio;
                        } else {
                            $height= $width/$ratio;
                        }

                        $img= imagecreatetruecolor($width,$height);
                        if ($tipo == 'image/jpeg') {
                            $origi= imagecreatefromjpeg('assets/images/anuncios/'.$tmpname);
                        } elseif($tipo == 'image/png') {
                            $origi= imagecreatefrompng('assets/images/anuncios/'.$tmpname);
                    }

                        imagecopyresampled($img, $origi, 0, 0, 0, 0, $width, $height,
                         $width_orig, $height_orig);

                         imagejpeg($img, 'assets/images/anuncios'.$tmpname, 80);


                         $sql=  $this->pdo->prepare("INSERT INTO  anuncios_imagens SET
                         id_anuncio=  :id_anuncio, urli= :urli");
                         $sql->bindValue(":id_anuncio", $id);                         
                         $sql->bindValue(":urli", $tmpname);
                         $sql->execute();                         
                }
            }
        }

       return true;
    } 

    public function totalAnuncios() {
        $sql= $this->pdo->query("SELECT COUNT(*) as c FROM anuncios");
        $row= $sql->fetch();

        return $row['c'];
    }

    public function filtroAnuncio($categoria, $valor) {
        $array= array();
        $preco= explode('/', $valor);
        $sql= $this->pdo->prepare("SELECT *,(select anuncios_imagens.urli
        from anuncios_imagens where anuncios_imagens.id_anuncio = anuncios.id limit 1)
        as urli,(select usuarios.telefone from usuarios where usuarios.id= anuncios.id_usuario)as user FROM anuncios WHERE valor BETWEEN :preco1 AND :preco2
         AND id_categorias= :categorias");

        $sql->bindValue(":preco1", $preco[0]);
        $sql->bindValue(":preco2", $preco[1]);
        $sql->bindValue(":categorias", $categoria);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array= $sql->fetchAll();
            
        } else {
            echo "<div class='alert alert-danger'>Nenhum Anuncio encontrado !!</div>";
            header("Refresh:2,index.php");
            exit;
        }
        return $array;
    }

   


}

?>