<?php
$error= null;
if(!empty($_POST['username']) && !empty($_POST['password']))
{
    if($_POST['username'] === 'root' && $_POST['password'] === 'root')
    {
        session_start();
        $_SESSION['connecte'] = 1;
        header('location: user.php');
        exit();
    }else{
        $error = "Identifiant incorrects";
    }
}
    require_once 'fonctions/auth.php';
    if(est_connecte()){
        header('location: /user.php');
        exit();
    }
    require_once 'elements/header.php';
?>
<div class="container">
    <div class="row">
        <div class="offset-lg-2 col-lg-8">
            <h1>Vous devez vous connecter</h1>
            <?php if($error): ?>
            <div class="alert alert-danger">
                <?= $error ?>
            </div>
            <?php endif; ?>
            <form action="" method="POST">
                <div class="form-group">
                    <input type="text" name="username" placeholder="Nom d'utilisateur" class="form-contol">
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Mot de passe" class="form-contol">
                </div>
                <button>Se connecter</button>
            </form>
        </div>
    </div>
</div>
</body>

</html>

<?php
    require_once 'elements/footer.php';
?>