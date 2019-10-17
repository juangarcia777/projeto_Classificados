<?php
    
    class Categoria {

        private $pdo;

        public function __construct($pdo) {
            $this->pdo= $pdo;
        }

        public function getLista() {
            $array = array();

            $sql= $this->pdo->prepare("SELECT * FROM categorias");
            $sql->execute();
            if ($sql->rowCount()  > 0) {
                $array=  $sql->fetchAll();
            }
            return $array;
        }
    }

?>