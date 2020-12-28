<?php session_start(); ?>

<?php
if (isset($_POST["connexion"])) {
    echo "test";
    # Teste de la validite de lemail et du mot de passe
    $email_valide = TRUE;
    $password_valide = TRUE;
    if (!isset($_POST["email"]) or !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email_valide = FALSE;
        $error = "Email erroner ou non definie";
    } else if (!isset($_POST["password"])) {
        $password_valide = FALSE;
        $error = "Mots de passe non definie";
    }

    #Confirmation du MDP dans la base de donne
    if ($email_valide && $password_valide) {
        $bdd = new PDO('mysql:host=localhost;dbname=brains;charset=utf8', 'root', 'root'); #TODO cree un nouvelle utilisateur a la place de root root
        $req = $bdd->prepare('SELECT U.PASSWORD as password FROM brains.user as U WHERE U.EMAIL = ?');
        $req->execute(array($_POST['email']));
        if ($donne = $req->fetch()) {
            if (password_verify($_POST["password"], $donne["password"])) {
                $message = "Connection reusie";
                $_SESSION['admin'] = 1;
            } else {
                $error = "Mot de pass invalid";
                $password_valide = FALSE;
            }
        } else {
            $error = "Email invalid";
            $email_valide = FALSE;
        }

    }
}
if (isset($_POST['deconnexion'])) {
    if (! isset($_SESSION["admin"]) or $_SESSION["admin"] != 1) {
        $error = "Vous n'etes pas connecter vous ne pouver donc pas vous deconecter";
    }
    else{
        $_SESSION["admin"] = 0;
        $message = "Deconnexion Reussi";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>

    <title>/!\ Admin only</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body>
    <?php if (isset($message)): ?>
        <div class="alert alert-success" >
            <?php echo $message ?>
        </div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger" >
            <?php echo $error ?>
        </div>
    <?php endif; ?>
    <div class="alert alert-info container border border-info m-5 mx-auto" role="alert">
        Cette page est reserver au administateur du site si vous en etes pas un merci de revenir a la <a href="../pages/index.php" class="alert-link">Page principale</a>
    </div>
    <?php if (! isset($_SESSION["admin"]) || $_SESSION["admin"] == 0): ?>
    <form method="post" action="/admin/connexion.php" class="container border border-secondary border-2 rounded-3 m-5 mx-auto p-2">
        <div class="mb-3">
            <label for="email" class="form-label">Adresse email</label>
            <input type="email" class="form-control <?php if (isset($email_valide)) {echo (! $email_valide) ? "is-invalid":"valide";}?>" value="<?php if (isset($_POST["email"])) {echo $_POST["email"];}?>" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control <?php if (isset($password_valide)) {echo (! $password_valide) ? "is-invalid":"valide";}?>" value="<?php if (isset($_POST["password"])) {echo $_POST["password"];}?>" name="password" required>
        </div>
        <div class="mb-3">
            <input type="submit" class="btn btn-primary" value="connexion">
        </div>
        <input type="hidden" name="connexion" value="1">
    </form>
    <?php else: ?>
    <form method="post" action="/admin/connexion.php" class="container border border-secondary border-2 rounded-3 m-5 mx-auto p-2">
        <input type="hidden" name="deconnexion" value="1">
        <input type="submit" class="btn btn-primary" value="deconnexion">
    </form>
    <?php endif ?>
</body>
</html>