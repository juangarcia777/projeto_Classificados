<?php

    class Usuario {

        private $pdo;

        public function __construct($pdo) {
            $this->pdo= $pdo;
        }

        public function totalUsuarios() {
            $sql= $this->pdo->query("SELECT COUNT(*) as c FROM usuarios");
            $row=$sql->fetch();

            return $row['c'];
        }

        public function cadastrar($nome, $email, $senha, $telefone) {
            $sql= $this->pdo->prepare("SELECT id FROM usuarios WHERE email= ?");
            $sql->bindValue(1, $email);
            $sql->execute();

            if($sql->rowCount()  > 0) {
            echo "<div class='alert alert-warning'>E-mail ja cadastrado<a class='alert-link' href='login.php'>
            Faça o Login Agora!</a></div>";
            
            } else {
                $sql= $this->pdo->prepare("INSERT INTO usuarios SET nome=?, email=?, senha=?, telefone=?");
                $sql->bindValue(1, $nome);
                $sql->bindValue(2, $email);
                $sql->bindValue(3, $senha);
                $sql->bindValue(4, $telefone);
                $sql->execute();

                return true;
            }
        }

        public function login($email, $senha)  {
        $sql= $this->pdo->prepare("SELECT id FROM usuarios WHERE email= :email AND senha= :senha");
        $sql->bindValue(":email", $email);
        $sql->bindValue(":senha", $senha);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $dado= $sql->fetch();
            $_SESSION['cLogin']= $dado['id'];
            return true;
         } else {
             return false;
         }
        }

        public function getUsuario($id) {
            $array= array();

            $sql= $this->pdo->prepare("SELECT * FROM usuarios WHERE id= :id ");
            $sql->bindValue(":id", $id);
            $sql->execute();

            if($sql->rowCount()  > 0) {
                $array= $sql->fetch();
            }
            return $array;
        }



    }


?>




