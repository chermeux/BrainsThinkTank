<?php session_start(); ?>

<?php
if (isset($_POST["connexion"])) {
    # Test de la validite de lemail et du mot de passe
    $email_valide = TRUE;
    $password_valide = TRUE;
    if (!isset($_POST["email"]) or !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email_valide = FALSE;
        $error = "Erreur Email";
    } else if (!isset($_POST["password"])) {
        $password_valide = FALSE;
        $error = "Erreur Mot de Passe";
    }

    #Confirmation du MDP dans la base de donne
    if ($email_valide && $password_valide) {
        $bdd = new PDO('mysql:host=localhost;dbname=brains;charset=utf8', 'root', 'root'); #TODO cree un nouvelle utilisateur a la place de root root
        $req = $bdd->prepare('SELECT U.PASSWORD as password FROM brains.user as U WHERE U.EMAIL = ?');
        $req->execute(array($_POST['email']));
        if ($donne = $req->fetch()) {
            if (password_verify($_POST["password"], $donne["password"])) {
                $message = "Connexion reussie";
                $_SESSION["admin"] = TRUE;
            } else {
                $error = "Mauvais Mot de passe";
                $password_valide = FALSE;
            }
        } else {
            $error = "Mauvais Email";
            $email_valide = FALSE;
        }

    }
}
if (isset($_POST['deconnexion'])) {
    if (! isset($_SESSION["admin"]) or ! $_SESSION["admin"]) {
        $error = "Vous n'êtes pas connecté vous ne pouvez donc pas vous deconnecter";
    }
    else{
        $_SESSION["admin"] = FALSE;
        $message = "Deconnexion Reussie";
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
    <h1 class="text-center">Connexion / Déconnexion</h1>
    <div class="alert alert-info container border border-info m-5 mx-auto" role="alert">
        Cette page est reservée aux administrateurs du site si vous n'en êtes pas un, merci de revenir à la <a href="../index.php" class="alert-link">Page principale</a>
    </div>
    <?php if (! isset($_SESSION["admin"]) || ! $_SESSION["admin"]): ?>
    <form method="post" action="/admin/connexion.php" class="container border border-secondary border-2 rounded-3 m-5 mx-auto p-2">
        <div class="form-floating mb-3">

            <input id="email" type="email" class="form-control <?php if (isset($email_valide)) {echo (! $email_valide) ? "is-invalid":"is-valid";}?>" value="<?php if (isset($_POST["email"])) {echo $_POST["email"];}?>" name="email" required>
            <label for="email">Adresse email</label>
        </div>
        <div class="form-floating mb-3">
            <input id="password" type="password" class="form-control <?php if (isset($password_valide)) {echo (! $password_valide) ? "is-invalid":"is-valide";}?>" value="<?php if (isset($_POST["password"])) {echo $_POST["password"];}?>" name="password" required>
            <label for="password">Password</label>
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

    <div class="container border border-secondary border-2 rounded-3 m-5 mx-auto p-2">
        <h2>
            Administration
        </h2>
        <ul class="list-group">
            <a href="evenement.php"><li class="list-group-item">Ajouter évènement</li></a>
            <a href="editUser.php"><li class="list-group-item">Créer utilisateur</li></a>
            <a href="liste_user.php"><li class="list-group-item">Liste des utilisateurs</li></a>
        </ul>

    </div>
    <?php endif ?>
</body>
</html>