<?php require_once 'pages/header.php'; ?>
<?php require_once 'classes/usuarios.class.php'; ?>

<div class="container">

<?php
$user=  new Usuario($pdo);
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $email= $_POST['email'];
        $senha= MD5($_POST['senha']);


        if($user->login($email, $senha)) {
        ?>
     <script type="text/javascript">window.location.href="./";</script>

        <?php
        } else {
            ?>
        <div class="alert alert-danger">Usuário e/ou Senha errados!</div>

        <?php
        }
    }
?>
    <br/>
    <hr/>
        <h1>Fazer Login</h1>
    

    <form method="POST">
        
        <div class="form-group">
            <label for="email">Seu E-mail:</label><br/>
            <input type="email" name="email" id="email" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="senha">Sua Senha:</label><br/>
            <input type="password" name="senha" id="senha" class="form-control"/>
        </div>
    
        <input type="submit" value="Logar" class="btn btn-danger btn-block">
    </form>
    <br/>
    <hr/>

    </div>

<?php require_once 'pages/footer.php'; ?>