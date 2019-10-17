<?php require_once 'pages/header.php'; ?>
<?php require_once 'classes/usuarios.class.php'; ?>

<div class="container">

<?php
$user=  new Usuario($pdo);
    if (isset($_POST['nome']) && !empty($_POST['nome'])) {
        $nome= $_POST['nome'];
        $email= $_POST['email'];
        $senha= md5($_POST['senha']);
        $telefone= $_POST['tel'];

        if(!empty($nome) && !empty($email) && !empty($senha)) {
        
            if($user->cadastrar($nome, $email, $senha, $telefone) == true) {
             ?>
             
             <div class="alert alert-success">
            Usuário cadastrado com Sucesso. <a class="alert-link" href="login.php">Faça o Login !</a> 
            </div>
    <?php
         }
    
        } else { 
            ?>

        <div class="alert alert-warning">
         Preencha todos os Campos !
        </div>
<?php 
        }
    }
 ?>

<br/>
    
        <h1>Cadastro</h1>
    

    <form method="POST">
        <div class="form-group">
            <label for="nome">Seu Nome:</label><br/>
            <input type="text" name="nome" id="nome" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="email">Seu E-mail:</label><br/>
            <input type="email" name="email" id="email" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="senha">Sua Senha:</label><br/>
            <input type="password" name="senha" id="senha" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="tel">Seu Telefone:</label><br/>
            <input type="tel" name="tel" id="tel" class="form-control"/>
        </div>
        <input type="submit" value="Cadastrar" class="btn btn-info">
    </form>

    </div>

<?php require_once 'pages/footer.php'; ?>